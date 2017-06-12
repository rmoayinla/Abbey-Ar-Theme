<?php 
function customizer_settings_init(){
	if( !class_exists( "Kirki" ) || !class_exists( "Abbey_theme_settings" ) )
		return; 
	
	
	Abbey_theme_settings::init(); 
	

	
	$customizer_config = array( 
		"option_type"	=>	"option", 
		"option_name"	=>	"abbey_theme" 
	); 

	$config_id = "abbey_theme";

	Kirki::add_config( $config_id, $customizer_config );

	Abbey_theme_settings::$option_key = $config_id; 

	$section = $panel = "";

	$section = "colors";
	Kirki::add_field( $config_id, array(
			"settings"	=>	"primary_color", 
			"type"		=>	"color",
			"label"		=>	esc_html__( "Select theme primary/main colour", "abbey" ),	
			"section"	=>	$section, 
			"default"	=>	Abbey_theme_settings::get_default_options( "gray_color", "colors"  ),
			"transport"	=>	"postMessage", 
			"js_vars"	=> array(
					array(
						"element"	=>	".primary, p, body",
						"function"	=>	"css", 
						"property"	=>  "color" 
					)
				)
		) 
	);
	
}

add_action( "init", "customizer_settings_init" );
