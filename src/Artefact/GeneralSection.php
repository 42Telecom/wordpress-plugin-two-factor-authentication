<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\Section;

/**
 * Implement Section for the General section
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class GeneralSection implements Section
{
    /**
     * @inheritDoc
     */
    public function add()
    {
        // Add the General section
        add_settings_section(
            'GeneralSection',
            'General',
            array($this, 'description'),
            'fortytwo-2fa-admin'
        );

        // Options for General section
        add_settings_field(
            'tokenNumber',
            'Your Token:',
            array($this, 'tokenCallback'),
            'fortytwo-2fa-admin',
            'GeneralSection'
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        echo 'Enter your <a href="https://controlpanel.fortytwo.com/">Fortytwo</a> Token below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function tokenCallback()
    {
        $options = get_option('fortytwo2fa');

        printf(
            '<input type="text" id="tokenNumber" name="fortytwo2fa[tokenNumber]" value="%s" />',
            isset($options['tokenNumber']) ? esc_attr($options['tokenNumber']) : ''
        );
    }
}
