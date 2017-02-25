<?php

function abbey_numerize($string){
	$result = preg_replace("/[^0-9.]/", '', $string); //use regex to remove non digit characters //
	return $result;
}

/*
* wrapper function for wp_nav_menu 
* instead of calling wp_nav_menu, I am using my own custom wrapper for the wordpress built in function
*/
function abbey_nav_menu( $args = array() ){
	$defaults = array(	'menu'              => '',
	                	'theme_location'    => '',
	                	'depth'             => 1,
	                	'container'         => 'div',
	                	'container_class'   => '',
	        			'container_id'      => '',
	                	'menu_class'        => '',
	                	'fallback_cb'       => '',
	                	'walker'            => ''
	            );
	$args = wp_parse_args( $args, $defaults ); //replace the default arguments with the user arguments if set //

	wp_nav_menu( $args ); //call the wordpress menu function //

}

/*
* wrapper function for wordpress register_sidebar
*
*/

/*
* function to generate font-awesome classes for social icons
* this function will only work properly when you have font-awesome enqueued in your theme
* @return: string 
*
*/
function abbey_contact_icon($contact){
	$contact = esc_attr($contact);
	switch ( $contact ){
		case "address" : 
			$icon = "fa-map-marker"; //icon for address//
			break;
		case "tel":
		case "telephone":
		case "phone-no":
		case "mobile-no":
			$icon = "fa-phone"; // mobile phone icon//
			break;
		case "email":
		case "mail":
			$icon = "fa-envelope"; // mail icon //
			break;
		case "facebook" :
			$icon = "fa-facebook"; // icon for facebook //
			break;
		case "twitter" :
			$icon = "fa-twitter"; // twitter icon //
			break;
		case "whatsapp":
		case "whats-app":
			$icon = "fa-whatsapp"; // whatsapp icon //
			break;
		case "pinterest":
		case "pininterest":
			$icon = "fa-pinterest"; // pinterst icon //
			break;
		case "g-plus":
		case "google-plus":
		case "googleplus":
			$icon = "fa-google-plus";
			break;
		case "instagram":
			$icon = "fa-instagram";
			break;
		case "tumblr":
			$icon = "fa-tumblr";
			break;
		case "github":
			$icon = "fa-github";
			break;
		case "bitbucket":
			$icon = "fa-bitbucket";
			break;
		case "website":
			$icon = "fa-globe"; 
			break;
		case "profile":
			$icon = "fa-user";
			break;
		case "posts":
			$icon = "fa-newspaper-o";
			break;
		default:
			$icon = "fa-list"; // default icon if icon is not set nor found //

	}
	return $icon;
}

function abbey_display_contact( $contact, $heading ){
	$html = "";
	
	if( !is_array( $contact ) ) {
		$html .= "<div class='col-md-6 margin-bottom-sm'>";
		$html .= "<header class='text-capitalize'>". esc_html( $heading ). "</header>";
		$html .= "<div class='medium'>". esc_html( $contact ) . "</div>";
		$html .= "</div>";
	}
	else{
		$contacts = $contact;
		foreach ( $contacts as $contact_heading => $contact ){
			$contact_heading = $contact_heading." ".$heading;
			$html .= abbey_display_contact($contact, $contact_heading); // recursive function //
		}
	}

	return $html;
}

function abbey_get_contact( $type, $key = "" ){
	global $abbey_defaults; // theme default values set in theme_setup.php //
	if( isset( $abbey_defaults["contacts"] ) ){
		$contacts = $abbey_defaults["contacts"];
		$contact_type = ( isset ( $contacts[ $type ] ) ) ? $contacts[$type] : "";
		if (! empty ( $contact_type ) ) {
			$contact = ( !empty($key) && isset($contact_type[$key]) ) ? $contact_type[$key] : $contact_type;
		}
		
	}
	return $contact;
}
function abbey_theme_page_id( $id= "" ){
	if ( empty($id) ) {
		if( is_front_page() ){ $id = "front-page"; }
		elseif ( is_page() ) { $id = "site-page"; }
		elseif( is_404() ) { $id = "error-404-page"; }
		elseif( is_search() ) { $id = "search-page"; }
		elseif ( is_single() ) {
			$id = ( ! has_post_format() ) ? "post-page" : get_post_format()."-post-page"; 
		}
		elseif( is_search() ){
			$id = "search-page";
		}
		elseif ( is_archive() ){
			$id = get_queried_object()->name."-archive";
		}

	} 
	echo esc_attr( apply_filters( "abbey_theme_page_id", $id ) );

}

function abbey_theme_show_services(){
	global $abbey_defaults;
	$services = ( !empty( $abbey_defaults["services"]["lists"] ) ) ? $abbey_defaults["services"]["lists"] : "";
	if( count($services) > 0 ){
			$html = "";
		foreach( $services as $service ){
			$html .= "<div class='col-md-4 col-sm-6 col-xs-6 service-icons'><div class='service-wrapper'>";
			if( !empty($service["icon"]) ){$html .= "<div class='service-icon'><span class='fa ".esc_attr($service["icon"])." fa-3x' > </span></div>"; }
			if( !empty($service["header-text"]) ){$html .= "<div class='service-heading text-capitalize'><h4>".esc_html($service["header-text"]). "</h4></div>"; }
			if( !empty($service["body-text"]) ){
				$html .= "<div class='service-body'>";
				$html .= esc_html($service["body-text"]);
				$html .= "</div>";
			 }
			$html .= "</div></div>";

		}
	}
	echo $html;
}

/*
* a wrapper function to get the uploaded logo 
*
*/

function abbey_custom_logo( $class = "" ){
	$class = ( !empty($class) ) ? esc_attr( $class ) : "";
	$title = get_bloginfo("name");
	if( has_custom_logo() ){
		$logo = get_theme_mod("custom_logo");
		$logo_attachment = wp_get_attachment_image_src( $logo, "full" );
		$logo_url = $logo_attachment[0]; 
		$image = "<img src='".esc_url($logo_url)."' class='custom-logo {$class}' alt ='{$title}' ";
		$image .= " /> ";
		return $image;
	}
	else{
		return "<h2>".bloginfo("name")."</h2>";
	}
}

function abbey_show_logo ( $prefix_id = "", $logo_class = "", $show_site_name = true ){
	$prefix_id = ( !empty( $prefix_id ) ) ? esc_attr( $prefix_id."-" ) : "";

	$html = '<div id="'.$prefix_id.'site-logo" class="inline">'.abbey_custom_logo( $logo_class ).'</div>';
	if ( $show_site_name )
		$html .= '<div id="'.$prefix_id.'site-name" class="inline">'.get_bloginfo('name'). '</div>';
	
	echo $html; 
	
}
function abbey_class ( $prefix ) {
	global $wp_query;
	$class = "";
	if( $wp_query->is_page() ){ $class = "page"; }
	esc_attr_e ( $prefix."-".$class );
}

function abbey_nav_toggle () { ?>
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	    <span class="sr-only">Toggle navigation</span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	</button>	<?php
}

/*
* display the theme set primary menu 
*
*/
function abbey_primary_menu(){
    $args = apply_filters( "abbey_primary_menu_args", array(
	                	'menu'              => 'primary',
	                	'theme_location'    => 'primary',
	              		'depth'             => 2,
	                	'container'         => 'div',
	                	'container_class'   => 'collapse navbar-collapse',
	        			'container_id'      => 'bs-example-navbar-collapse-1',
	                	'menu_class'        => 'nav navbar-nav',
	                	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	                	'walker'            => new wp_bootstrap_navwalker()
	               	 	)
	);
	if ( has_nav_menu( 'primary' ) ):
    	abbey_nav_menu ( $args ); //this function is a wrapper function for wp_nav_menu
    endif;
}
add_action( "abbey_theme_primary_menu", "abbey_primary_menu" ); 

/*
* display the theme set secondary menu
*
*/
function abbey_secondary_menu( $args = array() ){
	$defaults = apply_filters( "abbey_theme_secondary_menu_args", array(
	                		'menu'              => 'secondary',
	                		'theme_location'    => 'secondary',
	                		'depth'             => 1,
	                		'container'         => 'ul',
	                		'menu_class'   		=> 'nav nav-pills',
	                	)
    );
    $args = ( count( $args ) > 0 ) ? wp_parse_args( $args, $defaults ) : $defaults;
	if( has_nav_menu("secondary") ) :
		abbey_nav_menu( $args ); // this function is a wrapper function for wp_nav_menu
	endif;
	
}

/*
* display the theme set social menu 
*
*/
function abbey_social_menu(){
	$defaults = apply_filters( "abbey_theme_social_menu_args", array(
								'menu' => 'social', 
								'theme_location' => 'social',
								'depth' => 1, 
								'container' => 'ul', 
								'menu_class' => 'nav', 
								'walker' => new Abbey_Social_Nav_Walker() // custom walker for social menu//
							) 
	);
	if (! has_nav_menu("social") ) 
		abbey_show_social_contacts(); //if there is no social menu set, just show the social contacts instead //
	
	abbey_nav_menu ($defaults);
}

/*
* wrapper function for wp post_class() function 
*
*/
function abbey_post_class ( $class = "" ){
	if ( !is_array( $class ) ) { $class .= " entry-content"; }
	else { $class[] = "entry-content"; }
	post_class( apply_filters( "abbey_post_classes", $class ) );
}

/*
* 
*
*/
function abbey_display_sidebar ( $sidebar_id ){
	if ( is_active_sidebar( $sidebar_id ) ){ // check if a sidebar is registered with this id //
		dynamic_sidebar( $sidebar_id );
	} else {
		echo __( "Sorry, there is no sidebar widget registered with {$sidebar_id}", "abbey" );
	}
}



function abbey_comments_args(){
	$commenter = wp_get_current_commenter();
	$fields = array(
	'author' => sprintf( '<div class="comment-form-author form-group">
						<label for="author">%1$s<span class="required">*</span></label>
						<input id="author" name="author" type="text" value="%2$s" maxlength="245" class="form-control" />
						</div>',  
						__( 'Name', 'abbey' ), 
						esc_attr( $commenter['comment_author'] ) 
				), 
	'email'  => sprintf( '<div class="comment-form-email form-group">
						<label for="email">%1$s<span class="required">*</span></label> 
						<input id="email" name="email" type="email" value="" maxlength="100" aria-describedby="email-notes" class="form-control"/>
						</div>',
						__( 'Email' ), 
						esc_attr(  $commenter['comment_author_email'] )
					)
 	);

	$args = array(
		"fields" => $fields, 
		"comment_field" => sprintf( '<div class="comment-form-comment form-group">
									<label for="comment">%1$s</label> 
									<textarea id="comment" name="comment" rows="3" maxlength="65525" aria-required="true" 
										required="required" placeholder="%2$s" class="form-control"></textarea>
									</div>',
							 __( 'Comment', 'abbey' ), 
							 __( "Enter your comment", "abbey" )
							), 
		'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-block btn-primary">%4$s</button>',
		'submit_field'  => '<div class="form-submit form-group">%1$s %2$s</div>'



	); 

	return $args;
}

function abbey_setup_query(){
	global $wp_query, $abbey_query; 
	if ( count( $wp_query->posts ) > 0 ){
		foreach( $wp_query->posts as $post ){
			$abbey_query[] = array(
				"ID" => $post->ID, 
				"post_type" => $post->post_type, 
				"post_author" => $post->post_author, 
				"comment_count" => $post->comment_count
			); 
		}
		$abbey_query["summary"][ "found_posts" ] = array( 
			"key" => $wp_query->found_posts, "icon" => "", "title" => __( "Total posts found", "abbey" )
		);
		$abbey_query["summary"][ "num_pages" ] = array(
			"key" => $wp_query->max_num_pages, "icon" => "", "title" => __( "Number of page", "abbey" )
		); 
		if( is_search() ){
			$abbey_query["summary"][ "keyword" ] = array(
			"key" => get_search_query(), "icon" => "fa-search", "title" => __( "Searched keyword", "abbey" )
			);
		}

		$abbey_query = apply_filters( "abbey_theme_query", $abbey_query );
	}


}

function abbey_group_posts( &$custom_posts ){
	$post_types = get_post_types( array( 'public' =>  true ), 'object' );
	$custom_posts = array();
	if( !empty( $post_types ) ){
		foreach( $post_types as $post_type ){
			$custom_posts[$post_type->name]["posts"] = array();
			
			if( !empty( $post_type->labels ) )
				$custom_posts[$post_type->name]["labels"] = $post_type->labels;
		}
	}

}
function abbey_add_posts( &$custom_posts ){
	$post_type = get_post_type();
	if( array_key_exists( $post_type, $custom_posts ) ){
		$custom_posts[$post_type]["posts"][] = array(
			"ID" => get_the_ID(), 
			"excerpt" => get_the_excerpt(), 
			"thumbnail" => abbey_page_media( "", get_the_ID(), false ), 
			"url" => get_permalink(), 
			"title" => get_the_title()
		);


	}
}
function abbey_gallery_images(){
	global $post; 
	
	$galleries = get_post_galleries_images( $post );

	$slide_images = $galleries;

	if( count( $galleries ) > 0 )
		$slide_images = array();
		for( $i = 0; $i < count( $galleries ); $i++ ){
			if( is_array( $galleries[$i] ) && !empty( $galleries[$i] ) ){
				foreach( $galleries[$i] as $gallery ){
					$slide_images[] = $gallery;
				}
			}
		}
		$slide_images[ "galleries" ] = $galleries;

	return $slide_images; 
}

/*
* a wp filter to add icons to nav_menu
*
*/
function abbey_add_to_primary_menu ( $items, $args ) {
	if( 'primary' === $args->theme_location ) {
		$items .= '</ul>';
		$items .= sprintf( '<form class="navbar-form navbar-left" action="%1$s/" method="get">
		        				<div class="form-group">
		          					<input type="search" class="form-control" placeholder="Search" name="s" />
		        				</div>
	        				</form>', 
      						esc_url( home_url() )
      					);
	}
	return $items;
}
add_filter( 'wp_nav_menu_items','abbey_add_to_primary_menu',10,2 );//wp filter to add to nav menus //

function abbey_get_posts( $args = array() ){
	$defaults = array(
		'posts_per_page'   => 5,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'no_found_rows'		=> true
	);
	$args = wp_parse_args( $args, $defaults ); 

	$posts = new WP_Query( $args ); 

	return $posts;
}

function abbey_posts_pagination( $args = array() ){
	$defaults = array( "type" => "array", "mid_size" => 1 ); 
	$args = wp_parse_args( $defaults, $args );
	$navigation = "";
	if( $GLOBALS['wp_query']->max_num_pages > 1 ){
		$links = paginate_links( $args ); 
		$navigation .= "<ul class='pagination'>";

		foreach( $links as $link ){
			$navigation .= "<li>".$link."</li>\n";
		}
		$navigation .= "</ul>\n";
	}
	echo $navigation; 

}