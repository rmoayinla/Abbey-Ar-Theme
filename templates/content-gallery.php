<?php
/**
 *
 * Template partial for displaying Gallery post formats
 * this theme support gallery post format by default, so you can show your posts in a gallery format
 * Header and footer are not showed here, only the gallery content
 * this template includes a Gallery sidebar for showing Gallery widgets
 *
 *@see: single.php for the actual loading of this file 
 *@category: Templates
 *@since: 0.1
 *@package: Abbey theme
 *
 */

?>

<?php $abbey_galleries = abbey_gallery_images(); ?>
		
		<section id="content" class="row">
			<header id="post-content-header" class="row text-center">
				<div id="page-title-wrap" class="md-50">
					<?php echo sprintf('<h3 class="page-title"><em>%1$s</em> %2$s</h3>', 
										__( "Photo Gallery:", "abbey" ), get_the_title() 
								); 
					?>
					<summary class="post-excerpt"><?php the_excerpt(); ?></summary>

					<?php do_action( "abbey_gallery_image_slides", $abbey_galleries ); ?>
				</div>
			</header>

			<div id="gallery-content" class="row">
				
				<aside class="col-md-3" id="gallery-sidebar">
					<?php do_action( "abbey_gallery_post_sidebar", $abbey_galleries ); ?>
				</aside>
				
				<figure <?php abbey_post_class( "col-md-6 col-md-offset-2" ); ?> id="post-<?php the_ID(); ?>">
					<?php the_content(); ?>
				</figure>

			</div>

		</section> <!--#content -->