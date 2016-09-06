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
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginMandatoryValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\RegisterMandatoryValue;

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

    /**
     * Map the list of fields used in the admin.
     *
     * @return array Name of value oject used as fields.
     */
    public function fieldMapping()
    {
        $fieldMap = array(
            'TokenValue',
            'LoginStateValue',
            'LoginMandatoryValue',
            'LoginResendStateValue',
            'LoginUsersValue',
            'RegisterStateValue',
            'RegisterMandatoryValue',
            'TrustedStateValue',
            'TrustedTTLValue',
            'APICodeLengthValue',
            'APICodeTypeValue',
            'APICodeCaseSensitiveValue',
            'APICallBackUrlValue',
            'APICustomSenderIDValue'
        );

        return $fieldMap;
    }

    public function sanitize($input)
    {
        $new_input = array();

        foreach ($fieldMap as $field) {
            if (isset($input[$field::getFieldId()])) {
                $value = new $field($input[$field::getFieldId()]);
                $new_input[$field::getFieldId()] = $value;
            }
        }

        return $new_input;
    }
}
