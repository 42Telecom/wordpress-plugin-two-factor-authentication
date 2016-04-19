<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller\AbstractAuth;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils\TemplateEngine;
use Fortytwo\SDK\TwoFactorAuthentication\TwoFactorAuthentication;

/**
 * Set register 2fa step UI and add logic
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class Register extends AbstractAuth
{
    /**
     * Declare actions, Javascript files and style for the plugin on register process
     */
    public function __construct()
    {
        if (self::isTwoFactorAvailableOn('register')) {
            // Action on register
            // Show the phone number field on the register form
            add_action('register_form', array($this, 'addTwoFactorRegister'), 10, 2);
            // Validate phone number
            //add_filter('registration_errors', array($this, 'phoneValidationErrors'), 10, 1);
            // Save phone on register
            add_action('user_register', array($this, 'savePhoneNumber'));
            // Add the second step to validate phone number
            add_action('register_post', array($this, 'showTwoFactorStep'), 10, 3);

            // Enqueue Script and Styles
            // Enqueue css
            add_action('login_enqueue_scripts', array($this, 'loadCss'), 10);
            // Enqueue javascript
            add_action('login_enqueue_scripts', array($this, 'loadJavascript'), 1);
        }
    }

    /**
     * Add the phone field on regsiter
     *
     * @param $user Wordpress user object
     */
    public function addTwoFactorRegister($user)
    {
        $phoneValue = (!empty($_POST['2faPhone'])) ? trim($_POST['2faPhone']) : '';
        echo TemplateEngine::render(
            'UserRegisterForm.html',
            array(
                'phoneValue'    => $phoneValue
            )
        );
    }

    /**
     * Validate the phone field on submit
     *
     * @param $errors Wordpress errors object
     * @param
     */
    public function phoneValidationErrors($errors)
    {
        if (empty($_POST['2faPhone']) || ! empty($_POST['2faPhone']) && trim($_POST['2faPhone']) == '') {
            $errors->add('2faPhone', __('<strong>ERROR</strong>: You must include a valid phone number.'));
        }
        return $errors;
    }

    /**
     * Register the needed css files for the plugin on register
     */
    public function loadCss()
    {
        wp_register_style(
            'fortytwo_two_factor_style_intl',
            plugin_dir_url(__FILE__) . '../Css/intlTelInput.css',
            false,
            '1.0.0'
        );
        wp_register_style(
            'fortytwo_two_factor_style_plugin',
            plugin_dir_url(__FILE__) . '../Css/plugin.css',
            false,
            '1.0.0'
        );
        wp_enqueue_style('fortytwo_two_factor_style_intl');
        wp_enqueue_style('fortytwo_two_factor_style_plugin');
    }

    /**
     * Register the needed javascripts files for the plugin on register
     */
    public function loadJavascript()
    {
        wp_enqueue_script(
            'fortytwo_two_factor_javascript_intlTelInput',
            plugin_dir_url(__FILE__) . '../Javascript/intlTelInput.min.js',
            array('jquery')
        );
        wp_enqueue_script(
            'fortytwo_two_factor_javascript_utils',
            plugin_dir_url(__FILE__) . '../Javascript/utils.js'
        );
        wp_enqueue_script(
            'fortytwo_two_factor_javascript_plugin',
            plugin_dir_url(__FILE__) . '../Javascript/plugin.js'
        );
    }

    /**
     * Logic function to show the 2FA step and manage the API calls.
     *
     * @param string $userLogin User login submited with the register form
     * @param string $userEmail User email submited with the regsiter form
     * @param object $errors    Wordpress error object - Default = null
     */
    public function showTwoFactorStep($userLogin, $userEmail, $errors = null)
    {
        self::phoneValidationErrors($errors);

        //Cathcup Wordpress validation first
        if (count($errors->errors) == 0) {

            // Sanitize the submited phone number
            $phoneNumber = self::sanitizePhoneNumber($_POST['2faPhone']);

            // Get configuration for 2fa plugin
            $options = get_option('fortytwo2fa');

            // Init Validate flag
            $validate = false;

            // if the 2fa code is submited so we verify the code with the API.
            if ($_POST['code']) {
                if (!empty($_POST['code'])) {
                    // Create and submit the request to API
                    $ApiRequest = new TwoFactorAuthentication($options['tokenNumber']);
                    $response = $ApiRequest->validateCode($_POST['fortytwo-client-ref'], $_POST['code']);

                    // Manage the response
                    if ($response->getResultInfo()->getStatusCode() != 0) {
                        $errorMsg = "Wrong authentication code.";
                    } else {
                        $validate = true;
                    }
                } else {
                    $errorMsg = "Authentication code empty.";
                }
            }

            // If code is not valdiated or not processed
            if (!$validate) {

                // We prepare the Resend form - Allowing user to resend form
                $resendHtml = TemplateEngine::render(
                    'ResendSMSRegister.html',
                    array(
                        'resendPhoneNumber' => '+'.$phoneNumber,
                        'userLogin'         => esc_attr($userLogin),
                        'userEmail'         => esc_attr($userEmail),
                        'redirectTo'        => esc_attr($_POST['redirect_to']),
                        'wpSubmit'          => esc_attr($_POST['wp-submit'])
                    )
                );

                if (isset($_POST['fortytwo-client-ref'])) {
                    $clientRef = $_POST['fortytwo-client-ref'];
                }

                // We send an API call to send the SMS code
                if (!$errorMsg) {
                    try {
                        $clientRef = 'wordpress' . date('YmdHis');
                        $args = self::buildRequestCodeOption();
                        $ApiRequest = new TwoFactorAuthentication(trim($options['tokenNumber']));
                        $response = $ApiRequest->requestCode($clientRef, $phoneNumber, $args);
                    } catch (\Exception $e) {
                        // FIXME - Need an update of the SDK to show proper errrors
                        //$errorMsg = $e->getMessage();
                        $errorMsg = "Error - Invalid Token.";
                    }
                }

                //Include the login header
                login_header();

                // Showing error messages if they exists.
                if (!empty($errorMsg)) {
                    echo '<div id="login_error"><strong>' . esc_html($errorMsg) . '</strong><br /></div>';
                }

                if (isset($options['apiCodeLength'])) {
                    $digits = $options['apiCodeLength'];
                } else {
                    $digits = 4;
                }

                //Hack for capturing the footer
                ob_start();
                do_action('login_footer');
                $wpFooter = ob_get_contents();
                ob_end_clean();

                // Showing the code validation template
                echo TemplateEngine::render(
                    'PhoneValidationForm.html',
                    array(
                        'formAction'    => $formAction,
                        'userLogin'     => esc_attr($userLogin),
                        'userEmail'     => esc_attr($userEmail),
                        'redirectTo'    => esc_attr($_POST['redirect_to']),
                        'wpSubmit'      => esc_attr($_POST['wp-submit']),
                        'homeUrl'       => esc_url(home_url('/')),
                        'HomeUrlLabel'  => esc_html(sprintf(__('&larr; Back to %s'), get_bloginfo('title', 'display'))),
                        'wpFooter'      => $wpFooter,
                        'clientRef'     => $clientRef,
                        'resendSMS'     => $resendHtml,
                        '2faPhone'      => $phoneNumber,
                        'digits'        => $digits
                    )
                );

                // Exit to avoid wordpress jumping the step.
                exit;
            }
        }
    }
}
