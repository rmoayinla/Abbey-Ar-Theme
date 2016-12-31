<form action="<?php echo esc_url( home_url() ). "/"?>" method="get" role="search" id="searchform">
    <div class="input-group">
	    <label for="search" class="sr-only">
	    	<?php echo apply_filters( "abbey_theme_search_form_sr_label", $label ) ?>
	    </label>
	    <input type="search" name="s" id="search" value="<?php the_search_query(); ?>" class="form-control"
	    	placeholder="<?php echo apply_filters( "abbey_theme_search_form_placeholder", __("What are you looking for?", "abbey" ) ); ?>"
	    />
	    <span class="input-group-btn">
	    	<input type="submit" title="Search" name="submit" class="btn btn-default"
	    		value="<?php echo apply_filters( "abbey_theme_search_form_submit_label", __( "Search", "abbey" ) ); ?>"
	    	/>
	    </span>
	</div>
	<?php do_action( "abbey_theme_search_form" ); ?>
</form>