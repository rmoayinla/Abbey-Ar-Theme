<?php
get_header();

global $count;

global $wp_query;

global $abbey_query;

$count = abbey_posts_count();

$abbey_query = array();
?>

	<main id="<?php abbey_theme_page_id(); ?>" class="row archives">
		
		<header id="site-content-header" class="text-center archive-header">
			<h2 class="page-header no-margin"> 
				<i class="fa fa-search"></i>
				<?php echo sprintf( __( "Search results for '<span class='search-keyword'>%s</span>'", "abbey" ), 
										get_search_query() 
								); ?> 
			</h2>
			<div id="search-form"> <?php get_search_form(); ?></div>
		</header>

		<section id="content" class="row">

			<?php if ( have_posts() ) : abbey_setup_query(); ?>
				
				<div class="" id="search-results-summary">
					<ul class="list-group"><?php do_action( "abbey_search_page_summary", $abbey_query ); ?></ul>
				</div>

				<div id="search-results" class="">
					
					<?php while ( have_posts() ) : the_post(); $count++; ?>
						<?php get_template_part("templates/content", "archive"); ?>
					<?php endwhile; ?> 
					
					<div class="navigation" role="navigation"><?php abbey_posts_pagination();?></div>
				</div>

			<?php else : get_template_part("templates/content", "archive-none"); ?>

			<?php endif; ?>	
			
		</section>
		

	</main>		<?php

get_footer();