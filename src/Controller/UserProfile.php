<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils\TemplateEngine;

/**
 * Set the user profile UI and logic
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class UserProfile extends AbstractAuth
{
    /**
     * Contructor - Set actions for wordpres.
     * - Show phone field in User profile and in edit user profile
     * - Save phone field on save.
     */
    public function __construct()
    {
        // Actions when user is login
        add_action('show_user_profile', array($this, 'addTwoFactorSection'), 10, 2);
        add_action('edit_user_profile', array($this, 'addTwoFactorSection'), 10, 2);
        add_action('personal_options_update', array($this, 'savePhoneNumber'), 10, 2);
        add_action('edit_user_profile_update', array($this, 'savePhoneNumber'), 10, 2);
    }

    /**
     * Add phone field in the user profile sections
     *
     * @param $user get an user object from wordpress
     *
     */
    public function addTwoFactorSection($user)
    {
        $phoneValue = esc_attr(get_user_option('2faPhone', $user->ID));

        echo TemplateEngine::render(
            'UserEditForm.html',
            array(
                'phoneValue'    => $phoneValue,
            )
        );
    }
}
