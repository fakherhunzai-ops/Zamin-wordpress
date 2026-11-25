<?php
/**
 * Property archive.
 *
 * @package Zamin
 */

get_header();
zamin_hero(
	'listing_hero',
	'',
	__( 'Properties in Gilgit-Baltistan', 'zamin' ),
	__( 'Browse verified houses, apartments, land and commercial properties across the valleys we know best.', 'zamin' ),
	array(),
	'z-hero--compact'
);
?>
<div class="z-container">
	<?php zamin_render_property_search( 'all' ); ?>
	<div class="z-toolbar"><span class="z-toolbar__count"><?php printf( esc_html__( '%d properties found', 'zamin' ), absint( $GLOBALS['wp_query']->found_posts ) ); ?></span><?php zamin_sort_select(); ?></div>
	<?php if ( have_posts() ) : ?>
		<div class="z-listing-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				zamin_listing_card( get_post(), 'property' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<?php zamin_empty( __( 'No properties available yet. Check back soon.', 'zamin' ), __( 'Verified Gilgit-Baltistan listings appear here automatically as soon as they are published by our advisors.', 'zamin' ) ); ?>
	<?php endif; ?>
</div>
<?php
get_footer();
