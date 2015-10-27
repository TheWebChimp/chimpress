<?php

	/**
	 * Chimpress Costumization
	 *
	 * @package 	WordPress
	 * @subpackage 	Chimpress
	 * @since 		Chimpress 1.0
	 *
	 */

	/* =============================================================================================
	Theme Support+
	============================================================================================= */

	add_theme_support('menus');
	add_theme_support('post-thumbnails');

	/* =============================================================================================
	Menus
	============================================================================================= */

	register_nav_menus( array('primary' => 'Primary Navigation') );

	/* =============================================================================================
	Sticky Footer
	============================================================================================= */

	define('STICKY_FOOTER', true);

	/* =============================================================================================
	Custom Image Sizes
	============================================================================================= */

	//add_image_size('nombre', x, y, true);

	/* =============================================================================================
	Hide Admin Bar
	============================================================================================= */

	if( ! current_user_can('edit_posts') ){ add_filter('show_admin_bar', '__return_false'); }

	/* =============================================================================================
	Remove link rel='prev' and link rel='next'
	============================================================================================= */

	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

	/* =============================================================================================
	Worpdress Login Style
	============================================================================================= */

	function wc_login_stylesheet() { ?>
		<link rel="stylesheet" type="text/css" id="wc-wp-admin-css" href="<?php echo get_bloginfo('stylesheet_directory') . '/css/login.css'; ?>" media="all">
	<?php }

	add_action('login_enqueue_scripts', 'wc_login_stylesheet');

	/* =============================================================================================
	Set the permalink structure
	============================================================================================= */

	add_action('init', function() {

		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure('/%postname%/');
	});

	/* =============================================================================================
	Hiding super admin (ID 1) user
	============================================================================================= */

	function wc_pre_user_query($user_search) {

		$user = wp_get_current_user();
		if ($user->ID != 1) {

			global $wpdb;
			$user_search->query_where = str_replace('WHERE 1=1', "WHERE 1=1 AND {$wpdb->users}.ID <> 1", $user_search->query_where);
		}
	}

	add_action('pre_user_query','wc_pre_user_query');

	/* =============================================================================================
	Hiding sections in the administator
	============================================================================================= */

	function wc_remove_menus() {

		global $menu;

		//Restricted example
		//$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));

		$restricted = array();

		end ($menu);
		while (prev($menu)){
			$value = explode( ' ',$menu[key($menu)][0] );
			if( in_array( $value[0] != null? $value[0] : "", $restricted ) ){ unset( $menu[key($menu)] ); }
		}
	}

	add_action('admin_menu', 'wc_remove_menus');

	function my_acf_show_admin($show) {

		$user = wp_get_current_user();
		if ( $user->ID != 1 ) {
			return false;
		}

		else return true;
	}

	add_filter('acf/settings/show_admin', 'my_acf_show_admin');

	/* =============================================================================================
	File upload special chars sanitization
	============================================================================================= */

	function wc_upload_sanitize_accents($filename) {

		return remove_accents($filename);
	}

	add_filter('sanitize_file_name', 'wc_upload_sanitize_accents', 10);

	/* =============================================================================================
	Body Class per Browser
	============================================================================================= */

	function wc_browser_body_class($classes) {

		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		if($is_lynx)		$classes[] = 'lynx';
		elseif($is_gecko)	$classes[] = 'gecko';
		elseif($is_opera)	$classes[] = 'opera';
		elseif($is_NS4)		$classes[] = 'ns4';
		elseif($is_safari)	$classes[] = 'safari';
		elseif($is_chrome)	$classes[] = 'chrome';
		elseif($is_IE){
			$classes[] = 'ie';
			if(preg_match('/MSIE ( [0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
				$classes[] = 'ie' . $browser_version[1];
		} else $classes[] = 'unknown';

		if($is_iphone) $classes[] = 'iphone';

		return $classes;
	}

	add_filter('body_class', 'wc_browser_body_class');

	/* =============================================================================================
	WP URLs
	============================================================================================= */

	function wc_ajaxurl() {
		?>
		<script type="text/javascript">
			var ajaxurl =	"<?php echo admin_url('admin-ajax.php'); ?>";
			var wpurl =		"<?php bloginfo('template_directory'); ?>";
		</script>
		<?php
	}

	add_action('wp_head', 'wc_ajaxurl');

	/* =============================================================================================
	Facebook OG Metas
	============================================================================================= */

	function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}

	add_filter('language_attributes', 'add_opengraph_doctype');

	//Lets add Open Graph Meta Info
	function wc_fbog() {

		global $post;
		global $site;

		echo "\n\t\t";
		$metas = array();

		$metas[] = '<meta property="fb:admins" content="YOUR USER ID">';
		$metas[] = '<meta property="og:title" content="' . get_the_title() . '">';
		$metas[] = '<meta property="og:type" content="article">';
		$metas[] = '<meta property="og:url" content="' . get_permalink() . '">';
		$metas[] = '<meta property="og:site_name" content="' . get_bloginfo('name') . '">';

		$default_image = $site->img('default-image.jpg', false);

		if ( ! is_singular() ) {
			$metas[] = '<meta property="og:image" content="' . $default_image . '">';
		}

		else if ( ! has_post_thumbnail( $post->ID ) ) {
			$metas[] = '<meta property="og:image" content="' . $default_image . '">';
		}

		else {
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			$metas[] = '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '">';
		}

		echo implode("\n\t\t", $metas);
		echo "\n";
	}

	add_action( 'wp_head', 'wc_fbog', 5 );

	/* =============================================================================================
	Add ACF Options Page
	============================================================================================= */

	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page();
	}

	/* =============================================================================================
	Custom Login Fail
	============================================================================================= */

	add_action('wp_login_failed', 'wc_login_fail');

	function wc_login_fail($username){
		// Get the reffering page, where did the post submission come from?
		$referrer = $_SERVER['HTTP_REFERER'];

		// if there's a valid referrer, and it's not the default log-in screen
		if(!empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin')){
			// let's append some information (login=failed) to the URL for the theme to use
			wp_redirect($referrer . '?login=failed');
		exit;
		}
	}

	add_action( 'wp_authenticate', 'wc_empty_user', 1, 2 );

	function wc_empty_user( $username, $pwd ) {

		$referrer = $_SERVER['HTTP_REFERER'];

		// if there's a valid referrer, and it's not the default log-in screen
		if(!empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin')){

			if ( empty( $username ) ) {
				// let's append some information (login=failed) to the URL for the theme to use
				wp_redirect($referrer . '?login=failed');
				exit;
			}
		}
	}

	/* =============================================================================================
	painLESS FTW
	============================================================================================= */

	function wc_painLESS($tag, $handle) {

		global $wp_styles;
		$match_pattern = '/\.less$/U';
		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {

			if( include_once (get_template_directory() . '/lib/lessc.inc.php') ) {

				$src = $wp_styles->registered[$handle]->src;
				$path = substr($src, 0, strrpos($src, '/'));
				$file = substr($src, strrpos($src, '/') + 1);
				$rel_path = str_replace(get_template_directory_uri(), '', $path);
				$comp_file = str_replace('.less', '.css', $file);

				$src_file = get_template_directory() . "{$rel_path}/{$file}";
				$dest_file = get_template_directory() . "{$rel_path}/{$comp_file}";

				$less = new lessc;
				$less->checkedCompile($src_file, $dest_file);

				$tag = str_replace('.less', '.css', $tag);
			}
		}

		return $tag;
	}

	add_filter( 'style_loader_tag', 'wc_painLESS', 5, 2 );
?>