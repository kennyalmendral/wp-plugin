<?php
/*
Plugin Name: WP Plugin
Plugin URI: http://github.com/kennyalmendral/wp-plugin
Description: Just another WordPress plugin boilerplate.
Version: 1.0.0
Author: Kenny Almendral
Author URI: http://github.com/kennyalmendral
*/

if ( ! defined('WPINC'))
	die();

define('WP_PLUGIN_ROOT_PATH', get_site_url());
define('WP_PLUGIN_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WP_PLUGIN_VIEWS_PATH', WP_PLUGIN_PLUGIN_PATH . 'views/');

define('WP_PLUGIN_VENDORS_PATH', WP_PLUGIN_PLUGIN_PATH . 'vendors/');
define('WP_PLUGIN_VENDORS_URL', plugin_dir_url(__FILE__) . 'vendors/');

define('WP_PLUGIN_ASSETS_PATH', WP_PLUGIN_PLUGIN_PATH . 'assets/');
define('WP_PLUGIN_ASSETS_URL', plugin_dir_url(__FILE__) . 'assets/');

require_once WP_PLUGIN_PLUGIN_PATH . 'wp-plugin.php';

$wp_plugin = new WP_Plugin();

register_activation_hook(__FILE__, array($wp_plugin, 'activate'));
register_deactivation_hook( __FILE__, array($wp_plugin, 'deactivate'));

$wp_plugin->run();
?>
