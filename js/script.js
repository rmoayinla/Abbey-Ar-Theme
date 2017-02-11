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

		$("#floating-video").affix({
		  offset: {
		    top: $(".entry-content iframe").offset().top
		    }
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

