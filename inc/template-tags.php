<?php
/**
 * Curated Archives Templates.
 */

/**
 * Check if an archive has a curated archive.
 *
 * @param integer|null $term_taxonomy_id
 * @return boolean
 */
function has_curated_archive( ?int $term_taxonomy_id = null ) : bool {
	$term = $term_taxonomy_id ? get_term_by( 'term_taxonomy_id', $term_taxonomy_id ) : get_queried_object();

	if ( empty( $term ) || ! is_object( $term ) || ! property_exists( $term, 'term_id' ) ) {
		return false;
	}

	$curated_archive_id = get_term_meta( $term->term_id, 'curated_archive_id', true );

	return ! empty( $curated_archive_id );
}

/**
 * Get the curated archive post object.
 *
 * @param integer|null $term_taxonomy_id
 * @return WP_Post|null
 */
function get_curated_archive( ?int $term_taxonomy_id = null ) : ?WP_Post {
	$term = $term_taxonomy_id ? get_term_by( 'term_taxonomy_id', $term_taxonomy_id ) : get_queried_object();

	if ( empty( $term ) || ! is_object( $term ) || ! property_exists( $term, 'term_id' ) ) {
		return null;
	}

	$curated_archive_id = get_term_meta( $term->term_id, 'curated_archive_id', true );

	return get_post( $curated_archive_id );
}

/**
 * Output the curated archive post content.
 *
 * @param integer|null $term_taxonomy_id
 * @return void
 */
function the_curated_archive( ?int $term_taxonomy_id = null ) : void {
	global $post;

	$archive_post = get_curated_archive( $term_taxonomy_id );

	if ( ! $archive_post ) {
		return;
	}

	// Check status.
	if ( $archive_post->post_status !== 'publish' && ! is_preview() ) {
		return;
	}

	$post = $archive_post;

	if ( is_preview() ) {
		$autosave = wp_get_post_autosave( $post->ID );
		if ( $autosave ) {
			$post = $autosave;
		}
	}

	setup_postdata( $post );
	the_content();
	wp_reset_postdata();
}
