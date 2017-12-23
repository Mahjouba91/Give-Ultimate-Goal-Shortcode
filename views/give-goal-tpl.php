<?php
/**
 * This template is used to display the goal with [give_ultimate_goal]
 */

$forms = array();
$income = 0;
$goal = 0;
foreach ( $ids as $id ) {
    $form = new Give_Donate_Form( $id );
    if ( $form !== false ) {
	    $forms[] = $form;

	    // Get earning from all the forms
	    $income += $form->get_earnings();

	    // Get goal from the main form
	    if ( $form->goal > 0 ) {
		    $goal        = apply_filters( 'give_goal_amount_target_output', $form->goal, $form->ID, $form );
		    $goal_format = give_get_meta( $form->ID, '_give_goal_format', true );
		    $color       = give_get_meta( $form->ID, '_give_goal_color', true );
	    }
    }
}
$income = apply_filters( 'give_goal_amount_raised_output', $income, $form->ID, $form );

//Sanity check - ensure form has pass all condition to show goal.
if ( empty( $forms[0]->ID ) ) {
	return false;
}

$show_text   = isset( $atts['show_text'] ) ? filter_var( $atts['show_text'], FILTER_VALIDATE_BOOLEAN ) : true;
$show_bar    = isset( $atts['show_bar'] ) ? filter_var( $atts['show_bar'], FILTER_VALIDATE_BOOLEAN ) : true;

/**
 * Filter the goal progress output
 *
 * @since 1.8.8
 */
$progress = apply_filters( 'give_goal_amount_funded_percentage_output', round( ( $income / $goal ) * 100, 2 ), $forms );

// Set progress to 100 percentage if income > goal.
if ( $income >= $goal ) {
	$progress = 100;
}

?>
<div class="give-goal-progress">
	<?php if ( ! empty( $show_text ) ) : ?>
        <div class="raised">
			<?php
			if ( $goal_format !== 'percentage' ) :

				// Get formatted amount.
				$income = give_human_format_large_amount( give_format_amount( $income, array( 'sanitize' => false ) ) );
				$goal   = give_human_format_large_amount( give_format_amount( $goal, array( 'sanitize' => false ) ) );

				echo sprintf(
				/* translators: 1: amount of income raised 2: goal target ammount */
					__( '%1$s of %2$s raised', 'give' ),
					'<span class="income">' . give_currency_filter( $income ) . '</span>',
					'<span class="goal-text">' . give_currency_filter( $goal ) . '</span>'
				);


            elseif ( $goal_format == 'percentage' ) :

				echo sprintf(
				/* translators: %s: percentage of the amount raised compared to the goal target */
					__( '%s%% funded', 'give' ),
					'<span class="give-percentage">' . round( $progress ) . '</span>'
				);

			endif;
			?>
        </div>
	<?php endif; ?>

	<?php if ( ! empty( $show_bar ) ) : ?>
        <div class="give-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo esc_attr( $progress ); ?>">
			<span style="width: <?php echo esc_attr( $progress ); ?>%;<?php if ( ! empty( $color ) ) {
				echo 'background-color:' . $color;
			} ?>"></span>
        </div><!-- /.give-progress-bar -->
	<?php endif; ?>

</div><!-- /.goal-progress -->