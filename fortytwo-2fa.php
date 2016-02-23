<?php
/*
Plugin Name: Fortytwo-2FA
Plugin URI: https://www.fortytwo.com
Description: Implement the fortytwo 2FA service for login and register on wordpress.
Version: 1.0.0
Author: Sebastien Lemarinel <sebastien.lemarinel@fortytwo.com>
Author URI: https://www.fortytwo.com
License: GPL2
*/

spl_autoload_register('fortytwo_autoload');

function fortytwo_autoload($class) {

    $prefix = 'Fortytwo\\TwoFactorAuthentication\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}

$TwoFactorAuth = new Fortytwo\TwoFactorAuthentication\TwoFactorAuthentication();
add_filter( 'wp_authenticate_user', array( $TwoFactorAuth, 'HookAuthentication' ) );
