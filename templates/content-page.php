<?php

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

		<footer class="entry-footer">

		</footer>

	</div>
	
	

</section><!-- #content .page-content closes -->
		
	
	