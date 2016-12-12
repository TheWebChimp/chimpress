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
<?php $site->partial('header-html'); ?>
	<?php $site->partial('header'); ?>

	<section class="section section-404">
		<div class="inner boxfix boxfix-vert">
			<div class="margins">
				<h2>Page not found</h2>
			</div>
		</div>
	</section>

	<?php $site->partial('footer'); ?>
<?php $site->partial('footer-html'); ?>