<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\Section;

/**
 * Implement Section for the Login Behavior
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class LoginBehaviorSection implements Section
{
    /**
     * @inheritDoc
     */
    public function add()
    {
        // Login Behavior section
        add_settings_section(
            'LoginBehaviorSection',
            'Login Behavior',
            array($this, 'description'),
            'fortytwo-2fa-admin'
        );

        // Options for login behavior section
        // Activate/Disable 2FA on Login
        add_settings_field(
            'twoFactorOnLogin',
            'Activate/disable 2FA on Login:',
            array($this, 'twoFactorOnLoginCallback'),
            'fortytwo-2fa-admin',
            'LoginBehaviorSection'
        );

        // Resend SMS
        add_settings_field(
            'smsResend',
            'Resend code option:
            <br><small style="font-weight:normal;">This give possbility for the user to resend the
            activation code after 60 seconds.</small>',
            array($this, 'resendSMSCallback'),
            'fortytwo-2fa-admin',
            'LoginBehaviorSection'
        );

        // Define with wich roles the 2FA is active
        add_settings_field(
            'twoFactorByRole',
            'Active 2FA by user roles:',
            array($this, 'twoFactorByRoleCallback'),
            'fortytwo-2fa-admin',
            'LoginBehaviorSection'
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        echo 'You can configure the behavior of the plugin on login here:';
    }


    /**
     * Select to activate or disabled the plugin on login
     */
    public function twoFactorOnLoginCallback()
    {
        $options = get_option('fortytwo2fa');

        $html = '<select id="twoFactorOnLogin" name="fortytwo2fa[twoFactorOnLogin]" >';
        if (isset($options['twoFactorOnLogin'])) {
            if ($options['twoFactorOnLogin'] == 'activated') {
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
     * Select to activate or disabled the resend option
     */
    public function resendSMSCallback()
    {
        $options = get_option('fortytwo2fa');

        $html = '<select id="smsResend" name="fortytwo2fa[smsResend]" >';
        if (isset($options['smsResend'])) {
            if ($options['smsResend'] == 'yes') {
                $html.= '<option selected="selected" value="yes">Yes</option>';
                $html.= '<option value="no">No</option>';
            } else {
                $html.= '<option value="yes">Yes</option>';
                $html.= '<option selected="selected" value="no">No</option>';
            }
        } else {
            $html.= '<option selected="selected" value="yes">Yes</option>';
            $html.= '<option value="no">No</option>';
        }
        $html.= '</select>';
        echo $html;
    }

    /**
     * multi-Select to choose which type of user can use the plugin
     */
    public function twoFactorByRoleCallback()
    {
        $options = get_option('fortytwo2fa');

        $html ='<select  id="twoFactorByRole" name="fortytwo2fa[twoFactorByRole][]"  size="5" multiple>';
        $select = '';

        $editable_roles = array_reverse(get_editable_roles());
        if (isset($options['twoFactorByRole'])) {
            foreach ($editable_roles as $role => $details) {
                $name = translate_user_role($details['name']);
                if (in_array($role, $options['twoFactorByRole'])) {
                    $select .= '<option selected="selected" value="' . esc_attr($role) . '"> ' . $name . '</option>';
                } else {
                    $select .= '<option value="' . esc_attr($role) . '">' . $name . '</option>';
                }
            }
        } else {
            foreach ($editable_roles as $role => $details) {
                $name = translate_user_role($details['name']);
                $select .= '<option selected="selected" value="' . esc_attr($role) . '"> ' . $name . '</option>';
            }
        }

        $html.= $select;

        $html.='</select>';

        echo $html;
    }
}
