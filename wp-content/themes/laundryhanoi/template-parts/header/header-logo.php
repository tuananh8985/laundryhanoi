<?php
/**
 * Template for Logo Header
 *
 * @package SH_Theme
 */

global $sh_option;
?>
<!-- Start Top Header -->
<?php if( $sh_option['display-topheader-widget'] == 1 ) : ?>
	<div class="top-header">
		<div class="container">
			<?php dynamic_sidebar( 'Top Header' );?>
		</div>
	</div>
<?php endif; ?>
<!-- End Top Header -->

<div class="header-main">
	<div class="container">
		<div class="site-branding">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<div class="header-content">
			<a id="showmenu" class="d-lg-none">
				<span class="hamburger hamburger--collapse">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</span>
			</a>
			<div class="row align-items-center">
				<div class="col-md-3">
					<div class="logo">
						<?php display_logo();?>
					</div>
				</div>
				<div class="col-md-9">
					<nav id="site-navigation" class="main-navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
						<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'menu_class' => 'menu clearfix' ) );?>
					</nav>
				</div>
			</div>
		</div>
		<?php //do_action( 'sh_after_menu' );?>
	</div>
</div>
