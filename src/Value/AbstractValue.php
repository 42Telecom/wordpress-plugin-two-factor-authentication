<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;

/**
 * Abstract class for the State values.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
abstract class AbstractValue
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $fieldName;
    /**
     * @var string
     */
    protected $fieldId;

    /**
     * Return the value of the object.
     *
     * @return mixed value of the object
     */
    public function __toString()
    {
        return $this->value;
    }
}
