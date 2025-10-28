<?php
/**
 * Plugin Name:       Fm Blocks
 * Description:       A collection of custom blocks for the WordPress block editor.
 * Version:           0.1.0.2
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Geoff Cordner
 * Author URI:        https://geoffcordner.net
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fm-blocks
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'FM_BLOCKS_DIR' ) )  define( 'FM_BLOCKS_DIR', plugin_dir_path( __FILE__ ) ); // has trailing slash
if ( ! defined( 'FM_BLOCKS_URL' ) )  define( 'FM_BLOCKS_URL', plugin_dir_url( __FILE__ ) );  // has trailing slash


// Optional helpers (handy for hardcoded assets/build files)
if ( ! defined( 'FM_BLOCKS_ASSETS_DIR' ) ) define( 'FM_BLOCKS_ASSETS_DIR', FM_BLOCKS_DIR . 'assets/' );
if ( ! defined( 'FM_BLOCKS_ASSETS_URL' ) ) define( 'FM_BLOCKS_ASSETS_URL', FM_BLOCKS_URL . 'assets/' );
if ( ! defined( 'FM_BLOCKS_BUILD_DIR' ) )  define( 'FM_BLOCKS_BUILD_DIR',  FM_BLOCKS_DIR . 'build/' );
if ( ! defined( 'FM_BLOCKS_BUILD_URL' ) )  define( 'FM_BLOCKS_BUILD_URL',  FM_BLOCKS_URL . 'build/' );

// Show admin notice if build/manifest is missing.
add_action('admin_init', function () {
    // Only show to folks who can activate plugins, and only in admin
    if ( ! is_admin() || ! current_user_can('activate_plugins') ) return;

    // If the build/manifest is missing, show a warning notice
    if ( ! file_exists( FM_BLOCKS_DIR . 'build/blocks-manifest.php' ) ) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p><strong>FM Blocks:</strong> Run <code>npm run build</code> to compile block assets.</p></div>';
        });

        // Optional: also show in Network Admin if you might network-activate
        if ( is_multisite() && is_network_admin() ) {
            add_action('network_admin_notices', function () {
                echo '<div class="notice notice-warning"><p><strong>FM Blocks:</strong> Run <code>npm run build</code> to compile block assets.</p></div>';
            });
        }
    }
});

/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function create_block_fm_blocks_block_init() {
    $manifest = __DIR__ . '/build/blocks-manifest.php';
    if ( file_exists( $manifest ) ) {
        if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
            wp_register_block_types_from_metadata_collection( __DIR__ . '/build', $manifest );
            return;
        }
        if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
            wp_register_block_metadata_collection( __DIR__ . '/build', $manifest );
        }
        $data = require $manifest;
        foreach ( array_keys( $data ) as $block_type ) {
            register_block_type( __DIR__ . "/build/{$block_type}" );
        }
    }
}
add_action( 'init', 'create_block_fm_blocks_block_init' );

