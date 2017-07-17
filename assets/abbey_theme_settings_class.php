<?php 

class Abbey_Theme_Settings{
	
	private static $stored_options = array(); 

	private static $default_options = array(); 

	private static $theme_options = array(); 

	public static $option_key = "";

	/**
	 * Initialize my option containers here
	 * calls set_options method to populate options with their respective values 
	 *@since: 0.1
	 *@sub-package: Abbey theme 
	 */
	public static function init(){
		self::set_options();
	}

	/**
	 * Getter function to get the default theme settings 
	 *@param: string|null $value
	 *@return: mixed $default_options 
	 *@since: 0.1
	 *@sub-package: Abbey theme
	 */
	public static function get_default_options( $value = NULL, $key =  NULL ) {

		if( empty( $value ) )
			return self::$default_options; 

		return self::get( $value, $key, self::$default_options );

	}

	/**
	 * Getter function to get the stored theme settings 
	 * These stored settings are handled by wordpress customizer API 
	 *@param: string|null $value
	 *@return: mixed $stored_options 
	 *@since: 0.1
	 *@sub-package: ABbey theme 
	 */
	public static function get_stored_options( $value = NULL ){
		if( empty( $value ) )
			return self::$stored_options; 

		return !empty( self::$stored_options[ $value ] ) ?: array();
	}

	/**
	 * Getter function to get theme options 
	 * These theme options is a combination of the defaults and the stored settings 
	 *@param: string|null $value 
	 *@return: mixed $theme_options
	 *@since: 0.1
	 *@sub-package: Abbey theme 
	 */
	public static function get_theme_options( $value = NULL ) {

		if ( !empty( $value ) && isset( self::$theme_options[ $value ] ) ) 
			return self::$theme_options[ $value ];
		
		return self::$theme_options;
	}

	/**
	 * Populate and initialize theme settings and cache the options 
	 * settings can either be default, stored or options (theme)
	 * @Usage: 
	 * set_options( $option = "stored|default|theme|null" )
	 * @uses: wordpress wp_cache_add and wp_cache_get to save theme settings in cache 
	 *@param: string|null $option
	 *@sub-package: Abbey theme 
	 *@since: 0.1
	 *
	 */
	private static function set_options( $option = NULL ){
		// dummmy containers for the options that will be set //
		$default = $stored = $options = "";
		
		/**
		 * Default options for the class is set/initialized here 
		 * We first check if the default is already in cache, if its in cache we merge with our normal defaults
		 */
		if( $option === "default" || empty( $option ) ){

			//check if default option is cached already //
			if( $default = wp_cache_get( self::$option_key."_default", self::$option_key ) ){
				
				// run a filter to access the default theme settings //
				add_filter( "abbey_theme_defaults", function( $defaults ) use( $default ){
					self::$default_options = array_merge( $default, $defaults );
					// return the normal defaults //
					return $defaults;
				}, 999 );
				
				if( !empty( $option ) ) return;
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

			if( !empty( $option ) )
				return;
		}

		if( $option === "theme" || empty( $option ) ){
			if( $options = wp_cache_get( self::$option_key."_options", self::$option_key ) ){
				self::$theme_options = $options;
				return;
			}
			self::$theme_options = wp_parse_args( self::get_default_options(), self::get_stored_options()  );
			self::$theme_options = array_intersect_key( self::$theme_options, self::$default_options );
			$options = wp_cache_add( self::$option_key."_options", self::$theme_options, self::$option_key );

			if( !empty( $option ) )
				return;
		}
		
		

	}

	/**
	 * private method to get options form theme settings 
	 * options can be default, stored or theme options 
	 * @params: 	string 		$value 		contains the value being searched for 
	 * 				string 		$key 		contains the index key of the value in the options 
	 *				array 		$options 	the option where value and key reside in 
	 * @return:		string|array 	
	 * @since:		0.1 
	 * @category: 	assets 
	 * @Usage: 		Abbey_theme_settings::get( "color", "gray_color", "default_options" )
	 */
	private static function get( $value, $key, $options ){

		/* if the key is empty, just check if the value exist in options or return an empty array */
		if( empty( $key ) )
			return !empty( $options[ $value ] ) ? $options[ $value ]: array();
		
		/**
		 * perform a multi check
		 * first check if the $value key exist in $options
		 * secondly, check if the $key exist in $options 
		 */
		if( isset( $options[ $value ] ) ){
			$default_value = $options[ $value ];
		}
		elseif( isset( $options[ $key ] ) ){
			$default_value = $options[ $key ];
		}

		// if the default value is not empty //
		if( !empty( $default_value ) ){

			// if somehow the default value is not an array, maybe a string or int, just return it //
			if( !is_array( $default_value ) )
				return $default_value;
			
			/**
			 * double check the indexes, if $value or $key exist as an index in our default_value 
			 */
			if( array_key_exists( $key, $default_value ) )
				return $default_value[ $key ];

			if( array_key_exists( $value , $default_value ) )
				return $default_value[ $value ];

			return $default_value;
		}

	}

	private function flush(  ){
		wp_cache_delete( self::$option_key."_default", self::$option_key );
	}

}