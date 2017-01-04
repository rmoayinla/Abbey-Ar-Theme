<?php
	$thumbnail_class = ( has_post_thumbnail() ) ? "has-thumbnail" : "no-thumbnail";
	global $abbey_defaults;
	$page_description = ( !empty( $abbey_defaults["page"]["description"] ) ) ?
						 esc_html( $abbey_defaults["page"]["description"] ) : "";
?>
<section  id="content" class="page-content col-md-6 col-md-offset-2">
	<header id="page-content-header" class="<?php echo esc_attr( $thumbnail_class ); ?>">
		<div id="page-title">
			<div class="page-title-wrap">
				<h1 class="page-title" itemprop="headline">
					<?php abbey_post_icon(); ?>
					<span class="page-title-text"><?php the_title(); ?></span>
				</h1>
				<summary class="description" itemprop="summary">
					<em><?php the_excerpt(); ?></em>
				</summary>
			</div>
			<div id="page-media"><?php abbey_page_media( "large" ); ?> </div>
			<div class=""><?php do_action( "abbey_theme_page_extra_header" ); ?></div>
		</div>
	
	</header><!-- #page-content-header closes -->

	<div class="row"><?php do_action("abbey_theme_after_page_header"); ?></div>
	
	<article <?php abbey_post_class(); ?> id="page-<?php the_ID(); ?>">
		<?php the_content("Read more . . "); ?>
	</article>
	


</section><!-- #content .page-content closes -->
		
	
	