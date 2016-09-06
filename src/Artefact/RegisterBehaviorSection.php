<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\ArtefactAbstract;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\SectionInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\RegisterStateValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\RegisterMandatoryValue;

/**
 * Implement SectionInterface for the Register behavior
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class RegisterBehaviorSection extends ArtefactAbstract implements SectionInterface
{
    /**
     * @inheritDoc
     */
    public function add()
    {
        // Login Behavior section
        add_settings_section(
            'RegisterBehaviorSection',
            'Register Behavior',
            array($this, 'description'),
            'fortytwo-2fa-admin'
        );

        // Options for register behavior section
        // Activate/Disable 2FA on register
        add_settings_field(
            'twoFactorOnRegister',
            'Activate/disable 2FA on Register:',
            array($this, 'twoFactorOnRegisterCallback'),
            'fortytwo-2fa-admin',
            'RegisterBehaviorSection'
        );

        // 2FA Mandatory on register
        add_settings_field(
            'twoFactorOnRegisterMandatory',
            '2FA on Register is mandatory:',
            array($this, 'twoFactorOnRegisterMandatoryCallback'),
            'fortytwo-2fa-admin',
            'RegisterBehaviorSection'
        );
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        echo 'You can configure the behavior of the plugin on register here:';
    }

    /**
     * Show select to activate or disabled the plugin on Register
     */
    public function twoFactorOnRegisterCallback()
    {
        echo $this->select(new RegisterStateValue());
    }

    /**
     * Show select to set 2FA as mandatory or not on Register.
     */
    public function twoFactorOnRegisterMandatoryCallback()
    {
        echo $this->select(new RegisterMandatoryValue());
    }
}
