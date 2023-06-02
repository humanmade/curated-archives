<?php
/**
 * Curated Archives Term Column.
 */

namespace HM\Curated_Archives\Term_Column;

/**
 * Add hooks.
 */
function bootstrap() : void {
	add_action( 'init', __NAMESPACE__ . '\\add_columns', 1000 );
}

/**
 * Add curated archive management columns.
 *
 * @return void
 */
function add_columns() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$taxes = get_taxonomies( [ 'public' => true ] );

	/**
	 * Filter the supported taxonomies for curated archives.
	 *
	 * @param array $taxes Taxonomy names to support.
	 */
	$taxes = apply_filters( 'curated_archives_taxonomies', $taxes );

	foreach ( $taxes as $tax ) {
		add_filter( 'manage_edit-' . $tax . '_columns', __NAMESPACE__ . '\\custom_column_header', 10 );
		add_action( 'manage_' . $tax . '_custom_column', __NAMESPACE__ . '\\custom_column_content', 10, 3 );
	}
}

/**
 * Register Curated Archive post type.
 *
 * @param array $columns - Array of current columns
 */
function custom_column_header( $columns ) {
	$columns['curated_archive'] = __( 'Curated Archive', 'hm-curated-archives' );
	return $columns;
}

/**
 * Register Curated Archive post type.
 *
 * @param object $value - Object of all current column data
 * @param string $column_name - Current name of Term
 * @param int $tax_id - Current Term ID
 */
function custom_column_content( $value, $column_name, $tax_id ) {
	if ( $column_name === 'curated_archive' ) {
		$curated_archive_id = get_term_meta( $tax_id, 'curated_archive_id', true );
		$post_status = get_post_status( $curated_archive_id );

		if ( ! $curated_archive_id || null === $post_status || 'trash' === $post_status ) {
			if ( current_user_can( 'edit_pages' ) ) {
				printf(
					'<a href="#" class="term-id-%s js-make-curated-archive button">%s</a>',
					esc_attr( $tax_id ),
					esc_html__( 'Add new', 'hm-curated-archive' )
				);
			}
		} elseif ( 'draft' === $post_status ) {
			if ( current_user_can( 'edit_page', $curated_archive_id ) ) {
				printf(
					'<a href="%s" class="button button-primary">%s</a>',
					admin_url( sprintf( 'post.php?post=%d&action=edit', esc_attr( $curated_archive_id ) ) ),
					esc_html__( 'Edit Draft', 'hm-curated-archive' )
				);
			}
		} elseif ( current_user_can( 'edit_page', $curated_archive_id ) ) {
			printf(
				'<a href="%s" class="button button-primary">%s</a>',
				admin_url( sprintf( 'post.php?post=%d&action=edit', esc_attr( $curated_archive_id ) ) ),
				esc_html__( 'Edit', 'hm-curated-archive' )
			);
		}
	}
}
