<?php
get_header();

$error_404_defaults["error-title"] = !get_query_var( "s_error_code" ) ? 
									__( "No error code", "abbey" ) : 
									get_query_var( "s_error_code" );

$error_404_defaults["error-message"] = __( "Access denied", "abbey" );

?>
	<main id="<?php abbey_theme_page_id(); ?>" class="site-content row">
			<header id="site-content-header">
					<?php do_action( "abbey_theme_before_page_content" ); ?>
			</header>
			
			<section id="content" class="page-content">
				<?php get_template_part( "templates/content", "none" ); ?>
			</section><!--#content closes -->

	</main> <!-- #page-404 main closes -->	

<?php
get_footer();