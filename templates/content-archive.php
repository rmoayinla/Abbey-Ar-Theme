<?php
global $count;
?>
		<article class="post-panel <?php echo "post-count-".$count; ?>" >
			<header class="post-panel-heading">
				<div class="row margin-minus-bottom-sm">
					<ul class="top-post-info">
						<li><?php abbey_show_post_type(); ?> </li>
						<li> <?php echo human_time_diff( get_the_time("U"), current_time("timestamp") ); ?> </li>
					</ul>
				</div>
				<?php echo sprintf( '<h2><a href="%1$s" title="%2$s">%3$s</a></h2>', 
									get_permalink(), 
									__( "Read this article", "abbey" ), 
									get_the_title()
								); ?>
				<ul class="breadcrumb"><?php abbey_post_info( true, array( "author", "date" )); ?></ul>
			</header>
			<div class="post-panel-body">
				<div class="post-thumbnail">
					<?php abbey_page_media( "large" ); ?>
				</div>
				
				<div class="post-excerpts">
					<?php the_excerpt(); ?>
				</div>
			</div>
			<footer class="post-panel-footer">
				<ul class="list-inline no-list-style">
					<li><?php echo abbey_cats_or_tags( "categories", "", "fa-folder-o" ); ?></li>
					<li><?php echo abbey_cats_or_tags( "tags", "", "fa-tags" );  ?></li>
				</ul>
			</footer>

			
		</article>


