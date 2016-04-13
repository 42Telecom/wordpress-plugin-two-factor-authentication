<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils\CodeFormValidation;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils\Nonce;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils\TemplateEngine;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils\TrustedDevice;
use Fortytwo\SDK\TwoFactorAuthentication\TwoFactorAuthentication;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedStateValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginResendStateValue;

/**
 * Set Login 2fa step UI and add logic
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class Login extends AbstractAuth
{
    public function __construct()
    {
        add_action('wp_login', array($this, 'wpLogin'), 10, 2);
        add_action('login_form_validate_2fa', array($this, 'loginFormValidate2fa'), 10, 2);
        add_action('login_enqueue_scripts', array($this, 'loginEnqueueScript'), 1);
    }

    public function loginEnqueueScript()
    {
        wp_enqueue_script('jquery');
    }

    /**
     * Handle the browser-based login.
     *
     * @param string  $user_login Username.
     * @param object $user WP_User object of the logged-in user.
     */
    public function wpLogin($user_login, $user)
    {
        $options = get_option('fortytwo2fa');

        if (self::isTwoFactorAvailableOn('login')) {
            if (!TrustedDevice::isTrustedDevice($user->ID)) {
                if ((count(array_intersect($options['twoFactorByRole'], $user->roles)) > 0) ||
                    (!isset($options['twoFactorByRole']))
                ) {

                    $phoneValue = esc_attr(get_user_option('2faPhone', $user->ID));
                    if (($phoneValue) && ($phoneValue != '')) {
                        wp_clear_auth_cookie();
                        self::showTwoFactorLogin($user);
                        exit;
                    }
                }
            }
        }
    }

    /**
     * Display the login form.
     *
     * @param object $user WP_User object of the logged-in user.
     */
    public static function showTwoFactorLogin($user)
    {
        if (!$user) {
            $user = wp_get_current_user();
        }

        $nonce = new Nonce();
        $loginNonce = $nonce->create($user->ID);

        if (!$loginNonce) {
            wp_die(esc_html__('Could not save login nonce.'));
        }

        $redirectTo = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : $_SERVER['REQUEST_URI'];

        self::loginHtml($user, $loginNonce['key'], $redirectTo);
        exit;
    }

    /**
     * Generates the html form for the second step of the authentication process.
     *
     * @param object        $user WP_User object of the logged-in user.
     * @param string        $loginNonce A string nonce stored in usermeta.
     * @param string        $redirectTo The URL to which the user would like to be redirected.
     * @param string        $errorMsg Optional. Login error message.
     */
    public function loginHtml($user, $loginNonce, $redirectTo, $errorMsg = false)
    {
        $options = get_option('fortytwo2fa');

        // Try to send Code request
        if (!$errorMsg) {
            try {
                $phoneValue = esc_attr(get_user_option('2faPhone', $user->ID));
                $clientRef = 'wordpress' . date('YmdHis');
                $args = self::buildRequestCodeOption();
                $ApiRequest = new TwoFactorAuthentication(trim($options['tokenNumber']));
                $response = $ApiRequest->requestCode($clientRef, $phoneValue, $args);
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();
            }
        }

        $interimLogin = isset($_REQUEST['interim-login']);

        // Save rememberme option
        $rememberme = 0;
        if (isset($_REQUEST['rememberme']) && $_REQUEST['rememberme']) {
            $rememberme = 1;
        }

        //Include the login header
        login_header();

        //Show error message
        if (!empty($errorMsg)) {
            echo '<div id="login_error"><strong>' . esc_html($errorMsg) . '</strong><br /></div>';
        }

        // Set form action url
        $formAction = esc_url(
            set_url_scheme(
                add_query_arg(
                    'action',
                    'validate_2fa',
                    wp_login_url()
                ),
                'login_post'
            )
        );

        // Trusted Device Section
        $trustedDevice = new TrustedStateValue();
        $trustedDeviceSection = '';
        if ($trustedDevice->isActive()) {
            $trustedDeviceSection = TemplateEngine::render('TrustedDevice.html');
        }

        // Add part to resend SMS
        $resendSMSLogin = new LoginResendStateValue();
        $resendSMSLoginSection = '';
        if ($resendSMSLogin->isActive()) {
            $resendSMSLoginSection = TemplateEngine::render('ResendSMSLogin.html');
        }

        //Hack for capturing the footer
        ob_start();
        do_action('login_footer');
        $wpFooter = ob_get_contents();
        ob_end_clean();


        if (isset($options['apiCodeLength'])) {
            $digits = $options['apiCodeLength'];
        } else {
            $digits = 4;
        }

        //Hack for capturing the footer
        echo TemplateEngine::render(
            'CodeValidationForm.html',
            array(
                'formAction'    => $formAction,
                'userId'        => esc_attr($user->ID),
                'authNonce'     => esc_attr($loginNonce),
                'interimLogin'  => $interimLogin,
                'redirectTo'    => $redirectTo,
                'rememberMe'    => esc_attr($rememberme),
                'homeUrl'       => esc_url(home_url('/')),
                'HomeUrlLabel'  => esc_html(sprintf(__('&larr; Back to %s'), get_bloginfo('title', 'display'))),
                'wpFooter'      => $wpFooter,
                'clientRef'     => $clientRef,
                'resendSMS'     => $resendSMSLoginSection,
                'digits'        => $digits,
                'trustedDevice' => $trustedDeviceSection
            )
        );
    }

    /**
     * Login form validation.
     */
    public function loginFormValidate2fa()
    {
        // Get configurations options for the plugin
        $options = get_option('fortytwo2fa');

        // Create Validation form object
        $formValidation = new CodeFormValidation;

        // Validating the form
        if ($form = $formValidation->validate($_POST)) {

            // Get user objectf from wordpress
            $user = get_userdata($_POST['wp-auth-id']);
            if (!$user) {
                return;
            }

            // Set the Nonce
            $Nonce = new Nonce();
            $nonce = $_POST['wp-auth-nonce'];
            if (true !== $Nonce->verify($user->ID, $nonce)) {
                wp_safe_redirect(get_bloginfo('url'));
                exit;
            }

            // Check the validity of the code
            $ApiRequest = new TwoFactorAuthentication($options['tokenNumber']);
            $response = $ApiRequest->validateCode($_POST['fortytwo-client-ref'], $_POST['code']);

            // If the code is not validated = Login failed
            if ($response->getResultInfo()->getStatusCode() != 0) {
                self::loginFailed($user);
            } else {
                $Nonce->delete($user->ID);

                // Adding the device as trusted
                TrustedDevice::add($user->ID);

                // Set rememberme checkbox
                $rememberme = false;
                if (isset($_REQUEST['rememberme']) && $_REQUEST['rememberme']) {
                    $rememberme = true;
                }

                // Set login cookies
                wp_set_auth_cookie($user->ID, $rememberme);

                // Must be global because that's how login_header() uses it.
                global $interimLogin;
                if ($_REQUEST['interim-login']!= '') {
                    $interimLogin = $_REQUEST['interim-login'];
                }

                // Interim login process
                if ($interimLogin) {
                    $customize_login = isset($_REQUEST['customize-login']);
                    if ($customize_login) {
                        wp_enqueue_script('customize-base');
                    }
                    $message = '<p class="message">' . __('You have logged in successfully.') . '</p>';
                    $interimLogin = 'success'; // WPCS: override ok.
                    login_header('', $message); ?>
                    </div>
                    <?php
                    do_action('login_footer'); ?>
                    <?php if ($customize_login) : ?>
                        <script type="text/javascript">
                            setTimeout(function(){
                                new wp.customize.Messenger(
                                    {
                                        url: '<?php echo wp_customize_url(); ?>',
                                        channel: 'login'
                                    }).send('login')
                                }, 1000
                            );
                        </script>
                    <?php endif; ?>
                    </body></html>
                    <?php
                    exit;
                }

                // Set redirect
                $redirect_to = apply_filters(
                    'login_redirect',
                    $_REQUEST['redirect_to'],
                    $_REQUEST['redirect_to'],
                    $user
                );
                wp_safe_redirect($redirect_to);
            }
        } else {
            $user = wp_get_current_user();
            self::loginFailed($user, 'ERROR: Invalid form.');
        }
        exit;
    }

    /**
     * Login failed when the SMS code is not good.
     *
     * @param object $user Wordpress user object
     * @param string $message Error message
     */
    public function loginFailed($user, $message = 'ERROR: Invalid verification code.')
    {
        do_action('wp_login_failed', $user->user_login);

        $Nonce = new Nonce();
        $loginNonce = $Nonce->create($user->ID);
        if (! $loginNonce) {
            return;
        }

        self::loginHtml(
            $user,
            $loginNonce['key'],
            $_REQUEST['redirect_to'],
            esc_html__($message)
        );
    }
}
