<?php



function abbey_post_title(){
	$summary = get_the_excerpt();
	$title = '<h1 class="page-title" itemprop="headline">' . get_the_title() . '</h1>
		<summary class="post-excerpt" itemprop="summary">
			<em>'.apply_filters( "abbey_post_summary", $summary, get_the_ID() ) . '</em>.
		</summary>';
	echo apply_filters( "abbey_theme_post_title", $title );
}





function abbey_latest_posts(){
	echo '
		<aside id="latest-posts" class="pad-medium col-md-6 text-center">
			<div class="inner-wrapper">
				<h2 class="page-header">'. __( "Recent Posts", "abbey" ). '</h2>
				<div class="small description inner-pad-medium"> ' . 
					__("Most recent posts from my blog") . 
				'</div>';	
			// run function to show posts //

	echo	'</aside>';

}
add_action ( "abbey_theme_404_page_widgets", "abbey_latest_posts", 10);

function abbey_latest_quotes(){
	echo '
		<aside id="quotes" class="pad-medium col-md-6 text-center">
			<div class="inner-wrapper">
				<h2 class="page-header">'. __("Todays's Quote", "abbey"). '</h2>
				<div class="small description inner-pad-medium"> '.
					__( "Quotes and thoughts from my Quote book", "abbey" ) .
				'</div>';
			//run function to show quotes //

	echo	'</aside>';

}
add_action ( "abbey_theme_404_page_widgets", "abbey_latest_quotes", 20 );

function abbey_footer_menu(){
	$args = array(
		'menu'				=>	'footer', 
		'theme_location'	=>	'footer',
		'depth'             => 1,
	    'container'         => 'ul',
	    'menu_class'   		=> 'list-inline list-left'
	);
	abbey_nav_menu( $args );
}

add_action ( "abbey_theme_footer_credits", "abbey_footer_menu" );

function abbey_theme_details(){
	$current_theme = wp_get_theme();
	?>
	<ul class="list-inline list-right">
		<li> 
			<?php echo sprintf( '<a href="www.wordpress.org" target="_blank" data-toggle="tooltip" title="%1$s">%2$s</a>',
								__( "Powered by:", "abbey" ),
								__( "Wordpress", "abbey" )
							); ?>
		</li>
		<li> 
			<?php echo sprintf( '<a href="%1$s" target="_blank" data-toggle="tooltip" title="%2$s">%3$s </a>',
								 esc_url( $current_theme->get( "ThemeURI" ) ), 
								 esc_attr( __( "Built on:", "abbey" ) ),
								 esc_html( $current_theme->get( "Name" ) ) 
								); ?>
		</li>
		<li> 
			<?php echo sprintf( '<a href="#" data-toggle="tooltip" title="%1$s">%2$s</a>',
									__( "Theme version:", "abbey" ),
									$current_theme->get( "Version" )
							); ?> 
		</li>
		<li> 
			<?php echo sprintf( '<a href="%1$s" target="_blank" data-toggle="tooltip" title="%2$s">%3$s </a>',
								 esc_url( $current_theme->get( "AuthorURI" ) ), 
								 __( "Theme design:", "abbey" ),
								 esc_html( $current_theme->get( "Author" ) ) 
								); ?>
		</li>
	</ul>
		<?php
}
add_action ( "abbey_theme_footer_credits", "abbey_theme_details", 20 );
function abbey_post_nav( $title = "" ){
	$prev_post = get_previous_post(); // previous post//
	$next_post = get_next_post(); // next post //
	$html = "<div class='post-navigation md-50'>\n";
	if( !empty( $title ) )
		$html.= sprintf( '<h3 class="entry-footer-heading">%s</h3>', esc_html($title) );

	if ( !empty( $prev_post ) ) {
		$html .= "<div class='previous-post text-left'>\n";
		$html .= abbey_show_nav( $prev_post, "previous" ); // check core for function documentation //
		$html .= "</div>";//close of previous-post class div//
	}
	if ( !empty( $next_post ) ){
		$html .= "<div class='next-post text-right'>\n";
		$html .= abbey_show_nav( $next_post, "next" );
		$html .= "</div>"; // close of next-post div //
	}
	$html .= "</div>"; // close of post-navigation class div //
	echo $html;
}



function abbey_post_author_info( $title = "" ){
	$author = abbey_post_author();
	
	$author_contacts = abbey_author_contacts( $author );

	$html = "<div class='author-info'>";
	if( !empty( $title ) )
		$html.= sprintf( '<h3 class="entry-footer-heading">%s</h3>', esc_html($title) );
	
	$html .= "<div class='author-photo heading-icon'>".abbey_author_photo( $author->ID, 120, "img-circle" ). "</div>";
	$html .= "<div class='author-details heading-content'>";
	$html .= sprintf( '<div class="author-title">
						<div class="author-name"><h4 class="no-top-margin no-bottom-margin"><a href="%4$s"> %1$s </a> </h4></div>
						<div class="author-rate"> <em> %2$s </em> <span class="author-post-count"> %3$s </span></div>
						',
						$author->display_name, 
						__( "Published posts:", "abbey" ),
						get_the_author_posts(), 
						get_author_posts_url( $author->ID )
					);
	
	$html .= "</div>"; //.author-title .row closes & author-details //

	$html .= "<div class='author-description'>".esc_html( $author->description ). "</div>";
	
		if( !empty( $author_contacts )  ){
			$html .= "<footer class='author-social-contacts col-md-5 h4 text-center'>";
			$html .= "<ul class='list-inline'>"; 
			foreach( $author_contacts as $social => $contact ){
				$html .= sprintf( '<li><a href="%1$s" title="%2$s" class="icon"><span class="fa fa-%3$s"></span></a></li>', 
								esc_url( $contact ), __( "Visit author's facebook", "abbey" ), esc_attr( $social )
							);
			}
			$html .= "</footer>";
		}
			
	
	$html .= "</div>\n</div>"; //.author-info //

	echo $html; 
}

function abbey_show_related_posts( $title = "" ){
	$args =  array(
		'post_type' => get_post_type(), 
		'posts_per_page' => 3, 
		'post__not_in' => array( get_the_ID() )
	);
	$related_posts = abbey_get_posts( $args );
	if( $related_posts->have_posts() ) : 
		ob_start(); ?>
		<div class="related-posts">	<?php
		if( !empty( $title ) )
			echo sprintf( '<h3 class="entry-footer-heading">%s</h3>', esc_html($title) ); ?>
			<div class="posts-slides" data-slick='{"rtl": true}'>
		<?php while( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
			<aside class="post-panel">
				<?php if( has_post_thumbnail() ) : ?>
					<figure class="post-panel-thumbnail"><?php the_post_thumbnail(); ?></figure>
				<?php endif; ?>
				<div class="post-panel-body">
					<h4 class="post-panel-heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<div class="post-panel-excerpt text-justify">
						<?php abbey_excerpt( "", "", true ); ?> 
						<?php /*<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e("Read more", "abbey"); ?></a>*/?>
					</div>
				</div>
			</aside>
		<?php endwhile; wp_reset_postdata(); ?>
		</div></div><?php endif; 
		
		echo ob_get_clean();

}

function abbey_post_categories(){
	$notes = sprintf( '<p class="small cats-note">%s</p>',
						__( "* You can learn more about this post by clicking on these links, 
							each topic contains several posts that are related to this article", 
							"abbey" )
					);
	$html = "<div class='row inner-pad-responsive outer-pad-medium' id='post-cats'>";
	
	if ( count( $categories = get_the_category() ) > 0 ){
		$list = "<ul class='post-categories'>";
		foreach( $categories as $category ){
			$list .=  sprintf( '<li><a href="%1$s" rel="category">%2$s 
						<span class="badge category-count">%3$s </span></a></li>',
				esc_url( get_category_link( $category->term_id ) ), 
				$category->name, 
				$category->count
				);
		}
		$list .= "</ul>\n"; 

		$html .= abbey_cats_or_tags( $list, __( "Topics", "abbey" ), "fa-folder-o", $notes );
	}

	$html .= "</div>";

	echo $html;
}
add_action ( "abbey_theme_post_footer", "abbey_post_categories", 5 );

/* 

search page 



*/

add_action( "abbey_archive_page_summary", "abbey_search_summary" ); 
function abbey_search_summary( $abbey ){
	$summaries = ( isset( $abbey["summary"] ) ) ? $abbey["summary"] : array();
	$html = $keyword = "";
	if( count( $summaries ) > 0 )
		$html .= "<ul class='list-group'>";
		foreach( $summaries as $title => $summary ){
			$html .= "<li class='list-group-item $title relative'>";
			if( !empty( $summary["title"] ) )
				$html .= sprintf( '<p class="list-group-item-text">%s</p>', esc_html( $summary["title"] ) );
			if( !empty( $summary["key"] ) )
				$keyword = ( $title === "keyword" ) ? "<span class='search-keyword'>" : "<span>";
				$html .= sprintf( '<h4 class="list-group-item-heading">%1$s %2$s </span></h4>', 
								$keyword, 
								$summary["key"] 
							);
			$html .= "</li>";
		}
		$html .= "</ul>";
		

	echo $html;

}

add_action( "abbey_archive_page_heading", "abbey_archive_heading" ); 
function abbey_archive_heading( $queried_object ){	
	$title = $icon = "";
	if( $queried_object instanceof WP_User ){
		$title = $queried_object->display_name; 
		$icon = abbey_author_photo( $queried_object->ID, 120, "img-circle" );
	}
	elseif( $queried_object instanceof WP_Post_Type ){
		$title = $queried_object->labels->archives;
	}
	elseif( $queried_object instanceof WP_Term ){
		$title = $queried_object->name;
	}
	 ?>
	 <?php if( !empty( $icon ) ) : ?>
	 	<div class='heading-icon'><?php echo $icon; ?> </div>
	 <?php endif; ?>
	 <div class='heading-content'>
		<h1 class="page-title"><?php echo esc_html( $title ); ?> </h1>
		<summary class="archive-description"><?php echo $queried_object->description; ?> </summary>
	</div>
	<?php
}

add_filter( "abbey_theme_page_media", "abbey_video_thumbnail", 20 );
function abbey_video_thumbnail( $thumbnail ){
	
	if( get_post_type() === "recordings" )
		$thumbnail = abbey_recording_video( false );
	

	return $thumbnail;

}

add_filter( "abbey_theme_page_media", "abbey_category_thumbnail", 10 );
function abbey_category_thumbnail( $thumbnail ){
	if( $categories = get_the_category() ){
		$cat_thumbnail = get_term_meta( $categories[0]->term_id, "thumbnail", true ); 
		if( !empty( $cat_thumbnail ) )
			$thumbnail = sprintf('<img class="wp-post-image" src="%s" />', $cat_thumbnail ); 
	}
	return $thumbnail;
	
}