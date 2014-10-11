<?php
	/**
	 * Chimpress functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Chimpress
 	 * @since 		Chimpress 4.0
	 */

	/* =============================================================================================
	Required external files
	============================================================================================= */

	require_once( 'external/chimpress-utilities.php' );
	require_once( 'external/customization.php' );
	require_once( 'external/shortcodes.php' );
	require_once( 'external/ajax.php' );

	/* =============================================================================================
	Actions and Filters
	============================================================================================= */

	add_action( 'wp_enqueue_scripts', 'chimpress_script_enqueuer' );
	add_filter( 'body_class', array( 'Chimpress_Utilities', 'add_slug_to_body_class' ) );

	/* =============================================================================================
	Custom Post Types - include custom post types and taxonimies here e.g.
	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	============================================================================================= */
	//require_once( 'custom-post-types/your-custom-post-type.php' );

	/* =============================================================================================
	Scripts
	============================================================================================= */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Rodrigo Tejero
	 */

	function chimpress_script_enqueuer() {

		#CSS =======================================================================================

		//Chimp Plugins
		wp_register_style( 'jquery.alert', get_stylesheet_directory_uri().'/css/jquery.alert.css', '', '', 'screen' );
		wp_enqueue_style( 'jquery.alert' );

		//Other Plugins

		//Fonts
		//Fonts go here

		//Structure
		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
		wp_enqueue_style( 'screen' );

		wp_register_style( 'boilerplate', get_stylesheet_directory_uri().'/css/boilerplate.css', '', '', 'screen' );
		wp_enqueue_style( 'boilerplate' );

		wp_register_style( 'site', get_template_directory_uri().'/site.css', '', '', 'screen' );
		wp_enqueue_style( 'site' );

		#JS ========================================================================================

		//Chimp Plugins
		wp_register_script( 'jquery.alert', get_template_directory_uri().'/js/jquery.alert.min.js', array( 'jquery' ) );
		wp_register_script( 'jquery.loading', get_template_directory_uri().'/js/jquery.loading.min.js', array( 'jquery' ) );
		wp_register_script( 'jquery.validator3', get_template_directory_uri().'/js/jquery.validator3.min.js', array( 'jquery' ) );

		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array(

			//Plugins
			'jquery',
			'jquery-form',

			//Chimp Plugins
			'jquery.alert',
			'jquery.loading',
			'jquery.validator3'
		));
		wp_enqueue_script( 'site' );
	}
?>