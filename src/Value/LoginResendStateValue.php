<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

class LoginResendStateValue extends AbstractCollectionValue implements ValueInterface
{
    /**
     * @inheritDoc
     */
    protected $collection = array('yes', 'no');

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
}
