<?php
global $count;
global $abbey_author_posts;

$post_types = get_post_types( array( 'public' =>  true ), 'names' );
?>
	<?php if( !empty( $post_types ) ) : foreach( $post_types as $post_type ) : ?>
		<?php if( count( $abbey_author_posts[ $post_type ] )  > 0 ) : 
				foreach( $abbey_author_posts[ $post_type ] as $author_posts  ) : 
					 ?>
				<div style="direction: ltr;"> <?php //print_r( $author_posts ); ?></div>
				<article class="post-panel">
					<?php if( !empty( $author_posts["thumbnail"] ) ) : ?>
						<div class="post-thumbnail"><?php echo $author_posts["thumbnail"]; ?>
					<?php endif;?>

					<h2 class="post-panel-title"><?php echo $author_posts["title"]; ?>
					<?php if( !empty( $author_posts["excerpt"] ) ) : ?>
						<summary class="post-excerpt"><?php echo $author_posts["excerpt"]; ?></summary>
					<?php endif; ?>

				</article>


				
				

	<?php endforeach; endif; endforeach; endif;  ?>


