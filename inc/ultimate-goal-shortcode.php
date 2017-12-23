<?php

require GIVEULTIMATEGOAL_DIR . 'inc/gugs-helpers.php';

/**
 * Ultimate Donation Form Goal Shortcode.
 *
 * Show the Give donation form goals.
 *
 * @since  1.0
 *
 * @param  array $atts Shortcode attributes.
 *
 * @return string
 */
function give_ultimate_goal_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'id'        => '', // ID or list of IDS like : id="1,2,3"
		'show_text' => true,
		'show_bar'  => true,
	), $atts, 'give_ultimate_goal' );

	ob_start();

	// Sanity check 1: ensure there is an ID Provided.
	if ( empty( $atts['id'] ) ) {
		Give()->notices->print_frontend_notice( __( 'The shortcode is missing Donation Form ID attribute.', 'give' ), true );
	}

	$ids = explode( ',', $atts['id'] );

	// Passed all sanity checks: output Goal.
	include( Gugs_Helpers::locate_template( 'give-goal-tpl' ) );

	$final_output = ob_get_clean();

	return apply_filters( 'give_ultimate_goal_shortcode_output', $final_output, $atts );
}

add_shortcode( 'give_ultimate_goal', 'give_ultimate_goal_shortcode' );