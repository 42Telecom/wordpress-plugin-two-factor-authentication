<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for the Register State value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class RegisterStateValue extends AbstractCollectionValue implements ValueInterface
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
    protected $fieldName = '2FA On Register';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'twoFactorOnRegister';
}
