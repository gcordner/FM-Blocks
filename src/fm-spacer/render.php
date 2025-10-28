<?php
/**
 * Render callback for the Responsive Spacer block.
 *
 * @package plk_Blocks
 * @subpackage Spacer
 * @since 1.0.0
 */

$attrs = wp_parse_args(
	isset( $attributes ) ? $attributes : array(),
	array(
		'desktopHeight' => 80,
		'mobileHeight'  => 40,
	)
);

$desktop_height = absint( $attrs['desktopHeight'] );
$mobile_height  = absint( $attrs['mobileHeight'] );

// Build class names array.
$class_names = array( 'plk-spacer' );
if ( ! empty( $attrs['className'] ) ) {
	$class_names[] = $attrs['className'];
}
$class_attr = implode( ' ', $class_names );
?>
<div 
	class="<?php echo esc_attr( $class_attr ); ?>"
	style="<?php echo esc_attr( '--spacer-desktop:' . $desktop_height . 'px;--spacer-mobile:' . $mobile_height . 'px' ); ?>"
	aria-hidden="true"
>
	<style>
		.plk-spacer {
			height: var(--spacer-desktop, 80px);
		}
		@media (max-width: 767px) {
			.plk-spacer {
				height: var(--spacer-mobile, 40px);
			}
		}
	</style>
</div>