<?php

/*
Plugin Name: Fortytwo - Two Factor Authentication plugin
Plugin URI: https://www.fortytwo.com
Description: Implement the fortytwo Two Factor Authentication service for login and register on wordpress.
Version: 1.0.0-RC10
Author: Sebastien Lemarinel <sebastien.lemarinel@fortytwo.com>
Author URI: https://www.fortytwo.com
License: GPL2
*/

// Load the composer autoload
require dirname(__FILE__) . '/vendor/autoload.php';

// Workaround for the Doctrine annotation
Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    dirname(__FILE__) . "/vendor/jms/serializer/src"
);

new Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller\Login();
new Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller\Admin();
new Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller\UserProfile();
new Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Controller\Register();
