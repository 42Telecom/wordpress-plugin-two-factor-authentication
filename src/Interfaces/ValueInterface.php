<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces;

/**
 * Define the Value object interface.
 */
interface ValueInterface
{
    /**
     * Constructor used to set the value object.
     *
     * @param mixed $value Value to set
     */
    public function __construct($value);

    /**
     * Return the value of the object.
     *
     * @return mixed value of the object
     */
    public function __toString();
}
