<?php
/**
 * Static front page template.
 *
 * @package Zamin
 */

get_header();
while ( have_posts() ) :
	the_post();
	the_content();
endwhile;
get_footer();
