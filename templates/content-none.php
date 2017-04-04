<?php
/*
* this template is used to display 404 pages and pages with empty content 
*@package: wordpress
*@theme: Abbey
*@version: 
*/
global $error_404_defaults;

?>
			<article <?php abbey_post_class(); ?> id="page-no-content">
				<div class="pad-large text-center">
					<h2 class="page-header"> <?php echo esc_html( $error_404_defaults["error-title"] ); ?> </h2>
					<p class="description h4"> <?php echo esc_html( $error_404_defaults["error-message"] ); ?> </p>
					<div id="search-form"> <?php get_search_form(); ?></div>
				</div>
				

				<?php do_action( "abbey_theme_after_content_none" ); ?>

			</article>