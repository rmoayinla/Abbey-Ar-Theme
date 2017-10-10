<?php
/**
 * Archive template file 
 *
 * This file displays the markup for all archive queried pages except archive for author and category
 * archive template shows posts matching the current query with some info like title, excerpt, author, more link etc
 * pagination links is shown if the returned query result multi-paged result per the posts_per_page settings
 * if a pagination link is not shown, a load more button is also displayed to load older posts 
 *
 *@author: Rabiu Mustapha
 *@package: Abbey 
 *@sub-package: 
 *@category: 
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
$queried_name = $queried_object->name;

//check if we have some archive settings in our theme global settings //
$archive_options = ( !empty( $abbey_defaults[ "archive" ] ) ) ? $abbey_defaults[ "archive" ] : array();
?>
	
	<header id="<?php echo $queried_name; ?>-archive-header" class="archive-header row">
		<div class="md-50"><?php do_action( "abbey_archive_page_heading", $queried_object ); ?></div>
	</header>

	<main id="<?php abbey_theme_page_id(); ?>" class="row archives <?php abbey_page_class(); ?>">
		
		<section id="content" class="row archive-content">

			<?php if ( have_posts() ) : abbey_setup_query(); ?>
				
				<?php if( !empty( (bool) $archive_options[ "sidebar" ] ) ) : ?>
					<div class="archive-sidebar col-md-3" id="<?php echo $queried_name; ?>-archive-sidebar">
						<?php do_action( "abbey_archive_page_summary", $abbey_query ); ?>
					</div>
				<?php endif; ?>

				<section id="<?php echo $queried_name; ?>-archive-posts" class="col-md-8 col-md-offset-1 archive-posts-wrapper">
					
					<div class="archive-posts">
						<?php while ( have_posts() ) : the_post(); $count++; ?>
							<?php get_template_part("templates/content", "archive"); ?>
						<?php endwhile; ?>
					</div>
					
					<!-- show the pagination links or a read/load more button for more/older posts -->
					<div class="navigation" role="navigation"><?php abbey_posts_pagination(); ?></div>
					
				</section>

				<?php else : get_template_part("templates/content", "archive-none"); ?>

			<?php endif; ?>	

		</section>
		

	</main>		<div style="direction: ltr;"> <?php ?></div><?php

//include footer.php for the template //
get_footer();