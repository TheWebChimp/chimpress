<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Please see /external/starkers-utilities.php for info on Chimpress_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Chimpress
 * @since 		Chimpress 1.0
 */
?>
<?php Chimpress_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<h2>Page not found</h2>

<?php Chimpress_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>