<?php
/**
 * 
 * Wordpress default category template file for showing category archives
 * 
 * this file is loaded when category archive is queried e.g. www.example.com/category/news 
 * this file can be loaded for only a particular category by renaming it to category-slug.php
 *
 *@author: Rabiu Mustapha
 *@package: Abbey theme
 *@version: 0.11
 *
 *
 *
 */

//include header.php //
get_header();

//global variables needed for displaying the template //
global $count, $wp_query, $abbey_query, $abbey_defaults;

//local variables to store some query info //
$current_page = $queried_object = $queried_name = $archive_options = "";

//get the current page we currently are, the current page is added to page styles //
$count = abbey_posts_count();

//this global var stores some query info from wp_query//
$abbey_query = array();

//get the queried object, this is an instance of WP_Terms class //
$queried_object = get_queried_object();

//the name of the category being queried //
$queried_name = $queried_object->slug;

//check if we have some archive settings in our theme global settings //
$archive_options = ( !empty( $abbey_defaults[ "archive" ] ) ) ? $abbey_defaults[ "archive" ] : array();
?>

	<main id="<?php abbey_theme_page_id(); ?>" class="row archives <?php abbey_page_class(); ?>">
		
		<header id="<?php echo $queried_name; ?>-archive-header" class="text-center archive-header">
			
			<div class="md-50"><?php do_action( "abbey_archive_page_heading", $queried_object ); ?></div>

			<?php print_r( get_term_meta( $queried_object->term_id, "thumbnail", true ) ); ?>

		</header>

		<section id="content" class="row archive-content">

			<?php if ( have_posts() ) : abbey_setup_query(); ?>

				<header class="archive-post-slides posts-slides" 
					data-slick='{"slidesToShow":1, "slidesToScroll":1,"autoplay":false,"arrows":false, 
					<?php if( is_rtl() ) echo '"rtl":true'; ?>,"dots":true,"infinite":true}'
				>
					<?php do_action( "abbey_theme_archive_slide" ); ?> 
				</header>

				<div class="archive-layout"><?php abbey_archive_layouts(); ?> </div>

				<?php if( !empty( (bool) $archive_options[ "sidebar" ] ) ) : ?>
					<aside class="col-md-3 archive-sidebar" id="<?php echo $queried_name; ?>-archive-summary">
						<?php do_action( "abbey_archive_page_summary", $abbey_query ); ?>
					</aside>

				<?php endif; ?>

				<section id="<?php echo $queried_name; ?>-archive-posts" class="col-md-8 col-md-offset-1 archive-posts-wrapper">
					
					<div class="category-archive-posts archive-posts">
						<?php while ( have_posts() ) : the_post(); $count++; ?>
							<?php get_template_part("templates/content", "archive"); ?>
						<?php endwhile; ?>
					</div>
					
					<div class="navigation" role="navigation"><?php abbey_posts_pagination();?></div>

				</section>

		
				<?php else : get_template_part("templates/content", "archive-none"); ?>

			<?php endif; ?>	

		</section>
		

	</main>		<div style="direction: ltr;"> <?php ?></div><?php

//include the footer.php //
get_footer();