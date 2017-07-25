<?php
get_header();

global $count, $wp_query, $abbey_author_posts;



$count = abbey_posts_count();

$abbey_author_posts = array();

$queried_object = get_queried_object();

$queried_name = "author";
?>

	<main id="<?php abbey_theme_page_id(); ?>" class="row archives">
		
		<header id="<?php echo $queried_name; ?>-archive-header" class="text-center archive-header">
			<div class="md-50"><?php do_action( "abbey_archive_page_heading", $queried_object ); ?></div>
		</header>

		<section id="content" class="row archive-content">

			<?php if ( have_posts() ) : abbey_group_posts( $abbey_author_posts ); ?>
				
				<div id="<?php echo $queried_name; ?>-archive-posts" class="col-md-12 archive-posts" >
					
					<?php while ( have_posts() ) : the_post(); ?>
						<?php abbey_add_posts( $abbey_author_posts ); ?>
					<?php endwhile; 	?>

					<?php get_template_part("templates/content", "author-archive"); ?>
					
				</div>

			<?php else : get_template_part("templates/content", "archive-none"); ?>

			<?php endif; ?>
		</section>


	
		

	</main>		<div style="direction: ltr;"> <?php print_r( $wp_query->query );
				 ?></div><?php

get_footer();