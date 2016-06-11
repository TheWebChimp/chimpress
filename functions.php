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
	Development Profile
	============================================================================================= */

	define('DEV_PROFILE', 'development');

	/* =============================================================================================
	Required external files
	============================================================================================= */

	require_once( 'external/site.inc.php' );
	require_once( 'external/utilities.inc.php' );
	require_once( 'external/ajax.inc.php' );
	require_once( 'external/customization.php' );
	require_once( 'external/shortcodes.php' );

	/* =============================================================================================
	Actions and Filters
	============================================================================================= */

	add_action( 'wp_enqueue_scripts', 'chimpress_script_enqueuer' );
	add_filter( 'body_class', array( 'Site', 'add_slug_to_body_class' ) );

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

		#Chimp Plugins
		wp_enqueue_style( 'jquery.plugins', get_stylesheet_directory_uri().'/css/plugins/jquery.plugins.css', '', '', 'screen' );

		#Other Plugins

		#Fonts
		wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css', '', '', 'screen' );
		wp_enqueue_style( 'google.fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,300,700,800,800italic,400italic,300italic|Open+Sans+Condensed:300,700,300italic|Oswald:400,700,300|Lato:400,300,700,900', '', '', 'screen' );

		#Structure
		wp_enqueue_style( 'chimplate', get_stylesheet_directory_uri().'/css/chimplate.css', '', '', 'screen' );

		if(DEV_PROFILE == 'development') {
			wp_enqueue_style( 'project', get_stylesheet_directory_uri().'/css/project.less', '', '', 'screen' );
		}

		else if(DEV_PROFILE == 'production') {
			wp_enqueue_style( 'project', get_stylesheet_directory_uri().'/css/project.css', '', '', 'screen' );
		}

		#JS ========================================================================================

		#Class
		wp_register_script( 'class.js', get_template_directory_uri().'/js/class.js' );

		#Chimp Scripts
		wp_register_script( 'chimp.plugins', get_template_directory_uri().'/js/plugins.js', array( 'jquery' ) );

		#Other Scripts

		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array(

			'class.js',

			//Plugins
			'jquery',
			'jquery-form',

			//Chimp Plugins
			'chimp.plugins',

			//Other Plugins
		));
		wp_enqueue_script( 'site' );
	}
?>