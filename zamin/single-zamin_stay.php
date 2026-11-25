<?php
/**
 * Single stay template.
 *
 * @package Zamin
 */

get_header();
while ( have_posts() ) :
	the_post();
	zamin_render_single_listing( get_post(), 'stay' );
endwhile;
get_footer();
