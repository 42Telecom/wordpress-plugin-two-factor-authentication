<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Factory\RegisterSection;

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
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TokenValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginStateValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginMandatoryValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginResendStateValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginUsersValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\RegisterStateValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\RegisterMandatoryValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedStateValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedTTLValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeLengthValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeTypeValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeCaseSensitiveValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICallBackUrlValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICustomSenderIDValue',
            '\Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APITemplateMessageValue'
        );

        return $fieldMap;
    }

    public function sanitize($input)
    {
        $newInput = array();

        foreach ($this->fieldMapping() as $field) {
            $obj = new $field();
            $fieldId = (string)$obj->getFieldId();

            if (isset($input[$fieldId])) {
                $valueObj = new $field($input[$fieldId]);
                $newInput[$fieldId] = $valueObj->getValue();
            }
        }
        return $newInput;
    }
}
