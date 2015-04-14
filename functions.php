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

		#Base
		wp_enqueue_style( 'reset', get_stylesheet_directory_uri().'/css/reset.css', '', '', 'screen' );
		wp_enqueue_style( 'sticky-footer', get_stylesheet_directory_uri().'/css/sticky-footer.css', '', '', 'screen' );

		#Chimp Plugins
		wp_enqueue_style( 'jquery.alert', get_stylesheet_directory_uri().'/css/plugins/jquery.alert.css', '', '', 'screen' );

		#Other Plugins

		#Fonts
		wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css', '', '', 'screen' );
		wp_enqueue_style( 'google.open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,300,700,800,800italic,400italic,300italic|Open+Sans+Condensed:300,700,300italic', '', '', 'screen' );
		wp_enqueue_style( 'google.oswald', '//fonts.googleapis.com/css?family=Oswald:400,700,300', '', '', 'screen' );
		wp_enqueue_style( 'google.lato', '//fonts.googleapis.com/css?family=Lato:400,300,700,900', '', '', 'screen' );

		#Structure
		wp_enqueue_style( 'chimplate', get_stylesheet_directory_uri().'/css/chimplate.css', '', '', 'screen' );
		wp_enqueue_style( 'mobile', get_template_directory_uri().'/css/mobile.css', '', '', 'screen' );
		wp_enqueue_style( 'desktop', get_template_directory_uri().'/css/desktop.css', '', '', 'screen' );

		#JS ========================================================================================

		#Chimp Plugins
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