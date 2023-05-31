<?php
/**
 * Curated Archives Templates.
 */

namespace HM\Curated_Archives\Template;

/**
 * Add hooks.
 */
function bootstrap() : void {
	add_filter( 'template_include', __NAMESPACE__ . '\\filter_template_include' );
}

/**
 * Filters the path of the current template before including it.
 *
 * @param string $template The path of the template to include.
 * @return string The path of the template to include.
 */
function filter_template_include( string $template ) : string {
    $queried_object = get_queried_object();

    if ( ! property_exists( $queried_object, 'term_id' ) ) {
        return $template;
    }

    $curated_archive_id = get_term_meta( $queried_object->term_id, 'curated_archive_id', true );

    if ( empty( $curated_archive_id ) ) {
        return $template;
    }

    $archive_template = locate_template( [
        "curated-archive-{$queried_object->slug}.php",
        "curated-archive-{$queried_object->term_id}.php",
        "curated-archive-{$queried_object->taxonomy}.php",
        'curated-archive.php',
    ] );

    if ( $archive_template ) {
        return $archive_template;
    }

	return $template;
}
