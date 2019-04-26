<?php
/**
 * Include function woocommerce
 */
require get_template_directory() . '/inc/functions-woocommerce/customizer-cart/customizer-cart-main.php';
require get_template_directory() . '/inc/functions-woocommerce/gallery-product/gallery-main.php';
require get_template_directory() . '/inc/functions-woocommerce/tooltip-product.php';
require get_template_directory() . '/inc/functions-woocommerce/swap-image-product.php';
require get_template_directory() . '/inc/functions-woocommerce/woocommerce-grid-list-toggle.php';

/**
 * Register Shop Widget Area
 */
function shtheme_add_sidebar_shop() {
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'shtheme' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Add widgets here.', 'shtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'shtheme_add_sidebar_shop' );

/**
 * Add Support Woocommrce
 */
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );

/**
 * Setup Layout Page Woocommerce
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function my_theme_wrapper_start() {
	echo '<div class="content-sidebar-wrap">';
	echo '<main id="main" class="site-main" role="main">';
}

function my_theme_wrapper_end() {
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	echo '</main>';
	if( $layout != '1' ) {
		echo '<aside class="sidebar sidebar-primary sidebar-shop" itemscope itemtype="https://schema.org/WPSideBar">';
			if( $sh_option['display-shopsidebar'] == 1 ) {
				dynamic_sidebar( 'sidebar-shop' );
			} else {
				dynamic_sidebar( 'sidebar-1' );
			}
		echo '</aside>';
	}
	echo '</div>';
}

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

/**
 * Show image category product
 */
function woocommerce_category_image($products) {
    $thumbnail_id = get_woocommerce_term_meta( $products, 'thumbnail_id', true );
    $arr = wp_get_attachment_image_src( $thumbnail_id, 'full' );
    $image = $arr[0];
    if ( $image ) {
	    echo '<div class="product-cat__featured-image mb-5"><img src="' . $image . '" alt="" /></div>';
	}
}

/**
 * Edit number product show per page in category product
 */
function woocommerce_edit_loop_shop_per_page( $cols ) {
	global $sh_option;
	if ( $sh_option['number-products-cate'] ) {
		$cols = $sh_option['number-products-cate'];
	} else {
		$cols = get_option( 'posts_per_page' );
	}
	return $cols;
}
add_filter( 'loop_shop_per_page', 'woocommerce_edit_loop_shop_per_page', 20 );

/**
 * Add percent sale in content product template
 */
function add_percent_sale(){
	global $product;
	if ( $product->is_on_sale() && $product->is_type( 'simple' ) ) {
		$per = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
		echo '<span class="percent">-'. $per .'%</span>';
	}
}
add_action( 'woocommerce_after_shop_loop_item','add_percent_sale',15 );

/**
 * Overwrite field checkout
 */
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_postcode']);

    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );


/**
 * Return class layout product
 */
function get_column_product($numcol) {
	global $sh_option;
	switch ($numcol) {
	    case '1':
	        $post_class = 'col-md-12';
	        break;
	    case '2':
	        $post_class = 'col-6';
	        break;
	    case '3':
	        $post_class = 'col-md-4 col-sm-6 col-6';
	        break;
	    case '4':
	        $post_class = 'col-md-3 col-sm-4 col-6';
	        break;
	    case '5':
	        $post_class = 'col-lg-15 col-md-3 col-sm-4 col-6';
	        break;
	    case '6':
	        $post_class = 'col-lg-2 col-md-3 col-sm-4 col-6';
	        break;
	}
	return $post_class;
}

/**
 * Tab Woocommerce
 */
function woo_remove_product_tabs( $tabs ) {
	// unset( $tabs['description'] );
    // unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_rename_tabs( $tabs ) {
	$tabs['description']['title'] 	= __( 'Information', 'shtheme' );
	$tabs['image']['title'] 		= __( 'Gallery', 'shtheme' );
	$tabs['video']['title'] 		= __( 'Video', 'shtheme' );
	$tabs['document']['title'] 		= __( 'Attachments', 'shtheme' );

	$tabs['image']['priority']		= 50;
	$tabs['video']['priority']		= 60;
	$tabs['document']['priority']	= 70;

	$tabs['image']['callback']		= 'content_tab_image';
	$tabs['video']['callback']		= 'content_tab_video';
	$tabs['document']['callback']	= 'content_tab_document';
	return $tabs;
}
// add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

/**
 * Customizer number product related
 */
function custom_numberpro_related_products_args( $args ) {
	global $sh_option;
	$numpro_related = $sh_option['number-product-related'];
	$args['posts_per_page'] = $numpro_related; // number related products
	// $args['columns'] 	= 2; // arranged in number columns
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'custom_numberpro_related_products_args' );

/**
 * Get Price Product
 */
function get_price_product(){
	global $product;
	if ( $product->is_type( 'simple' ) ) {
		$regular_price 	= $product->regular_price;
		$sale_price 	= $product->sale_price;
		if ( empty( $regular_price ) ) {
			echo '<p class="price">'.__( 'Contact', 'shtheme' ).'</p>';
		} elseif ( ! empty( $regular_price ) && empty( $sale_price ) ) {
			echo '<p class="price">'. wc_price( $regular_price) . '</p>';
		} elseif ( ! empty( $regular_price ) && ! empty( $sale_price ) ) {
			echo '<p class="price"><ins>'. wc_price( $sale_price) .'</ins><del>'. wc_price( $regular_price) .'</del></p>';
		}
	} elseif( $product->is_type( 'variable' ) ) {
		if( is_product() ) {
			// echo '<p class="price d-none">'. $product->get_price_html() .'</p>';
			echo '<p class="price d-none">'. wc_price($product->get_price()) .'</p>';
		} else {
			echo '<p class="price">'. wc_price($product->get_price()) .'</p>';
		}
	}
}
//add_action( 'woocommerce_after_shop_loop_item','get_price_product',9 );

/**
 * Title Product content-product.php
 */
function add_title_name_product(){
	echo '<h3 class="woocommerce-loop-product__title"><a 
	title="' . get_the_title() . '" 
	href=" '. get_the_permalink() .' ">' . get_the_title() . ' </a></h3>';
}
add_action( 'woocommerce_shop_loop_item_title','add_title_name_product',10 );
function add_excerpt_product() {
	echo '<div class="excerpt-product"> '.get_the_excerpt().' </div>';
}
add_action( 'woocommerce_shop_loop_item_title','add_excerpt_product',15 );

/**
 * Include JS CSS Files 
 */
function shtheme_lib_woocommerce_scripts(){

	// Main js
	wp_enqueue_script( 'main-woo-js', SH_DIR . '/lib/js/main-woo.js', array(), '1.0', true );
	// wp_localize_script(	'main-woo-js', 'ajax', array( 'url' => admin_url('admin-ajax.php') ) );
	
	// Woocommerce Style
	wp_enqueue_style( 'woocommerce-style', SH_DIR .'/lib/css/custom-woocommerce.css' );
	wp_enqueue_style( 'woocommerce-layout-style', SH_DIR .'/lib/css/layout-woocommerce.css' );

}
add_action( 'wp_enqueue_scripts', 'shtheme_lib_woocommerce_scripts' , 99 );

/**
 * Insert button share single product
 */
function insert_share_product(){
	?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57e482b2e67c850b"></script>
	<div class="addthis_inline_share_toolbox_4524"></div>
	<?php
}
add_action( 'woocommerce_share','insert_share_product' );

/**
 * Returns Mini Cart
 *
 * @return string
 */
if( ! function_exists('sh_woocommerce_get__cart_menu_item__content') ) {
	function sh_woocommerce_get__cart_menu_item__content() {
		?>
		<div class="navbar-actions">
			<div class="navbar-actions-shrink shopping-cart">
				<a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>" class="shopping-cart-icon-container ffb-cart-menu-item">
					<span class="shopping-cart-icon-wrapper" title="<?php echo WC()->cart->get_cart_contents_count();?>">
						<span class="shopping-cart-menu-title">
							<?php echo get_the_title( wc_get_page_id('cart') );?>
						</span>
						<img src="<?php echo get_stylesheet_directory_uri();?>/lib/images/icon-cart.png">
					</span>
				</a>
				<div class="shopping-cart-menu-wrapper">
					<?php wc_get_template( 'cart/mini-cart.php', array('list_class' => ''));?>
				</div>
			</div>
	</div>
		<?php
	}
	add_action( 'sh_after_menu', 'sh_woocommerce_get__cart_menu_item__content');
}

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<div class="navbar-actions">
		<div class="navbar-actions-shrink shopping-cart">
			<a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>" class="shopping-cart-icon-container ffb-cart-menu-item">
				<span class="shopping-cart-icon-wrapper" title="<?php echo WC()->cart->get_cart_contents_count();?>">
					<span class="shopping-cart-menu-title">
						<?php echo get_the_title( wc_get_page_id('cart') );?>
					</span>
					<img src="<?php echo get_stylesheet_directory_uri();?>/lib/images/icon-cart.png">
				</span>
			</a>
			<div class="shopping-cart-menu-wrapper">
				<?php wc_get_template( 'cart/mini-cart.php', array('list_class' => ''));?>
			</div>
		</div>
	</div>
	<?php
	$fragments['.navbar-actions'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

/**
 * Button Detail In File content-product.php
 */
function insert_btn_detail(){
	?>
	<div class="row">
		<div class="col-lg-6 text-lg-right text-center  button-chitiet ">
		<a href="<?php echo get_permalink() ?> " title="'<?php echo get_the_title() ?> " class="view-more">Chi tiết</a>
		</div>
		<div class="col-lg-6 text-lg-left  text-center button-lienhe">
			<?php $url = home_url( 'lien-he' ); ?>
				<a class="button-contact" href="<?php echo $url  ?>?ten=<?php echo get_the_title() ?>"> Liên hệ</a>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item','insert_btn_detail',20 );

/**
 * Hook Woocommerce
 */
// File archive-product.php
// remove_action( 'woocommerce_before_shop_loop','woocommerce_result_count',20 );
// remove_action( 'woocommerce_before_shop_loop','woocommerce_catalog_ordering',30 );
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar',10 );

// File content-product.php
remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10 );
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10 );
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10 );
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10 );

// File content-single-product.php
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta',40 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta',6 );
