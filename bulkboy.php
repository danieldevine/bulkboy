<?php
/**
 * Bulkboy plugin.
 *
 * @package Bulkboy
 * @since 1.0.1
 *
 * @wordpress-plugin
 * Plugin Name: Bulkboy
 * Plugin URI: https://coderjerk.com/bulkboy
 * Description: Bulk add pages, posts and custom post types.
 * Version: 1.0.1
 * License: GPLv3
 * Text Domain: bulkboy
 * Author: Dan Devine <dandevine0@gmail.com>
 * Author URI: https://coderjerk.com
 */

use Bulkboy\Setup\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( ABSPATH . '/wp-includes/pluggable.php' );
require_once __DIR__ . '/vendor/autoload.php';

if ( ! defined( 'BULKBOY_PLUGIN_URL' ) ) {
	define( 'BULKBOY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'BULKBOY_PLUGIN_PATH' ) ) {
	define( 'BULKBOY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

define( 'BULKBOY_CURRENT_VERSION', '1.0.1' );

$admin = new Admin( 'Bulkboy' );

$admin->add_actions();
$admin->add_styles();
