<!DOCTYPE html>
<html <?php language_attributes(); ?> class="">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>

	
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	<div class="container-fluid" id="site-wrapper">
	
		<header id="sitehead" class="site-header row" role="header">
			<div id="header-top" class=""><?php do_action( "abbey_theme_before_header" ); ?></div>
			<!--#header-top closes -->
			
			<div class="skip-link">
				<a class="skip-link sr-only" href="#content"><?php _e( 'Skip to content', 'abbey' ); ?></a>
			</div><!--skip link closes -->

			<div id="main-header">
				<nav class="navbar navbar-default no-bottom-margin" role="navigation" id="primary-menu">
	  				<div class="navbar-header">
	      				<a class="navbar-brand" href="<?php echo home_url( "/" ); ?>">
	               			<?php abbey_show_logo( "", "", false ); ?>
	      				</a>
	      				<!-- Brand and toggle get grouped for better mobile display -->
	      				<?php echo abbey_nav_toggle(); ?>
	      			</div>
					<?php do_action("abbey_theme_primary_menu"); ?>
				</nav>
			
			</div><!--#main-header closes -->

			
				
		</header><!-- .site-header -->


		