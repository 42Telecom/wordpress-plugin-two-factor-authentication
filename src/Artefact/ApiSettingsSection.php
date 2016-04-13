<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\SectionInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeLengthValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeTypeValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICustomSenderIDValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICodeCaseSensitiveValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\APICallBackUrlValue;

/**
 * Implement SectionInterface for the API Settings
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class ApiSettingsSection implements SectionInterface
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
        $codeLength = new APICodeLengthValue();

        $html = '<select id="apiCodeLength" name="fortytwo2fa[apiCodeLength]" >';
        foreach ($codeLength->getOptions() as $value) {
            if ($codeLength == $value) {
                $html.= '<option selected="selecte" value="' . $value . '" >' . $value . '</option>';
            } else {
                $html.= '<option value="' . $value . '" >' . $value . '</option>';
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
        $codeType = new APICodeTypeValue();

        $html = '<select id="apiCodeType" name="fortytwo2fa[apiCodeType]" >';

        foreach ($codeType->getOptions() as $value) {
            if ((string)$codeType == $value) {
                $html.= '<option selected="selecte" value="' . $value . '" >' . $value . '</option>';
            } else {
                $html.= '<option value="' . $value . '" >' . $value . '</option>';
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
        $codeCaseSensitive = new APICodeCaseSensitiveValue();

        $html = '<select id="apiCodeType" name="fortytwo2fa[apiCaseSensitive]" >';
        if ((string)$codeCaseSensitive == 'true') {
            $html.= '<option value="true" selected="selected" >Yes</option>';
            $html.= '<option value="false" >No</option>';
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
        $callbackurl = new APICallBackUrlValue();

        printf(
            '<input type="text" id="apiCallbackUrl" name="fortytwo2fa[apiCallbackUrl]" value="%s" />',
            $callbackurl
        );
    }

    /**
     * API Sender ID.
     */
    public function apiSenderIdCallback()
    {
        $senderID = new APICustomSenderIDValue();

        printf(
            '<input type="text" id="apiSenderId" name="fortytwo2fa[apiSenderId]" value="%s" />
            <br>
            <small>Only Alphanumeric and numeric are accepted. Max characters for numeric is 15 & alphanumeric is 11.</small>',
            $senderID
        );
    }
}
