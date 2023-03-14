<?php
/**
 * This file is template for the footer menu.
 *
 * @package TwentyTwentyOneChild
 * @since 1.0.0
 */

if ( ! isset( $args['name'] ) || ! isset( $args['menu'] ) ) {
	return;
}

$name         = $args['name'];
$display_menu = $args['menu'];
?>

<span class="primary-text-primary-font st-footer-company-navigation">
	<?php echo esc_html( $name ); ?>
</span>

<?php echo wp_kses(
	$display_menu,
	array(
		'nav' => array(
			'class' => array(),
			'id'    => array(),
		),
		'ul'  => array(
			'class' => array(),
			'id'    => array(),
		),
		'li'  => array(
			'class' => array(),
			'id'    => array(),
		),
		'a'   => array(
			'class' => array(),
			'id'    => array(),
		),
	)
); ?>
