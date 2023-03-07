<?php
/**
 * This file is used to add the screen time site logo to the header.
 *
 * @package WordPress
 * @subpackage TwentyTwentyOneChild
 * @since Twenty Twenty-One Child 1.0
 */

$wrapper_class              = 'screen-time-logo-container';
$logo_text_class            = 'screen-time-logo-text';
$logo_last_half_text_class  = 'screen-time-logo-last-half-text';
$logo_first_half_text_class = 'screen-time-logo-first-half-text';

?>

<div id="logo" class="<?php echo esc_attr( $wrapper_class ); ?>">
	<span class="<?php echo esc_attr( $logo_text_class ); ?>">
		<span class="<?php echo esc_attr( $logo_first_half_text_class ); ?>">SCREEN</span><span class="<?php echo esc_attr( $logo_last_half_text_class ); ?>"> TIME</span>
	</span>
</div>
