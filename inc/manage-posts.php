<?php
/**
 * Curated Archives Manage Posts on Term Change/Delete.
 */

namespace HM\Curated_Archives\Manage_Posts;

/**
 * Add hooks.
 */
function bootstrap() : void {
	add_action( 'pre_delete_term', __NAMESPACE__ . '\\delete_term_delete_post', 10, 2 );
	add_action( 'before_delete_post', __NAMESPACE__ . '\\delete_post_delete_term_meta', 10, 2 );
}

/**
 * Delete Curated Archive (if exists) when deleting Term.
 *
 * @param int $term - Term ID
 * @param string $taxonomy - Taxonomy name
 */
function delete_term_delete_post( $term, $taxonomy ) {
	$term_post_id = get_term_meta( $term, 'curated_archive_id', true );

	if ( $term_post_id ) {
		wp_delete_post( $term_post_id, true );
	}
}

/**
 * Delete Term Meta (if exists) when deleting Curated Archive Post.
 *
 * @param int $postid - Post ID of deleting post
 * @param object $post - Post object that is being deleted
 */
function delete_post_delete_term_meta( $postid, $post ) {
	$post_term_meta = get_post_meta( $postid, 'curated_term_id', true );

	if ( $post_term_meta ) {
		delete_term_meta( $post_term_meta, 'curated_archive_id', $postid );
	}
}
