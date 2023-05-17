<?php
/**
 * Bulkboy plugin file.
 *
 * @package Bulkboy
 */


namespace Bulkboy\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles fom input
 */
class Form {

	/**
	 * Post titles seperated by newlines.
	 */
	public string $post_titles;

	/**
	 * The WordPress post type.
	 */
	public string $post_type;

	/**
	 * The author of the posts.
	 */
	public string $post_author;


	/**
	 * [__construct description]
	 *
	 * @param string $post_titles the post titles.
	 * @param string $post_type   the post type.
	 * @param string $post_author the post author.
	 */
	public function __construct( $post_titles, $post_type, $post_author ) {
		$this->post_titles = $post_titles;
		$this->post_type = sanitize_text_field( $post_type );
		$this->post_author = sanitize_text_field( $post_author );
	}

	/**
	 * Splits the string of titles into an array,
	 * while removing whitespace and blank lines.
	 * 
	 * @param  string $titles newline seperated titles 
	 * @return array    
	 */
	protected function split_titles()
	{
		$titles = preg_replace( '/\n+/', "\n", trim( $this->post_titles ) );

		$exploded_titles = explode( "\n", $titles );

		$filtered_titles = array_filter(
			$exploded_titles,
			function ( $element ) {
				return is_string( $element ) && '' !== trim( $element );
			}
		);

		return $filtered_titles;
	}

	/**
	 * Generates WordPress posts.
	 *
	 * @return string
	 */
	public function create_posts() {

		if ( ! $this->post_titles ) {
			wp_die( 'Please add some titles.' );
		}

		$titles = $this->split_titles();

		foreach ( $titles as $title ) {
			$title = sanitize_text_field( $title );

			$title = wp_strip_all_tags( $title );

			$args = array(
				'post_title'   => $title,
				'post_content' => '',
				'post_type'    => $this->post_type,
				'post_status'  => 'publish',
				'post_author'  => $this->post_author,
			);

			wp_insert_post( $args );
		}

		return "<div class='updated notice'><p>{$this->post_type} created!</p></div>";
	}
}
