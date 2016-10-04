<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\ArtefactAbstract;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\SectionInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedTTLValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TrustedStateValue;

/**
 * Implement SectionInterface for the Trusted devices
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TrustedDeviceSection extends ArtefactAbstract implements SectionInterface
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
        echo $this->select(new TrustedStateValue());
    }

    /**
     * Show Trusted Device Timeout or TimetoLive Select
     */
    public function trustedDeviceTimeOutCallback()
    {
        echo $this->select(new TrustedTTLValue());
    }
}
