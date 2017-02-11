<?php
global $count;
global $abbey_author_posts;
$post_count = $count;
$post_types = get_post_types( array( 'public' =>  true ), 'names' );
?>
	<?php if( !empty( $post_types ) ) : foreach( $post_types as $post_type ) : ?>
		<?php if( count( $abbey_author_posts[ $post_type ]["posts"] )  > 0 ) : ?>
				<header class="page-heading collapse-heading clickable">
					<h2><?php echo ucwords( $abbey_author_posts[$post_type]["labels"]->archives ); ?></h2>
				</header>
					<div class="<?php echo $post_type;?>-posts panel-posts collapse-item">
					<?php foreach( $abbey_author_posts[ $post_type ]["posts"] as $author_posts  ) : $post_count++?>
					
						<article class="post-panel <?php echo "post-count-".$post_count; ?>">
							<?php if( !empty( $author_posts["thumbnail"] ) ) : ?>
								<div class="post-thumbnail"><?php echo $author_posts["thumbnail"]; ?>
							<?php endif;?>
							<div class="post-panel-body">
								<div class="post-panel-title">
									<h2><?php echo $author_posts["title"]; ?></h2>
									<?php abbey_post_date(); ?>
								</div>
								
								<?php if( !empty( $author_posts["excerpt"] ) ) : ?>
									<summary class="post-excerpts"><?php echo $author_posts["excerpt"]; ?></summary>
								<?php endif; ?>
							</div>
							<footer class="post-panel-footer">
								<ul class="list-inline no-list-style">
									<li><?php echo abbey_cats_or_tags( "categories", "", "fa-folder-o", "",
									$author_posts["ID"] );?></li>
									<li><?php echo abbey_cats_or_tags( "tags", "", "fa-tags", "", $author_posts["ID"] );   ?></li>
								</ul>
							</footer>

						</article>
					<?php endforeach; ?>	
				</div>
				

	<?php endif; $post_count = $count; endforeach; endif;  ?>


