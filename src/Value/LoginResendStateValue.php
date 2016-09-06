<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for the Login Resend SMS Value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class LoginResendStateValue extends AbstractCollectionValue implements ValueInterface
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
    protected $fieldName = 'Login SMS Resend';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'smsResend';

    /**
     * True if the field is in the active state or false if is not.
     *
     * @return bool Status : true = activated, false = disabled
     */
    public function isActive()
    {
        if ($this->value == 'yes') {
            return true;
        } else {
            return false;
        }
    }
}
