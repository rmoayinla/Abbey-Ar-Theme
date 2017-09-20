<?php
/**
 *
 * A default wordpress template file for displaying pages 
 *
 * you can copy this template, rename to a different file to display specific pages 
 * example copy the content here, create a file and name it page-contact.php to display contact page 
 * 
 *@author: Rabiu Mustapha
 *@package: Abbey theme
 *@version: 0.11
 *
 *
 */

	/**
	 * Simple indicator to determine if the page should have a sidebar
	 * this indicator is set by a custom field in the wordpress admin post page 
	 * true: if there should not be a sidebar
	 * false: if there should be a sidebar 
	 */
	$no_sidebar = ( abbey_custom_field( "no_sidebar" ) == 0 ) ? false  : true;

	//containers for setting some html attributes if these page has a thumbnail image //
	$thumbnail_url = $thumbnail_class = "";

	if ( has_post_thumbnail() ) {
 		$thumbnail_url = get_the_post_thumbnail_url(); //the post thumbnail url //
 		$thumbnail_class = "has-thumbnail";  //a css class //
	}

	/**
	 * Simple indicator to determine if the page has a background 
	 * this indicator is set by a custom filed in the wordpress admin post page
	 * the page background is added by using css background properties 
	 */
	$page_background = !empty( abbey_custom_field( "page_background" ) ) ? abbey_custom_field( "page_background" ) : "";

?>

<?php get_header(); ?>

	<main id="<?php abbey_theme_page_id(); ?>" 
		class="row site-content <?php if( $no_sidebar ){ echo "no-sidebar";}?>"
	> 
	
	<?php if ( have_posts() ) : ?>
	
		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php global $more; $more = 0; ?>
			
			<header id="site-content-header" class="before-content"><?php do_action( "abbey_theme_before_content" ); ?></header>
			
			<header id="page-content-header" class="content-header">
				<div class="page-title-wrap md-50">		
					<h1 class="page-title no-top-margin" itemprop="headline"><?php the_title(); ?></h1>
					<h4><?php abbey_custom_field( "sub_title", true ); ?> </h4>
					<summary class="description" itemprop="summary"><?php the_excerpt(); ?></summary>
				</div>

			</header><!-- #page-content-header closes -->

			<div class="row inner-content" style="background-image:url(<?php abbey_custom_field( "page_background", true );?> );">
				
				<?php get_template_part("templates/content", "page"); ?>
				
				<?php if ( !$no_sidebar ) : ?>
					<aside class="col-md-3 sidebar" role="complimentary" id="primary-sidebar">
						<?php abbey_display_sidebar( "sidebar-main" ); ?>
					</aside>
				<?php endif; ?>

			</div>
			
		<?php endwhile; ?> 

	<?php else : get_template_part("templates/content", "none");?>

	<?php endif; ?>


</main> <!--main #page closes -->	<?php 
	
get_footer();