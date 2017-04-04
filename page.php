<?php
/*
* a wordpress template file for displaying pages 
* you can copy this template, rename to a different file to display specific pages 
* example copy the content here, create a file and name it page-contact.php to display contact page 
* 
*/
$no_sidebar = ( abbey_custom_field( "no_sidebar" ) == 0 ) ? false  : true;
$thumbnail_url = $thumbnail_class = "";
 if ( has_post_thumbnail() ) {
 	$thumbnail_url = get_the_post_thumbnail_url();
 	$thumbnail_class = "has-thumbnail"; 
}
$page_background = !empty( abbey_custom_field( "page_background" ) ) ? abbey_custom_field( "page_background" ) : "";
get_header(); ?>

<main id="<?php abbey_theme_page_id(); ?>" class="row site-content <?php if( $no_sidebar ){ echo "no-sidebar";}?>"
	style="backgound-image:url(<?php echo $page_background; ?>)"> 
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php global $more; $more = 0; ?>

			<header id="page-content-header" class="<?php echo esc_attr( $thumbnail_class ); ?>">
				<div id="page-title">
					<div class="page-title-wrap">
						<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
						<h4><?php abbey_custom_field( "sub_title", true ); ?> </h4>
						<summary class="description" itemprop="summary"><em><?php the_excerpt(); ?></em></summary>
					</div>
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