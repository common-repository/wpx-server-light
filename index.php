<?php

/**
 * Plugin Name: WPX Server Light
 * Plugin URI: http://undolog.com
 * Description: Display and manage your website server.
 * Version: 2.2.0
 * Author: Giovambattista Fazioli
 * Author URI: http://undolog.com
 * Text Domain: wpx-server-light
 * Domain Path: localization
 *
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/
use WPXServerLight\WPBones\Foundation\Plugin;

require_once __DIR__ . '/bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap the plugin
|--------------------------------------------------------------------------
|
| We need to bootstrap the plugin.
|
*/

// comodity define for text domain
define('WPXSERVERLIGHT_TEXTDOMAIN', 'wpx-server-light');

$GLOBALS[ 'WPXServerLight' ] = require_once __DIR__ . '/bootstrap/plugin.php';

if (! function_exists('WPXServerLight')) {

  /**
   * Return the instance of plugin.
   *
   * @return Plugin
   */
    function WPXServerLight()
    {
        return $GLOBALS[ 'WPXServerLight' ];
    }
}
