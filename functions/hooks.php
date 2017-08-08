<?php
/*
* Hooks i.e. filters and actions found in my theme 
* All hooks here are NOT WORDPRESS HOOKS but custom hooks only found in Abbey theme 
*
*/


/*
* 404 page action hook
* display latest posts in 404 page 
*
*/
add_action ( "abbey_theme_404_page_widgets", "abbey_latest_posts", 10);
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

/*
* 404 page action hook 
* display latest quotes in 404 page 
* 
*/
add_action ( "abbey_theme_404_page_widgets", "abbey_latest_quotes", 20 );
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

/*
* Header action hook 
* display the theme set primary menu 
*
*/
add_action( "abbey_theme_primary_menu", "abbey_primary_menu" ); // this action hook can be found in header.php
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
    	abbey_nav_menu ( $args ); //this function is a wrapper function for wp_nav_menu, can be found in functions/core.php //
    endif;
}


/*
* Footer action hook 
* display some menus in the footer 
* 
*/
add_action ( "abbey_theme_footer_credits", "abbey_footer_menu" );//found in footer.php //
function abbey_footer_menu(){
	$args = array(
		'menu'				=>	'footer', 
		'theme_location'	=>	'footer',
		'depth'             => 	1,
	    'container'         => 'ul',
	    'menu_class'   		=> 'list-inline list-left' //class for the wrapping ul //
	);
	abbey_nav_menu( $args ); //check functions/core.php //
}

/*
* Footer action hook 
* display theme details e.g. theme version, theme designer etc. 
*
*/
add_action ( "abbey_theme_footer_credits", "abbey_theme_details", 20 );//found in footer.php //
if( !function_exists( "abbey_theme_details" ) ) : 
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
	} //end function abbey_theme_details //

endif; //endif function_exist abbey_theme_details 

/* 
* display and generate html for showing next and previous posts 
* depends on abbey_show_nav function 
* this function displays both the previous and next at once 
*
*/
add_action( "abbey_theme_post_entry_footer", "abbey_post_nav", 5 );
if( !function_exists( "abbey_post_nav" ) ) :
	function abbey_post_nav( $title = "" ){
		$prev_post = get_previous_post(); // previous post//
		$next_post = get_next_post(); // next post //
		$html = "<div class='post-navigation entry-footer-info'>\n";//start of .post-navigation //
		if( !empty( $title ) )
			$html.= sprintf( '<h3 class="entry-footer-heading">%s</h3>', esc_html($title) );

		if ( !empty( $prev_post ) ) {
			$html .= "<div class='previous-post'>\n";
			$html .= abbey_show_nav( $prev_post, "previous" ); // check functions/template-tags.php //
			$html .= "</div>";//close of previous-post class div//
		}
		if ( !empty( $next_post ) ){
			$html .= "<div class='next-post text-right'>\n";
			$html .= abbey_show_nav( $next_post, "next" );
			$html .= "</div>"; // close of next-post div //
		}
		$html .= "</div>"; // close of post-navigation class div //
		echo $html;

	} //end function abbey_post_nav

endif; //endif function exists abbey_post_nav //

add_action( "abbey_theme_post_entry_footer", "abbey_post_terms", 5 );

/**
 * Display author bio after the post 
 * this function uses abbey_post_author and abbey_author_contacts
 *
 */
add_action( "abbey_theme_post_entry_footer", "abbey_post_author_info", 20 );
if ( !function_exists( "abbey_post_author_info" ) ) : 

	function abbey_post_author_info( $title = "" ){
		$author = abbey_post_author(); //check functions/template-tags.php //
		
		$html = "<div class='author-info entry-footer-info'>"; //start html .author-info //
		if( !empty( $title ) )
			$html.= sprintf( '<h3 class="entry-footer-heading">%s</h3>', esc_html($title) );
		
		$html .= "<div class='author-photo heading-icon'>".abbey_author_photo( $author->ID, 120, "img-circle" ). "</div>";
		$html .= "<div class='author-details heading-content'>";//start .author-details //
		$html .= sprintf( '<div class="author-title">
							<div class="author-name"><h4 class="no-top-margin no-bottom-margin"><a href="%4$s"> %1$s </a> </h4></div>
							<div class="author-rate"> <em> %2$s </em> <span class="author-post-count"> %3$s </span></div>
							</div>',
							$author->display_name, 
							__( "Published posts:", "abbey" ),
							get_the_author_posts(), 
							get_author_posts_url( $author->ID )
						);

		$html .= sprintf( '<div class="author-description"><p>%s</p></div>', esc_html( $author->description ) );
		
		/* display author social contacts */
		$author_contacts = abbey_author_contacts( $author ); //check functions/template-tags.php //
		if( !empty( $author_contacts )  ){
			$html .= "<footer class='social-contacts col-md-5 h4 text-center'>";
			$html .= "<ul class='list-inline'>"; 
			foreach( $author_contacts as $social => $contact ){ //start loop //
				$html .= sprintf( '<li><a href="%1$s" title="%2$s" class="icon"><span class="fa fa-%3$s"></span></a></li>', 
									esc_url( $contact ), 
									__( "Visit author's facebook", "abbey" ), 
									esc_attr( $social )
							);
			}//end foreach //
			$html .= "</footer>";
		}//end if $author_contacts //
				
		$html .= "</div>"; //.author-details //
		$html .= "</div>\n"; //.author-info //

		echo $html; 

	}//end function abbey_post_author_info//

endif; //endif function_exists abbey_post_author_info //

/*
* function to show related posts in a slide i.e carousel 
* this function queries related posts excluding the current post
* depends on abbey_query_post, abbey_excerpt, abbey_page_media  
*
*/
add_action( "abbey_theme_post_entry_footer", "abbey_show_related_posts", 30 );
if ( !function_exists( "abbey_show_related_posts" ) ) :
	function abbey_show_related_posts( $title = "" ){
		$args =  array(
			'post_type' => get_post_type(), 
			'posts_per_page' => 3, 
			'post__not_in' => array( get_the_ID() ) //exclude the current post id from query //
		);
		$related_posts = abbey_get_posts( $args ); // check functions/core.php //
		if( $related_posts->have_posts() ) : ob_start(); ?>
			<div class="related-posts entry-footer-info">	
				<?php
				if( !empty( $title ) ){
					echo sprintf( '<h3 class="entry-footer-heading">%s</h3>', esc_html( $title ) );
				} 
				?>
				<!--start putting the post in a slide-->
				<div class="posts-slides" data-slick='{"rtl": true, "slidesToShow" : 1, "centerMode" : true, "centerPadding" : "40px", "arrows" : true, "autoplay" : false }'>
					<?php while( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
						<!-- start of each post panel -->
						<aside class="post-panel">
							<figure class="post-panel-thumbnail"><?php abbey_page_media(); ?></figure>
							<div class="post-panel-body">
								<h4 class="post-panel-heading">
									<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e( "Read full post", "abbey" ); ?>" >
										<?php the_title(); ?>
									</a>
								</h4>
								<div class="post-panel-excerpt text-justify"><?php abbey_excerpt( 25, "", true ); ?> </div>
							</div>
						</aside>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		<?php endif; //end if have_posts() //
			
		echo ob_get_clean();

	}//end function abbey_show_related_posts //

endif; //endif function exists abbey_show_related_posts //

/*
* Search page action hook 
* function to show search summaries i.e. searched keyword, returned result etc
* @param: array - $abbey, this array contains the summaries of search query 
*/
add_action( "abbey_archive_page_summary", "abbey_search_summary" ); //found in search.php 
function abbey_search_summary( $abbey ){
	$summaries = ( isset( $abbey["summary"] ) ) ? $abbey["summary"] : array();
	$html = $keyword = "";
	if( count( $summaries ) > 0 ){
		$html .= "<ul class='list-group'>"; //start html .list-group //
		foreach( $summaries as $title => $summary ){
			$html .= "<li class='list-group-item $title relative'>";//list item //
			if( !empty( $summary["title"] ) )
				$html .= sprintf( '<p class="list-group-item-text">%s</p>', esc_html( $summary["title"] ) );
			if( !empty( $summary["key"] ) )
				$keyword = ( $title === "keyword" ) ? "<span class='search-keyword'>" : "<span>";
				$html .= sprintf( '<h4 class="list-group-item-heading">%1$s %2$s </span></h4>', 
								$keyword, 
								$summary["key"] 
							);
			$html .= "</li>";//end of list item //
		}
		$html .= "</ul>";//end of item .list-group //
	} //end of if summaries //
	echo $html;
}

/*
* Archive page action hook 
* function to display heading and description for archive pages e.g category name and description 
* @param: WP_Object - this can instance of a wordpress user, post_type or term object depending on the queried object
*/
add_action( "abbey_archive_page_heading", "abbey_archive_heading" ); //found in archive.php, category.php, author.php //
if( !function_exists( "abbey_archive_heading" ) ) : 
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
	}//end function abbey_archive_heading 
	
endif; //endif function exist abbey_archive_heading //

/**
 * Template function filter for thumbnail - abbey_page_media function 
 * function to show uploaded video as thumbnail for recordings 
 *
 */
add_filter( "abbey_theme_page_media", "abbey_video_thumbnail", 20, 2 );//abbey_page_media function, check functions/template-tags.php 
function abbey_video_thumbnail( $thumbnail, $page_id ){

	// check if there is a thumbnail already for the post //
	if( !empty( $thumbnail ) )
		return $thumbnail; //bail early //

	if( get_post_type( $page_id ) === "recordings" )
		$thumbnail = abbey_recording_video( false, $page_id ); //@see functions/template-tags.php //
	
	return $thumbnail;
}

/**
 * Template filter for thumbnail - abbey_page_media function 
 * function to show first category thumbnail image if post thumbanial is not found 
 * @edited: added an 'alt' attribute for the thumbnail
 */
add_filter( "abbey_theme_page_media", "abbey_category_thumbnail", 10, 2 );//abbey_page_media function, check functions/template-tags.php 
function abbey_category_thumbnail( $thumbnail, $page_id ){
	
	//bail early if there isnt a thumbnail for the post already //
	if( !empty( $thumbnail ) )
		return $thumbnail;

	if( $categories = get_the_category( $page_id ) ){
		$cat_thumbnail = get_term_meta( $categories[0]->term_id, "thumbnail", true ); 
		if( !empty( $cat_thumbnail ) )
			$thumbnail = sprintf('<img class="wp-post-image" src="%1$s" alt="%2$s"/>', esc_url( $cat_thumbnail ), esc_attr( $categories[0]->term_name ) ); 
	}
	return $thumbnail;
	
}

/**
 * An action hook that fires before showing the main post content
 * Show the post tags of the current post 
 * @edited: bail early if there is no tag 
 */
add_action( "abbey_theme_before_post_content", "abbey_post_tags", 90 );//found in single.php // 
function abbey_post_tags(){
	
	if( !empty ( get_the_tags() ) ) return ; //bail early if there is no tag with this post //

	$html = "<div class='post-tags'>";//start .post-tags //
	
	$html .= abbey_cats_or_tags( "tags", __( "Tagged in:", "abbey" ), "fa-tags" );//check functions/template-tags.php//

	$html .= "</div>";//end .post-tags //

	echo $html;
}

/**
 * Gallery Post format action hook
 * this function displays gallery images uploaded for the current post in a slick carousel 
 * uses wordpress native get_post_gallery function to get the embed galleries 
 * @return: string 		$html 		a nicely formated HTML gallery list 
 * @since: 0.1
 */
add_action( "abbey_theme_after_page_header", "abbey_post_gallery_slides" );//found in templates/content-gallery.php //
function abbey_post_gallery_slides(){
	$gallery = get_post_gallery( get_the_ID(), false ); //get the embed galleries, note these are not the images //
	
	if( !has_post_format() || empty( $gallery ) )
		return; //if there is no galleries and no post format bail //
	
	$gallery_id = explode( ",", $gallery["ids"] ); //extract the gallery ids into an array //

	$html = "<ul class='list-inline'>";// start of html list //

	foreach( $gallery["src"] as $key => $src ){
		$html .= sprintf( '<li><a href="%1$s" data-full-image="%3$s"><img src="%2$s"></a></li>', 
							get_attachment_link( (int) $gallery_id[$key] ),
							esc_url( $src ), 
							wp_get_attachment_image_url( $gallery_id[$key], "full" )
						);
	}
	$html .= "</ul>";//end of list //

	echo $html;

	print_r($gallery);

}

/**
 * Quote post format action hook 
 * Display a link to quote post type archive 
 */
add_action( "abbey_theme_quote_post_footer", "abbey_show_quote_archive", 10 ); //check templates/content-quote.php //
function abbey_show_quote_archive(){
	$html = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', 
						get_post_format_link( "quote" ), //quote post format archive //
						__( "Read all my quotes", "abbey" ), 
						__( "RMO Book of Quotes", "abbey" ) 
					);
	echo "<li>$html</li>";
}

/*
* Gallery post format sidebar action hook 
* this function behaves like a typical wordpress widget, hook to the sidebar and display some info
* this sidebar widget shows the title of the gallery 
*/
add_action( "abbey_gallery_post_sidebar", "abbey_gallery_title", 10 ); //found in templates/content-gallery.php //
function abbey_gallery_title( $galleries ){
	$html = sprintf( '<div class="widgets gallery-widgets gallery-title-widget">
						<h4 class="widget-title">%1$s </h4>
						<span class="widget-icon"><i class="fa fa-camera"></i></span>
						<p class="widget-text">%2$s<p>
						</div>',
						__( "Album title:", "abbey" ),
						get_the_title() 
					);
	echo $html;
}

/*
* Gallery post format sidebar action hook 
* this function behaves like a typical wordpress widget, hook to the sidebar and display some info
* this sidebar widget shows the number of galleries in the post and the total number of gallery images
* @param: array $galleries - contains the imagies and gallery id of the current post 
*/
add_action( "abbey_gallery_post_sidebar", "abbey_gallery_count", 20 ); //found in templates/content-gallery.php //
function abbey_gallery_count( $galleries ){
	$image_count = ( !empty( $galleries ) ) ? (int) count( $galleries ) : 0; //total number of images in galleries //
	$gallery_count = ( !empty( $galleries["galleries"] ) ) ? (int) count( $galleries[ "galleries" ] ) : 0; //number of galleries in post //
	$html = sprintf( '<div class="widgets gallery-widgets gallery-count-widget">
						<h4 class="widget-title">%s </h4>', 
						__( "Album photo count", "abbey" )
					);
	if ( $image_count > 0 )
		$html .= sprintf( '<div class="widget-content">
							<span class="widget-icon"><i class="fa fa-file-image-o"></i></span>
							<p class="widget-text">%1$s</p>
							</div>',
							sprintf( __( "There are <strong>%s</strong> pictures in this album", "abbey" ), 
									$image_count ) 
						);
	if ( $gallery_count > 0 )
		$html .= sprintf( '<div class="widget-content">
							<span class="widget-icon"><i class="fa fa-picture-o"></i></span>
							<p class="widget-text">%1$s</p>
							</div>',
							sprintf( __( "There are <strong>%s</strong> gallery in this album", "abbey" ), 
									$gallery_count ) 
						);
	$html .= "</div>";//end of .widgets //

	echo $html;

}

/*
* Gallery post format sidebar action hook 
* this function behaves like a typical wordpress widget, hook to the sidebar and display some info
* this sidebar widget shows the gallery uploaded date 
*/

add_action( "abbey_gallery_post_sidebar", "abbey_gallery_date", 30 ); //found in templates/content-gallery.php //
function abbey_gallery_date( $galleries ){
	$html = sprintf( '<div class="widgets gallery-widgets gallery-date-widget">
						<h4 class="widget-title">%s</h4>',
						__( "Album uploaded date", "abbey" ) 
					);
	$html .= '<div class="widget-content">'; //start .widget-content //
	$html .= '<span class="widget-icon"><i class="fa fa-calendar-o"></i></span>';
	$html .= sprintf( '<time datetime="%3$s" class="widget-text"><span class="sr-only">%2$s</span><span>%1$s </span></time>',
						get_the_time( get_option( 'date_format' ).' \@ '.get_option( 'time_format' ) ), 
						__( "Posted on:", "abbey" ), 
						get_the_time('Y-md-d')
					); 
	$html  .= "</div>\n"; //close .widget-content //
	$html .= "</div>"; //close .widgets //

	echo $html;
}

add_action( "abbey_gallery_post_sidebar", "abbey_gallery_author", 40 ); 
function abbey_gallery_author( $galleries ){
	$html = sprintf( '<div class="widgets gallery-widgets gallery-author-widget">
						<h4 class="widget-title">%s</h4>',
						__( "Album uploaded by", "abbey" ) 
					);
	$author = abbey_post_author();
	$html .= sprintf( '<div class="widget-content">%s</div>', 
						abbey_show_author( false )
				);
	$html .= "</div>\n";

	echo $html;
	
}


add_action( "abbey_gallery_post_sidebar", "abbey_gallery_pictures", 90 ); //check templates/content-gallery.php //
function abbey_gallery_pictures( $galleries ){
	$image_count = ( !empty( $galleries ) ) ? (int) count( $galleries ) : 0;
	$gallery_count = ( !empty( $galleries["galleries"] ) ) ? (int) count( $galleries[ "galleries" ] ) : 0;
	
	$html = sprintf( '<div class="widgets gallery-widgets gallery-pictures-widget">
						<h4 class="widget-title">%s</h4>',
						__( "Album photos:", "abbey" )
					);
	/*
	* displaying all the uploaded gallery images in a carousel 
	* there are some configurations to make the carousel work 
	* image_per_slide: number of images i.e pictures to show in carousel slide e.g. 4
	* image_in_slide: the position of the current image in the carousel, this is to determine how to divide the image per slide 
	* slide_no: the slide number just like page no, this is to determine the slide we are viewing e.g. first, second etc.
	* image_number: the position of the current image in the actual gallery, this is not used for pagination
	*/
	if( $image_count > 0 ){
		$images_per_slide = 6; //default no of images in slide //
		$image_in_slide = 0; //current image position in the slide//
		$image_number = 0; 
		$slide_no = 0;
		$html .= "<div class='photo-carousel'>";
		foreach ( $galleries as $no => $image ){
			if( !is_int( $no ) )
				continue;
			$image_in_slide = ( $no === 0 ) ?  1 : $image_in_slide; //slide image number should be 1 for the first image //
			$image_number = ( $no + 1 ); //gallery image number should be the index key + 1, index 0 is number one //
			$slide_no = 1; //the default slide no should be 1 //

			/*
			* note we are checking for image_number not image_in_slide
			* because image_in_slide will default to 1 once it is greater than the image per slide 
			* so for the first slide, we check the image number and create the wrapper if its the actual first image in the gallery 
			*/
			if( $image_number === 1  ){
				$html .= "<div class='widget-content slide-$slide_no'>";//start of html slide //
			}
			/*
			* if the image in slide is greater than image per slide, we will have to paginate here so that the other
			* images can go to the next slide, then we default our image in slide to 0, to start the count afresh and 
			* increment the slide number to show we have move to another slide 
			*/
			elseif( $image_in_slide > $images_per_slide ){
				$slide_no += 1;
				$html .= "</div>"; //close the previous .widget-content //
				$html .= "<div class='widget-content slide-$slide_no'>";//start of html for another slide //
				$image_in_slide = 0;
			}

			// this part is basic and doesnt change regardless of the slide or image number // 
			$html .= sprintf( '<a href= "" title=""><img src="%1$s" class="image-%2$s" /></a>', 
								esc_url( $image ), 
								esc_attr( $image_number ) 
							); 
			//if the total images i.e. image_count is equal to the current index, wrap up the slides //
			if( $image_count === $no )
				$html .= "</div>";//close .widget-content //
			
			$image_in_slide += 1; //increment the current image position number and continue the loop //
		}//end of loop //

	}//end if image_count //

	$html .= "</div> \n"; // close of .photo-carousel //
	$html .=  "</div>"; //close of .widgets //
	echo $html;
}


add_action( "abbey_gallery_image_slides", "abbey_gallery_slides" );//check templates/content-gallery.php //
function abbey_gallery_slides( $galleries ){
	$slide_images = $galleries;
	$html = "";

	if( !empty( $slide_images ) )
		$html = "<div class='gallery-slides'>"; 
		foreach( $slide_images as $key => $image ){
			if( !is_int( $key ) )
				continue;
			$html .= sprintf( '<div class="gallery-image" id="gallery-image-%1$s">
								<img src="%2$s" alt="%3$s" />
								</div>',
								esc_attr( $key ), 
								esc_url( $image ), 
								sprintf( __( "Gallery Picture %s", "abbey" ), esc_attr( $key ) )
							);
		}
		$html .= "</div>";

	echo $html;

	//print_r($slide_images);//
}
