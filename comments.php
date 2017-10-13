<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php do_action( "abbey_before_comments_display" ); ?>
	<div class="comments-list">
		<?php if ( have_comments() ) : ?>
			
			<h2 class="comments-title"> </h2>

			<div class="comment-list"><?php abbey_list_comments(); ?></div><!-- .comment-list -->

		<?php endif; // have_comments() ?>

		<!-- If comments are closed and there are comments, let's leave a little note, shall we? -->
		<?php if ( ! comments_open() && '0' != get_comments_number() && 
				post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<div class="no-comments"><?php _e( 'Comments are closed.', 'abbey' ); ?></div>
		<?php endif; ?>
	</div>
	
	<div class="comments-form"><?php $args = abbey_comments_args();	comment_form( $args ); ?></div>


</div><!-- #comments -->
