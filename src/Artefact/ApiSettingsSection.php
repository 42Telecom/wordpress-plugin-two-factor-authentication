<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\Section;

/**
 * Implement Section for the API Settings
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class ApiSettingsSection implements Section
{
    /**
     * @inheritDoc
     */
    public function add()
    {
        // API Settings
        add_settings_section(
            'ApiSettingsSection',
            'API Settings',
            array($this, 'description'),
            'fortytwo-2fa-admin'
        );

        // Options for API settings
        // Code length
        add_settings_field(
            'apiCodeLength',
            'Code length:',
            array($this, 'apiCodeLengthCallback'),
            'fortytwo-2fa-admin',
            'ApiSettingsSection'
        );
        // Code length
        add_settings_field(
            'apiCodeType',
            'Code type:',
            array($this, 'apiCodeTypeCallback'),
            'fortytwo-2fa-admin',
            'ApiSettingsSection'
        );
        // Case sensitive
        add_settings_field(
            'apiCaseSensitive',
            'Code input case sensitive:',
            array($this, 'apiCaseSensitiveCallback'),
            'fortytwo-2fa-admin',
            'ApiSettingsSection'
        );
        // Callback url
        add_settings_field(
            'apiCallbackUrl',
            'Call back url:',
            array($this, 'apiCallbackUrlCallback'),
            'fortytwo-2fa-admin',
            'ApiSettingsSection'
        );
        // Api Sender url
        add_settings_field(
            'apiSenderId',
            'Custom sender ID:',
            array($this, 'apiSenderIdCallback'),
            'fortytwo-2fa-admin',
            'ApiSettingsSection'
        );
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        echo 'You can configure the API settings for <a href="https://www.fortytwo.com/apis/two-factor-authentication/request-code/">request code</a>:';
    }

    /**
     * API Code Length
     */
    public function apiCodeLengthCallback()
    {
        $options = get_option('fortytwo2fa');

        $html = '<select id="apiCodeLength" name="fortytwo2fa[apiCodeLength]" >';
        for ($i=6; $i<=20; $i++) {
            if (isset($options['apiCodeLength'])) {
                if ($options['apiCodeLength'] == $i) {
                    $html.= '<option selected="selecte" value="' . $i . '" >' . $i . '</option>';
                } else {
                    $html.= '<option value="' . $i . '" >' . $i . '</option>';
                }
            } else {
                if ($i == 6) {
                    $html.= '<option selected="selecte"  value="' . $i . '" >' . $i . '</option>';
                } else {
                    $html.= '<option value="' . $i . '" >' . $i . '</option>';
                }
            }
        }
        $html.= '</select>';
        echo $html;
    }

    /**
     * API Code Type
     */
    public function apiCodeTypeCallback()
    {
        $options = get_option('fortytwo2fa');

        $html = '<select id="apiCodeType" name="fortytwo2fa[apiCodeType]" >';

        $codeTypes = ['numeric', 'alpha', 'alphanumeric'];

        foreach ($codeTypes as $value) {
            if (isset($options['apiCodeType'])) {
                if ($options['apiCodeType'] == $value) {
                    $html.= '<option selected="selecte" value="' . $value . '" >' . $value . '</option>';
                } else {
                    $html.= '<option value="' . $value . '" >' . $value . '</option>';
                }
            } else {
                if ($value == 'numeric') {
                    $html.= '<option selected="selecte"  value="' . $value . '" >' . $value . '</option>';
                } else {
                    $html.= '<option value="' . $value . '" >' . $value . '</option>';
                }
            }
        }
        $html.= '</select>';
        echo $html;
    }

    /**
     * API Case Sensitive
     */
    public function apiCaseSensitiveCallback()
    {
        $options = get_option('fortytwo2fa');

        $html = '<select id="apiCodeType" name="fortytwo2fa[apiCaseSensitive]" >';
        if (isset($options['apiCaseSensitive'])) {
            if ($options['apiCaseSensitive'] == 'true') {
                $html.= '<option value="true" selected="selected" >Yes</option>';
                $html.= '<option value="false" >No</option>';
            } else {
                $html.= '<option value="true" >Yes</option>';
                $html.= '<option value="false" selected="selected" >No</option>';
            }
        } else {
            $html.= '<option value="true" >Yes</option>';
            $html.= '<option value="false" selected="selected" >No</option>';
        }

        $html.= '</select>';
        echo $html;
    }

    /**
     * API Callbakc URL
     */
    public function apiCallbackUrlCallback()
    {
        $options = get_option('fortytwo2fa');

        printf(
            '<input type="text" id="apiCallbackUrl" name="fortytwo2fa[apiCallbackUrl]" value="%s" />',
            isset($options['apiCallbackUrl']) ? esc_attr($options['apiCallbackUrl']) : ''
        );
    }

    /**
     * API Sender ID.
     */
    public function apiSenderIdCallback()
    {
        $options = get_option('fortytwo2fa');

        printf(
            '<input type="text" id="apiSenderId" name="fortytwo2fa[apiSenderId]" value="%s" />',
            isset($options['apiSenderId']) ? esc_attr($options['apiSenderId']) : ''
        );
    }
}
