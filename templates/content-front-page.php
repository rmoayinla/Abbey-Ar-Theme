<?php
/*
*

*/

$front_page_defaults = abbey_theme_front_page_defaults();
$blog_section = $front_page_defaults["blog-posts"];
$service_section = $front_page_defaults["services"];
$quote_section = $front_page_defaults["quotes"];
$contact_section = $front_page_defaults["contact"];

?>

<!-- #content is already open in header.php -->
	<section id="latest-posts" class="bg-white text-center row frontpage-sections" data-animate="slide-up">
		<div class="inner-wrapper">
			<h2 class="page-header text-capitalize"> <?php echo esc_html( $blog_section["header-text"] ); ?></h2>
			<div class="small description inner-pad-medium"><?php echo esc_html( $blog_section["body-text"] ); ?></div>
			<article><?php do_action("abbey_theme_front_page_recent_posts"); ?></article>
			
			<div class="md-50 margin-top-md">
				<a href="" role="button" class="btn btn-default btn-lg btn-block"> <?php esc_html_e("View all articles", "abbey" ); ?></a>
			</div><!--.inner-wrapper closes -->
		</div>
	</section><!-- #latest-posts section closes -->

	<section id="services" class="bg-light text-center row frontpage-sections">
		<div class="inner-wrapper">
			<h2 class="page-header text-capitalize"><?php echo esc_html($service_section["header-text"]);?></h2>
			<div class="small description"><?php echo esc_html($service_section["body-text"]); ?></div>
			<div class="row margin-top-md" id=""><?php abbey_theme_show_services(); ?></div>
		</div>
	</section><!--end of #services section -->

	<section id="quotes" class="frontpage-sections text-center row">
		<div class="inner-wrapper">
			<h2 class="page-header text-capitalize"> <?php echo esc_html($quote_section["header-text"]); ?> </h2>
			<div class="small description">
				<?php echo esc_html ( $quote_section["body-text"] ); ?>
			</div>
			<div id="front-page-quotes" class=""><?php do_action("abbey_theme_front_page_quotes"); ?></div>
		</div>
	</section><!--end of section #quotes -->

	<section id="contact" class="text-center row bg-white frontpage-sections">
		<div class="inner-wrapper">
			<h2 class="page-header text-capitalize"> <?php echo esc_html($contact_section["header-text"]); ?> </h2>
			<div class="small description"><?php echo esc_html($contact_section["body-text"]); ?></div>
			<div class="row margin-top-md text-left">
				<div class="panel panel-default row">
					<div class="panel-body col-md-8 pad-medium">
						<?php do_action("abbey_theme_front_page_contacts"); ?>
					</div>
					<div id="front-page-contact-form" class="panel-footer col-md-4 pad-medium">
						<div class="" id="contact-form-wrapper">
							<div class="text-center">
								<h4><?php echo apply_filters("abbey_theme_front_page_contact_form_header_text", esc_html($contact_section["form-header-text"]) ); ?></h4>
							</div>
							<?php do_action("abbey_theme_front_page_contact_form"); ?>
						</div>
					</div><!--#front-page-contact-form closes -->
				</div>
			</div>
		</div>
	</section><!-- #contact section closes -->

	<?php do_action( "abbey_theme_front_page_sections" ); ?>

</main>
	
