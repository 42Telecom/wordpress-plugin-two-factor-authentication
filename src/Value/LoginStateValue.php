<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for the Login state Value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class LoginStateValue extends AbstractCollectionValue implements ValueInterface
{
    /**
     * @inheritDoc
     */
    protected $collection = array('activated' => 'Activated', 'disabled' => 'Disabled');

    /**
     * @inheritDoc
     */
    protected $value = 'activated';

    /**
     * @inheritDoc
     */
    protected $fieldName = '2FA On Login';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'twoFactorOnLogin';

    /**
     * True if the field is in the active state or false if is not.
     *
     * @return bool Status : true = activated, false = disabled
     */
    public function isActive()
    {
        if ($this->value == 'activated') {
            return true;
        } else {
            return false;
        }
    }
}
