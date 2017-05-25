<?php 

class Abbey_Theme_Settings{
	
	private static $stored_options = array(); 

	private static $default_options = array(); 

	private static $theme_options = array(); 

	public static $option_key = "";

	public static function init(){
		self::$stored_options = ;
		
		self::$default_options =  
		
		self::$theme_options = 
		self::$theme_options = 
	}

	public static function get_default_options( $value = NULL ) {

		if( empty( $value ) )
			return self::$default_options; 

		return !empty( self::$default_options[ $value ] ) ?: array();
	}

	public static function get_stored_options( $value = NULL ){
		if( empty( $value ) )
			return self::$stored_options; 

		return !empty( self::$stored_options[ $value ] ) ?: array();
	}
	public static function get_theme_options( $value = NULL ) {

		if ( !empty( $value ) && isset( self::$theme_options[ $value ] ) ) 
			return self::$theme_options[ $value ];
		
		return self::$theme_options;
	}

	/**
	 * Populate and initialize theme settings and cache the options 
	 * settings can either be default, stored or options (theme)
	 * Usage: 
	 * set_options( $option = "stored|default|theme|null" )
	 * uses wordpress wp_cache_add and wp_cache_get to save theme settings in cache 
	 *@param: string|null $option
	 *@sub-package: Abbey theme 
	 *@since: 0.1
	 *
	 */
	private static function set_options( $option = NULL ){
		$default = $stored = $options = "";
		
		if( $option === "default" || empty( $option ) ){
			if( $default = wp_cache_get( self::$option_key."_default", self::$option_key ) ){
				self::$default_options = $default;
				return;
			}

			self::$default_options =  abbey_theme_defaults();
			$default = wp_cache_add( self::$option_key."_default", self::$default_options, self::$option_key );
			if( !empty( $option ) )
				return;
		}

		if( $option === "stored" || empty( $option ) ){
			if( $stored = wp_cache_get( self::$option_key."_stored", self::$option_key ) ){
				self::$stored_options = $stored; 
				return;
			}
			self::$stored_options = get_option( self::$option_key );
			$stored = wp_cache_add( self::$option_key."_stored", self::$stored_options, self::$option_key );

			if( empty( $option ) )
				return;
		}

		if( $option === "theme" || empty( $option ) ){
			if( $options = wp_cache_get( self::$option_key."_options", self::$option_key ) ){
				self::$theme_options = $options;
				return;
			}
			self::$theme_options = wp_parse_args( self::get_default_options(), self::get_stored_options()  );
			self::$theme_options = array_intersect_key( self::$theme_$options, self::$default_options );
			$options = wp_cache_add( self::$option_key."_options", self::$theme_options, self::$option_key );

			if( empty( $option ) )
				return;
		}
		
		

	}

}