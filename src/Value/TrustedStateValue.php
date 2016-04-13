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
}
