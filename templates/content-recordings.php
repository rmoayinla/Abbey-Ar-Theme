<?php
	
?>
<section  id="content" class="post-content col-md-9 content-recording" itemscope itemtype="http://schema.org/Article">
	<section class="post-entry row">
		
		<div class="entry-header">
			<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
			<ul class="breadcrumb post-info"><?php abbey_post_info(); ?></ul>
		</div>

		<summary class="entry-excerpt">
			<?php the_excerpt(); ?>
		</summary>

		<article <?php abbey_post_class( "col-md-8 col-md-push-4" ); ?> id="post-<?php the_ID(); ?>">
			<?php the_content(); ?>
			<div><?php abbey_post_pagination(); ?> </div>
		</article>


		<aside class="col-md-4 col-md-pull-8" id="primary-sidebar">
			<?php do_action( "abbey_theme_recording_sidebar" ); ?>
		</aside>

		<div class="clearfix"></div>
		<footer class="entry-footer"> 
			<?php abbey_post_nav( "تسجيل الإعلامية المقبل والسابق", "abbey" ); ?>
			<?php abbey_post_author_info( __( "عرَف المؤلف", "abbey" ) ); ?>
		</footer>
		
	

		<?php if ( comments_open() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>

	</section><!-- .post-entry closes -->

</section><!-- #content .page-content closes -->

<div id="floating-video">
	<?php abbey_recording_video(); ?>
</div>