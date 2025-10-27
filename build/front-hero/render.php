<?php
/**
 * Render callback for the Front Hero block.
 *
 * Outputs a hero with one desktop image and two mobile candidates.
 * We render a single <img> (desktop by default) and expose data attributes
 * for a tiny view script to swap to a random mobile image on small viewports.
 * Alt text always matches the active image.
 *
 * @package FM_Blocks
 * @subpackage Front_Hero
 * @since 1.0.0
 */

// Aspect ratio presets - must match edit.js
$aspect_ratio_presets = array(
	'banner' => array(
		'desktop' => '384/120',
		'mobile'  => '8/5',
	),
	'hero'   => array(
		'desktop' => '6/4',
		'mobile'  => '4/5',
	),
);

// $attributes are available when using "render": "file:./render.php".
$attrs = wp_parse_args(
	isset( $attributes ) ? $attributes : array(),
	array(
		'desktopId'         => 0,
		'desktopAlt'        => '',
		'mobile1Id'         => 0,
		'mobile1Alt'        => '',
		'mobile2Id'         => 0,
		'mobile2Alt'        => '',
		'aspectRatioPreset' => 'banner',
		'ratioDesktop'      => '',
		'ratioMobile'       => '',
		'roundedCorners'    => false,
	)
);

// Hardcoded fallbacks (bundled assets).
$fallbacks = array(
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

// Helper: get src/alt using attachment ID with optional custom alt,
// falling back to the provided fallback when missing.
$get_img = static function ( $id, $custom_alt, $fallback_key ) use ( $fallbacks ) {
	$src = '';
	$alt = '';

	if ( $id ) {
		$src = wp_get_attachment_image_url( (int) $id, 'full' ) ?: '';
		$alt = trim( (string) $custom_alt );
		if ( '' === $alt ) {
			$alt = (string) get_post_meta( (int) $id, '_wp_attachment_image_alt', true );
		}
	}

	// Fallbacks if no ID or missing data.
	if ( '' === $src ) {
		$src = $fallbacks[ $fallback_key ]['src'];
	}
	if ( '' === $alt ) {
		$alt = $fallbacks[ $fallback_key ]['alt'];
	}

	return array( 'src' => $src, 'alt' => $alt );
};

$desktop = $get_img( $attrs['desktopId'], $attrs['desktopAlt'], 'desktop' );
$mobile1 = $get_img( $attrs['mobile1Id'], $attrs['mobile1Alt'], 'mobile1' );
$mobile2 = $get_img( $attrs['mobile2Id'], $attrs['mobile2Alt'], 'mobile2' );

// Get aspect ratios from preset or use stored values
$preset = $attrs['aspectRatioPreset'];
if ( ! empty( $preset ) && isset( $aspect_ratio_presets[ $preset ] ) ) {
	$ratio_desktop = $aspect_ratio_presets[ $preset ]['desktop'];
	$ratio_mobile  = $aspect_ratio_presets[ $preset ]['mobile'];
} else {
	// Fallback to stored values or ultimate defaults
	$ratio_desktop = ! empty( $attrs['ratioDesktop'] ) ? $attrs['ratioDesktop'] : '384/120';
	$ratio_mobile  = ! empty( $attrs['ratioMobile'] ) ? $attrs['ratioMobile'] : '8/5';
}

// Determine initial image based on viewport - desktop by default
$initial = $desktop;

if ( empty( $initial['src'] ) ) {
	return;
}

// Generate unique ID for this block instance
$block_id = 'fm-front-hero-' . wp_unique_id();
?>
<section
	id="<?php echo esc_attr( $block_id ); ?>"
	class="fm-front-hero"
	style="<?php echo esc_attr( '--fh-desktop:' . $ratio_desktop . ';--fh-mobile:' . $ratio_mobile ); ?>"
	data-fh="1"
	data-desktop-src="<?php echo esc_url( $desktop['src'] ); ?>"
	data-desktop-alt="<?php echo esc_attr( $desktop['alt'] ); ?>"
	data-mobile-a-src="<?php echo esc_url( $mobile1['src'] ); ?>"
	data-mobile-a-alt="<?php echo esc_attr( $mobile1['alt'] ); ?>"
	data-mobile-b-src="<?php echo esc_url( $mobile2['src'] ); ?>"
	data-mobile-b-alt="<?php echo esc_attr( $mobile2['alt'] ); ?>"
>
	<div class="fm-front-hero__media">
		<img
			class="fm-front-hero__img"
			src="<?php echo esc_url( $initial['src'] ); ?>"
			alt="<?php echo esc_attr( $initial['alt'] ); ?>"
			loading="eager"
			fetchpriority="high"
			decoding="async"
		/>
	</div>

	<script>
	(function() {
		var block = document.getElementById('<?php echo esc_js( $block_id ); ?>');
		if (!block) return;
		
		var img = block.querySelector('.fm-front-hero__img');
		if (!img) return;

		var isMobile = window.matchMedia('(max-width: 767px)').matches;
		
		if (isMobile) {
			// Pick random mobile image and store choice
			var choice = Math.random() < 0.5 ? 'A' : 'B';
			block._fhMobileChoice = choice;
			block._fhInitialIsMobile = true;
			
			// Update to mobile image
			var src = choice === 'A' ? block.dataset.mobileASrc : block.dataset.mobileBSrc;
			var alt = choice === 'A' ? block.dataset.mobileAAlt : block.dataset.mobileBAlt;
			if (src) {
				img.src = src;
				if (alt) img.alt = alt;
			}
		}
	})();
	</script>

	<style>
		.fm-front-hero__media{display:block;width:100%;aspect-ratio:var(--fh-desktop,384/120);overflow:hidden<?php echo $attrs['roundedCorners'] ? ';border-radius:25px' : ''; ?>}
		.fm-front-hero__media img{width:100%;height:100%;object-fit:cover;display:block}
		@media (max-width:767px){
			.fm-front-hero__media{width:100vw;margin-left:calc(50% - 50vw);aspect-ratio:var(--fh-mobile,8/5)}
		}
	</style>
</section>