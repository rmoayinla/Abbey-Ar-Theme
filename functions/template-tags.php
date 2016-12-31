<?php

function abbey_author_photo( $id, $size = 32, $class = "" ){
	return get_avatar( $id, $size, "user_upload", "", array("class" => $class ) );
}

function abbey_post_author( $key = "" ){
	global $authordata, $post;

	$author_id = ( is_object( $authordata ) ) ? $authordata->ID : $post->post_author; // get the post author id //
	$author = get_userdata( $author_id );
	
	$values = array(); 
	$values["display_name"] = $author->display_name; // the author display name//
	$values["post_count"] = get_the_author_posts(); // the author post count //
	$values["description"] = $author->description;
	
	if ( !empty( $key ) && array_key_exists( $key, $values ) )
		return $values[$key];

	return $author;
	/*$html = sprintf( '<span class="post-author-info"><span class="author-name"> %1$s </span>
						<span class="badge author-post-count"> %2$s </span> </span>',
						esc_html( $values["display_name"] ), 
						(int) $values["post_count"]
					);
	
	*/
	
}

function abbey_show_author( $echo = true ){
	$author = abbey_post_author();
	$html = sprintf( '<span class="post-author-image">%1$s</span>
					<span class="post-author-name strong">
						<a href="%2$s" title="%3$s"> %4$s </a> 
					</span>', 
					abbey_author_photo( $author->ID, 32, "img-circle" ), 
					get_author_posts_url( $author->ID ), 
					__( "Read all author posts", "abbey" ),
					esc_html( $author->display_name ) 
				);
	if ( $echo ) 
		echo $html;
	return $html;
}

function abbey_author_info( $author, $key = "" ){
	$author_info = array(); // array to contain author info which will be displayed in a dropdown //
	$author_info["email"] = sprintf( '<a href="mailto:%1$s" title="%2$s" id="emailauthor">
									<span class="fa fa-envelope"></span></a>', 
							antispambot( $author->user_email ), 
							esc_attr( __( "Send this author an email", "abbey" ) )
							); 
	
	$author_info["website"] = sprintf( '<a href="%1$s" title="%2$s" target="_blank">
										<span class="fa fa-fw fa-globe"></span> </a>',
									esc_url( $author->user_url ),
									esc_attr( __( "Visit author's website", "abbey" ) )
							);


	$author_info["profile"] = sprintf( '<a href="#" title="%1$s" id="authorprofile" class="js-link"> 
										<span class="fa fa-fw fa-user"></span> </a>',
										esc_attr( __( "View author's profile", "abbey" ) )
							);

	$author_info["posts"] = sprintf( '<a href="%1$s" title="%2$s"> 
									<span class="fa fa-fw fa-newspaper-o"></span> </a>', 
							esc_url( get_author_posts_url( $author->ID ) ),
							esc_attr( sprintf( __( "View posts by %s", "abbey" ), $author->display_name ) )
							 );
	return $author_info;
}

function abbey_post_info( $echo = true, $keys = array() ){
	$info = array();
	$cats = get_the_category(); // $cats[0]->name->categroy_count
	
	$info["author"] = sprintf ( '<span class="sr-only"> %1$s </span> %2$s', __( "Posted by:", "abbey" ), abbey_show_author( false )
						); 
	$info["date"] = sprintf( '<time datetime="%3$s"><span class="sr-only">%2$s</span><span>%1$s </span></time>',
						get_the_time( get_option( 'date_format' ).' \@ '.get_option( 'time_format' ) ), 
						__( "Posted on:", "abbey" ), 
						get_the_time('Y-md-d')
					); 
	if( !empty ( $cats[0] ) ){
		$cat_link = ( isset( $cats[0] ) ) ? get_category_link( $cats[0]->cat_ID ) : "";
		$info["more"] = sprintf( '<a href="%1$s" title="%2$s" role="button" class="">%3$s </a>', 
	 				esc_url( $cat_link ), 
	 				__( "Click to read more posts", "abbey" ), 
	 				sprintf( __( "اقرأ من المقالات الأخرى من %s", "abbey" ), esc_html( $cats[0]->name ) )
	 				);
	}

	$post_infos = apply_filters( "abbey_post_info", $info );
	$html = $icon = $heading = $class = "";
	if( !empty( $post_infos ) ) {
		foreach ( $post_infos as $title => $post_info ){
			if( !empty( $keys ) && !( in_array( $title, $keys ) || array_key_exists($title, $keys ) )  )
				continue;
			if( !empty( $keys[$title] ) && is_array( $keys[$title] ) )
				$icon = ( !empty( $keys[$title]["icon"] ) ) ? 
						"<span class='fa ".esc_attr( $keys[$title]["icon"] )."'></span>" : "";
				$heading = ( !empty( $keys[$title]["title"] ) ) ? 
							"<span class='$title-heading'>".esc_html( $keys[$title]["title"] )."</span>" : "";

			$class = esc_attr( $title );
			$html .= "<li class='$class'>$icon $heading $post_info</li>\n";
		}
	}
	if ( $echo )
		echo $html; 
	return $html;
}

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

function abbey_show_nav( $post, $nav = "previous"){
	$class = ( $nav === "previous" ) ? "previous-button" : "next-button";
	$icon = ( $nav === "previous" ) ? "glyphicon-chevron-left" : "glyphicon glyphicon-chevron-right";
	$title = ( !get_post_format( $post->ID ) ) ? "" : sprintf( '%s:', ucwords( get_post_format( $post->ID ) ) );
	$nav_text = sprintf( '%s post', ucwords( $nav ) );

	
	return sprintf( '<a href="%1$s" class="%2$s-button" title="%3$s">
				<span class="glyphicon %4$s"></span>
		 		<h4 class="%2$s-post-title"><em>%5$s</em> %6$s </h4>
		 	   </a>',
			get_permalink($post->ID),
			esc_attr( $nav ),
			sprintf( __( "Click to view %s", "abbey" ), $nav_text ),
			esc_attr( $icon ),
			$title,
			apply_filters( "the_title", $post->post_title )
			);
}

function abbey_cats_or_tags( $cats, $title = "", $icon = "", $notes = "" ){
	$list = $cats;
	if( $cats === "categories" )
		$list = get_the_category_list(); 

	elseif ( $cats === "tags"  )
		$list = get_the_tag_list( "<ul class='tag-list'><li>", "</li><li>", "</li></ul>" );


	if( empty( $list ) )
		return;
	
	if( $cats !== "categories" && $cats !== "tags" )
		$cats = "categories"; 

	$html = sprintf( '<i class="fa %1$s fa-fw %5$s-icon"></i><span class="%5$s-heading">%2$s</span>
						%3$s
						<div class="%5$s-list">%4$s</div>', 
							esc_attr( $icon ),  
							esc_html( $title ),
							$notes,
							$list, 
							esc_attr($cats)			
				);
	return $html;
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