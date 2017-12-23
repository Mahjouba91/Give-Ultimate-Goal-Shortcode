<?php
/**
 * Plugin Name:    Give - Ultimate Goal Shortcode
 * Description:    The Ultimate goal shortcode plugin allow you to show current earning of a list of forms
 * Version:        1.0
 * Author:         Florian TIAR
 * Author URI:     https://wpstrategie.fr
 * License:        GNU General Public License v3 or later
 * License URI:    http://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:    giveultimategoal
 *
 */

// Defines Plugin directory for easy reference
define( 'GIVEULTIMATEGOAL_DIR', plugin_dir_path( __FILE__ ) );
define( 'GIVEULTIMATEGOAL_URL', plugin_dir_url( __FILE__ ) );
define( 'GIVEULTIMATEGOAL_VIEWS_FOLDER_NAME', 'give_donorlist' );

// Checks if GIVE is active. 
// If not, it bails with an Admin notice as to why. 
// If so, it loads the necessary scripts 

function giveultimategoal_plugin_init() {

	// If Give is NOT active
	if ( current_user_can( 'activate_plugins' ) && ! class_exists( 'Give' ) ) {

		add_action( 'admin_init', 'giveultimategoal_deactivate' );

		// Deactivate GIVEDONOR
		function giveultimategoal_deactivate() {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}

		// Throw an Alert to tell the Admin why it didn't activate
		function giveultimategoal_admin_notice() {
			echo "<div class=\"error\"><p><strong>" . __( '"Give Ultimate Goal"</strong> requires the free <a href="https://wordpress.org/plugins/give" target="_blank">Give Donation Plugin</a> to function. Please activate Give before activating this plugin. For now, the plug-in has been <strong>deactivated</strong>.', 'ggfd' ) . "</p></div>";
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}

		// If Give IS Active, then we load everything up.
	} else {

		// Include/Execute necessary files
		include_once( GIVEULTIMATEGOAL_DIR . 'inc/ultimate-goal-shortcode.php' );

	}
}

// The initialization function
add_action( 'plugins_loaded', 'giveultimategoal_plugin_init' );