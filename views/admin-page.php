<?php
/**
 * Bulkboy plugin file.
 *
 * @package Bulkboy
 */

use Bulkboy\Setup\Plugin;
use Bulkboy\Handlers\Form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function prepare_input( $input )
{
	return sanitize_text_field( wp_unslash( $input ) );
}

if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' == $_SERVER['REQUEST_METHOD'] ) {

	if ( ! isset( $_POST['nonce_check'] ) || ! wp_verify_nonce( wp_unslash( $_POST['nonce_check'] ), 'bulkboy' ) ) {
		wp_die( 'Sorry, your nonce did not verify.', 'bulkboy' );
	}

	// Get the form data.
	if ( isset( $_POST['post_titles'] ) ) {
		$bulkboy_post_titles =  $_POST['post_titles'];
	}

	if ( isset( $_POST['post_type'] ) ) {
		$bulkboy_post_type = prepare_input( $_POST['post_type'] );
	}

	if ( isset( $_POST['post_author'] ) ) {
		$bulkboy_post_author = prepare_input( $_POST['post_author'] );
	}

	if ( empty( $bulkboy_post_titles ) || empty( $bulkboy_post_type ) || empty( $bulkboy_post_author ) ) {
		wp_die( 'Please fill all fields.', 'bulkboy' );
	}

	$form = new Form( $bulkboy_post_titles, $bulkboy_post_type, $bulkboy_post_author );

	echo $form->create_posts();
}
?>

<div class="bulkboy-admin">
	<div class="bulkboy-admin__content">
		<h1 class="wp-heading-inline">Bulkboy</h1>
		<form id="bulkboy_form" name="bulkboy_form" method="post" action="">
			<?php wp_nonce_field( 'bulkboy', 'nonce_check' ); ?>
			<table class="widefat">
				<thead>
					<tr>
						<th class="manage-column" style="width: 250px;">
							<?php esc_html_e( 'Option', 'bulkboy' ); ?>
						</th>
						<th colspan="2" class="manage-column">
							<?php esc_html_e( 'Setting', 'bulkboy' ); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate iedit">
						<td>Post Type</td>
						<td colspan="2">
							<?php echo Plugin::get_post_types_as_select_field(); ?>
						</td>
					</tr>
					<tr class="alternate iedit">
						<td valign="top">
							<?php esc_html_e( 'Titles:', 'bulkboy' ); ?>
							<br />
							<small>
								<?php esc_html_e( 'Add each new post title on a new line', 'bulkboy' ); ?>
							</small>
						</td>
						<td>
							<textarea name="post_titles" rows="8" cols="30"></textarea>
						</td>
					</tr>
					<tr class="alternate iedit">
						<td valign="top">
							<?php esc_html_e( 'Author', 'bulkboy' ); ?>
						</td>
						<td colspan="2">
							<?php echo Plugin::get_users_as_select_field(); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="bulkboy-admin__form__submit">
				<input type="submit" name="submit" value="<?php esc_html_e( 'Add Posts', 'bulkboy' ); ?>" class="button-primary">
			</div>
		</form>
	</div>
</div>
