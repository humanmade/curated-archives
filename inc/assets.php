<?php
/**
 * Load assets.
 */

namespace HM\Curated_Archives\Assets;

use HM\Curated_Archives;

/**
 * Add hooks.
 */
function bootstrap() : void {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets_admin' );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets_frontend' );
}

/**
 * Check if we should load admin bar assets in the admin.
 */
function enqueue_assets_admin() : void {
	if ( get_current_screen()->base !== 'edit-tags' ) {
		return;
	}

	enqueue_admin_bar_assets();
}

/**
 * Check if we should load admin bar assets on the frontend.
 */
function enqueue_assets_frontend() : void {
	if ( ! is_admin_bar_showing() || ! is_archive() ) {
		return;
	}

	enqueue_admin_bar_assets();
}

/**
 * Enqueue scripts for the WP admin bar.
 */
function enqueue_admin_bar_assets() : void {
	wp_enqueue_script(
		'curated-archives',
		plugins_url( 'src/index.js', Curated_Archives\FILE ),
		[],
		'1.0.0',
		true
	);

	wp_localize_script(
		'curated-archives',
		'curated_archive_vars',
		[
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'ajax_nonce_curated_post' => wp_create_nonce( 'curated_post' ),
		]
	);
}
