<?php
/**
 * Template Name: Page Template
 *
 * @package 	WordPress
 * @subpackage 	Chimpress
 * @since 		Chimpress 1.0
 */
?>
<?php Chimpress_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<section>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
	<?php endwhile; ?>
</section>

<?php Chimpress_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>