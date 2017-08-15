<?php
/*
* Functions that are customised for my theme use 
* These functions are majorly wrappers for some wordpress native functions 
*
*/

/**
 * Show author or user avatar 
 * @uses: the native wordpress get_avatar() function
 * @since: 0.1
 */
function abbey_author_photo( $id, $size = 32, $class = "" ){
	return get_avatar( $id, $size, "", "", array("class" => $class ) );
}

/**
 * Wrapper function for abbey_post_author 
 * to generate html to show author info 
 * @since: 0.1
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

/**
 * function to show author social contacts 
 * this depends if the author social meta is enabled 
 * @since: 0.1
 * @edited: the social contact are now being set/get from the global default settings.
 * @return: array() - author_contacts 
 *
 */
function abbey_author_contacts( $author, $key = "" ){
	global $abbey_defaults;
	$social_contacts = ( !empty( $abbey_defaults[ "authors" ][ "social_contacts" ] ) ) ? $abbey_defaults[ "authors" ][ "social_contacts" ] : array();
	$author_contacts = array();
	
	//bail if there is no author social contact //
	if( empty( $social_contacts ) ) return; 
	
	foreach( $social_contacts as $contact ){
		if( $author_contact = get_the_author_meta( $contact, $author->ID ) )
			$author_contacts[ $contact ] = $author_contact;
	}
	
	return $author_contacts;
}

/**
 * Show some little post info e.g. post date, author, category 
 * this function is pluggable and overridable, simply create a function with the same name in your child theme
 * @since: 0.1
 * @return: 	string 		HTML formatted post info 
 */
if( !function_exists( "abbey_post_info" ) ) : 
	function abbey_post_info( $echo = true, $keys = array() ){
		$info = array();
		$cats = get_the_category(); // $cats[0]->name->categroy_count
		/* author info */
		$info["author"] = sprintf ( '<div class="post-info-list"><span class="sr-only"> %1$s </span> %2$s</div>',
									__( "Posted by:", "abbey" ), 
									abbey_show_author( false ) // check functions/template-tags.php //
									);
		/* date info */ 
		$info["date"] = sprintf( '<time datetime="%3$s" class="post-info-list"><span class="sr-only">%2$s</span><span>%1$s </span></time>',
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
			$info["more"] = sprintf( '<a href="%1$s" title="%2$s" role="button" class="post-info-list">%3$s </a>', 
		 				esc_url( $cat_link ), 
		 				__( "Click to read more posts", "abbey" ), 
		 				sprintf( __( "اقرأ من المقالات الأخرى من %s", "abbey" ), esc_html( $cats[0]->name ) )
		 				);
		}

		$post_infos = apply_filters( "abbey_post_info", $info );//filter to add more post info //

		if( empty( $post_infos ) ) return; //bail early if no post_info //

		$html = $icon = $heading = $class = "";
		
		/**
		* before the post info is displayed, we check if a key param is passed throught this function
		* this key param which must be an array is to set which of the infos to be displayed and which to be excluded
		*/
		foreach ( $post_infos as $title => $post_info ){ //loop through the infos 
			
			/** 
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
			if( !empty( $keys[$title] ) && is_array( $keys[$title] ) ){
				if ( !empty( $keys[$title]["icon"] ) )  
						"<span class='fa ".esc_attr( $keys[$title]["icon"] )." post-info-list-icon'></span>";

				if ( !empty( $keys[$title]["title"] ) )
					"<span class='post-info-list-heading'>".esc_html( $keys[$title]["title"] )."</span>";
			}

			$class = esc_attr( $title );
			$html .= "<li class='$class'>$icon $heading $post_info</li>\n";//the list of each post info //
		}
		
		if ( !$echo ) return $html; //$echo is false, dont output just return //
		
		echo $html; 

	} //end of function abbey_post_info //

endif; //endif function exists abbey_post_info //

/**
 * Wrapper function for wordpress link pages 
 * this function is different from page_pagination because this function is for linking posts through the --next-page shortcode
 * this function shows pagination within published posts or pages i.e. a multipaged post or article 
 * @since: 0.1
 * @return:		string|array 	a HTML formatted list containing links to next or prev page or an array 
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
* this function can only show either previous or next noth both of them at once  
* this function only generate the html, the post object is passed by param 
*/
function abbey_show_nav( $post, $nav = "previous" ){
	$class = ( $nav === "previous" ) ? "previous-button" : "next-button";
	$icon = ( $nav === "previous" ) ? "glyphicon-chevron-left" : "glyphicon glyphicon-chevron-right";
	$title = ( !get_post_format( $post->ID ) ) ? sprintf( '%s post:', ucwords( $nav ) ) : sprintf( '%s:', ucwords( get_post_format( $post->ID ) ) );
	$nav_text = sprintf( '%s post', ucwords( $nav ) );

	
	return sprintf( '<a href="%1$s" class="%2$s-button" title="%3$s">
					<span class="glyphicon %4$s"></span>
		 			<em>%5$s</em><h4 class="%2$s-post-title"> %6$s </h4>
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



/**
 * Display post categories for a post, this function behaves similarly to abbey_post_terms
 * the difference is just that this function only displays the categories 
 * @since: 0.1 
 * @category: functions/template-tags  
 *
 */
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

/**
 * Display post date
 * @since: 0.11
 */
function abbey_post_date( $echo = true, $post_id = "", $icon = "" ){
	if( empty( $post_id ) ) $post_id = get_the_ID();
	$date = sprintf( '<time datetime="%3$s"><span class="sr-only">%2$s</span><span>%1$s </span></time>',
						get_the_time( get_option( 'date_format' ).' \@ '.get_option( 'time_format' ), $post_id ), 
						__( "Posted on:", "abbey" ), 
						get_the_time('Y-md-d', $post_id )
					); 
	if( !empty( $icon ) ) //if $icon param is not empty //
		$date =  $icon.$date;
	if( ! $echo )
		return $date;
	echo $date;
}

/*
* wrapper function for wordpress post_type to show posts type
*
*/
if( !function_exists( "abbey_show_post_type" ) ) : 
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

endif; //endif function exist abbey_show_post_type //

/**
 * Wrapper function for displaying post thumbnails 
 * if the post thumbnail is found, the thumbnail is returned, else a custom thumbnail is displayed 
 * @since: 0.1
 * @param: 	string 		$size 			thumbnail image size to return 
 *			int 		$page_id 		image or media ID 
 * 			bool 		$echo 			echo or return output 
 *
 */
function abbey_page_media( $size = "medium", $page_id = "", $echo = true ){
	$icon = "";
	$page_id = ( empty( $page_id ) ) ? get_the_ID() : $page_id;

	$icon = ( has_post_thumbnail( $page_id ) ) ? get_the_post_thumbnail( $page_id, $size ) : apply_filters( "abbey_theme_page_media", $icon, $page_id ); //wp thumbnail or custom thumbnail//
	
	if( !$echo )
		return $icon;
	echo $icon;
}

/*
 * wrapper function for showing some cutom excerpt length 
 * this is mostly useful, because with this different excerpt lenght can be displayed for different posts 
 * and different excerpt length can be displayed for different pages 
 */
function abbey_excerpt( $length = "", $more = "", $echo = false ){
	$length = empty( $length ) ? get_option( 'excerpt_length' ) : $length; //excerpt characters max lenght //
	$more_text = empty( $more ) ? abbey_excerpt_more() : $more;
	$more_text = wp_trim_words( get_the_excerpt(), $length, $more_text );
	if( !$echo )
		return $more_text;

	echo $more_text;
	
}

/* 
* wrapper function for wp get_media_embedded_in_content
* this function grabs the first video found in a post 
* this function returns an html styled content 
*
*/
function abbey_recording_video( $echo = true, $page_id = "" ){
	$content = get_the_content( $page_id );
	$embeds = get_media_embedded_in_content( $content );

	if( empty( $embeds ) ) return;
	if( ! $echo  )
		return $embeds[0];

	echo $embeds[0];
}

