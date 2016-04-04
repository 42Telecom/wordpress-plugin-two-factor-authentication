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

        // Enqueue Script and Styles
        // Enqueue css
        add_action('admin_enqueue_scripts', array($this, 'loadCss'), 10);
        // Enqueue javascript
        add_action('admin_enqueue_scripts', array($this, 'loadJavascript'), 1);
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

    /**
     * Register the needed css files for the plugin on edit profile
     */
    public function loadCss($hook)
    {
        if ($hook != 'profile.php') {
            return;
        }

        wp_register_style(
            'fortytwo_two_factor_style_intl',
            plugin_dir_url(__FILE__) . '../Css/intlTelInput.css',
            false,
            '1.0.0'
        );
        wp_register_style(
            'fortytwo_two_factor_style_plugin',
            plugin_dir_url(__FILE__) . '../Css/plugin.css',
            false,
            '1.0.0'
        );
        wp_enqueue_style('fortytwo_two_factor_style_intl');
        wp_enqueue_style('fortytwo_two_factor_style_plugin');
    }

    /**
     * Register the needed javascripts files for the plugin on edit profile
     */
    public function loadJavascript($hook)
    {
        if ($hook != 'profile.php') {
            return;
        }

        wp_enqueue_script(
            'fortytwo_two_factor_javascript_intlTelInput',
            plugin_dir_url(__FILE__) . '../Javascript/intlTelInput.min.js'
        );
        wp_enqueue_script(
            'fortytwo_two_factor_javascript_utils',
            plugin_dir_url(__FILE__) . '../Javascript/utils.js'
        );
        wp_enqueue_script(
            'fortytwo_two_factor_javascript_plugin',
            plugin_dir_url(__FILE__) . '../Javascript/plugin.js'
        );
    }
}
