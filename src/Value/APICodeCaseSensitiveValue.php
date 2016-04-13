<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractCollectionValue;

/**
 * Class for API Code case sensitive value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class APICodeCaseSensitiveValue extends AbstractCollectionValue implements ValueInterface
{

    /**
     * @inheritDoc
     */
    protected $collection = array('false', 'true');

    /**
     * @inheritDoc
     */
    protected $value = 'false';

    /**
     * @inheritDoc
     */
    protected $fieldName = 'API Code case sensitive';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'apiCaseSensitive';
}
