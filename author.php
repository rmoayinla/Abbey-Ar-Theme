<?php
get_header();

global $count;

global $wp_query;

global $abbey_author_posts;


$current_page = (int) get_query_var( 'paged' );
$count = ( $current_page > 1 ) ? ( ( $current_page - 1) * (int) get_option( 'posts_per_page' ) ) : 0;

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
				
				<div id="<?php echo $queried_name; ?>-archive-posts" 
					class="col-md-12 archive-posts" >
					
					<?php while ( have_posts() ) : the_post(); 
							abbey_add_posts( $abbey_author_posts ); 
					endwhile; 	?>

					<?php get_template_part("templates/content", "author-archive"); ?>

					
				</div>

		
				<?php else : get_template_part("templates/content", "archive-none"); ?>

		</section>


	<?php endif; ?>
		

	</main>		<div style="direction: ltr;"> <?php print_r( $wp_query->query );
				 ?></div><?php

get_footer();