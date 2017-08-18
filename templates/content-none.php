<?php
/**
 *
 *
 * This template is used to display 404 pages and pages with empty content 
 * Non-existing pages and posts will return a 404 error and this template partial will be loaded 
 * Headers, Sidebars and Footers are not displayed here. This file only load the content 
 *
 *@see: 404.php, single.php, page.php, home.php for how this file is loaded 
 *@package: Abbey theme
 *@since: 0.1
 *@category: templates 
 *
*/

?>
<?php global $error_404_defaults; //404 page defaults from the theme settings //?>
			<article <?php abbey_post_class(); ?> id="page-no-content">
				
				<div class="pad-large text-center">
					<h2 class="page-header"> <?php echo esc_html( $error_404_defaults["error-title"] ); ?> </h2>
					<p class="description h4"> <?php echo esc_html( $error_404_defaults["error-message"] ); ?> </p>
					<div id="search-form"> <?php get_search_form(); ?></div>
				</div>
				
				<!-- 404 action hook to display maybe recent posts, quotes, ADs etc -->
				<?php do_action( "abbey_theme_after_content_none" ); ?>

			</article>