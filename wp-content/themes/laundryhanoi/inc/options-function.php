<?php
/**
 * Display Call Ring
 */
function insert_callring(){
	global $sh_option;
	if( $sh_option['switch-phonering'] && $sh_option['phonering-number'] ) {
		wp_enqueue_style( 'phonering-style' );
		echo '<div class="quick-alo-phone quick-alo-green quick-alo-show d-none d-xl-block" id="quick-alo-phoneIcon">';
			echo '<a href="tel:'. $sh_option['phonering-number'] .'" title="'. __('Call now','shtheme') .'">';
				echo '<div class="quick-alo-ph-circle"></div>';
				echo '<div class="quick-alo-ph-circle-fill"></div>';
				echo '<div class="quick-alo-ph-img-circle"></div>';
				echo '<span class="phone_text">'. __('Call now','shtheme') .': '. $sh_option['phonering-number'] .'</span>';
			echo '</a>';
		echo '</div>';
		echo '<div class="alo-floating d-xl-none"><a href="tel:'. $sh_option['phonering-number'] .'"><i class="fas fa-phone"></i> <strong>'. $sh_option['phonering-number'] .'</strong></a></div>';
	}
}
add_action('sh_after_footer','insert_callring');

/**
 * Display Metaslider
 */
function insert_metaslide(){
	global $sh_option;
	if( $sh_option['metaslider'] && is_home() ) {
		$metaslider = $sh_option['metaslider'];
		echo '<div class="slider">'.do_shortcode('[metaslider id="'.$metaslider.'" restrict_to=home]').'</div>';
	}
}
add_action('before_loop_main_content','insert_metaslide');

/**
 * Display Logo
 */
function display_logo(){
	global $sh_option;
	$url_logo = $sh_option['opt_settings_logo']['url'];
	if(  $url_logo ) {
		echo '<a href="'.get_site_url( ).'"><img src="'. $url_logo .'"></a>';
	}
}

/**
 * Display Footer
 */
function sh_footer_widget_areas() {

	global $sh_option;

	$footer_widgets = $sh_option['opt-number-footer'];
	$footer_widgets_number = intval($footer_widgets);

	switch ($footer_widgets_number) {
	    case '1':
	        $classes = 'footer-widgets-area col-md-12';
	        break;
	    case '2':
	        $classes = 'footer-widgets-area col-md-6';
	        break;
	    case '3':
	        $classes = 'footer-widgets-area col-md-4';
	        break;
	    case '4':
	        $classes = 'footer-widgets-area col-md-3';
	        break;
	    case '5':
	        $classes = 'footer-widgets-area col-lg-15 col-md-4 col-sm-6';
	        break;
	}

 	$counter = 1;
	while ( $counter <= $footer_widgets_number ) {

		echo '<div class="'. $classes .'">';
			dynamic_sidebar( 'footer-' . $counter );
		echo '</div>';
		$counter++;

	}

}
add_action( 'sh_footer', 'sh_footer_widget_areas' );

/**
 * Inser Code To Header Footer
 */
function insert_code_to_header(){
	global $sh_option;
	$html_header = $sh_option['opt-textarea-header'];
	if( $html_header ) {
		echo $html_header;
	}
}
add_action( 'wp_head','insert_code_to_header' );

function insert_code_to_footer(){
	global $sh_option;
	$html_footer = $sh_option['opt-textarea-footer'];
	if( $html_footer ) {
		echo $html_footer;
	}
}
add_action( 'wp_footer','insert_code_to_footer' );