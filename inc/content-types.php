<?php
/**
 * Curated Archives Content Types.
 */

namespace HM\Curated_Archives\Content_Types;

const CURATED_ARCHIVE_CPT_SLUG = 'curated_archive';

/**
 * Add hooks.
 */
function bootstrap() : void {
	add_action( 'init', __NAMESPACE__ . '\\register_curated_archives_cpt', 11 );
}

/**
 * Register Curated Archive post type.
 */
function register_curated_archives_cpt(): void {

	$template = [];

	/**
	 * Filters the default template for curated archive posts.
	 *
	 * @param array $template The default template for the curated archives post type.
	 */
	$template = apply_filters( 'curated_archives_template', $template );

	register_post_type(
		CURATED_ARCHIVE_CPT_SLUG,
		[
			'capabilities' => [
				'create_posts' => 'do_not_allow',
			],
			'capability_type' => 'page',
			'hierarchical' => false,
			'map_meta_cap' => true,
			'public' => false,
			'publicly_queryable' => true,
			'show_in_rest' => true,
			'show_ui' => true,
			'show_in_menu' => false,
			'supports' => [
				'title',
				'editor',
			],
			'template' => $template,
		]
	);
}
