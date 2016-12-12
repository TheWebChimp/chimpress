<?php
/**
 * The Template for displaying all single posts
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

		<section class="section section-single">
			<div class="inner boxfix boxfix-vert">
				<div class="margins">
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						<article>
							<h2><?php the_title(); ?></h2>
							<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
							<?php the_content(); ?>
						</article>

					<?php endwhile; ?>
				</div>
			</div>
		</section>

	<?php $site->partial('footer'); ?>
<?php $site->partial('footer-html'); ?>