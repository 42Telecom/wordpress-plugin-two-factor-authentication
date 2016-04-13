<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\SectionInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\RegisterStateValue;

/**
 * Implement SectionInterface for the Register behavior
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class RegisterBehaviorSection implements SectionInterface
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
        $state = new RegisterStateValue();

        $html = '<select id="twoFactorOnRegister" name="fortytwo2fa[twoFactorOnRegister]" >';
        if ((string)$state == 'activated') {
            $html.= '<option selected="selected" value="activated">Activated</option>';
            $html.= '<option value="disabled">Disabled</option>';
        } else {
            $html.= '<option value="activated">Activated</option>';
            $html.= '<option selected="selected" value="disabled">Disabled</option>';
        }
        $html.= '</select>';
        echo $html;
    }
}
