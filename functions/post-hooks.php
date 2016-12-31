<?php
add_action( "abbey_theme_before_post_content", "abbey_post_tags", 90 ); 
function abbey_post_tags(){
	if( has_post_format() )
		return;
	
	$html = "<div class='post-tags'>";
	if( !empty ( get_the_tags() ) ){
		$html .= abbey_cats_or_tags( "tags", __( "Tagged in:", "abbey" ), "fa-tags" );
	}

	$html .= "</div>";

	echo $html;
}

//add_action( "abbey_theme_after_page_header", "abbey_post_gallery_slides" );//
function abbey_post_gallery_slides(){
	$gallery = get_post_gallery( get_the_ID(), false ); 
	

	if( has_post_format() || empty( $gallery ) )
		return;
	
	$gallery_id = explode( ",", $gallery["ids"] );

	$html = "<ul class='list-inline'>";
	$gallery = get_post_gallery( get_the_ID(), false ); 
	foreach( $gallery["src"] as $key => $src ){
		$html .= sprintf( '<li><a href="%1$s" data-full-image="%3$s"><img src="%2$s"></a></li>', 
							get_attachment_link( (int) $gallery_id[$key] ),
							esc_url( $src ), 
							wp_get_attachment_image_url( $gallery_id[$key], "full" )
						);
	}
	$html .= "</ul>";

	echo $html;

	print_r($gallery);

}

/*
Quote post
*/
add_action( "abbey_theme_quote_post_footer", "abbey_show_quote_archive", 10 ); 
function abbey_show_quote_archive(){
	$html = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', 
						get_post_format_link( "quote" ), 
						__( "Read all my quotes", "abbey" ), 
						__( "RMO Book of Quotes", "abbey" ) 
					);
	echo "<li>$html</li>";
}

/*
* Gallery post 
*/
add_action( "abbey_gallery_post_sidebar", "abbey_gallery_title", 10 ); 
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

add_action( "abbey_gallery_post_sidebar", "abbey_gallery_count", 20 ); 
function abbey_gallery_count( $galleries ){
	$image_count = ( !empty( $galleries ) ) ? (int) count( $galleries ) : 0;
	$gallery_count = ( !empty( $galleries["galleries"] ) ) ? (int) count( $galleries[ "galleries" ] ) : 0;
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
	$html .= "</div>";

	echo $html;

}

add_action( "abbey_gallery_post_sidebar", "abbey_gallery_date", 30 ); 
function abbey_gallery_date( $galleries ){
	$html = sprintf( '<div class="widgets gallery-widgets gallery-date-widget">
						<h4 class="widget-title">%s</h4>',
						__( "Album uploaded date", "abbey" ) 
					);
	$html .= '<div class="widget-content">
				<span class="widget-icon"><i class="fa fa-calendar-o"></i></span>';
	$html .= sprintf( '<time datetime="%3$s" class="widget-text"><span class="sr-only">%2$s</span><span>%1$s </span></time>',
						get_the_time( get_option( 'date_format' ).' \@ '.get_option( 'time_format' ) ), 
						__( "Posted on:", "abbey" ), 
						get_the_time('Y-md-d')
					); 
	$html  .= "</div>\n </div>"; 

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


add_action( "abbey_gallery_post_sidebar", "abbey_gallery_pictures", 90 ); 
function abbey_gallery_pictures( $galleries ){
	$image_count = ( !empty( $galleries ) ) ? (int) count( $galleries ) : 0;
	$gallery_count = ( !empty( $galleries["galleries"] ) ) ? (int) count( $galleries[ "galleries" ] ) : 0;
	
	$html = sprintf( '<div class="widgets gallery-widgets gallery-pictures-widget">
						<h4 class="widget-title">%s</h4>',
						__( "Album photos:", "abbey" )
					);
	if( $image_count > 0 )
		$images_per_slide = 6;
		$image_in_slide = 0;
		$image_number = 0;
		$slide_no = 0;
		$html .= "<div class='photo-carousel'>";
		foreach ( $galleries as $no => $image ){
			if( !is_int( $no ) )
				continue;
			$image_in_slide = ( $no === 0 ) ?  1 : $image_in_slide;
			$image_number = ( $no + 1 );
			$slide_no = 1;
			if( $image_number === 1  ){
				$html .= "<div class='widget-content slide-$slide_no'>";
			}
			elseif( $image_in_slide > $images_per_slide ){
				$slide_no += 1;
				$html .= "</div><div class='widget-content slide-$slide_no'>";
				$image_in_slide = 0;
			}
			$html .= sprintf( '<a href= "" title=""><img src="%1$s" class="image-%2$s" /></a>', 
				esc_url( $image ), 
				esc_attr( $image_number ) 
				); 
			if( $image_count === $no )
				$html .= "</div>";
			$image_in_slide += 1;
		}
	$html .= "</div> \n </div>";
	echo $html;
}


add_action( "abbey_gallery_image_slides", "abbey_gallery_slides" );
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


function abbey_recording_video(){
	$content = get_the_content();
	$embeds = get_media_embedded_in_content( $content );

	echo $embeds[0];
}