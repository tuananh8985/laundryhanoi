<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

global $sh_option;
get_header(); ?>
	<div id="primary" class="content-sidebar-wrap">

		<?php do_action( 'before_main_content' ) ?>

		<main id="main" class="site-main" role="main">

			<?php do_action( 'before_loop_main_content' ) ?>


			<div class="box-about" id="home-aboutus">
				<div class="container">
					<div class="section-title wow fadeInDown text-center"><h2 class="heading"><a> <?php echo $sh_option['text'] ?> </a></h2></div>
					<div class="box-info-about ">
						<div class="row">
							<div class="col-lg-6 wow fadeInLeft box-desc">
								<?php 
									if( $sh_option['page-introduce'] ) {
										$page_introduce = $sh_option['page-introduce'];
										$link = get_page_link($page_introduce);
										$object_page 	= get_post($page_introduce);
										$content 		= $object_page->post_content;
										echo '<div class="haboutus-desc">'. apply_filters('the_content', $content) .'</div>';
									}
								?>
							</div>
							<div class="col-lg-6 wow fadeInRight box-image-about">
								<div class="haboutus-img">
			        				<div class="embed-responsive embed-responsive-16by9">
									  <iframe class="embed-responsive-item" src="<?php echo $sh_option['text2'] ?>" allowfullscreen></iframe>
									</div>
			        			</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			

			<div id="news">
				<div class="container">
					<!-- --------------------- News --------------------- -->
					<?php
					if( $sh_option['list_cat_post'] ) {
						$list_cat_post = $sh_option['list_cat_post'];
						if( $sh_option['number_news'] ) {
							$number_news = $sh_option['number_news'];
						}
						if( $sh_option['type_layout'] ) {
							$type_layout = $sh_option['type_layout'];
						}
						echo '<div class="news-wrap">';
							foreach ($list_cat_post as $key => $idpost) {
								echo '<h2 class="heading"><a title="'. get_cat_name( $idpost ) .'" href="'. get_category_link( $idpost ) .'">'. get_cat_name( $idpost ) .'</a></h2>';
								echo do_shortcode('[shblog posts_per_page="' . $number_news . '" categories="' . $idpost . '" number_character="140" style="' . $type_layout . '"]');
							}
						echo '</div>';
					}
					?>
				</div>
			</div>
			<div id="products">
				<div class="container">
					<!-- --------------------- Products --------------------- -->
					<?php
					if ( class_exists( 'WooCommerce' ) ) {
						if( $sh_option['list_cat_product'] ) {
							$list_cat_product = $sh_option['list_cat_product'];
							if( $sh_option['number_product'] ) {
								$number_product = $sh_option['number_product'];
							}
							if( $sh_option['number_product_row'] ) {
								$number_product_row = $sh_option['number_product_row'];
							}
							echo '<div class="product-wrap">';
								foreach ($list_cat_product as $key => $idpost) {
									echo '<h2 class="heading"><a title="'. get_dm_name( $idpost,'product_cat' ) .'" href="'. get_dm_link( $idpost,'product_cat' ) .'">'. get_dm_name( $idpost,'product_cat' ) .'</a></h2>';
									echo do_shortcode('[shproduct posts_per_page="' . $number_product . '" categories="' . $idpost . '" numcol="' . $number_product_row . '"]');
								}
							echo '</div>';
						}
					}
					?>
				</div>
			</div>

			<div id="testimonials">
				<div class="container">
					<h2 class="m_1 nobg text-center heading"><a><?php echo $sh_option['text3']; ?></a></h2>
					<div class="testimonials-desc text-center col-lg-8 offset-lg-2">
						<p><?php echo $sh_option['textarea']; ?></p>
					</div>
					<?php
					wp_enqueue_script( 'slick-js' );
			        wp_enqueue_style( 'slick-style' );
			        wp_enqueue_style( 'slick-theme-style' );
			        echo '<div class="slick-carousel" 
						data-item="2" 
						data-item_md="2" 
						data-item_sm="1" 
						data-item_mb="1" 
						data-row="1" 
						data-dots="true" 
						data-arrows="false" 
						data-vertical="false">';
						$args = array(
	                        'post_type' 		=> 'testimonials',
	                        'posts_per_page'    => 20,
	                    );
	                    $the_query = new WP_Query($args);
	                    while($the_query -> have_posts()) :
	                	$the_query -> the_post();
	                	$position = get_field('position');
						?>
						<div class="item">
							<?php if(has_post_thumbnail()) the_post_thumbnail("sh_thumb180x180",array("class" => "","alt" => get_the_title()));?>
							<div class="testimonials-content">
								<div class="testimonials-item">
									<div class="clearfix"></div>
									<div class="name"><?php the_title( );?></div>
									<div class="position"><?php echo $position;?></div>
									<div class="content">
										<?php the_content( );?>
									</div>
								</div>
							</div>
						</div>
						<?php
						endwhile;
						wp_reset_postdata();
						echo '</div>';
					?>
					</div>
			</div>

			<div class="feature-information">
				<div class="container">
					<?php
					if( $sh_option['opt-gallery3'] ) {
						$gallery3 = $sh_option['opt-gallery3'];
						echo '<div class="box_information">';
							echo '<div class="row">';
							foreach ($gallery3 as $key => $value) {
								echo '<div class="box_item_information col-lg-3 col-6">';
									echo '<div class="box_information_item">';
										echo '<div class="img_item"><img src="'.$value['image'].'"/></div>';
										echo '<div class="information_item">';
											echo '<h3 class="title_information_item">'.$value['title'].'</h3>';
											echo '<div class="desc_information_item">'.$value['description'].'</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							}
							echo '</div>';
						echo '</div>';
					}
					?>
				</div>
			</div>

		</main><!-- #main -->

		<?php //do_action( 'sh_after_content' );?>

	</div><!-- #primary -->
	
<?php
get_footer();