<?php
get_header();

global $count, $wp_query, $abbey_query, $abbey_defaults;
$current_page = $queried_object = $queried_name = $archive_options = "";

$current_page = (int) get_query_var( 'paged' );
$count = ( $current_page > 1 ) ? ( ( $current_page - 1) * (int) get_option( 'posts_per_page' ) ) : 0;

$abbey_query = array();

$queried_object = get_queried_object();

$queried_name = $queried_object->slug;

$archive_options = ( !empty( $abbey_defaults[ "archive" ] ) ) ? $abbey_defaults[ "archive" ] : array();
?>

	<main id="<?php abbey_theme_page_id(); ?>" class="row archives">
		
		<header id="<?php echo $queried_name; ?>-archive-header" class="text-center archive-header">
			
			<div class="md-50"><?php do_action( "abbey_archive_page_heading", $queried_object ); ?></div>
			<?php print_r( get_term_meta( $queried_object->term_id, "thumbnail", true ) ); ?>

		</header>

		<section id="content" class="row archive-content">

			<?php if ( have_posts() ) : abbey_setup_query(); ?>
				
				<?php if( !empty( (bool) $archive_options[ "sidebar" ] ) ) : ?>
					<div class="col-md-3 archive-summary" id="<?php echo $queried_name; ?>-archive-summary">
					<?php do_action( "abbey_archive_page_summary", $abbey_query ); ?>
					</div>
				<?php endif; ?>

				<div id="<?php echo $queried_name; ?>-archive-posts" class="col-md-8 col-md-offset-1 archive-posts-wrapper">
					
					<div class="category-archive-posts archive-posts">
						<?php while ( have_posts() ) : the_post(); $count++; ?>
							<?php get_template_part("templates/content", "archive"); ?>
						<?php endwhile; ?>
					</div>
					
					<div class="navigation" role="navigation">
						<?php if( empty( (bool) $archive_options[ "ajax_load_posts" ] ) ) : ?>
							<?php abbey_posts_pagination();?>
						<?php endif; ?>
					</div>
				</div>

		
				<?php else : get_template_part("templates/content", "archive-none"); ?>

			<?php endif; ?>	

		</section>
		

	</main>		<div style="direction: ltr;"> <?php print_r( (bool) $archive_options[ "sidebar" ] ); ?></div><?php

get_footer();