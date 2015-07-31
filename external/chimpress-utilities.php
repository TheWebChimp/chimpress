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
		function img( $filename, $echo = true ) {
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
		function baseDir( $path = '', $echo = false ) {
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
		function getSiteTitle( $echo = false ) {
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
		function errorMessage( $message ) {
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
		function getParts( $parts = array() ) {

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
		 * @author 	WebChimp
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
		 * @author 	WebChimp
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
		 * @author 	WebChimp
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
		 * @author 	WebChimp
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
	 * Pretty-print an array or object
	 * @param  mixed $a Array or object
	 */
	function print_a( $a ) {
		print( '<pre>' );
		print_r( $a );
		print( '</pre>' );
	}

	/**
	 * Print html for image from images folder
	 * @param 	string, bool
	 * @return 	void
	 */
	function img( $path = '', $echo = true ) {

		global $site;
		$site->img($path, $echo);
	}

	/**
	 * Convert a shorthand byte value from a PHP configuration directive to an integer value
	 * @param    string   $value
	 * @return   int
	 */
	function convert_bytes( $value ) {
		if ( is_numeric( $value ) ) {
			return $value;
		} else {
			$value_length = strlen( $value );
			$qty = substr( $value, 0, $value_length - 1 );
			$unit = strtolower( substr( $value, $value_length - 1 ) );
			switch ( $unit ) {
				case 'k':
					$qty *= 1024;
					break;
				case 'm':
					$qty *= 1048576;
					break;
				case 'g':
					$qty *= 1073741824;
					break;
			}
			return $qty;
		}
	}

	/**
	 * Get an item from an array, or a default value if it's not set
	 * @param  array $array    Array
	 * @param  mixed $key      Key or index, depending on the array
	 * @param  mixed $default  A default value to return if the item it's not in the array
	 * @return mixed           The requested item (if present) or the default value
	 */
	function get_item($array, $key, $default = '') {
		return isset( $array[$key] ) ? $array[$key] : $default;
	}

	/**
	 * Get an item from an object, or a default value if it's not set
	 * @param  object $object  Object
	 * @param  mixed $key      Key or index, depending on the object
	 * @param  mixed $default  A default value to return if the item it's not in the object
	 * @return mixed           The requested item (if present) or the default value
	 */
	function get_item_object($object, $key, $default = '') {
		return isset( $object->$key ) ? $object->$key : $default;
	}

	/**
	 * Mark an option as selected by evaluating the variable
	 * @param  mixed  $var   Variable expected value
	 * @param  mixed  $val   Variable actual value
	 * @param  string $attr  Attribute to use (selected, checked, etc)
	 * @param  boolean $echo Whether to echo the result or not
	 * @return string        Selected attribute text or an empty text
	 */
	function option_selected($var, $val, $attr = "selected", $echo = true) {
		$ret = ($var == $val) ? "{$attr}=\"{$attr}\"" : '';
		if ($echo) {
			echo $ret;
		}
		return $ret;
	}

	/**
	 * Log something to file
	 * @param  mixed  $data     What to log
	 * @param  string $log_file Log name, without extension
	 * @return nothing
	 */
	function log_to_file($data, $log_file = '') {
		global $site;
		$log_file = $log_file ? $log_file : date('Y-m');
		$file = fopen( $site->baseDir("/log/{$log_file}.log"), 'a');
		$date = date('Y-m-d H:i:s');
		if ( is_array($data) || is_object($data) ) {
			$data = json_encode($data);
		}
		fwrite($file, "{$date} - {$data}\n");
		fclose($file);
	}

	/**
	 * Generate <option> tags for day selection
	 * @param  boolean $selected       The selected day (01-31)
	 * @param  boolean $leading_zeroes Whether to add leading zeroes nor not
	 * @param  boolean $echo           Whether to echo the result or not
	 * @return string                  The generated option tags
	 */
	function select_days($selected = false, $leading_zeroes = true, $echo = true) {
		$ret = '';
		for ($i = 1; $i <= 31; $i++){
			$option_value = str_pad($i, 2, '0', STR_PAD_LEFT);
			$option_text = $leading_zeroes? $option_value : $i;
			$ret .= "<option " . ($selected == $i? 'selected="selected"' : '') . " value=\"{$option_value}\">{$option_text}</option>\n";
		}
		if($echo) echo $ret;
		return $ret;
	}

	/**
	 * Generate <option> tags for month selection
	 * @param  boolean $selected The selected month (01-12)
	 * @param  string  $format   The month format, see the date() function reference on the PHP manual
	 * @param  boolean $echo     Whether to echo the result or not
	 * @return string            The generated option tags
	 */
	function select_months($selected = false, $format = 'm', $echo = true) {
		$ret = '';
		for ($i = 1; $i <= 12; $i++){
			$option_value = str_pad($i, 2, '0', STR_PAD_LEFT);
			$option_text = date( $format, mktime( 0, 0, 0, $i + 1, 0, 0, 0 ) );
			$ret .= "<option " . ($selected == $i? 'selected="selected"' : '') . " value=\"{$option_value}\">{$option_text}</option>\n";
		}
		if($echo) echo $ret;
		return $ret;
	}

	/**
	 * Generate <option> tags for year selection
	 * @param  boolean $selected   The selected year (yyyy format)
	 * @param  boolean $start_year The starting year
	 * @param  integer $num        How many years will be added/subtracted
	 * @param  integer $direction  Whether to add years (1) or subtract them (-1)
	 * @param  boolean $echo       Whether to echo the result or not
	 * @return string              The generated option tags
	 */
	function select_years($selected = false, $start_year = false, $num = 100, $direction = -1, $echo = true) {
		$ret = '';
		$current_year = !$start_year? date('Y') : $start_year;
		for ($i = 0; $i <= $num; $i++){
			$option_value = $current_year + ($i*$direction);
			$option_text = $option_value;
			$ret .= "<option " . ($selected == $i? 'selected="selected"' : '') . " value=\"{$option_value}\">{$option_text}</option>\n";
		}
		if($echo) echo $ret;
		return $ret;
	}

	/**
	 * Convert camelCase to snake_case
	 * @param  string $val Original string
	 * @return string      The converted string
	 */
	function camel_to_snake($val) {
		$val = preg_replace_callback('/[A-Z]/', create_function('$match', 'return "_" . strtolower($match[0]);'), $val);
		return ltrim($val, '_');
	}

	/**
	 * Convert snake_case to camelCase
	 * @param  string $val Original string
	 * @return string      The converted string
	 */
	function snake_to_camel($val) {
		$val = str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
		$val = strtolower(substr($val, 0, 1)).substr($val, 1);
		return $val;
	}

	/**
	 * Enqueue all styles inside a folder
	 * @param 	string
	 * @return 	void
	 */
	function wc_enqueue_dev_styles( $dir = '/css/src/' ) {

		if ($handle = opendir(get_template_directory() . $dir) ) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {

					wp_enqueue_style( $entry, get_template_directory_uri() . $dir . $entry, '', '', 'screen' );
				}
			}
			closedir($handle);
		}
	}
?>