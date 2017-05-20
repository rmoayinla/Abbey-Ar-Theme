<?php

?>
<section  id="content" class="page-content col-md-6 col-md-offset-2">

	<div id="page-media"><?php abbey_page_media( "large" ); ?> </div>
			
	<div class="row"><?php do_action("abbey_theme_before_page_content"); ?></div>
	
	<article <?php abbey_post_class(); ?> id="page-<?php the_ID(); ?>">
		<?php the_content("Read more . . "); ?>
	</article>
	
	

</section><!-- #content .page-content closes -->
		
	
	