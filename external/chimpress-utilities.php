<?php

	/**
	 * Chimpress_Utilities
	 *
	 * Chimpress Utilities Class v.0.1
	 *
	 * @package 	WordPress
	 * @subpackage 	Chimpress
	 * @since 		Chimpress 1.0
	 *
	 */

	class Chimpress_Utilities {

		/**
		 * Get a well formed url to the specified image file and optionally echo it
		 * @param  string  $filename Image file name (e.g. 'logo.png')
		 * @param  boolean $echo     Whether to print out the resulting url or not
		 * @return string            The resulting url
		 */
		function img($filename, $echo = true) {
			$ret = get_bloginfo('template_url') . "/images/{$filename}";
			if ($echo) {
				echo $ret;
			}
			return $ret;
		}

		/**
		 * Get base folder
		 * @param  string  $path Path to append
		 * @param  boolean $echo Whether to print the resulting string or not
		 * @return string        The well-formed path
		 */
		function baseDir($path = '', $echo = false) {
			$ret = get_template_directory();
			if ($echo) {
				echo $ret;
			}
			return $ret;
		}

		/**
		 * Get a well formed url to the specified route or page slug
		 * @param  string  $route    Route or page slug
		 * @param  boolean $echo     Whether to print out the resulting url or not
		 * @param  string  $protocol Protocol to override default http (https, ftp, etc)
		 * @return string            The resulting url
		 */
		function urlTo($route, $echo = false, $protocol = null) {
			$url = home_url( $path, $protocol );
			if ($echo) {
				echo $url;
			}
			return $url;
		}

		/**
		 * Get the site name
		 * @param  boolean $echo Print the result?
		 * @return string        Site name
		 */
		function getSiteTitle($echo = false) {
			$ret = get_bloginfo('name');
			if ($echo) {
				echo $ret;
			}
			return $ret;
		}

		/**
		 * Display a generic error message
		 * @param  string $message The error message
		 */
		function errorMessage($message) {
			$markup = '<!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <title>{$title}</title> <style> body { font-family: sans-serif; font-size: 14px; background: #F8F8F8; } div.center { width: 960px; margin: 0 auto; padding: 1px 0; } p.message { padding: 15px; border: 1px solid #DDD; background: #F1F1F1; color: #656565; } </style> </head> <body> <div class="center"> <p class="message">{$message}</p> </div> </body> </html>';
			$markup = str_replace('{$title}', $this->getSiteTitle(), $markup);
			$markup = str_replace('{$message}', $message, $markup);
			echo $markup;
			exit;
		}

		/**
		 * Load the specified template parts
		 * @param  mixed $mixed An string or array of parts
		 */
		function getParts($parts = array()) {

			if ( is_array($parts) ) {
				foreach( $parts as $part ) {
					get_template_part( $part );
				};
			} else if ( is_string($parts) ) {
				get_template_part( $parts );
			}
		}

		/**
		 * Simple wrapper for native get_template_part()
		 * Allows you to pass in an array of parts and output them in your theme
		 * e.g. <?php get_template_parts(array('part-1', 'part-2')); ?>
		 *
		 * @param 	array
		 * @return 	void
		 * @author 	Keir Whitaker
		 **/
		public static function get_template_parts( $parts = array() ) {
			foreach( $parts as $part ) {
				get_template_part( $part );
			};
		}

		/**
		 * Pass in a path and get back the page ID
		 * e.g. Chimpress_Utilities::get_page_id_from_path('about/terms-and-conditions');
		 *
		 * @param 	string
		 * @return 	integer
		 * @author 	Keir Whitaker
		 **/
		public static function get_page_id_from_path( $path ) {
			$page = get_page_by_path( $path );
			if( $page ) {
				return $page->ID;
			} else {
				return null;
			};
		}

		/**
		 * Append page slugs to the body class
		 * NB: Requires init via add_filter('body_class', 'add_slug_to_body_class');
		 *
		 * @param 	array
		 * @return 	array
		 * @author 	Keir Whitaker
		 */
		public static function add_slug_to_body_class( $classes ) {
			global $post;

			if( is_page() ) {
				$classes[] = sanitize_html_class( $post->post_name );
			} elseif(is_singular()) {
				$classes[] = sanitize_html_class( $post->post_name );
			};

			return $classes;
		}

		/**
		 * Get the category id from a category name
		 *
		 * @param 	string
		 * @return 	string
		 * @author 	Keir Whitaker
		 */
		public static function get_category_id( $cat_name ){
			$term = get_term_by( 'name', $cat_name, 'category' );
			return $term->term_id;
		}
	}

	global $site;
	$site = new Chimpress_Utilities();

	/* 	    ______                 __  _
		   / ____/_  ______  _____/ /_(_)___  ____  _____
		  / /_  / / / / __ \/ ___/ __/ / __ \/ __ \/ ___/
		 / __/ / /_/ / / / / /__/ /_/ / /_/ / / / (__  )
		/_/    \__,_/_/ /_/\___/\__/_/\____/_/ /_/____/
		                                                  */


	/**
	 * Print a pre formatted array to the browser - very useful for debugging
	 *
	 * @param 	array
	 * @return 	void
	 * @author 	Keir Whitaker
	 **/
	function print_a( $a ) {
		print( '<pre>' );
		print_r( $a );
		print( '</pre>' );
	}

	/**
	 * Print html for image from images folder
	 *
	 * @param 	array
	 * @return 	void
	 * @author 	Keir Whitaker
	 **/
	function img($path = '', $echo = true){

		global $site;
		$site->img($path, $echo);
	}
?>