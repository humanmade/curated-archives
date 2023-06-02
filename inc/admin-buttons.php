<?php
/**
 * Curated Archives Admin Bar Button.
 */

namespace HM\Curated_Archives\Admin_Buttons;

/**
 * Add hooks.
 */
function bootstrap() : void {
	add_action( 'admin_bar_menu', __NAMESPACE__ . '\\curated_archive_admin_bar_link', 999 );
}

/**
 * Add Make Curated Archive button to WP Admin Bar.
 *
 * @param object $wp_admin_bar - Instance of WP Admin Bar
 */
function curated_archive_admin_bar_link( $wp_admin_bar ) {
	if ( is_admin() || ! is_archive() || ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$term_id = get_queried_object()->term_id;

	$term_curated_archive = get_term_meta( $term_id, 'curated_archive_id', true );

	$post_status = get_post_status( $term_curated_archive );

	// If Term Meta does not exist, then show make button. If exists but draft, then show Edit Draft. Else show edit.
	if ( ! $term_curated_archive || null === $post_status || 'trash' === $post_status ) {

		// Add Make button.
		$wp_admin_bar->add_node( [
			'id' => 'make-curated-archive',
			'title' => __( 'Make Curated Archive', 'hm-curated-archives' ),
			'href' => '#',
			'meta' => [
				'class' => 'term-id-' . $term_id . ' js-type-admin-bar js-make-curated-archive',
			],
		] );

	} elseif ( 'draft' === $post_status ) {

		// Add Edit Draft button.
		$wp_admin_bar->add_node( [
			'id' => 'edit-curated-archive',
			'title' => __( 'Edit Draft Curated Archive', 'hm-curated-archives' ),
			'href' => admin_url( 'post.php?post=' . $term_curated_archive . '&action=edit' ),
		] );

	} else {

		// Add Edit button.
		$wp_admin_bar->add_node( [
			'id' => 'edit-curated-archive',
			'title' => __( 'Edit Curated Archive', 'hm-curated-archives' ),
			'href' => admin_url( 'post.php?post=' . $term_curated_archive . '&action=edit' ),
		] );

	}
}
