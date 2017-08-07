<?php
function html5_comment( $comment, $args, $depth ) {
	global $post;
		$status = ( !empty( wp_get_comment_status( $comment->comment_ID ) ) ) ? wp_get_comment_status( $comment->comment_ID )  : "";
		$user = get_userdata( $comment->user_id );
		$user_pics = ( !empty( $user ) ) ? "user_upload" : "";

		$action_links = array(
			"approved" => sprintf( '<a href="%1$s" target="_blank" title="%3$s"><span class="fa fa-check"></span> %2$s</a>', 
						comment_action_url( "approve", $comment->comment_ID ), __( "Approve", "abbey" ), 
						__( "Approve this comment", "abbey" ) 
						), 

			"trash" =>	sprintf( '<a href="%1$s" target="_blank" title="%3$s"><span class="fa fa-trash-o"></span> %2$s</a>', 
						comment_action_url( "trash", $comment->comment_ID ), __( "Trash", "abbey" ), 
						__( "Delete this comment", "abbey" ) 
						),

			"spam" => sprintf( '<a href="%1$s" target="_blank" title="%3$s"><span class="sr-only">%3$s</span><span class="fa fa-ban"></span> %2$s</a>', 
						comment_action_url( "spam", $comment->comment_ID ), __( "Spam", "abbey" ), 
						__( "Spam this comment", "abbey" ) 
						)
		);

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		
?>		
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent media' : 'media' ); ?>
		itemscope itemtype="http://schema.org/Comment" itemprop="comment">

		<?php if ( 0 != $args['avatar_size'] ): ?>
			<div class="media-left text-center">
				<a href="<?php echo get_comment_author_url(); ?>" class="media-object" itemprop="Author">
					<?php echo abbey_author_photo( $comment, $args['avatar_size'], array( "class" => "img-circle" ) ); ?>
				</a>

				<?php if ( $comment->user_id === $post->post_author ) : ?>
					<p><em><?php _e( 'Author', 'abbey' ); ?></em></p>
				<?php endif; ?>

			</div><!--.media-left closes -->
		<?php endif; ?>

		<div class="media-body">
			<div class="row margin-left-sm">	
				<?php abbey_comment_title( $comment ); ?>
				<div class="comment-time">
					<time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
						<?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
						<small> &nbsp; - <?php echo human_time_diff( get_comment_time("U"), current_time("timestamp") ); ?></small>
					</time>
				</div><!-- .comment-time -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation label label-info"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
				<?php endif; ?>	
		

				<div class="comment-content" itemprop="text">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->
				
				<ul class="list-inline">
					<?php edit_comment_link( __( 'Edit', 'abbey' ), '<li class="edit-comment">', '</li>' ); ?>
					<?php comment_reply_link( array_merge( $args, array(
						'depth'         => $depth,
						'max_depth'		=> $args["max_depth"],
		                'before'        => '<li class="reply-comment">',
		                'after'         => '</li>', 
		                ) ), $comment->comment_ID ); 
		            ?>
					<?php if ( current_user_can( 'moderate_comments' ) && !$user ) : 
						foreach ( $action_links as $action => $link ) :
							if ( $action === $status )
								continue; 
						echo sprintf( '<li class="%1$s">%2$s</li>', esc_attr( $action ), $link ); 
						endforeach; endif;
					?>
					<?php $extra_action_links = apply_filters( "abbey_comment_action_links", array(), $comment );
							if ( count ( $extra_action_links ) > 0 ){
								foreach ( $extra_action_links as $action => $link ){
									echo sprintf( '<li class="%1$s">%2$s</li>', 
													esc_attr( $action ), 
													$link 
												);
								}
							}	?>
				</ul>
				
			</div><!--row-->
		</div><!--.media-body -->	<?php
}	

function comment_action_url( $action, $id ){

	return esc_url ( add_query_arg( [ 'action' => $action, 'c' => $id ], admin_url( 'comment.php' ) ) )."#wpbody-content";
}

function truncate( $string, $length=100, $append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n", $string, 2);
    $string = $string[0] . $append;
  }

  return $string;
}

function abbey_comment_title( $comment ){
	$html = '<h4 class="media-heading" itemprop="author">'; 
	$html .= get_comment_author_link(); 
	if ( 0 < $comment->comment_parent && $parent = get_comment( $comment->comment_parent ) ) {
		$html .= sprintf('&nbsp; <span class="secondary">%1$s </span>
				<a class="" data-toggle="collapse" href=".reply-comment" title="%3$s">
				<span class="caret"></span></a>
				</h4>
				<div class="reply-comment collapse"> %2$s </div>', 
					sprintf( __( "replied: %s", "abbey" ), $parent->comment_author ),
					truncate( $parent->comment_content ), 
					__( "View parent comment", "abbey" )
				); 
	} else{
		$html .= "</h4>";
	}
	echo $html;
}