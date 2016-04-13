<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for API Code length value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class APICodeLengthValue extends AbstractCollectionValue implements ValueInterface
{

    /**
     * @inheritDoc
     */
    protected $collection = array('6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20');

    /**
     * @inheritDoc
     */
    protected $value = '6';

    /**
     * @inheritDoc
     */
    protected $fieldName = 'API Code Length';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'apiCodeLength';
}
