<?php
/******************************************************************************/
/******************************************************************************/

// Long's Functions
add_shortcode( 'vth_navigations_sc', 'vth_navigations' );


function vth_navigations(){
	// You need protect against arbitrary paged values
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	$args = array(
	    'post_type' => 'page',
	    'posts_per_page' => 6,
	    'paged' => $paged,
	);

	$my_query = new WP_Query( $args );
	return easy_wp_pagenavigation($my_query);
}

// Hoang's Phân Sần