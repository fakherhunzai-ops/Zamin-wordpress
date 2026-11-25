<?php
/**
 * Default single post template.
 *
 * @package Zamin
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<section class="z-section"><div class="z-container z-two-col-form">
		<div class="z-prose">
			<span class="z-eyebrow"><?php echo esc_html( get_the_date() ); ?></span>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_post_thumbnail() ) : ?>
				<p><?php the_post_thumbnail( 'large' ); ?></p>
			<?php endif; ?>
			<?php the_content(); ?>
		</div>
		<div class="z-card"><?php dynamic_sidebar( 'zamin-blog' ); ?></div>
	</div></section>
	<?php
endwhile;
get_footer();
