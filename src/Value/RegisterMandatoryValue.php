<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for the Register 2FA Mandatory value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class RegisterMandatoryValue extends AbstractCollectionValue implements ValueInterface
{
    /**
     * @inheritDoc
     */
    protected $collection = array('yes' => 'Yes', 'no' => 'No');

    /**
     * @inheritDoc
     */
    protected $value = 'yes';

    /**
     * @inheritDoc
     */
    protected $fieldName = '2FA is mandatory';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'twoFactorOnRegisterMandatory';

    /**
     * True if 2FA on Register is marked as mandatory state or false if is not.
     *
     * @return bool Status : true = mandatory, false = optional
     */
    public function isMandatory()
    {
        if ($this->value == 'yes') {
            return true;
        } else {
            return false;
        }
    }
}
