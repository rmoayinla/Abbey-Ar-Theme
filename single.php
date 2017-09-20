<?php

get_header(); 
global $more; ?>

	<main id="<?php abbey_theme_page_id(); ?>" class="row site-content">
		
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $more = 0; ?>
				<header id="site-content-header" class="before-content"><?php do_action( "abbey_theme_before_content" ); ?></header>
			
				<!-- set of conditions on which template file should be selected to display the post
					 all template files are found in templates folder 
					1. if its a custom post type e.g. news, reviews, check if there is a content-{post-type} e.g. content-news.php
					2. if it doesnt have a post format and its a normal post, use content-post.php 
					3. if the post has a post format i.e. quote, gallery, use content-{post-format} e.g content-quote.php
					-->
				<?php if( ! has_post_format() ) : ?>
				
					<?php 
						if( locate_template( "templates/content-".get_post_type().".php" ) ) 
							get_template_part("templates/content", get_post_type() ); 
						else
							get_template_part(  "templates/content", "post" ); 
					?>

				<?php else: ?>
					<?php get_template_part("templates/content", get_post_format() ); ?>
			
				<?php endif; ?>
			
			
			<?php endwhile; //end of loop //?> 

	<?php else : get_template_part("templates/content", "none"); ?>

	<?php endif; //end if have_posts() // ?>

	
	<?php if( !has_post_format() ) : ?>

		<aside class="col-md-4 col-md-offset-1 sidebar" role="complimentary" id="primary-sidebar">
			<?php abbey_display_sidebar( "sidebar-main" ); ?>
		</aside>

	<?php endif; //end if has_post_format // ?>

	</main>		<?php
		
get_footer();