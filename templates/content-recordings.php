<?php
	
?>
<section  id="content" class="post-content col-md-7 content-recording" itemscope itemtype="http://schema.org/Article">
	<div class="single-post-panel row">
		<header class="entry-header">
			<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
			<ul class="breadcrumb post-info"><?php abbey_post_info(); ?></ul>
		</header>

		<?php if( has_excerpt() ) : ?>
			<summary class="entry-excerpt"><?php the_excerpt(); ?></summary>
		<?php endif; ?>

		<section class="post-entry">
			<article <?php abbey_post_class(); ?> id="post-<?php the_ID(); ?>">
				<?php the_content(); ?>
				<div><?php abbey_post_pagination(); ?> </div>
			</article>

			<footer class="post-entry-footer"> 
				<?php abbey_post_terms( get_the_ID() ) ?>
				<?php abbey_post_nav( "تسجيل الإعلامية المقبل والسابق", "abbey" ); ?>
				<?php abbey_post_author_info( __( "عرَف المؤلف", "abbey" ) ); ?>
			</footer>
	
		</section><!-- .post-entry closes -->	

		<footer class="entry-footer">
			<?php if ( comments_open() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</footer>
	</div>
	<div id="floating-video" class="panel">
		<div class="panel-video"><?php abbey_recording_video(); ?></div>
		<div class="panel-body">
			<h4 class="post-panel-title"><?php the_title(); ?> </h4>
		</div>
	</div>
	
</section><!-- #content .page-content closes -->

