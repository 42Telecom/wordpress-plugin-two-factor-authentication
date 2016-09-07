<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\ArtefactAbstract;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\SectionInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginUsersValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginStateValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginMandatoryValue;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\LoginResendStateValue;

/**
 * Implement SectionInterface for the Login Behavior
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class LoginBehaviorSection extends ArtefactAbstract implements SectionInterface
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

        add_settings_field(
            'twoFactorOnLoginMandatory',
            '2FA on Login is mandatory:',
            array($this, 'twoFactorOnLoginMandatoryCallback'),
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
        echo $this->select(new LoginStateValue());
    }

    /**
     * Select to have the 2FA mandatory on login.
     */
    public function twoFactorOnLoginMandatoryCallback()
    {
        echo $this->select(new LoginMandatoryValue());
    }

    /**
     * Select to activate or disabled the resend option
     */
    public function resendSMSCallback()
    {
        echo $this->select(new LoginResendStateValue());
    }

    /**
     * multi-Select to choose which type of user can use the plugin
     */
    public function twoFactorByRoleCallback()
    {
        $rolesObj = new LoginUsersValue();
        $roles = $rolesObj->getValue();
        $html ='<select  id="twoFactorByRole" name="fortytwo2fa[twoFactorByRole][]"  size="5" multiple>';
        $select = '';

        $editable_roles = array_reverse(get_editable_roles());
        if (count($roles) > 0) {
            foreach ($editable_roles as $role => $details) {
                $name = translate_user_role($details['name']);
                if (in_array($role, $roles)) {
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
