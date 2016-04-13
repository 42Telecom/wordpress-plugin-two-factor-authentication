<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Factory\RegisterSection;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TokenValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedTTLValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginUsersValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginStateValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeTypeValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedStateValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeLengthValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\RegisterStateValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICallBackUrlValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginResendStateValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICustomSenderIDValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeCaseSensitiveValue;

/**
 * Manage Admin settings for the plugin
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class Admin
{

    private $options;

    /**
     * Contructor - Call action to add the setting page.
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addPluginPage'));
        add_action('admin_init', array($this, 'pageInitSection'));
    }

    /**
     * Add options page
     */
    public function addPluginPage()
    {
        // This page will be under "Settings"
        add_options_page(
            'Two Factor Authentication',
            'Two Factor Authentication',
            'manage_options',
            'fortytwo-2fa-admin',
            array($this, 'createAdminPage')
        );
    }

    /**
     * Options page callback
     */
    public function createAdminPage()
    {
        // Set class property
        $this->options = get_option('fortytwo2fa');
        ?>
        <div class="wrap">
            <h2>Two Factor Authentication Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields('fortytwoTwoFactorSetting');
                do_settings_sections('fortytwo-2fa-admin');
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Add section and fields
     */
    public function pageInitSection()
    {
        // Add Group
        register_setting(
            'fortytwoTwoFactorSetting',
            'fortytwo2fa',
            array($this, 'sanitize')
        );

        RegisterSection::get("GeneralSection")->add();
        RegisterSection::get("LoginBehaviorSection")->add();
        RegisterSection::get("RegisterBehaviorSection")->add();
        RegisterSection::get("TrustedDeviceSection")->add();
        RegisterSection::get("ApiSettingsSection")->add();
    }

    public function sanitize($input)
    {
        $new_input = array();
        if (isset($input['tokenNumber'])) {
            $token = new TokenValue($input['tokenNumber']);
            $new_input['tokenNumber'] = (string)$token;
        }

        if (isset($input['twoFactorOnLogin'])) {
            $loginState = new LoginStateValue($input['twoFactorOnLogin']);
            $new_input['twoFactorOnLogin'] = (string)$loginState;
        }

        if (isset($input['smsResend'])) {
            $loginSMSResend = new LoginResendStateValue($input['smsResend']);
            $new_input['smsResend'] = (string)$loginSMSResend;
        }

        if (isset($input['twoFactorByRole'])) {
            $loginByRole = new LoginUsersValue($input['twoFactorByRole']);
            $new_input['twoFactorByRole'] = $loginByRole->getValues();
        }

        if (isset($input['twoFactorOnRegister'])) {
            $registerState = new RegisterStateValue($input['twoFactorOnRegister']);
            $new_input['twoFactorOnRegister'] = (string)$registerState;
        }

        if (isset($input['trustedDeviceOption'])) {
            $trustedState = new TrustedStateValue($input['trustedDeviceOption']);
            $new_input['trustedDeviceOption'] = (string)$trustedState;
        }

        if (isset($input['trustedDeviceTimeOut'])) {
            $trustedTTL = new TrustedTTLValue($input['trustedDeviceTimeOut']);
            $new_input['trustedDeviceTimeOut'] = (string)$trustedTTL;
        }

        if (isset($input['apiCodeLength'])) {
            $codeLength = new APICodeLengthValue($input['apiCodeLength']);
            $new_input['apiCodeLength'] = (string)$codeLength;
        }

        if (isset($input['apiCodeType'])) {
            $codeType = new APICodeTypeValue($input['apiCodeType']);
            $new_input['apiCodeType'] = (string)$codeType;
        }

        if (isset($input['apiCaseSensitive'])) {
            $codeCaseSensitive = new APICodeCaseSensitiveValue($input['apiCaseSensitive']);
            $new_input['apiCaseSensitive'] = (string)$codeCaseSensitive;
        }

        if (isset($input['apiCallbackUrl'])) {
            $apiCallbackUrl = new APICallBackUrlValue($input['apiCallbackUrl']);
            $new_input['apiCallbackUrl'] = (string)$apiCallbackUrl;
        }

        if (isset($input['apiSenderId'])) {
            $apiSenderId = new APICustomSenderIDValue($input['apiSenderId']);
            $new_input['apiSenderId'] = (string)$apiSenderId;
        }
        return $new_input;
    }
}
