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
<?php $site->getParts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<section class="section section-404">
	<div class="inner boxfix boxfix-vert">
		<div class="margins">
			<h2>Page not found</h2>
		</div>
	</div>
</section>

<?php $site->getParts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>