<?php
get_header();

global $count;

global $wp_query;

global $abbey_query;

$current_page = (int) get_query_var( 'paged' );
$count = ( $current_page > 1 ) ? ( ( $current_page - 1) * (int) get_option( 'posts_per_page' ) ) : 0;

$abbey_query = array();

$queried_object = get_queried_object();

$queried_name = $queried_object->name;
?>

	<main id="<?php abbey_theme_page_id(); ?>" class="row archives">
		
		<header id="<?php echo $queried_name; ?>-archive-header" class="text-center archive-header">
			<div class="md-50"><?php do_action( "abbey_archive_page_heading", $queried_object ); ?></div>
		</header>

		<section id="content" class="row archive-content">
			<?php if ( have_posts() ) : abbey_setup_query(); ?>
				
				<div class="archive-posts-summary" id="<?php echo $queried_name; ?>-archive-summary">
						<?php //do_action( "abbey_archive_page_summary", $abbey_query ); ?>
				</div>

				<div id="<?php echo $queried_name; ?>-archive-posts" class="col-md-8 col-md-offset-2 archive-posts">
					
					<?php while ( have_posts() ) : the_post(); $count++; ?>
					
						<?php get_template_part("templates/content", "archive"); ?>

					<?php endwhile; ?>

					<div class="clearfix"></div>
					
					<div class="text-center"><?php abbey_posts_pagination();?></div>
				</div>

		
				<?php else : get_template_part("templates/content", "archive-none"); ?>
		</section>


	<?php endif; ?>
		

	</main>		<div style="direction: ltr;"> <?php print_r( get_queried_object() );
				?></div><?php

get_footer();