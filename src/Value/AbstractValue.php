<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;

/**
 * Abstract class for the values.
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

    /**
     * Return the value of the object.
     *
     * @return mixed value of the object
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Return the field name.
     *
     * @return string Field name.
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Return the field id.
     *
     * @return string Field id.
     */
    public function getFieldId()
    {
        return $this->fieldId;
    }
}
