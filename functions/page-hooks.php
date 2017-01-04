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
	    'menu_class'   		=> 'list-inline'
	);
	abbey_nav_menu( $args );
}

add_action ( "abbey_theme_footer_credits", "abbey_footer_menu" );

function abbey_post_nav( $title = "" ){
	$prev_post = get_previous_post(); // previous post//
	$next_post = get_next_post(); // next post //
	$html = "<div class='post-navigation md-50'>\n";
	if( !empty( $title ) )
		$html.= sprintf( '<h4 class="entry-footer-heading">%s</h4>', esc_html($title) );

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
	$author_info = abbey_author_info( $author );

	$html = "<div class='author-info'>";
	if( !empty( $title ) )
		$html.= sprintf( '<h4 class="entry-footer-heading">%s</h4>', esc_html($title) );
	
	$html .= "<div class='author-photo'>".abbey_author_photo( $author->ID, 120, "img-circle" ). "</div>";
	$html .= "<div class='author-details'>";
	$html .= sprintf( '<div class="author-title row">
						<div class="author-name col-md-7"><h4 class="no-top-margin no-bottom-margin"> %1$s </h4></div>
						<div class="author-rate col-md-5"> <em> %2$s </em> <span class="author-post-count"> %3$s </span>
						</div></div>',
						$author->display_name, 
						__( "Published posts:", "abbey" ),
						get_the_author_posts()
					);
	$html .= "<div class='author-description'>".esc_html( $author->description ). "</div>";
	$html .= '<footer class="author-info-footer h4">';
	if ( !empty( $author_info ) ){
		$html .= "<ul class='list-inline'>";
		foreach ( $author_info as $info ){
			$html .= "<li>$info</li>";
		}
		$html .= "</ul>";
	}
	$html .= "</footer>";
	$html .= "</div>\n</div>"; //.author-info //

	echo $html; 
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
function abbey_archive_heading( $queried_object ){	?>
	<h1 class="page-title"><?php echo $queried_object->labels->archives; ?> </h1>
	<summary class="archive-description"><?php echo $queried_object->description; ?> </summary>
	<?php
}

add_action( "abbey_theme_page_media", "abbey_video_thumbnail" );
function abbey_video_thumbnail(){
	if( is_post_type_archive( "recordings" ) ){
		
	}

}