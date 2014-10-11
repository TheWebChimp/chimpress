<?php if(STICKY_FOOTER): ?>
	<div id="wrapper" class="site-wrapper">
<?php endif; ?>

<header class="site-header">
	<h1 class="site-logo"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	<nav class="site-header-navigation primary-navigation"><?php wp_nav_menu( array('container' => false, 'theme_location' => 'primary')); ?></nav>
	<?php //get_search_form(); ?>
</header>
