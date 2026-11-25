<?php
/**
 * Default page template.
 *
 * @package Zamin
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php the_content(); ?>
	</article>
	<?php
endwhile;
get_footer();
