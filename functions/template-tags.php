<?php
/*
* Functions that are customised for my theme use 
* These functions are majorly wrappers for some wordpress native functions 
*
*/

/*
* function to show author or user avatar 
* uses the native get_avatar
*
*/
function abbey_author_photo( $id, $size = 32, $class = "" ){
	return get_avatar( $id, $size, "user_upload", "", array("class" => $class ) );
}

/*
* Wrapper function for abbey_post_author 
* to generate html to show author info 
*
*/
function abbey_show_author( $echo = true ){
	$author = abbey_post_author(); // check functions/core.php //
	$html = sprintf( '<span class="post-author-image">%1$s</span>
					<span class="post-author-name strong">
						<a href="%2$s" title="%3$s"> %4$s </a> 
					</span>', 
					abbey_author_photo( $author->ID, 32, "img-circle" ), //check functions/template-tags.php //
					get_author_posts_url( $author->ID ), 
					__( "Read all author posts", "abbey" ),
					esc_html( $author->display_name ) 
				);
	if ( $echo ) 
		echo $html;
	return $html;
}

/*
* function to show author social contacts 
* this depends if the author social meta is enabled 
* @return: array() - author_contacts 
*
*/
function abbey_author_contacts( $author, $key = "" ){
	$social_contacts = apply_filters( "abbey_author_social_contacts", array( "facebook", "twitter", "google-plus", "linkedin", "github" ) );
	$author_contacts = array();
	if( !empty( $social_contacts ) ){
		foreach( $social_contacts as $contact ){
			if( $author_contact = get_the_author_meta( $contact, $author->ID ) )
				$author_contacts[ $contact ] = $author_contact;
		}
	}//end if social_contacts //
	return $author_contacts;
}

/*
* function to show some little post info e.g. post date, author, category 
*
*/
function abbey_post_info( $echo = true, $keys = array() ){
	$info = array();
	$cats = get_the_category(); // $cats[0]->name->categroy_count
	/* author info */
	$info["author"] = sprintf ( '<span class="sr-only"> %1$s </span> %2$s',
								__( "Posted by:", "abbey" ), 
								abbey_show_author( false ) // check functions/template-tags.php //
								);
	/* date info */ 
	$info["date"] = sprintf( '<time datetime="%3$s"><span class="sr-only">%2$s</span><span>%1$s </span></time>',
							get_the_time( get_option( 'date_format' ).' \@ '.get_option( 'time_format' ) ), 
							__( "Posted on:", "abbey" ), 
							get_the_time('Y-md-d')
						); 
	/*
	* post category info, only the first category info is displayed 
	* the first category name and link is displayed 
	*
	*/ 
	if( !empty ( $cats[0] ) ){
		$cat_link = ( isset( $cats[0] ) ) ? get_category_link( $cats[0]->cat_ID ) : "";
		$info["more"] = sprintf( '<a href="%1$s" title="%2$s" role="button" class="">%3$s </a>', 
	 				esc_url( $cat_link ), 
	 				__( "Click to read more posts", "abbey" ), 
	 				sprintf( __( "اقرأ من المقالات الأخرى من %s", "abbey" ), esc_html( $cats[0]->name ) )
	 				);
	}

	$post_infos = apply_filters( "abbey_post_info", $info );//filter to add more post info //

	$html = $icon = $heading = $class = "";
	/*
	* before the post info is displayed, we check if a key param is passed throught this function
	* this key param which must be an array is to set which of the infos to be displayed and which to be excluded 
	*
	*/
	if( !empty( $post_infos ) ) {
		foreach ( $post_infos as $title => $post_info ){ //loop through the infos 
			/* 
			* check if $key param is empty, if $key is not empty, then 
			* 1. check if the title is in keys or 
			* 2. if the title exist in keys array, 
			* if not then exclude this info */
			if( !empty( $keys ) && !( in_array( $title, $keys ) || array_key_exists( $title, $keys ) )  )
				continue;
			/*
			* if keys is not empty and the current title is found in keys, and this title index is an array 
			* generate an icon and a heading 
			*/
			if( !empty( $keys[$title] ) && is_array( $keys[$title] ) )
				$icon = ( !empty( $keys[$title]["icon"] ) ) ? 
						"<span class='fa ".esc_attr( $keys[$title]["icon"] )."'></span>" : "";

				$heading = ( !empty( $keys[$title]["title"] ) ) ? 
							"<span class='$title-heading'>".esc_html( $keys[$title]["title"] )."</span>" : "";

			$class = esc_attr( $title );
			$html .= "<li class='$class'>$icon $heading $post_info</li>\n";//the list of each post info //
		}
	} //end if $post_infos //
	if ( $echo )
		echo $html; 
	return $html;
}

/* 
* Wrapper function for wordpress link pages 
* this function is different from page_pagination because this function is for linking posts through the --next-page shortcode
* this function shows pagination within published posts or pages i.e. a multipaged post or article 
*
*/
function abbey_post_pagination( $args = array() ){
	$defaults = array(
		'before'           => '<ul class="pagination">',
		'after'            => '</ul>',
		'link_before'      => '',
		'link_after'       => '',
		'next_or_number'   => 'number',
		'separator'        => ' ',
		'nextpagelink'     => __( 'Next page' ),
		'previouspagelink' => __( 'Previous page' ),
		'pagelink'         => '%',
		'echo'             => 1
	);
	wp_link_pages( $defaults );
}

/*
* function to show links to previous and next post 
* this function only generate the html, the post object is passed by param 
*/
function abbey_show_nav( $post, $nav = "previous" ){
	$class = ( $nav === "previous" ) ? "previous-button" : "next-button";
	$icon = ( $nav === "previous" ) ? "glyphicon-chevron-left" : "glyphicon glyphicon-chevron-right";
	$title = ( !get_post_format( $post->ID ) ) ? "" : sprintf( '%s:', ucwords( get_post_format( $post->ID ) ) );
	$nav_text = sprintf( '%s post', ucwords( $nav ) );

	
	return sprintf( '<a href="%1$s" class="%2$s-button" title="%3$s">
					<span class="glyphicon %4$s"></span>
		 			<h4 class="%2$s-post-title"><em>%5$s</em> %6$s </h4>
		 	   		</a>',
					get_permalink( $post->ID ),
					esc_attr( $nav ),
					sprintf( __( "Click to view %s", "abbey" ), $nav_text ),
					esc_attr( $icon ),
					$title,
					apply_filters( "the_title", $post->post_title )
			);
}

/*
* function to show category or tags for a post, this function has been extended to show other terms too i.e custom taxonomies
*
*/
function abbey_cats_or_tags( $cats, $title = "", $icon = "", $notes = "", $post_id = "" ){
	global $post; 
	$post_id = (!empty ( $post_id ) ) ? (int) $post_id : $post->ID;

	// taxonomy_exists( $cats  ) //
	$list = $cats; //clone the cats //
	$class = "categories"; // default class //

	if( $cats === "categories" || $cats === "category" ){// if post categories is requested //
		$list = get_the_category_list( '', '', $post_id ); 
		$icon = ( empty( $icon ) ) ? "fa-folder" :  $icon;
		$class = "categories";
	}

	elseif ( $cats === "tags" || $cats === "post_tag" ){ //if post tags is requested //
		$list = get_the_tag_list( "<ul class='tag-list'><li>", "</li><li>", "</li></ul>", $post_id );
		$icon = ( empty( $icon ) ) ? "fa-tag" :  $icon;
		$class = "tags";
	}

	elseif( taxonomy_exists( $cats ) ){ //if the requested term exists //
		$list = get_the_term_list( $post_id, $cats, "<ul class='{$cats}-list'><li>", ',</li><li>', '</li></ul>' );
		$class = $cats;
	}

	if( empty( $list ) )
		return;

	$html = sprintf( '<div class="%4$s-list">
						<i class="fa %1$s fa-fw %4$s-icon"></i>
						<span class="%4$s-heading">%2$s</span>
						%3$s
					  </div>', 
						esc_attr( $icon ),  
						esc_html( $title ),
						$list,
						esc_attr( $class ) 		
				);
	return $html;
}

/*
* function for showing terms with their post count 
* all terms related to the present post are displayed automatically unlike abbey_cat_or_tag that shows a single term
*
*/
function abbey_post_terms( $post_id ){
	$taxonomies  = get_object_taxonomies( get_post_type( $post_id ), 'names' ); //get all taxonomies related to this post//
	$list = $html = "";
	$icon = ""; 
	if( $taxonomies ){
		$html .= "<div class='post-taxonomies'>\n"; //start html .post-taxonomies //
		$html.= sprintf( '<p class="md-50 dark text-center">%s</p>', __( "Read more or all posts related to this article", "abbey" ) );
		
		foreach( $taxonomies as $taxonomy ){ //loop through the taxonomies //
			$icon = abbey_contact_icon( $taxonomy ); //get taxonomy icon //
			$terms = get_the_terms( $post_id, $taxonomy ); //get the terms i.e. categories related to this post //
			
			if ( !empty( $terms ) ){ // if the terms i.e. categories are not empty //
				$terms = array_values( $terms );
				foreach ( array_keys( $terms ) as $key ) {
	        		_make_cat_compat( $terms[$key] );
	   			}
   				$list = "<ul class='post-{$taxonomy} post-terms list-inline'>";//start of terms list //
				foreach( $terms as $term ){
					$list .=  sprintf( '<li><a href="%1$s" rel="category">%2$s 
										<span class="badge category-count">%3$s </span></a></li>',
										esc_url( get_term_link( $term, $terms ) ), 
										$term->name, 
										$term->count
								);
				}
				$list .= "</ul>\n"; //end of terms list list //
				$icon = apply_filters( "abbey_terms_icon", $icon, $taxonomy );
				$html .= abbey_cats_or_tags( $list, "", $icon, "" ); // check functions/template-tags.php //

	   		}// end if !empty terms //

		}
		$html .= "</div>"; // end html .post-taxonomies //
	} //end if taxonomies //
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

function abbey_post_date( $echo = true, $post_id = "", $icon = "" ){
	
	$date = sprintf( '<time datetime="%3$s"><span class="sr-only">%2$s</span><span>%1$s </span></time>',
						get_the_time( get_option( 'date_format' ).' \@ '.get_option( 'time_format' ), $post_id ), 
						__( "Posted on:", "abbey" ), 
						get_the_time('Y-md-d', $post_id)
					); 
	if( !empty( $icon ) )
		$date =  $icon.$date;
	if( ! $echo )
		return $date;
	echo $date;

}

function abbey_list_comments( $args = array() ){
	wp_list_comments( array(
		'style'      => 'ol',
		'short_ping' => true,
		'avatar_size'=> 60,	
		'callback'	=> 'html5_comment'			
		) 
	);
}

function abbey_show_post_type(){
	$post_type = get_post_type(); 
	$post = "";
	switch ( $post_type ){
		case "post":
			$post = __( "مقالة", "abbey" );
			break; 
		case "page":
			$post = __( "Page", "abbey" ); 
			break; 
		case "news":
			$post = __( "أخبار", "abbey" );
		
		default: 
			$post = ucwords( $post_type ); 
	}
	echo apply_filters( "abbey_post_type", $post );
}



function abbey_page_media( $size = "medium", $page_id = "", $echo = true ){
	$icon = "";

	if ( has_post_thumbnail() )
		$icon = ( $echo ) ? the_post_thumbnail( $size ) : get_the_post_thumbnail( $size );
	else 
		$icon =  apply_filters( "abbey_theme_page_media", $icon, $page_id );
	
	if( !$echo )
		return $icon;
	echo $icon;
}

function abbey_excerpt( $length = "", $more = "", $echo = false ){
	$length = empty( $length ) ? 55 : $length;
	$more_text = empty( $more ) ? abbey_excerpt_more() : "...";
	if( !$echo )
		return wp_trim_words( get_the_excerpt(), $length, $more_text );

	echo wp_trim_words( get_the_content(), $length, $more_text );
	//the_excerpt();
}
