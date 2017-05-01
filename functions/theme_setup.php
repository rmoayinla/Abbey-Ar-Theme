<?php
/*
* Abbey theme defaults
* the functions and filters are default values for some of Abbey theme infos e.g. author name, 
* address, phone no, logo, author avatar e.t.c. 
*
*
*/

/*
* Main function containing the Abbey theme filter 
* this function provide some default values or an empty array 
* @return: array $defaults - Abbey theme default values 
*
*/
function abbey_theme_defaults(){
	$defaults = apply_filters( "abbey_theme_defaults", 
		array(
			"contacts" => array(
				"address" => __( "8, Kadiri street, Alausa, Ikeja, Lagos State, Nigeria", "abbey"),
				"tel" => array( "08028617830me" )
			),
			"social-contacts" => array(
				"facebook" => "facebook.com/rabiu.mustapha.5",
				"twitter" => "twitter.com/rabiu.mustapha",
				"instagram" => "instagram.com/rmoayinla",
				"pinterst" => "",
				"yahoo" => "",
				"tumblr"=> "",
				"whatsapp" => "+2348028617830"
			),
			"services" => array(), 
			"about" => __("I am Rabiu Mustapha, a blogger and developer from Lagos, Nigeria. This 
							blog is where I share my latest projects, code snippets and new hacks
							I have just learn in the ever evolving web developing field.",
						"abbey"
			),
			"admin" => array(
				"name" => "",
				"roles" => "",
				"pics"	=> ""
			), 
			"front-page" => array(
					"blog-posts" => array(
						"header-text" => __("آخر من بلدي بلوق", "abbey"),
						"body-text" => __("قراءة أحدث المقالات من بلدي تتجه بلوق وظائف", "abbey"),
						"posts_no" => 5
					), 
					"services" => array(
						"header-text" => __("خدماتي - ما أقوم به", "abbey"), 
						"body-text" => __("نحن مجموعة من الأفراد الملتزمين في تحسين مستوى ونوعية اللغة العربية في نيجيريا وغرب أفريقيا", "abbey"),
						"lists" => array()
							
					), 
					"quotes" =>  array(
						"header-text" => __("rmo quotes", "abbey"), 
						"body-text" => __("Straight out of my Quotes Book, Read my quote of the day. ", "abbey"), 
						"default" => __("This is only a default quote, this is not fetched from my quotes 
							post type or quotes post format", 
							"abbey"
						),
						"quotes_no" => 3
					),
					"contact" => array(
						"header-text" => __("اتصل بي", "abbey"),
						"body-text" => __("Hire me for your web projects, Want me to review your codes,
							Want to join my dev team, you have a feedback/review/comment on any of my
							projects?.", "abbey"),
						"form-header-text" => __("Kindly visit me, mail me or fill the contact form below.", "abbey")
					)

			), 
			"page" => array(
				"description" => __("This is a sample of a page description, 
							a simple small text saying something brief about the page", "abbey"),
				"icon" => ""
			), 
			"error-404-page" => array(
				"error-title" => __("404 Error", "abbey"),
				"error-message" => __("Oops, seems the page or post you are looking for have been moved or does
					not exist.", "abbey"), 
				"icon" => "fa fa-exclamation-triangle"
			), 
			"footer" => array(
				"contacts" => true, 
				"social-icons" => true, 
				"credits" => ""
			)
		)
	);

	return $defaults;
}

/*
* function to get only the front-page keys from global defaults 
* @return: array 
*
*
*/
function abbey_theme_front_page_defaults(){
	global $abbey_defaults; 
	return $abbey_defaults["front-page"];
}

/*
* function to get a particular key from global defaults 
* @return: array or string - depending on the key requested, if key is not found it returns an empty string 
*
*
*/
function abbey_get_defaults( $key ){
	global $abbey_defaults;

	return ( isset( $abbey_defaults[$key] ) ) ? $abbey_defaults[$key] : "";
}

/*
* A filter for Abbey defaults adding list of services to be displayed 
* @return: array - Abbey defaults 
*
*
*/
add_filter( "abbey_theme_defaults", "abbey_theme_add_services" );

function abbey_theme_add_services($defaults){
	$defaults["services"]["lists"] = array(
		array("icon" => "fa-registered", "header-text" => __("تنقيح و نقد", "abbey"), 
				"body-text" => __("نستعرض المواد، والأغاني، والمنشورات والمجلات للأفراد والمؤسسات", "abbey") 
		), 
		array("icon"=> "fa-globe", "header-text" => __("الأخبار والتحديثات", "abbey"),
				"body-text" => __("نعطي كسر وآخر الأخبار عن التحديثات والمعلومات حول الأحداث الرئيسية في نيجيريا وغرب أفريقيا والعالم كله", "abbey")
		),
		array("icon" => "fa-lock", "header-text" => __("المقالات و المنشورات", "abbey"), 
			"body-text" => __( "نكتب المنشورات في شكل مقالات ومحاضرات ومناقشات، والتاريخ، والأغاني وغيرها الكثير للمجلات أو المنتديات الإسلامية أو العربية.", "abbey" )
		)
	);
	return $defaults; // dont forget to return defaults in all filters //
}

/*
* A filter to add contacts i.e. email, phone no, address etc
* @return: array - Abbey defaults 
*
*
*/
add_filter( "abbey_theme_defaults", "abbey_theme_add_contacts", 30 );

function abbey_theme_add_contacts($defaults){
	$contacts = $defaults["contacts"]; // default contacts //
	
	$contacts["address"] = array(
		"office" => __("8, Kadiri street, Alausa, Ikeja, Lagos State, Nigeria", "abbey"),
		"branch" => __("19, Omobanta Street, Mile 12, Lagos State, Nigeria", "abbey")

	); 
	$contacts["tel"] = array(
		"office" => abbey_numerize( __("08028617830mew", "abbey") ), 
		"branch" => abbey_numerize( __("08184278864kola", "abbey") )
	);
	$contacts["email"] = array(
		"helpdesk" => __("enquiries@rmodiary.com", "abbey"),
		"services" => __("services@rmodiary.com", "abbey"),
		"customer-service" => __("customers_service@rmodairy.com", "abbey")
	);

	$defaults["contacts"] = wp_parse_args( $contacts, $defaults["contacts"] ); //overrirde default contacts with new ones  //
	
	return $defaults; // always return defaults for all filter
}

/*
* Filter for adding slide images, carousel, posts for the front page 
* this filter works only on the frontpage 
* @return: array - Abbey defaults 
*
*
*/
add_filter( "abbey_theme_defaults", "abbey_add_front_page_slides", 40 );

function abbey_add_front_page_slides( $defaults ){
	$front_page = $defaults["front-page"]; // default front-page key containing all front-page defaults //
	$news =  get_post_type_object("news");
	/*
	* Adding a key for slides to front-page defaults
	* this key is a multi-dimensional array with each array containing info for each slide 
	* a slide can show a picture or query for a particular post_type e.g. news 
	* contains a filter in case a user wants to add or remove some slides 
	*
	*/
	$front_page[ "slides" ] = apply_filters( "abbey_front_page_slides", array(
			array(
				"image" => get_template_directory_uri()."/img/banner-1.jpg"
			), 	
			array(
				"image" => get_template_directory_uri()."/img/banner-2.jpg", 
				"caption" => array(
					"title" => $news->labels->archives,
					"description" => $news->description,
					"url" =>  get_post_type_archive_link( "news" ),
					"query" => array(
						"post_type" => "news", "posts_per_page" => 2
					)
				)
			 ),
			array(
				"image" => get_template_directory_uri()."/img/banner-3.jpg"
			 )

		)
	);
	$defaults[ "front-page" ] = wp_parse_args ( $front_page, $defaults["front-page"] ); //override my default front-page with this one //
	
	return $defaults; // return the defaults as usual for all theme default filters //
}

/*
* A filter to add the administrator/owner info to Abbey theme 
* these infos can be owner's email, photo and contacts 
* @return: array - Abbey defaults 
*
*
*/
add_filter( "abbey_theme_defaults", "abbey_add_admin_info", 5 );

function abbey_add_admin_info( $defaults ){
	$admin = $defaults["admin"];  // get the default admin key //
	$args = array(
		"role" => "administrator", 
		"number" => 1
	);
	$admin_user = get_users( $args ); // run a wordpress user query for administrator, only return one user //

	if( !empty( $admin_user ) ){
		foreach( $admin_user as $user ){
			$admin["pics"] = get_avatar( $user->ID, "", "", "", array("class" => "img-circle" ) ); // get pics of the user //
			$admin["name"] = $user->display_name;
			$admin["info"] = $user;
			$admin["roles"] = array();
			$admin["url"] = get_author_posts_url( $user->ID );
		}
	}

	$defaults[ "admin" ] = wp_parse_args ( $admin, $defaults["admin"] ); //override admin defaults with user details //

	return $defaults; 
}