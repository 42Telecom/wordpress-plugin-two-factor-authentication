<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\Section;

/**
 * Implement Section for the Register behavior
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class RegisterBehaviorSection implements Section
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
            'Activate/disable 2FA on Regsiter:',
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
        $options = get_option('fortytwo2fa');

        $html = '<select id="twoFactorOnRegister" name="fortytwo2fa[twoFactorOnRegister]" >';
        if (isset($options['twoFactorOnRegister'])) {
            if ($options['twoFactorOnRegister'] == 'activated') {
                $html.= '<option selected="selected" value="activated">Activated</option>';
                $html.= '<option value="disabled">Disabled</option>';
            } else {
                $html.= '<option value="activated">Activated</option>';
                $html.= '<option selected="selected" value="disabled">Disabled</option>';
            }
        } else {
            $html.= '<option selected="selected" value="activated">Activated</option>';
            $html.= '<option value="disabled">Disabled</option>';
        }
        $html.= '</select>';
        echo $html;
    }
}
