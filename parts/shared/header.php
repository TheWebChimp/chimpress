<?php if(STICKY_FOOTER): ?>
	<div id="wrapper">
<?php endif; ?>

<header>
	<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	<nav class="primary-navigation"><?php wp_nav_menu( array('container' => false, 'theme_location' => 'primary')); ?></nav>
	<?php //get_search_form(); ?>
</header>
