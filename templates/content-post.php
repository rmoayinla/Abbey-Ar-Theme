<?php
/** 
 *
 * Theme Template partial for single posts or single {post_type}
 * this file is loaded when a sing post with no post format is queried 
 * It only loads the content of the posts. Sidebars, headers, footers are loaded separately ie. get_header()
 *
 *@author: Rabiu Mustapha
 *@package: Abbey theme
 *@since: 0.1
 *@category: Templates 
 *
 */
?>

<?php $has_thumbnail = ( has_post_thumbnail() ) ? true : false; $title = ""; ?>
<section  id="content" class="post-content col-md-7" itemscope itemtype="http://schema.org/Article">
	
	<div class="single-post-panel">

		<div class="row"><?php do_action( "abbey_theme_before_post_panel" ); ?></div>

		<header id="post-content-header" class="entry-header">
			<ul class="breadcrumb post-info"><?php abbey_post_info(); ?></ul>
			<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
		</header><!-- #page-content-header closes -->

		<figure class="post-thumbnail" itemprop="image"><?php abbey_page_media( "large" ); ?> </figure>
		<?php if( $has_thumbnail ): ?>
			<figcaption class="post-thumbnail-caption"><?php the_post_thumbnail_caption(); ?></figcaption>
		<?php endif; ?>
		
		<summary class="post-excerpt"><?php the_excerpt(); ?></summary>
		
		<section class="post-entry row inner-wrap">	
			
			<article <?php abbey_post_class(); ?> id="post-<?php the_ID(); ?>">			
				<?php the_content(); ?>
				<div><?php abbey_post_pagination(); ?> </div>
			</article>

			<footer class="post-entry-footer"> <?php do_action( "abbey_theme_post_entry_footer", $title ); ?></footer>
		
		</section><!-- .post-entry closes -->

		<footer class="entry-footer"><?php if ( comments_open() ) comments_template(); ?></footer>

	</div>
	
</section><!-- #content .page-content closes -->
<?php
