<?php


$error_404_defaults = abbey_get_defaults( "error-404-page" );


get_header();	?>

		<main id="<?php abbey_theme_page_id(); ?>" class="site-content row">
			<header id="site-content-header">
					<?php do_action( "abbey_theme_before_page_content" ); ?>
			</header>
			
			<section id="content" class="page-content">
				<?php get_template_part( "templates/content", "none" ); ?>
			</section><!--#content closes -->

		</main> <!-- #page-404 main closes -->	<?php
get_sidebar("404");
get_footer();