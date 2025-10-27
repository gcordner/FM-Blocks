<?php
/**
 * Render callback for the Front Hero block.
 *
 * Outputs the hero section with a desktop image and one of two randomly selected
 * mobile images, each using its own descriptive alt text. Uses wp_rand() for
 * randomization and includes responsive aspect ratios via inline CSS.
 *
 * @package FM_Blocks
 * @subpackage Front_Hero
 * @since 1.0.0
 *
 * @see wp_rand()
 * @see https://developer.wordpress.org/reference/functions/wp_is_mobile/
 */

// Define all image paths and their alt text.
$images = array(
	'desktop' => array(
		'src' => FM_BLOCKS_ASSETS_URL . 'front-hero/desktop.webp',
		'alt' => 'Hero image showing the desktop layout view',
	),
	'mobile1' => array(
		'src' => FM_BLOCKS_ASSETS_URL . 'front-hero/mobile.webp',
		'alt' => 'Hero image optimized for mobile layout, version one',
	),
	'mobile2' => array(
		'src' => FM_BLOCKS_ASSETS_URL . 'front-hero/mobile02.webp',
		'alt' => 'Hero image optimized for mobile layout, version two',
	),
);

// Choose which image to display based on screen width.
$is_mobile = wp_is_mobile();
if ( $is_mobile ) {
	$choice = wp_rand( 1, 2 ) === 1 ? 'mobile1' : 'mobile2';
} else {
	$choice = 'desktop';
}

$selected_image = $images[ $choice ];
?>
<section class="fm-front-hero" style="--fh-desktop:6/4;--fh-mobile:4/5;">
	<div class="fm-front-hero__media">
	<img 
		src="<?php echo esc_url( $selected_image['src'] ); ?>" 
		alt="<?php echo esc_attr( $selected_image['alt'] ); ?>" 
		loading="eager" 
		fetchpriority="high" 
		decoding="async"
	>
	</div>

	<style>
	.fm-front-hero__media {
		display: block;
		width: 100%;
		aspect-ratio: var(--fh-desktop, 6/4);
		overflow: hidden;
	}
	.fm-front-hero__media img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
	}
	@media (max-width: 767px) {
		.fm-front-hero__media {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		aspect-ratio: var(--fh-mobile, 4/5);
		}
	}
	</style>
</section>
