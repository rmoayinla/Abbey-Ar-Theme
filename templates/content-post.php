<?php
	$has_thumbnail = ( has_post_thumbnail() ) ? true : false;
	$title = ""
?>
<section  id="content" class="post-content col-md-7" itemscope itemtype="http://schema.org/Article">
	<div class="single-post-panel">

		<div class="row"><?php do_action( "abbey_theme_before_post_panel" ); ?></div>

		<header id="post-content-header" class="entry-header">
			
			<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>

			<ul class="breadcrumb post-info"><?php abbey_post_info(); ?></ul>
		</header><!-- #page-content-header closes -->

		<section class="post-entry row">
				
			<?php if( $has_thumbnail ) : ?>
				
				<figure class="post-thumbnail" itemprop="image"><?php the_post_thumbnail( "large" ); ?> </figure>
				
				<figcaption class="post-thumbnail-caption"><?php the_post_thumbnail_caption(); ?></figcaption>
				
			<?php endif; ?>

			<article <?php abbey_post_class(); ?> id="post-<?php the_ID(); ?>">
				
				<summary class="post-excerpt"><?php the_excerpt(); ?></summary>
				
				<?php the_content(); ?>

				<div><?php abbey_post_pagination(); ?> </div>

			</article>

			<footer class="post-entry-footer"> 
				<?php abbey_post_nav( "المقالة السابقة والتالية", "abbey" ); ?>
				<?php abbey_post_author_info( __( "عرَف المؤلف", "abbey" ) ); ?>

				<?php do_action( "abbey_theme_entry_footer", $title ); ?>
			</footer>
		
		</section><!-- .post-entry closes -->

		<footer class="entry-footer">
			<?php if ( comments_open() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</footer>

	</div>
	
</section><!-- #content .page-content closes -->