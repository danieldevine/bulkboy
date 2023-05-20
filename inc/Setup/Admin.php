<?php
/**
 * Bulkboy plugin file.
 *
 * @package Bulkboy
 */

namespace Bulkboy\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up the Bulkboy admin area
 */
class Admin {

	/**
	 * The name of the plugin
	 *
	 * @var string
	 */
	public $plugin_title;

	/**
	 * Class constructor.
	 *
	 * @param string $plugin_title title of the plugin.
	 */
	public function __construct( $plugin_title ) {
		$this->plugin_title = $plugin_title;
	}

	/**
	 * Adds the action.
	 *
	 * @return void
	 */
	public function add_actions() {
		 add_action( 'admin_menu', array( $this, 'add_to_menu' ) );
	}

	/**
	 * Enqueues Bulkboy's css.
	 *
	 * @return void
	 */
	public function add_styles() {
		add_action( 'admin_enqueue_scripts', array( $this, 'setup_styles' ) );
	}

	/**
	 * Lists Bulkboy under the WordPress 'Tools' menu.
	 *
	 * @return void
	 */
	public function add_to_menu() {
		add_submenu_page(
			'tools.php',
			$this->plugin_title,
			$this->plugin_title,
			'administrator',
			BULKBOY_PLUGIN_PATH . 'views/admin-page.php',
		);
	}

	/**
	 * Registers & enqueues admin page styles.
	 *
	 * @return void
	 */
	public function setup_styles() {
		wp_register_style( 'bulkboy-styles', BULKBOY_PLUGIN_URL . 'assets/css/admin.css', array(), '1.0' );
		wp_enqueue_style( 'bulkboy-styles' );
	}
}
