<?php
get_header();

global $count;

global $wp_query;

global $abbey_query;

$current_page = (int) get_query_var( 'paged' );
$count = ( $current_page > 1 ) ? ( ( $current_page - 1) * (int) get_option( 'posts_per_page' ) ) : 0;

$abbey_query = array();




?>

	<main id="<?php abbey_theme_page_id(); ?>" class="row archives">
		
		<header id="blog-archive-header" class="text-center archive-header">
			<div class="md-50"><?php  ?></div>
		</header>

		<section id="content" class="row archive-content">

			<?php if ( have_posts() ) : abbey_setup_query(); ?>
				
				<div class="col-md-3 archive-posts-summary" id=">-archive-summary">
					<?php do_action( "abbey_archive_page_summary", $abbey_query ); ?>
				</div>

				<div id="-archive-posts" class="col-md-6 col-md-offset-1 archive-posts">
					
					<?php while ( have_posts() ) : the_post(); $count++; ?>
					
						<?php get_template_part("templates/content", "archive"); ?>

					<?php endwhile; ?>

					<div class="clearfix"></div>
					
					<div><?php abbey_posts_pagination();?></div>
				</div>

		
				<?php else : get_template_part("templates/content", "archive-none"); ?>
		</section>


	<?php endif; ?>
		

	</main>		<?php

get_footer();