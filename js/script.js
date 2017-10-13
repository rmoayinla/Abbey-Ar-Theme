// jquery-javascript //
(function($) {
	$( document ).ready( function() {

		/**
		 * Show gallery in a Slick carousel 
		 * this depends on the Slick Library as the carousel is created in the jQuery plugin 
		 *@requires: Slick Slider 
		 */
		$(".gallery-slides").slick({
			autoplay: true, //autoplay the slide //
			autoplaySpeed: 2000, //speed in ms //
			arrows: false, //dont show a slider arrow //
			slidesToShow: 3, // show 3 slides at once //
			responsive: [ //slide responsive settings //
				{
					breakpoint: 480, //on screen with max-width 480 i.e. mobile device //
					settings: {
						slidesToShow: 2 //show only to slides //
					}
				}
			]
		}); //end .gallery-slides //

		/**
		 * Show '.photo-carousel' in a Slick slide 
		 *@requires: Slick Slider 
		 */
		$(".photo-carousel").slick({
			autoplay: true, 
			autoplaySpeed: 3000, 
			arrows: false, //dont show arrows //
			dots: true //show carousel dots indicators //
		});//end .photo-carousel //

		/**
		 * Show posts in slides i.e. carousel 
		 * the settings here can be overriden by setting a data-slide attribut on the child of '.posts-slides' element
		 *@requires: Slick Slider 
		 */
		$(".posts-slides").slick({
			autoplay: true, //autoplay the slide on page load //
			arrows: true, //show arrows //
			dots: false // hide carousel indicators //
		});

		
		/**
		 * Settings for Bootstrap collapse module/plugin 
		 * Bind some functions to run before the collapse element is shown or hidden 
		 * @requires: Bootstrap.js
		 */
		$( function(){

			/**
			 * Loop through the '.collapse-heading' element and add a collapse indicator 
			 * this indicator is a simple Fontawesome icon showing if the collapse is hidden or shown 
			 */
			$( ".collapse-heading" ).each( function(){
				var _this = $( this );
				//add the collpase indicator icon //
				_this.prepend( '<a href="#" class="toggle-icon"><i class="fa fa-chevron-circle-up fa-lg"></i></a>' );
			});

			/**
			 * Attach a collapse event to '.collapse-heading' 
			 * @require: Bootstrap.js 
			 */
			$( document ).on( "click", ".collapse-heading", function(e){
				var _this;
				//prevent the default action for this element //
				e.preventDefault();

				//copy the jQuery $this object //
				_this = $( this );

				//find the next element which has '.collapse-item' and collapse it (hide|show)//
				_this.next( ".collapse-item" ).collapse( 'toggle' );

			});//end '.collpase-heading' click event //

			/** 
			 * Bind an event to run before the '.collpase-item' element is shown 
			 * Here we will add some class for transitioning and change the indicator icon 
			 */
			$(".collapse-item").on('show.bs.collapse', function(){
	        	
	        	// add '.collapse-show' class to the element and remove '.collapse-hide' class //
	        	$( this ).addClass( "collapse-show" ).removeClass( "collapse-hide" );

	        	//find the icon and replace with an arrow facing up //
	        	$(this).prev( ".collapse-heading" ).find( ".toggle-icon" ).html( '<i class="fa fa-chevron-circle-up fa-lg"></i>' );
	    	});

	    	/**
	    	 * Bind an event to run before the '.collapse-item' is hidden 
	    	 * Here we will add some class for transitioning and change the icon 
	    	 */
	    	$(".collapse-item").on('hide.bs.collapse', function(){
	       		$(this).addClass( "collapse-hide" ).removeClass( "collapse-show" );
	       		$(this).prev( ".collapse-heading" ).find( ".toggle-icon" ).html( '<i class="fa fa-chevron-circle-down fa-lg"></i>' );
	   		});

		}); //end bootstrap collapse events //

		/**
		 * Attach an event to '.more-button' link/button in single pages/posts
		 * this button will show the remainder of the current post that was hidden 
		 */
		$(document).on("click", ".entry-content .more-button", function(event){
			//declare variables //
			var _this, nextElements;

			//copy the jQuery $this object //
			_this = $(this);

			/**
			 * Get the next element with id "more-content" and display/hide it 
			 */
			nextElements = _this.next("#more-content");
			nextElements.toggleClass("hidden in");
		}); //.more-button


		/**
		 * A simple module for animating elements on scroll 
		 * The animations and transitions are done with CSS, so classes are added/removed on scroll 
		 * The elements are animated when in view e.g. zoom in, slide in, slide up, slide down, zoom out etc
		 */
			//target elements to be animated, they can be selected through class/data attribute //
			var $animation_elements = $('.scroll-animate, .frontpage-sections');

			// clone the jQuery window object to a variable //
			var $window = $(window);

			/**
			 * Check if the targeted elements are being in view and add appropriate transtion class 
			 * An element is in view when the scroll bar position is equal to the element top offset position 
			 */
			function check_if_in_view() {
			  var window_height = $window.height();
			  var window_top_position = $window.scrollTop();
			  var window_bottom_position = (window_top_position + window_height);
			 
			  $.each($animation_elements, function() {
			    var $element = $(this);
			    var element_height = $element.outerHeight(true);
			    var element_top_position = $element.offset().top;
			    var element_bottom_position = (element_top_position + element_height);
			 	var animate_class = $animation_elements.data( "animate" );
			 	
			 	if( animate_class !== undefined ){
			 		$element.addClass( animate_class );
			 	}
			    //check to see if this current container is within viewport
			    if ( (element_bottom_position >= window_top_position) &&
        			 (element_top_position <= window_bottom_position)
			    	){
			    		
			     	 	$element.addClass( "in-view" );
			    	} 
			    else {
			      		$element.removeClass( "in-view" );
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
		gallery.each(function(){
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

		iframe_video = $( ".entry-content iframe[src*='youtube'], .entry-content iframe[src*='vimeo'], .entry-content iframe[src*='google']" ); 
		iframe_video.each( function(){
			var _this = $(this);
			var src = _this.attr( "src" ).replace( /(.+)\/embed\/(.+)/, "$1/watch/?v=$2" );
			_this.after( '<a href="'+src+'" class="btn btn-default video-popup" role="button">View in popup </a>' ).parent().addClass("video-iframe");
		});

		
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
	
	if (typeof $.fn.popover == 'function') $('[data-toggle="tooltip"]').tooltip(); 

	$(function(){
		var postCard, hoverCard;
		postCard = $(".archive-posts .post-panel:not(.post-count-1)");
		
		postCard.each(function(){
			var _this, postExcerpt;
			_this = $(this);
			postExcerpt = _this.find( ".post-excerpts" ).html();
			_this.append("<div class='hover-card'><span class='close-icon'>&times;</span></div>");
			_this.children(".hover-card").append(postExcerpt);
		})//end .each //


		$(document).on({
			 mouseenter: function(){
			 	$(this).children(".hover-card").addClass("in");
			 }, 
			 mouseleave: function(){
			 	$(this).children(".hover-card").removeClass("in");
			 }
		},".post-panel:not(.post-count-1)" 
		); //end of on mousenter and mouseleave //

		$(document).on("click", ".close-icon", function(ev){
			ev.preventDefault(); 
			var target, _this;
			_this = $(this);
			if( _this.data("target") ){
				_this.parents(_this.data("target")).fadeOut("slow");//hide the parent element passed throught the data attribute //
			} else{
				_this.parent().fadeOut("slow"); //hide only the direct parent element of the close-icon //
			}
		});
		

	})//end function //


	$(function(){
		$( ".layout-links" ).click( function(ev){
			ev.preventDefault();
			var _this, wrapper,layoutClasses, layoutClass;
			_this = $(this);
			wrapper = $( ".archive-posts-wrapper" );
			layoutClasses = "layout-grid-column layout-grid-row";
			wrapper.toggleClass( _this.data( "layoutClass" ) );

		} );
	});
	$(function(){
		$("#floating-video").affix({
  			offset: {
    			top: $(".entry-content iframe").offset().top
  			}
		});
	});



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

