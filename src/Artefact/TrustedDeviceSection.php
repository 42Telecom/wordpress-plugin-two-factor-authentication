<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\SectionInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedTTLValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedStateValue;

/**
 * Implement SectionInterface for the Trusted devices
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TrustedDeviceSection implements SectionInterface
{
    /**
     * @inheritDoc
     */
    public function add()
    {
        // Trusted devices
        add_settings_section(
            'TrustedDeviceSection',
            'Trusted Device behavior',
            array($this, 'description'),
            'fortytwo-2fa-admin'
        );

        // Options for activate trusted device option
        add_settings_field(
            'trustedDeviceOption',
            'Activate/Disable Trusted device:',
            array($this, 'trustedDeviceOptionCallback'),
            'fortytwo-2fa-admin',
            'TrustedDeviceSection'
        );

        // Define timeout for the trusted device
        add_settings_field(
            'trustedDeviceTimeOut',
            'A device is trusted during:',
            array($this, 'trustedDeviceTimeOutCallback'),
            'fortytwo-2fa-admin',
            'TrustedDeviceSection'
        );
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        echo 'After the first login with 2FA, users can add their device as
        "trusted device", so they don\'t have to pass trougth the 2FA process
        at each login.';
    }

    /**
     * Show Trusted Device Select
     */
    public function trustedDeviceOptionCallback()
    {
        $trustedState = new TrustedStateValue();

        $html = '<select id="trustedDeviceOption" name="fortytwo2fa[trustedDeviceOption]" >';

        if ((string)$trustedState == 'activated') {
            $html.= '<option selected="selected" value="activated">Activated</option>';
            $html.= '<option value="disabled">Disabled</option>';
        } else {
            $html.= '<option value="activated">Activated</option>';
            $html.= '<option selected="selected" value="disabled">Disabled</option>';
        }
        $html.= '</select>';
        echo $html;
    }

    /**
     * Show Trusted Device Timeout or TimetoLive Select
     */
    public function trustedDeviceTimeOutCallback()
    {
        $trustedTTL = new TrustedTTLValue;

        $html = '<select id="trustedDeviceTimeOut" name="fortytwo2fa[trustedDeviceTimeOut]" >';
        foreach ($trustedTTL->getOptions() as $value) {
            if ((string)$trustedTTL == $value) {
                $html.= '<option selected="selecte" value="' . $value . '" >' . $value . ' days</option>';
            } else {
                $html.= '<option value="' . $value . '" >' . $value . ' days</option>';
            }
        }
        $html.= '</select>';
        echo $html;
    }
}
