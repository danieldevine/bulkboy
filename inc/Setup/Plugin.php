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
 * Sets up Bulkboy
 */
class Plugin {

	/**
	 * Displays a list of available post types
	 * formatted as a select field.
	 *
	 * @return string
	 */
	public static function get_post_types_as_select_field() {
		$args = array(
			'_builtin' => false,
		);

		$post_types = get_post_types( $args, 'objects' );

		// Unset acf cpts.
		unset( $post_types['acf-post-type'] );

		unset( $post_types['acf-taxonomy'] );

		unset( $post_types['acf-field-group'] );

		unset( $post_types['acf-field'] );

		$select = "<select name='post_type'>";

		$select .= "<option value='page'>Page</option>";

		$select .= "<option value='post'>Post</option>";

		if ( ! empty( $post_types ) ) {

			foreach ( $post_types as $post_type ) {

				$select .= "<option value='{$post_type->name}'>{$post_type->label}</option>";

			}
		}

		$select .= '</select>';

		return $select;
	}

	/**
	 * Displays a list of users
	 * formatted as a select field.
	 *
	 * @return string
	 */
	public static function get_users_as_select_field() {
		 $user_query = new \WP_User_Query( array( 'role__not_in' => 'Subscriber' ) );

		 $select = "<select name='post_author'>";

		if ( ! empty( $user_query->get_results() ) ) {

			foreach ( $user_query->get_results() as $user ) {

				$select .= '<option value="' . $user->ID . '">' . $user->display_name . '</option>';

			}
		}

		$select .= '</select>';

		return $select;

	}
}
