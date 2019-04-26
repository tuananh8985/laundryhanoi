<?php
add_action( 'widgets_init', 'like_box_facebook_widget' );

function like_box_facebook_widget() {
    register_widget('Like_Box_Facebook');
}

class Like_Box_Facebook extends WP_Widget {

    function __construct() {
		parent::__construct (
	      	'facebook_like',
	      	__( '3B - Facebook Like Box', 'shtheme' ), 
	      	array(
	          	'description' => __( 'Display like box fanpage Facebook', 'shtheme' ),
	      	)
	    );
    }

    function widget( $args, $instance ) {
		extract($args);
		$page_url = $instance['page_url'];
		echo $before_widget;
		if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;

		if( $page_url ): ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0';
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<div class="fb-page" 
				data-href="<?php echo $page_url; ?>" 
				data-small-header="false" 
				data-adapt-container-width="true" 
				data-hide-cover="false" 
				data-show-facepile="true">
			</div>
		<?php endif;
		echo $after_widget;
    }
 
    function form( $instance ) {
		$default = array(
			'title' 	=> __('Like Facebook','shtheme'),
			'page_url' 	=> '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		?>
		<p>
            <label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php  echo $this->get_field_name('title'); ?>" value="<?php  echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php  echo $this->get_field_id('page_url'); ?>"><?php _e('Link Fanpage', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php  echo $this->get_field_name('page_url'); ?>" value="<?php echo esc_attr( $instance['page_url'] ); ?>" />
        </p>
		<?php
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    
    
}