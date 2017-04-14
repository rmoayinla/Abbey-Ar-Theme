<?php
/*
	* the functions here are added to actions or filters 
	* Check each function to know the exact action or filter attached to 
	* @theme: Abbey
	* @package: wordpress
	* @version: 0.1 
*/



function abbey_header_address( $contact ){

	echo '
		<div class="header-contacts" id="header-address">
			<div class="row">
				<div class="col-md-1 col-sm-1 col-xs-1 lead"> <i class="fa fa-map-marker"></i> </div>
				<div class="col-md-10 col-sm-10 col-xs-10">
					<p class="no-bottom-margin strong"> Visit me: </p>
					<p>'.esc_html(abbey_get_contact( "address", "office" ) ).'</p>
				</div>
				
				
			</div>
		</div>
	';
}
add_action( "abbey_theme_footer_contacts", "abbey_header_address" );//hook to header_contact; check header.php //

function abbey_header_telephone( $contact ){
	echo '
		<div class="header-contacts" id="header-telephone">
			<div class="row">
				<div class="col-md-1 col-sm-1 col-xs-1 lead"> <i class="fa fa-clock-o"> </i> </div>
				<div class="col-md-10 col-sm-10 col-xs-10">
					<p class="no-bottom-margin strong"> Call me: </p>
					<p>'.esc_html( implode( abbey_get_contact( "tel" ), "," ) ).'</p>
				</div>
			</div>
		</div>
	';
}
add_action( "abbey_theme_footer_contacts", "abbey_header_telephone", 20 );

function abbey_header_social_icons($contact){
	echo '<div class="header-contacts" id="header-social-icons">';
	abbey_social_menu();
	echo '</div>';
}
//add_action( "abbey_theme_footer_widgets", "abbey_header_social_icons", 30 );

function abbey_slide_default_caption () {
	global $abbey_defaults;
	$defaults = $abbey_defaults;
	ob_start(); ?>
		<div class="col-md-6 col-sm-8 col-xs-12 text-right" id="site-details">
			<div class="page-header no-bottom-margin"><h1><?php bloginfo('name'); ?> </h1></div>
			<div class="description"><p><?php bloginfo('description');?></p></div>
			<div class="" id="about-site"><?php echo esc_html($defaults["about"]); ?></div>
			
		</div><!--#site-details closes-->
		<div class="col-md-4 col-md-offset-1 text-center col-sm-3 col-xs-12" id="admin-profile">
			<?php ?>
			<div class="no-border">
				<div class="col-xs-4 col-md-12 col-sm-12" id="admin-picture">
					<?php echo $defaults['admin']['pics']; ?>
				</div>
				<div class="col-xs-8 col-md-12 col-sm-12" id="admin-info">
					<h3> <?php echo esc_html($defaults['admin']['name']); ?></h3>
					<em class="small italize"> <?php echo implode( $defaults['admin']['roles'], " , " );  ?> </em>
					<a href="<?php echo esc_url( $defaults["admin"]["url"] ); ?>" class="btn btn-block btn-primary">
						Visit Author page </a>
				</div>

			</div>
		</div><!--#admin-info closes --> 
	<?php return ob_get_clean(); 
}

function abbey_slide_caption( $caption ){
	$html = "";
	ob_start(); ?>
	<div class="col-md-4 col-sm-8 col-xs-12 text-right">
		<?php if( !empty( $caption["title"] ) ) ?>
			<div class="page-header no-bottom-margin"><h1><?php esc_html_e( $caption["title"] ); ?> </h1></div>
		<?php if( !empty( $caption["description"] ) ) ?>	
			<div class="description"><p><?php esc_html_e( $caption["description"] ); ?></p></div>	
		<?php if( !empty( $caption["url"] ) ) ?>	
			<a href="<?php echo esc_url( $caption["url"] ); ?>" class="btn btn-block btn-default">Read all </a>		
	</div><!--#site-details closes-->

	<?php if( !empty( $caption["query"] ) ) : 
			$posts_query = abbey_get_posts( $caption["query"] ); 
			if( $posts_query->have_posts() ) : ?>
				<div class="col-md-5 col-md-offset-1 col-sm-3 col-xs-12 posts-slides text-left">
				<?php while( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
						<div class="post-slide">
							<?php echo sprintf( '<h4 class="slide-title"><a href="%1$s">%2$s</a></h4>', get_permalink(), get_the_title() );
							if( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
							<summary class='slide-excerpt'> <?php the_excerpt(); ?></summary>
							
						</div>

				<?php endwhile; ?>
				</div>
			<?php wp_reset_postdata(); endif; ?>
	<?php endif; ?>	
	
		<?php return ob_get_clean(); 
}

function abbey_front_page_slides(){
	global $abbey_defaults;
	$slides = ( isset( $abbey_defaults["front-page"]["slides"] ) ) ? $abbey_defaults["front-page"]["slides"] : "";
	if ( count( $slides ) > 0 ){
		$html = '<div id="carousel" class="carousel slide" data-ride="carousel" data-interval="10000">';
		$html .= '<div class="carousel-inner" role="listbox">';
		$indicators = "";
		foreach ( $slides as $no => $slide ){
			$active = ( $no === 0 ) ? "active" : "";
			$default_caption = abbey_slide_default_caption();
			

			$indicators .= '<li data-target="#carousel" data-slide-to="'.esc_attr($no).'" class="'.$active.'"> </li>';
			$html .= '<div class="item '.$active.'">';
			
				if( !empty( $slide["image"] ) )
					$html .= '<img src="'.esc_url( $slide["image"] ).'" alt="'.basename( $slide["image"], "jpg" ).'" 
						class="carousel-image">';
	      		
	      		$html .= '<div class="carousel-caption">';

	      			if( $no === 0 )
	      				$html .= $default_caption;
	      			elseif ( !empty( $slide["caption"] ) )
	      				$html .= abbey_slide_caption( $slide["caption"] );

      			
      			$html .= "</div>\n"; //.carousel-caption div closes //
      		
      		
      		$html .= "</div>\n"; // .item div closes //
		} //end foreach //

		$html .= '<ol class="carousel-indicators">';
		$html .= $indicators;
 		$html .= '</ol>';
		$html .= "</div>\n";//.carousel-inner closes //
		$html .= '<a class="left carousel-control" href="#carousel" role="button" data-slide="prev" title="previous slide">
    				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    				<span class="sr-only">Previous</span>
  				</a>';
  		$html .= '<a class="right carousel-control" href="#carousel" role="button" data-slide="next" title="next slide">
    				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    				<span class="sr-only">Next</span>
  					</a>';
  		$html .= "</div>\n"; //.carousel slide closes //
	}
	echo $html;
}
add_action ( "abbey_theme_front_page_banner", "abbey_front_page_slides" );


function abbey_service_lists(){
	global $abbey_defaults;
	$services = $abbey_defaults["services"]["extras"];
	
	if(count($services) > 0 ){
		$html = "";
		foreach($services as $service){
			$html .= "<div class='col-md-3 col-xs-4 col-sm-4 more-service-icons'><div class='service-wrapper row'>";	
			if( !empty($service["icon"]) ){ 
				$html .= "<div class='more-service-icon col-md-3'>
							<span class='fa ".esc_attr($service["icon"])." fa-3x' > 
							</span> </div> ";
			 }
			
			if( !empty($service["text"]) ){ 
				$html .= "<div class='more-service-heading col-md-9 text-left'>"
						. esc_html( $service["text"] ). 
						"</div>" ; 
			}
			$html .= "</div></div>";
		}
	
	}

	echo $html;
	
}
add_action( "abbey_theme_more_services", "abbey_service_lists" );

function abbey_theme_contact_form(){
	ob_start(); ?>
		<form role="form" id="contact-form" method="post">
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			</div>
			<div class="form-group">
				<label for="exampleInputFile">File input</label>
				<input type="file" id="exampleInputFile">
				<p class="help-block">Example block-level help text here.</p>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox"> Check me out
				 </label>
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
				
		</form> <?php
	echo ob_get_clean(); 

}
add_action("abbey_theme_front_page_contact_form", "abbey_theme_contact_form");

function abbey_show_contacts(){
	global $abbey_defaults;
	$contacts = ( !empty( $abbey_defaults["contacts"] ) ) ? $abbey_defaults["contacts"] : "";
	
	if( count($contacts) > 0 ){
		$html = "<aside class='row inner-pad-medium'>";
		foreach( $contacts as $heading => $contact ){
			$html .= "<div class='row contact-wrapper' id='contact-".esc_attr($heading)."'>";
			$html .= "<div class='contact-icon lead'> <span class='fa ".abbey_contact_icon($heading)."'> </span> </div>";
			$html .= "<div class='col-md-11'><div class='row'>";
			$html .= abbey_display_contact( $contact, $heading );
			$html .= "</div></div>"; 
			$html .= "</div>";
			
		}
		
		$html .= "</aside>";
	}

	echo $html;
	
	
}
add_action( "abbey_theme_front_page_contacts", "abbey_show_contacts" );

function abbey_show_social_contacts(){
	global $abbey_defaults;
	$social_contacts = ( !empty( $abbey_defaults["social-contacts"] ) ) ? $abbey_defaults["social-contacts"] : "";

	if( count( $social_contacts ) > 0 ){
		$html = "<footer id='social-contacts' class='row inner-pad-medium'>";
		$html .= "<div id='social-icons-header'><h4>".apply_filters( "abbey_theme_social_icons_header_text", "Follow me on social media" )."</h4></div>";
		$html .= "<div class='social-icons' id='social-contacts'><ul class='nav'>";
		foreach ( $social_contacts as $social => $contact ){
			if( empty($contact) ) continue;
			$html .= "<li class='inline'><a href='".esc_url($contact)."' class='' target='_blank' >";
			$html .= "<span class='fa fa-fw fa-2x ". abbey_contact_icon($social)."'> </span>"; 
			$html .= "</a></li>";
		}

		$html .= "</ul></div>";
		$html .= "</footer>";
	}
	echo $html;
}
add_action ( "abbey_theme_front_page_contacts", "abbey_show_social_contacts", 20 );

