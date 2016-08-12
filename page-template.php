<?php
/**
 * Template Name: Page Template
 *
 * @package 	WordPress
 * @subpackage 	Chimpress
 * @since 		Chimpress 1.0
 */
?>
<?php $site->getParts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<section class="section section-page">
	<div class="inner boxfix boxfix-vert">
		<div class="margins">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</div>
</section>

<?php $site->getParts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>