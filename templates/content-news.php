<?php
/**
 * Template partial for displaying content of news (post type)
 *
 * this file is included in the loop and display the current news content i.e. titile, content, comments etc
 * included via wordpress get_template_part in single.php
 * change the file name to your wp custom post type e.g. content-products, content-events 
 *
 *@author: Rabiu Mustapha 
 *@version: 0.11
 *@package: Abbey theme 
 *@category: templates 
 *
 */
	
?>
<section  id="content" class="post-content col-md-7" itemscope itemtype="http://schema.org/Article">
	
	<div class="single-post-panel">
		<div class="row"><?php do_action( "abbey_theme_before_post_panel" ); ?></div>

		<header id="post-content-header" class="entry-header">
			<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
			<ul class="breadcrumb post-info"><?php abbey_post_info(); ?></ul>
		</header><!-- #page-content-header closes -->


		<section class="post-entry">
			
			<figure class="post-thumbnail" itemprop="image"><?php abbey_page_media( "large" ); ?> </figure>
			
			<figcaption class="post-thumbnail-caption"><?php the_post_thumbnail_caption(); ?></figcaption>
		
			<summary class="post-excerpt"><?php the_excerpt(); ?></summary>

			<article <?php abbey_post_class(); ?> id="post-<?php the_ID(); ?>">
				
				<?php the_content(); ?>

				<div><?php abbey_post_pagination(); ?> </div>

			</article>
			
				
			<footer class="post-entry-footer"> <?php do_action( "abbey_theme_post_entry_footer", "" ); ?></footer>
			
		</section><!-- .post-entry closes -->
		
		<footer class="entry-footer"><?php if ( comments_open() ) comments_template(); ?></footer>
		
		
	</div>

	
</section><!-- #content .page-content closes -->