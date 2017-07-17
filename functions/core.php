<?php
/**
 * Core functions for Abbey theme 
 * these functions are mostly written from scratch either to implement/supplement some wordpress functions 
 * or to add a new functionality that is not provided by wordpress 
 *@since: 0.1 
 *@author: Rabiu Mustapha 
 *@package: Abbey theme 
 *@category: functions 
 *@version: 0.1 
 *
 */

/**
 * Remove alphabets from a string and return the digit numbers only 
 * this function is a sanitizer for numerics and digits
 *@since: 0.1 
 *@param: 	mixed 		$string 	a string to be sanitized 
 */
function abbey_numerize( $string ){
	$result = preg_replace("/[^0-9.]/", '', $string); //use regex to remove non digit characters //
	return $result; // return the processed string i.e. those with digits only //
}

/**
 * wrapper function for wp_nav_menu 
 * instead of calling wp_nav_menu, I am using my own custom wrapper for the wordpress built in function
 *@param: 	array 		$args 		arguments for the outputting menu 
 *@uses: wp_nav_menu()
 *@usage: abbey_nav_menu(['menu' => 'primary', 'theme_location'=> 'primary', 'menu_class'=>'navbar_menu'])
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

	wp_nav_menu( $args ); //call the native wordpress menu function //

}


/**
 * Function to generate font-awesome classes for social or general icons
 * @warning: this function will only work properly when you have font-awesome enqueued in your theme
 * @param:  	string 		$contact 	the item to generate an icon for 
 * @return: 	string 		the corresponding icon of the contact  being passed 
 * @since: v0.1 
 *
 */
function abbey_contact_icon( $contact ){
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
		case "category":
		case "categories":
			$icon = "fa-folder-open";
			break;
		case "tags":
		case "post_tag":
			$icon = "fa-tag";
			break;
		default:
			$icon = "fa-list"; // default icon if icon is not set nor found //

	}
	return apply_filters( "abbey_font_icon", $icon, $contact ); //add a filter in case you want to add additional icons to return //
}

/**
 * function to style and generate contacts html  
 * This function does not get the contact details, the contact to display is passed to this function through the params
 * this function is recursive as multiple level contacts are flattened 
 * @param: 	array|string 	$contact 		string or array containing stored contacts to generate 
 * 			string 			$heading  		title for the contacts 
 * @return: string 			$html 			a nicely formatted contact, flattened out with headings
 *
 */
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
			$html .= abbey_display_contact( $contact, $contact_heading ); // recursive function //
		}
	}

	return $html;
}

/**
 * Function to return/get contact details stored in Theme defaults
 * This function can get a particular contact e.g. phone no, email or return all contacts depending on the $key param
 * @return: string|array 	$contact 		depending on the $type param, a single contact or multiple (array) of contacts
 * @param: 	string 			$type 			the contact type as stored in theme options 
 * 			string 			$key 			a specific key in the contact type 
 * @usage: abbey_get_contact( "tel", "customer-service" )
 *
 */
function abbey_get_contact( $type, $key = "" ){
	global $abbey_defaults; // theme default values set in theme_setup.php //

	if( empty( $abbey_defaults["contacts"] ) ) //if contacts key is not found in defaults //
		return;  //bail early //

	$contacts = $abbey_defaults["contacts"];
	$contact_type = ( isset ( $contacts[ $type ] ) ) ? $contacts[$type] : "";
	if ( !empty ( $contact_type ) ) {
		$contact = ( !empty( $key ) && isset( $contact_type[$key] ) ) ? $contact_type[ $key ] : $contact_type;
	}
		
	return $contact;
}

/**
 * Generate an id attribute for theme template pages 
 * @return: string 
 * @since: v0.1 
 */
function abbey_theme_page_id( $id= "" ){
	if ( empty($id) ) {
		if( is_front_page() ){ 
			$id = "front-page"; 
		}
		elseif ( is_page() ) { 
			$id = "site-page"; 
		}
		elseif( is_404() ) { 
			$id = "error-404-page"; 
		}
		elseif( is_search() ) { 
			$id = "search-page"; 
		}
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
	echo esc_attr( apply_filters( "abbey_theme_page_id", $id ) );//filter to enable other id to be generated //

}

/**
 * Function to show services stored in theme defaults 
 * this function display the services i.e. generate the html 
 * the services being displayed here are gotten from theme settings i.e abbey_defaults 
 */
function abbey_theme_show_services(){
	global $abbey_defaults; // abbey theme defaults //
	$services = $abbey_defaults["services"]["lists" ];
	if( empty( $services ) ) //if there are no services //
		return; //bail early //
	$html = "";
	foreach( $services as $service ){ //loop through the services //
		$html .= "<div class='col-md-4 col-sm-6 col-xs-6 service-icons'><div class='service-wrapper'>";
		if( !empty( $service["icon"] ) ){
			$html .= "<div class='service-icon'><span class='fa ".esc_attr($service["icon"])." fa-3x' > </span></div>"; 
		}
		if( !empty( $service["header-text"] ) ){
			$html .= "<div class='service-heading text-capitalize'><h4>".esc_html($service["header-text"]). "</h4></div>"; 
		}
		if( !empty( $service["body-text"] ) ){
			$html .= "<div class='service-body'>";
			$html .= esc_html( $service["body-text"] );
			$html .= "</div>";
		 }
		$html .= "</div></div>";

	} //end foreach loop //
	
	echo $html;
}

/**
 * A wrapper function to get the uploaded logo 
 * this function return the uploaded image i.e. the html //
 *@since: v0.1 
 *@param: 	string 		$class 		additional class attribute for the generated img tag 
 *@return: 	string 		$image 		the generated html or site name 
 */

function abbey_custom_logo( $class = "" ){
	$class = ( !empty($class) ) ? esc_attr( $class ) : "";
	$title = get_bloginfo("name"); // get the site name //
	
	if( has_custom_logo() ){ // if a custom  logo has been uploaded in customizer //
		$logo = get_theme_mod( "custom_logo" );
		$logo_attachment = wp_get_attachment_image_src( $logo, "full" );
		$logo_url = $logo_attachment[0]; 
		$image = "<img src='".esc_url( $logo_url )."' class='custom-logo {$class}' alt ='{$title}' ";
		$image .= " /> ";
		return $image;
	}
	else{
		return "<h2>".bloginfo("name")."</h2>";
	}
}

/**
 * Function to show logo with sitename 
 * might later be deprecated in my theme in the future 
 *@since: 0.1
 *@param: 	string 		$prefix_id		id attribute for the wrapper div 
 *			string 		$logo_class		class for the logo img tag 
 *			bool 		$show_site_name show the logo with site name or not 
 *@return: 	string 		$html 			logo html 
 */
if( !function_exists( "abbey_show_logo" ) ) : 
	function abbey_show_logo ( $prefix_id = "", $logo_class = "", $show_site_name = true ){
		$prefix_id = ( !empty( $prefix_id ) ) ? esc_attr( $prefix_id."-" ) : "";

		$html = '<div id="'.$prefix_id.'site-logo" class="inline-block">'.abbey_custom_logo( $logo_class ).'</div>';
		if ( $show_site_name )
			$html .= '<div id="'.$prefix_id.'site-name" class="inline-block">'.get_bloginfo('name'). '</div>';
		
		echo $html; 
		
	}

endif;

/**
 * Function to display bootstrap mobile menu 
 * in case you dont want to use boostrap's mobile icon, this function can be overriden in a child theme
 *@since: 0.1 
 *
 */
if( !function_exists( "abbey_nav_toggle" ) ) : 
	function abbey_nav_toggle () { ?>
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		    <span class="sr-only">Toggle navigation</span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		</button>	<?php
	}
endif;



/**
 * display the theme set secondary menu
 * this function rely on abbey_nav_menu - see functions/core.php 
 *@param:	array 		$args 		an array of settings of how the menu will be displayed 
 *@since: v0.1 
 */
function abbey_secondary_menu( $args = array() ){
	if( !has_nav_menu( "secondary" ) ) //if secondary menu is not registered or empty //
		return;  //bail early //
	
	$defaults = array(
	        		'menu'              => 'secondary',
	        		'theme_location'    => 'secondary',
	        		'depth'             => 1,
	        		'container'         => 'ul',
	        		'menu_class'   		=> 'nav nav-pills',
	            ); 

    $args = ( count( $args ) > 0 ) ? wp_parse_args( $args, $defaults ) : $defaults;
	
	abbey_nav_menu( apply_filters( "abbey_theme_secondary_menu_args", $args ) ); // this function is a wrapper function for wp_nav_menu
	
}

/**
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
								'walker' => new Abbey_Social_Nav_Walker() // custom walker object for social menu, this class can be found in libs/abbey_social_navwalker.php //
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
	if ( !is_array( $class ) )  //if the $class param is not an array, just show it //
		$class .= " entry-content"; 
	else 
		$class[] = "entry-content"; //if its an array, add this to the array //

	post_class( apply_filters( "abbey_post_classes", $class ) ); //use native wordpress function to show the class//
}

/*
* Function to generate author details e.g. name, description, bio etc
*
*/
function abbey_post_author( $key = "" ){
	global $authordata, $post; //wordpress global containing author data and post data //
	
	$values = array(); 
	$values["display_name"] = $authordata->display_name; // the author display name//
	$values["post_count"] = get_the_author_posts(); // the author post count //
	$values["description"] = $authordata->description;
	
	if ( !empty( $key ) && array_key_exists( $key, $values ) )
		return $values[$key];

	return $authordata;
	
}

/*
* function to display registered sidebars in template files
* this function checks if the passed sidebar is registered, if its not a normal message is dispalyed 
*
*
*/
function abbey_display_sidebar ( $sidebar_id ){
	if ( is_active_sidebar( $sidebar_id ) ) // check if a sidebar is registered with this id //
		dynamic_sidebar( $sidebar_id );
	else 
		echo __( "Sorry, there is no sidebar widget registered with {$sidebar_id}", "abbey" );
	
}

/*
* Function to generate and filter comment fields 
* this filter customize my comment fields with custom classes and attributes 
* @return : array - $args to be used when displaying the comment form in comment.php
*
*/
function abbey_comments_args(){
	$commenter = wp_get_current_commenter(); //get current commenter details 
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

/*
* wrapper function for wordpress list_comments 
* this function set the avatar size and the callback to be used 
*
*/
function abbey_list_comments( $args = array() ){
	wp_list_comments( array(
		'style'      => 'ol',
		'short_ping' => true,
		'avatar_size'=> 60,	
		'callback'	=> 'html5_comment'//this function can be found in libs/abbey_bootstrap_comments.php //		
		) 
	);
}

/*
* Function to retreive some details from wordpress query results 
* the retreive details e.g. author, post_found e.t.c are then stored in a custom variable 
* this can be used to group or sort posts according to authors or categories 
*
*
*/
function abbey_setup_query(){
	global $wp_query, $abbey_query; //wordpress wp_query containing query result and my custom variable to save some details from wp_query//
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

		$abbey_query = apply_filters( "abbey_theme_query", $abbey_query ); //filter to add additional details to abbey_query //
	}


}

/*
* Function to group posts based on post_types 
* the posts are passed by reference
* ( might need some tweaking )
*/
function abbey_group_posts( &$custom_posts ){
	$post_types = get_post_types( array( 'public' =>  true ), 'object' );//get all post types registered //
	$custom_posts = array();
	if( !empty( $post_types ) ){
		foreach( $post_types as $post_type ){ //loop through the registered post types //
			$custom_posts[ $post_type->name ][ "posts" ] = array();
			if( !empty( $post_type->labels ) )
				$custom_posts[$post_type->name]["labels"] = $post_type->labels;
		}
	}

}

/*
* This function must be called only after abbey_group_posts and must be called in the loop 
* this function add posts to grouped posts 
* the custom_posts param is passed by reference
* ( might need some rewriting )
*
*/
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

/*
* Function get gallery images from a gallery post format 
* Useful when gallery post format is enabled - it is enabled in this theme by default 
*
*
*/
function abbey_gallery_images(){
	global $post; 
	
	$galleries = get_post_galleries_images( $post ); // get the gallery images for this post //

	$slide_images = $galleries; // clone the images //
	/*
	* Based on how get_post_galleries_images retrun the gallery images we have to do a double loop 
	* first we check if the galleries is not empty, then because the galleries is a multi-dimensional array
	* We loop through each index i.e. galleries[0], then loop through the index to get the image 
	*
	*/
	if( count( $galleries ) > 0 )
		$slide_images = array();
		for( $i = 0; $i < count( $galleries ); $i++ ){
			if( is_array( $galleries[$i] ) && !empty( $galleries[$i] ) ){
				foreach( $galleries[$i] as $gallery ){
					$slide_images[] = $gallery;
				}
			}
		}
		$slide_images[ "galleries" ] = $galleries; // save the entire galleries again in our slide //

	return $slide_images; 
}

/*
* a wp filter to add icons or form or anything  to nav_menu
*
*/
function abbey_add_to_primary_menu ( $items, $args ) {
	if( 'primary' === $args->theme_location ) {
		$items .= '</ul>';
		$items .= sprintf( '<form class="navbar-form navbar-left" action="%1$s/" method="get">
		        				<div class="form-group relative">
		          					<input type="search" class="form-control" placeholder="Click on the search icon to search" name="s" />
		          					<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
		        				</div>
	        				</form>', 
      						esc_url( home_url() )
      					);
	}
	return $items;
}
add_filter( 'wp_nav_menu_items','abbey_add_to_primary_menu',10,2 );//wp filter to add to nav menus, found in header.php //

/*
* A wrapper function for wordpress WP_Query class 
* this function is used to query posts 
* @return: Wp query object 
*
*/
function abbey_get_posts( $args = array() ){
	$defaults = array(
		'posts_per_page'   => 5,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'no_found_rows'		=> true
	);
	$args = wp_parse_args( $args, $defaults ); //override passed args with my default values if present //

	$posts = new WP_Query( $args ); //call the WP_Query class //

	return $posts;
}

/*
* Function to wrap wordpress native pagainate_links function
* this function generate a nice Bootstrap pagination style and html 
*
*/
function abbey_posts_pagination( $args = array() ){
	$defaults = array( "type" => "array", "mid_size" => 1 ); 
	$args = wp_parse_args( $defaults, $args );
	$navigation = "";
	if( $GLOBALS['wp_query']->max_num_pages > 1 ){
		$links = paginate_links( $args ); 
		$navigation .= "<ul class='pagination'>";//start the pagination list//

		foreach( $links as $link ){
			$navigation .= "<li>".$link."</li>\n";
		}
		$navigation .= "</ul>\n";//close the pagination  list //
	}
	echo $navigation; 

}

/**
 * Wrapper function getting registered custom metabox fields 
 * this function checks if the metabox plugin is installed, then get the meta value else return empty 
 *@since: 0.1
 *@param: 	string 		$value 		the custom field value to look for 
 * 			bool 		$echo 		echo or return custom field value 
 *@return: 	string|array 	value of the custom field stored in wp meta table 
 */
function abbey_custom_field( $value, $echo = false ){
	if ( !function_exists( "get_field" ) )
		return; 
	if( !$echo  )
		return get_field( $value );
	echo get_field( $value );
}

function abbey_page_class(){
	$class = $archive_options ="";
	global $abbey_defaults;
	if( is_archive() ){
		$archive_options = $abbey_defaults[ "archive" ];
		if( empty( (bool) $archive_options[ "sidebar" ] ) )
			$class .= "no-sidebar";
	}
	echo esc_attr( $class );
}
