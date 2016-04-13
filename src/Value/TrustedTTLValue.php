<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for the Trusted device TTL cookie Value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TrustedTTLValue extends AbstractCollectionValue implements ValueInterface
{
    /**
     * @inheritDoc
     */
    protected $collection = array('10', '20', '30', '40', '50', '60');

    /**
     * @inheritDoc
     */
    protected $value = '30';

    /**
     * @inheritDoc
     */
    protected $fieldName = 'Trusted device time out';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'trustedDeviceTimeOut';
}
