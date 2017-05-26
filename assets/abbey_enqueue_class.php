<?php 
/**
 * A simple class to handle enqueueing and dequeueing assets i.e styles and scripts
 * this class provides simple interface to add styles and scripts
 * scripts and styles added can also be removed before being hooked into wp enqueue action 
 * @version: 0.1 
 * @theme: Abbey 
 */

class Abbey_Enqueue {
	protected static $styles; 
	protected static $scripts; 
	protected static $theme_uri; 

	/**
	 * method to initialize and enqueue default styles and script for theme
	 * theme style and script is loaded by this method, if it's a child theme parent style is loaded too here
	 *@since: 0.1
	 */
	public static function init(){
		self::$theme_uri = ( is_child_theme() ) ? 
							trailingslashit ( get_stylesheet_uri() ) : 
							trailingslashit( get_template_directory_uri() );

		self::add_style( "abbey-style", get_stylesheet_uri()  ); 
		self::add_script( "abbey-script", self::$theme_uri."js/script.js", array( "jquery" ), 1.0, true );
		
		/* If using a child theme, auto-load the parent theme style. */
    	if ( is_child_theme() ) {
       	 	self::add_style( 'abbey-parent-style', self::$theme_uri.'style.css' );
    	}
	}

	/**
	 * method to add style to the class, this method is used publicly 
	 * @params: string $handle, string $src, array $deps, bool|string $ver, string $media
	 *@since: 0.1 
	 */
	public static function add_style( $handle, $src = "", $deps = array(), $ver = false, $media = "all" ){
		self::$styles[] = array( 	"handle" => $handle, 
									"src" => $src, 
									"deps" => $deps, 
									"ver" =>$ver, 
									"media" => $media 

								); 
	}

	/**
	 * method to add scripts to the class, this method is used publicly 
	 * @params: string $handle, string $src, array $deps, bool|string $ver, string $in_footer 
	 *@since: 0.1 
	 */
	public static function add_script( $handle, $src = "", $deps = array(), $ver = false, $in_footer = true ){
		self::$scripts[] = array(	"handle" => $handle, 
									"src" => $src, 
									"deps" => $deps, 
									"ver" => $ver, 
									"in_footer" => $in_footer 
								);

	}

	/**
	 * method to return all added styles in the class, note: styles returned may not be enqueued yet 
	 *@return: array $styles 
	 *@since: 0.1 
	 */
	public static function get_styles (  ){
		return self::$styles; 
	}

	/**
	 * method to return all added scripts in the class, note: scripts returned may not be enqueued yet 
	 *@return: array $scripts 
	 *@since: 0.1 
	 */
	public static function get_scripts(  ){
		return self::$scripts; 
	}

	/**
	* method to return theme uri used for loading assets
	* the theme uri can be the child uri, the parent theme uri or current theme uri 
	*@return: string $theme_uri 
	*/
	public static function get_theme_uri(){
		return self::$theme_uri; 
	}

	/**
	* method to perform the actual enqueueing, this method can enqueue only styles or only scripts or both
	*@param: string $type 
	*/
	public static function enqueue( $type = "all" ){
		if( !property_exists( "Abbey_Enqueue", $type ) && $type !== "all" )
			return; 
		
		switch ( $type ){
			case "all" :
			default :
				self::enqueue_styles();
				self::enqueue_scripts();
				break;
			case "styles" :
				self::enqueue_styles();
				break; 
			case "scripts" :
				self::enqueue_scripts(); 
				break;
		} 
		
	}

	/**
	 * a protected method to enqueue only styles, this method can only be called within this class not publicly
	 */
	protected static function enqueue_styles(){
		if( empty( self::get_styles() ) )
			return; 
		foreach( self::get_styles() as $style ){
			$src = esc_url( $style[ "src" ] ); 
			$handle = $style[ "handle" ]; 
			wp_enqueue_style( $handle, $src, $style[ "deps" ], $style[ "ver" ], $style[ "media" ] ); 
		}
	}

	/**
	 * a protected method to enqueueu only scripts, this method can only be called within this class not publicly 
	 */
	protected static function enqueue_scripts(){
		if( empty( self::get_scripts() ) )
			return; 
		foreach( self::get_scripts() as $script ){
			$src = esc_url( $script[ "src" ] ); 
			$handle = $script[ "handle" ]; 
			wp_enqueue_script( $handle, $src, $script[ "deps" ], $script[ "ver" ], $script[ "in_footer" ] ); 
		}
	}
}