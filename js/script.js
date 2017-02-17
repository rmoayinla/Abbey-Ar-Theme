// jquery-javascript //
(function($) {
	$( document ).ready( function() {
		

		$(".gallery-slides").slick({
			autoplay: true, 
			autoplaySpeed: 2000, 
			arrows: false, 
			slidesToShow: 3,
			responsive: [
				{
					breakpoint: 480,
					settings: {
					slidesToShow: 2
					}
				}
			]
		});
		$(".photo-carousel").slick({
			autoplay: true, 
			autoplaySpeed: 3000, 
			arrows: false, 
			dots: true
		});

		$(".posts-slides").slick({
			autoplay: true, 
			arrows: true,
			dots: false

		});

		$( document ).on( "click", ".collapse-heading", function(e){
			var _this;
			e.preventDefault();
			_this = $( this );
			_this.next( ".collapse-item" ).collapse( "toggle" );
		} );

		$(".collapse-item").on('show.bs.collapse', function(){
        	$( this ).slideDown( "slow" );
    	});

    	 $(".collapse-item").on('hide.bs.collapse', function(){
       		$(this).slideUp( "slow" );
   		 });

		$(document).on("click", ".entry-content .more-button", function(event){
			var _this, nextElements;
			_this = $(this);
			nextElements = _this.next("#more-content");
			nextElements.toggleClass("hidden in");
		}); //.more-button


		
			var $animation_elements = $('.scroll-animate');
			var $window = $(window);

			function check_if_in_view() {
			  var window_height = $window.height();
			  var window_top_position = $window.scrollTop();
			  var window_bottom_position = (window_top_position + window_height);
			 
			  $.each($animation_elements, function() {
			    var $element = $(this);
			    var element_height = $element.outerHeight(true);
			    var element_top_position = $element.offset().top;
			    var element_bottom_position = (element_top_position + element_height);
			 
			    //check to see if this current container is within viewport
			    if ((element_bottom_position >= window_top_position) &&
        			(element_top_position <= window_bottom_position)
			    	){

			     	 $element.addClass('in-view');
			    } 
			    else {
			      $element.removeClass('in-view');
			    }

			  });
			}

			$window.on('scroll resize', check_if_in_view);
			$window.trigger('scroll');

		

		

		$(function(){
			var clone_gallery, gallery; 
			gallery = $( ".gallery" );
			clone_gallery = gallery.clone();
			clone_gallery.addClass( "gallery-nav-main" );
			clone_gallery.find( ".gallery-item" ).each( function( index ){
				var _this = $( this );
				_this.find( ".gallery-caption" ).remove();
			});
			gallery.before( clone_gallery );
			gallery.addClass( "gallery-nav-sub" );
			
			gallery.slick({
				slidesToShow: 3,
			  	slidesToScroll: 1,
			  	arrows: true,
			  	centerMode: true, 
			  	rtl: true, 
			  	asNavFor: '.gallery-nav-main', 
			  	responsive: [
				    {
				      breakpoint: 780,
				      settings: {
				        slidesToShow: 2,
				      }
				    },
				    {
				      breakpoint: 480,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1
				      }
				    }
				]
			});

			clone_gallery.slick({
				rtl: true, 
				slidesToShow: 1, 
				slidesToScroll: 1, 
				asNavFor: '.gallery-nav-sub', 
				fade: true, 
				arrows: false
			});
		});//function ends //

	$( function(){
		var gallery, image_link, iframe_video;
		gallery = $('.entry-content .gallery-item:not(.slick-cloned)');
		gallery.find( ".gallery-item" ).each(function(){
			var _this, imgSrc, imgTitle;
			_this = $( this );
			imgSrc = _this.find( "a" ).attr( "href" );
			imgTitle = _this.find( ".gallery-caption" ).text();
			_this.attr({
				"href" : imgSrc,
				"title" : imgTitle
			});

		});
		gallery.magnificPopup({
		  type: 'image',
		  //delegate: '.gallery-item:not(.slick-cloned)',//
		  gallery:{
		    enabled: true, 
		    tCounter: '<span class="mfp-counter">%curr% of %total%</span>'
		  }
		});

		iframe_video = $( "iframe[src*='youtube'], iframe[src*='vimeo']" ); 
		iframe_video.each( function(){
			var _this = $(this);
			var src = _this.attr( "src" ).replace( /(.+)\/embed\/(.+)/, "$1/watch/?v=$2" );
			_this.after( '<a href="'+src+'" class="btn btn-default video-popup" role="button">View in popup </a>' );
		} );

		
		$( ".video-popup" ).magnificPopup({
			type: 'iframe', 
			patterns: {
			    youtube: {
			      index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

			      id: 'v=', // String that splits URL in a two parts, second part should be %id%
			      // Or null - full URL will be returned
			      // Or a function that should return %id%, for example:
			      // id: function(url) { return 'parsed id'; }

			      src: 'https://www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
			    },
			    vimeo: {
			      index: 'vimeo.com/',
			      id: '/',
			      src: '//player.vimeo.com/video/%id%?autoplay=1'
			    },
			    gmaps: {
			      index: '//maps.google.',
			      src: '%id%&output=embed'
			    }

		    // you may add here more sources

		  }

		});


	});//end of fucntion 
		
		
		

		



	}); //document.ready //

})( jQuery ); 

function setupMoreButton(){
	var moreButton; 
		
		if( jQuery(".entry-content .more-button").length < 1 ){
			jQuery(".entry-content > p").each( function(index){
				var _this = jQuery(this);
				if(index === 5){
					_this.after("<p><button class='more-button'>continue reading</button></p>");
				}
			} );
			
		}
		moreButton = jQuery(".entry-content .more-button");
		moreButton.unwrap(); 
		moreButton.nextAll().wrapAll("<div id='more-content' class='hidden'></div>");
}

jQuery("#floating-video").affix({
  offset: {
    top: jQuery(".entry-content iframe").offset().top
  }
});