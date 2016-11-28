<?php

function abbey_page_title(){
	global $abbey_defaults;
	$page_description = ( !empty( $abbey_defaults["page"]["description"] ) ) ? esc_html( $abbey_defaults["page"]["description"] ) : "";
	
	$title = sprintf('<div class="page-title-wrap">
							<h1 class="page-title" itemprop="headline">
								<span class="fa %1$s page-title-icon"></span> 
								<span class="page-title-text">%2$s</span>
							</h1>
							<summary class="description" itemprop="summary">
								<em>%3$s</em>
							</summary>
						</div>',
						apply_filters( "abbey_page_icon", "fa-envelope" ),
						get_the_title(), 
						apply_filters( "abbey_page_description", $page_description, get_the_ID() )
					);

	echo apply_filters( "abbey_theme_page_title", $title );
}

function abbey_post_title(){
	$summary = get_the_excerpt();
	$title = '<h1 class="page-title" itemprop="headline">' . get_the_title() . '</h1>
		<summary class="post-excerpt" itemprop="summary">
			<em>'.apply_filters( "abbey_post_summary", $summary, get_the_ID() ) . '</em>.
		</summary>';
	echo apply_filters( "abbey_theme_post_title", $title );
}


function abbey_page_media(){
	if ( has_post_thumbnail() ){
		$icon = the_post_thumbnail();
	} else{
		$icon = "";
	}
	//$icon = '<div><h2 class="icon-large"><span class="glyphicon glyphicon-blackboard"></span></h2></div>';//
	echo apply_filters( "abbey_theme_page_header_media", $icon );
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

function abbey_footer_credits(){
	$footer_defaults = ( !empty( abbey_get_defaults( "footer" ) ) ) ? abbey_get_defaults( "footer" ) : "";
	$footer_credits = ( !empty( $footer_defaults ) ) ? $footer_defaults[ "credits" ] : "";

	if( count( $footer_credits ) > 0 ) : 
		$html = '<ul class="list-inline">';
		foreach ( $footer_credits as $title => $credits ) : 
			$html .= '<li>'.$credits.'</li>';
		endforeach;
		$html .= '</ul>';
	endif;

	echo $html;
}

add_action ( "abbey_theme_footer_credits", "abbey_footer_credits" );

function abbey_post_nav(){
	$prev_post = get_previous_post(); // previous post//
	$next_post = get_next_post(); // next post //
	$html = "<div class='row post-navigation'>\n";
	if ( !empty( $prev_post ) ) {
		$html .= "<div class='col-md-6 previous-post text-left'>\n";
		$html .= abbey_show_nav( $prev_post ); // check core for function documentation //
		$html .= "</div>";//close of previous-post class div//
	}
	if ( !empty( $next_post ) ){
		$html .= "<div class='col-md-6 next-post text-right'>\n";
		$html .= abbey_show_nav( $next_post, "next" );
		$html .= "</div>"; // close of next-post div //
	}
	$html .= "</div>"; // close of post-navigation class div //
	echo $html;
}

add_action( "abbey_theme_post_footer", "abbey_post_nav", 99);

function abbey_post_author_info(){
	$author = abbey_post_author();
	$author_info = abbey_author_info( $author );

	$html = "<div class='author-info'>";
	$html .= "<div class='author-photo'>".abbey_author_photo( $author->ID, 64, "img-circle" ). "</div>";
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
	$html .= "</div>"; //.author-info //

	echo $html; 
}
add_action ( "abbey_theme_post_footer", "abbey_post_author_info", 20);

function abbey_post_categories(){
	$notes = sprintf( '<p class="small cats-note">%s</p>',
						__( "* You can learn more about this post by clicking on these links, 
							each topic contains several posts that are related to this article", 
							"abbey" )
					);
	$html = "<div class='row inner-pad-responsive outer-pad-medium' id='post-cats'>";
	
	if ( count( get_the_category() ) > 0 ){
		$html .= abbey_cats_or_tags( "categories", __( "Topics", "abbey" ), "fa-folder-o", $notes );
	}
	$html .= "</div>";

	echo $html;
}
add_action ( "abbey_theme_post_footer", "abbey_post_categories", 5 );

/* search page 



</li>*/

add_action( "abbey_search_page_summary", "abbey_search_summary" ); 
function abbey_search_summary( $abbey ){
	$summaries = ( isset( $abbey["summary"] ) ) ? $abbey["summary"] : array();
	$html = "";
	if( count( $summaries ) > 0 )
		foreach( $summaries as $title => $summary ){
			$html .= "<li class='list-group-item $title relative'>";
			if( !empty( $summary["title"] ) )
				$html .= sprintf( '<p class="list-group-item-text">%s</p>', esc_html( $summary["title"] ) );
			if( !empty( $summary["key"] ) )
				$html .= sprintf( '<h4 class="list-group-item-heading">%s</h4>', $summary["key"] );
			$html .= "</li>";
		}
		

	echo $html;

}
