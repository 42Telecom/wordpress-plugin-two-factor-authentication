<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for the Trusted state Value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TrustedStateValue extends AbstractCollectionValue implements ValueInterface
{
    /**
     * @inheritDoc
     */
    protected $collection = array('activated', 'disabled');

    /**
     * @inheritDoc
     */
    protected $value = 'activated';

    /**
     * @inheritDoc
     */
    protected $fieldName = 'Trusted device';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'trustedDeviceOption';

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
