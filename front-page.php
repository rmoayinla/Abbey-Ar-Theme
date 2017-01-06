<?php
/*
* a wordpress themplate for rendring my front page 
* @theme: Abbey 
* @package: wordpress
* @version: 0.1 
*
*/

get_header();  ?>
	
	<main id="<?php abbey_theme_page_id();?>" class="site-content">
		<?php  ?>
			<div class="row" id="site-banner" role="banner">
				<?php do_action( "abbey_theme_front_page_banner" ); ?>
			</div><!--end of jumbotron/#site-banner --> <?php 
			
			get_template_part("templates/content", "front-page");//include the front-page content layout //

		

get_footer();