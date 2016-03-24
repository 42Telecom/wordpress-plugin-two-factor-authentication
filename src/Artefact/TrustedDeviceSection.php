<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\Section;

/**
 * Implement Section for the Trusted devices
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TrustedDeviceSection implements Section
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
        $options = get_option('fortytwo2fa');

        $html = '<select id="trustedDeviceOption" name="fortytwo2fa[trustedDeviceOption]" >';
        if (isset($options['trustedDeviceOption'])) {
            if ($options['trustedDeviceOption'] == 'activated') {
                $html.= '<option selected="selected" value="activated">Activated</option>';
                $html.= '<option value="Disabled">Disabled</option>';
            } else {
                $html.= '<option value="activated">Activated</option>';
                $html.= '<option selected="selected" value="Disabled">Disabled</option>';
            }
        } else {
            $html.= '<option selected="selected" value="activated">Activated</option>';
            $html.= '<option value="Disabled">Disabled</option>';
        }
        $html.= '</select>';
        echo $html;
    }

    /**
     * Show Trusted Device Timeout or TimetoLive Select
     */
    public function trustedDeviceTimeOutCallback()
    {
        $options = get_option('fortytwo2fa');

        $html = '<select id="trustedDeviceTimeOut" name="fortytwo2fa[trustedDeviceTimeOut]" >';
        for ($i=10; $i<=60; $i+=10) {
            if (isset($options['trustedDeviceTimeOut'])) {
                if ($options['trustedDeviceTimeOut'] == $i) {
                    $html.= '<option selected="selecte" value="' . $i . '" >' . $i . ' days</option>';
                } else {
                    $html.= '<option value="' . $i . '" >' . $i . ' days</option>';
                }
            } else {
                if ($i == 6) {
                    $html.= '<option selected="selecte"  value="' . $i . '" >' . $i . ' days</option>';
                } else {
                    $html.= '<option value="' . $i . '" >' . $i . ' days</option>';
                }
            }
        }
        $html.= '</select>';
        echo $html;
    }
}
