<?php
/**
 * Curated Archives Create Post.
 */

namespace HM\Curated_Archives\Create_Post;

use HM\Curated_Archives\Content_Types;

/**
 * Add hooks.
 */
function bootstrap() : void {
	// AJAX hooks.
	add_action( 'wp_ajax_create_curated_archive_post', __NAMESPACE__ . '\\create_curated_archive_post' );
}

/**
 * Get all the taxonomies registered.
 */
function create_curated_archive_post() {
	// Check the nonce and exit.
	if ( ! check_ajax_referer( 'curated_post', 'nonce' ) ) {
		wp_send_json_error( 'Invalid nonce provided' );
		return;
	}

	// Get current term.
	$term_id = isset( $_POST['term_id'] ) ? sanitize_text_field( wp_unslash( $_POST['term_id'] ) ) : null;

	// Die if term id not set.
	if ( ! $term_id ) {
		wp_send_json_error( 'No term set' );
		return;
	}

	$term = get_term( $term_id );

	// Die if term does not exist.
	if ( ! term_exists( $term->term_id ) ) {
		wp_send_json_error( 'Term does not exist' );
		return;
	}

	// If term already has an associated post, then just return the post edit url.
	if ( metadata_exists( 'term', $term->term_id, 'curated_archive_id' ) ) {

		wp_send_json( admin_url( 'post.php?post=' . get_term_meta( $term->term_id, 'curated_archive_id', true ) . '&action=edit' ) );

		wp_die();

	} else {

		$curated_archive_post = [
			'post_title' => esc_html( $term->name ),
			'post_type' => Content_Types\CURATED_ARCHIVE_CPT_SLUG,
		];

		/**
		 * Filters the default post data used to populate new curated archives.
		 *
		 * @param array $post The post data to set for a new curated archive.
		 * @param WP_Term $term The term we're creating a post for.
		 */
		$curated_archive_post = apply_filters( 'curated_archives_post_data', $curated_archive_post, $term );

		// Create new post. Set Term Name as Post Name.
		$new_post_id = wp_insert_post( $curated_archive_post );

		// If creation of new post fails, die here.
		if ( is_wp_error( $new_post_id ) ) {
			wp_send_json_error( $new_post_id->get_error_message() );
			return;
		}

		// Set the new Post ID to the current term.
		add_term_meta( $term->term_id, 'curated_archive_id', $new_post_id );

		// Set the Term ID to the new Post.
		add_post_meta( $new_post_id, 'curated_term_id', $term->term_id, true );

		// Send back edit URL for new post to be used in JS.
		wp_send_json( admin_url( 'post.php?post=' . $new_post_id . '&action=edit' ) );

		wp_die();

	}
}
