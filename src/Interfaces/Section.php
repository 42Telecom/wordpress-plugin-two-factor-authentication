<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces;

/**
 * Define the section interface.
 */
interface Section
{
    /**
     * Add section in the wordpress admin page
     *
     * @param $id Identificator of the section
     * @param $name Name of the section
     *
     * @return the current instance
     */
    public function add();

    /**
     * Print the description above the title
     */
    public function description();
}
