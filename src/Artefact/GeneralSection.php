<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\ArtefactAbstract;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\SectionInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\TokenValue;

/**
 * Implement SectionInterface for the General section
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class GeneralSection extends ArtefactAbstract implements SectionInterface
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
        $token = new TokenValue();

        printf(
            '<input type="text" id="tokenNumber" name="fortytwo2fa[tokenNumber]" value="%s" />',
            isset($token) ? esc_attr($token) : ''
        );
    }
}
