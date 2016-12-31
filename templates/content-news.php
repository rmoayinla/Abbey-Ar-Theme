<?php
	$has_thumbnail = ( has_post_thumbnail() ) ? true : false;
	$navigation_title = ""
?>
<section  id="content" class="post-content col-md-9" itemscope itemtype="http://schema.org/Article">
	
	<header id="post-content-header" class="row entry-header">

		<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>

		<ul class="breadcrumb post-info"><?php abbey_post_info(); ?></ul>

	</header><!-- #page-content-header closes -->

	<div class="row"><?php do_action("abbey_theme_after_page_header"); ?></div>

	<section class="post-entry row">
			
		<?php if( $has_thumbnail ) : ?>
			
			<figure class="post-thumbnail" itemprop="image">
				<?php the_post_thumbnail( "large" ); ?> 
			</figure>
			
			<figcaption class="post-thumbnail-caption">
				<?php the_post_thumbnail_caption(); ?>
			</figcaption>
		<?php endif; ?>

		<article <?php abbey_post_class( "col-md-8 col-md-push-4" ); ?> id="post-<?php the_ID(); ?>">
			
			<summary class="post-excerpt"><?php the_excerpt(); ?></summary>

			<?php the_content(); ?>

			<div><?php abbey_post_pagination(); ?> </div>

		</article>
		
		<aside class="col-md-4"> <?php  ?></aside>

		<div class="clearfix"></div>

		<footer class="entry-footer"> 
			<?php abbey_post_nav( "أخبار السابق والتالي", "abbey" ); ?>
			<?php abbey_post_author_info( __( "عرَف المؤلف", "abbey" ) ); ?>
		</footer>
	
	<?php if ( comments_open() ) : ?>
				<?php comments_template(); ?>
	<?php endif; ?>
	
	</section><!-- .post-entry closes -->

	
</section><!-- #content .page-content closes -->