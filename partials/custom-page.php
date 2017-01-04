<?php
/*
* Template Name: Custom Page 
*
*/
get_header(); ?>

<main id="<?php abbey_theme_page_id( "custom-page" );?>" class="row site-content">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php global $more; $more = 0; ?>
						
			<?php get_template_part("templates/content", "custom-page"); ?>

		<?php endwhile; ?> 

	<?php else : get_template_part("templates/content", "none");?>

	<?php endif; ?>


</main>	<?php
get_footer();