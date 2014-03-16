<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Foundation_s
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<header id="masthead" class="site-header contain-to-grid" role="banner">
		<nav id="site-navigation" class="main-navigation top-bar" role="navigation" data-topbar>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'foundation-s' ); ?></a>

			<ul class="site-branding title-area">
				<li class="name">
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h1>
				</li>
				<li class="toggle-topbar menu-icon">
					<a href="#"><span><?php esc_attr_e( 'Menu', 'foundation-s' ); ?></span></a>
				</li>
			</ul>

			<section class="top-bar-section">
			<?php if (has_nav_menu('right-menu')) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'right-menu', 'menu_class' => 'right', 'container' => '', 'walker' => new foundation_s_topbar() )); ?>
			<?php endif; ?>

			<?php if (has_nav_menu('left-menu')) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'left-menu', 'menu_class' => 'left', 'container' => '', 'walker' => new foundation_s_topbar() )); ?>
			<?php endif; ?>
			</section><!-- /.top-bar-section -->
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content row">
