<?php if(STICKY_FOOTER): ?>
	<div class="sticky-wrapper">
<?php endif; ?>

<header class="site-header">
	<h1 class="site-logo"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	<nav class="site-header-navigation primary-navigation">
		<div class="hamburger show-mobile"><i class="fa fa-navicon"></i></div>
		<?php wp_nav_menu( array('container' => false, 'theme_location' => 'primary') ); ?>
	</nav>
</header>