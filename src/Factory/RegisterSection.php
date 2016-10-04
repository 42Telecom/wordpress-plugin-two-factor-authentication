<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Factory;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\ApiSettingsSection;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\GeneralSection;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\LoginBehaviorSection;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\RegisterBehaviorSection;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Artefact\TrustedDeviceSection;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\Section;

/**
 * Factory - Instantiate RegisterSection classes
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class RegisterSection
{
    /**
     * Create a RegisterSection object
     *
     * @param string $type Type of Section to create
     *
     * @return Section interface
     */
    public static function get($type)
    {
        $instance = null;

        switch ($type) {

            case 'ApiSettingsSection':
                $instance = new ApiSettingsSection();
                break;

            case 'GeneralSection':
                $instance = new GeneralSection();
                break;

            case 'LoginBehaviorSection':
                $instance = new LoginBehaviorSection();
                break;

            case 'RegisterBehaviorSection':
                $instance = new RegisterBehaviorSection();
                break;

            case 'TrustedDeviceSection':
                $instance = new TrustedDeviceSection();
                break;

            default:
                throw new \Exception("Bad Section definition.", 1);
        }

        return $instance;
    }
}
