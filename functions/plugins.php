<?php

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}
// Apply filter
add_filter( 'get_avatar' , 'abbey_custom_avatar' , 1 , 6 );//

function abbey_custom_avatar( $avatar, $id_or_email, $size, $default, $alt, $args ) {
    $user = false;
    global $abbey_defaults;

    if ( is_numeric( $id_or_email ) ) {
		$id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );	
    }

    if ( $user && is_object( $user ) && $default === "user_upload" ) {
            $avatar = $abbey_defaults["admin"]["pics"];
            $class = ( !empty($args) && isset( $args["class"] ) ) ? esc_attr( $args["class"] ) : "";
            $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} {$class}' height='{$size}' width='{$size}' />";
        }


    return $avatar;
}

add_filter( 'wp_link_pages_link', 'abbey_post_navigation_link', 10, 2 );

function abbey_post_navigation_link( $link, $i ){
    global $page, $numpages, $multipage, $more;
    $active = ( $i === $page ) ? "active" : "";
    if ( $page === $numpages && $i === $page ){
        $link = "<li class='active'><a>".esc_html( $page )."</a></li>";
    } else {
        $link = preg_replace('~<a(.*)>(.*)</a>~i',"<li class='$active'><a $1>$2</a></li>", $link );
    }
    return $link;
}

add_filter('wp_link_pages_args','abbey_add_next_and_number');
function abbey_add_next_and_number( $args ){
        global $page, $numpages, $multipage, $more, $pagenow;
        $args['next_or_number'] = 'number';
        $prev = '';
        $next = '';
        if ( $multipage ) {
            if ( ! $more ) {
                $i = $page - 1;
                if ( $i && ! $more ) {
                    $prev .= "<li>"._wp_link_page($i);
                    $prev .= $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a></li>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && ! $more ) {
                    $next .= "<li>"._wp_link_page($i);
                    $next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a></li>';
                }
            }
        }
        $args['before'] = $args['before'].$prev;
        $args['after'] = $next.$args['after'];   
    
    return $args;
}

add_filter( 'avatar_defaults', 'new_default_avatar' );

function new_default_avatar ( $avatar_defaults ) {
    global $abbey_defaults;
        //Set the URL where the image file for your avatar is located
        $new_avatar_url = site_url()."/img/author.jpg";
        //Set the text that will appear to the right of your avatar in Settings>>Discussion
        $avatar_defaults[$new_avatar_url] = 'Custom Avatar';
        return $avatar_defaults;
}

add_filter( 'comment_class', 'abbey_custom_comment_class', 10, 5 );
function abbey_custom_comment_class ( $classes, $class, $comment_ID, $comment, $post_id ){
    $status = ( !empty( wp_get_comment_status( $comment_ID ) ) ) ? esc_attr( wp_get_comment_status( $comment_ID ) ) : "";
    $classes[] = $status; 
    
    return $classes; 
}

add_action('pre_get_comments', 'abbey_show_all_comments' ); 
function abbey_show_all_comments ( $query ) {
    if( is_admin() )
        return;
    $args = array();
    if ( is_user_logged_in() && current_user_can( 'moderate_comments' ) )
        $args['status'] = [ 'all', 'spam' ] ;
    
    $query->query_vars = wp_parse_args( $args, $query->query_vars );

}

add_filter( 'comment_reply_link', 'abbey_custom_comment_reply_link', 10, 4 ); 
function abbey_custom_comment_reply_link ( $link, $args, $comment, $post ){
    $link = preg_replace('~<a(.*)>(.*)</a>~i',"<a $1><span class='fa fa-reply'></span>&nbsp;$2</a>", $link );
    return $link;
}

add_filter( 'edit_comment_link', 'abbey_custom_edit_comment_link', 10, 3 );
function abbey_custom_edit_comment_link ( $link, $comment_ID, $text ){
    $link = preg_replace('~<a(.*)>(.*)</a>~i',"<a $1 target='_blank'><span class='fa fa-pencil'></span>&nbsp;$2</a>", $link );
    return $link;
}

add_filter( 'human_time_diff', 'abbey_time_diff', 10, 4 ); 
function abbey_time_diff( $since, $diff, $from, $to ){
    $mins = absint( round( $diff / MINUTE_IN_SECONDS ) );
    $hours = absint( round( $diff / HOUR_IN_SECONDS  ) );
    $days = absint( round( $diff / DAY_IN_SECONDS ) );
    $weeks = round( $diff / WEEK_IN_SECONDS );
    $months = round( $diff / MONTH_IN_SECONDS );
    $years = round( $diff / YEAR_IN_SECONDS );

    if ( $mins <= 10  ){
        $since = __( "Just now", "abbey" );
    } elseif ( $hours === 1 && $mins >= 60 ){
        $since = __( "An hour ago", "abbey" );
    } elseif( $days === 1 && $hours >= 24 ){
        $since = __( "Yesterday", "abbey" );
    }elseif( $weeks === 1 && $days > 7 ){
        $since = __( "Last week", "abbey" );
    }elseif( $months === 1 && $weeks > 4 ){
        $since = __( "Last month", "abbey" );
    }else{
        $since .= __( " ago", "abbey");
    }

    return $since;
}

add_filter('the_content', 'abbey_filter_content', 99 );
function abbey_filter_content( $content ){
    $content = preg_replace( '#<([^ >]+)[^>]*>([[:space:]]|&nbsp;)*</\1>#', '', $content );
    return $content;
}
/*
function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">Your Read More Link Text</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

function remove_more_link_scroll( $link ) {
    $link = preg_replace( '|#more-[0-9]+|', '', $link );
    return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
       global $post;
    return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read the full article...</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

*/