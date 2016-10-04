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
    protected $collection = array(
        '10' => '10 Days',
        '20' => '20 Days',
        '30' => '30 Days',
        '40' => '40 Days',
        '50' => '50 Days',
        '60' => '60 Days'
    );

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
