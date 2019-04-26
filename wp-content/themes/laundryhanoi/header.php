<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<?php global $sh_option;?>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

<?php do_action( 'sh_before_header' );?>

<div id="page" class="site">

	<header id="masthead" <?php header_class();?> role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">

		<?php sh_header_layout();?>

	</header><!-- #masthead -->
	<?php if(is_home()): ?>
		<?php echo do_shortcode( '[rev_slider alias="home"]' ); ?>
	<?php endif; ?>
	<div id="content" class="site-content">

		<?php do_action( 'before_content' ) ?>

			<div class="container">
