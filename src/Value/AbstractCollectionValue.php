<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractValue;

/**
 * Abstract class for the Collection values.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
abstract class AbstractCollectionValue extends AbstractValue implements ValueInterface
{
    /**
     * @var array
     */
    protected $collection = array();

    /**
     * @inheritDoc
     */
    public function __construct($value = false)
    {
        if ($value) {
            if (in_array($value, array_flip($this->collection))) {
                $this->value = $value;
            } else {
                add_settings_error(
                    'fortytwo2fa',
                    esc_attr($this->fieldId),
                    'Wrong ' . $this->fieldName . ' option: ' . $value,
                    'error'
                );
            }
        } else {
            $options = get_option('fortytwo2fa');

            if (isset($options[$this->fieldId])) {
                $this->value = $options[$this->fieldId];
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return $this->collection;
    }
}
