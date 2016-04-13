<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for API Code type value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class APICodeTypeValue extends AbstractCollectionValue implements ValueInterface
{

    /**
     * @inheritDoc
     */
    protected $collection = array('numeric', 'alpha', 'alphanumeric');

    /**
     * @inheritDoc
     */
    protected $value = 'numeric';

    /**
     * @inheritDoc
     */
    protected $fieldName = 'API Code type';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'apiCodeType';
}
