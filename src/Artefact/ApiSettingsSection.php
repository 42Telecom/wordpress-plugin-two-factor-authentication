<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\ArtefactAbstract;
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
class ApiSettingsSection extends ArtefactAbstract implements SectionInterface
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
            'Callback url:',
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
        echo $this->select(new APICodeLengthValue());
    }

    /**
     * API Code Type
     */
    public function apiCodeTypeCallback()
    {
        echo $this->select(new APICodeTypeValue());
    }

    /**
     * API Case Sensitive
     */
    public function apiCaseSensitiveCallback()
    {
        echo $this->select(new APICodeCaseSensitiveValue());
    }

    /**
     * API Callbakc URL
     */
    public function apiCallbackUrlCallback()
    {
        $callbackurl = new APICallBackUrlValue();

        printf(
            '<input type="text" id="apiCallbackUrl" name="fortytwo2fa[apiCallbackUrl]" value="%s" />',
            (string)$callbackurl
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
            (string)$senderID
        );
    }
}
