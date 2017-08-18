<?php
/**
 * 
 * Template partial for loading/displaying single pages 
 * this template file is loaded when a single page (post_type) is queried 
 * the contents of the queried page are loaded here. Sidebars, Headers and footers are not displayed here 
 *
 *@see: Open the page.php in the theme folder root to see how this file is loaded 
 *@author: Rabiu Mustapha
 *@since: 0.1
 *@category: Templates 
 *
 *
 */
?>
<section  id="content" class="page-content col-md-6 col-md-offset-2">

	<div class="single-post-panel">
		
		<div class="row entry-header"><?php do_action("abbey_theme_before_page_content"); ?></div>

		<section class="post-entry" id="page-entry">

			<div id="page-media" class="post-thumbnail"><?php abbey_page_media( "large" ); ?> </div>
		
			<article <?php abbey_post_class(); ?> id="page-<?php the_ID(); ?>">
				<?php the_content("Read more . . "); ?>
			</article>

		</section>

		<footer class="entry-footer"></footer>

	</div>
	
	

</section><!-- #content .page-content closes -->
		
	
	