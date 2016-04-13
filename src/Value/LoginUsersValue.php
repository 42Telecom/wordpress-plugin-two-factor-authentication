<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractValue;

/**
 * Class for the Users Value on login.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class LoginUsersValue extends AbstractValue implements ValueInterface
{
    /**
     * @inheritDoc
     */
    protected $fieldName = '2FA active by role';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'twoFactorByRole';

    /**
     * @inheritDoc
     */
    public function __construct($value = false)
    {
        if ($value) {
            $this->roles = $value;
        } else {
            $options = get_option('fortytwo2fa');

            if (isset($options[$this->fieldId])) {
                $this->roles = $options[$this->fieldId];
            }
        }
    }

    /**
     * Get the roles saved.
     *
     * @return array list of selected roles.
     */
    public function getValues()
    {
        return $this->roles;
    }
}
