<?php
/*
* custom header template 
* this template file must be called with get_header
*
*
*/
global $abbey_defaults; 
?>
<?php do_action( "abbey_theme_before_html" ); ?>
<!DOCTYPE html>
	<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
	<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 8]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
		<head> 
			<!-- meta tags -->
			<meta charset="<?php bloginfo( 'charset' ); ?>" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<?php do_action("abbey_theme_meta_tags"); ?>

			<!-- link tags --> 
			<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
			<link rel="shortcut icon" href="<?php ?>" />

     

			<?php wp_head(); ?>
		</head> 
		<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
			<div class="container-fluid" id="site-wrapper">
				<header id="custom-header" class="row" role="header">
					<div id="header-top"> <?php do_action( "abbey_theme_before_header" ); ?></div>
					<!--#header-top closes -->
					
					<div id="skip-link">
						<a class="sr-only" href="#content" title="<?php esc_attr_e("Skip to content", "abbey"); ?>">
							<?php esc_html_e( 'Skip to content', 'abbey' ); ?></a>
					</div><!--#skip link closes -->

					<div id="main-header">
						<div id="inner-header" role="contact" class="row">
							<div class="float-right-responsive col-md-9 col-sm-12" id="header-contact">
								<div class="row">
									<?php do_action ("abbey_theme_header_contact", $abbey_defaults["contacts"] ); ?>
								</div>
							</div>
							<div class="navbar-header col-md-3">
	      						<!-- Brand and toggle get grouped for better mobile display -->
	      						<?php echo abbey_nav_toggle(); ?>
	      						<a class="navbar-brand" href="<?php echo home_url( "/" ); ?>" title="<?php echo home_url("/"); ?>">
	               					<?php abbey_show_logo(); ?>
	      						</a>
	      					</div>

						</div><!--#header-contact closes -->

						<nav class="navbar navbar-default" role="navigation">
							<?php do_action("abbey_theme_primary_menu"); ?>
						</nav>
					</div><!--#main-header closes-->

				</header><!--#custom-header closes -->



