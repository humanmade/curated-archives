<?php
/**
 * Redirects.
 */

namespace HM\Curated_Archives\Redirects;

use HM\Curated_Archives\Content_Types;

/**
 * Add hooks.
 */
function bootstrap(): void {
	add_action( 'template_redirect', __NAMESPACE__ . '\\redirect_curated_archive_posts' );
}

/**
 * Redirect Curated Archive posts to the Term Archive page.
 *
 * Allows us to continue using 'view' links in the admin, and prevents
 * accidental access to the shadow post type on the frontend.
 */
function redirect_curated_archive_posts(): void {
	if ( get_post_type() !== Content_Types\CURATED_ARCHIVE_CPT_SLUG ) {
		return;
	}

	$post_term_meta = get_post_meta( get_the_ID(), 'curated_term_id', true );

	if ( empty( $post_term_meta ) ) {
		return;
	}

	wp_safe_redirect( get_term_link( (int) $post_term_meta ) );
	exit;
}
