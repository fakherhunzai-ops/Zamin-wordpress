<?php
/**
 * Stay archive.
 *
 * @package Zamin
 */

get_header();
zamin_hero(
	'stays_hero',
	__( 'ZAMIN Stays', 'zamin' ),
	__( 'Verified Mountain Stays', 'zamin' ),
	__( 'Handpicked villas, cabins and heritage homes across Gilgit-Baltistan.', 'zamin' ),
	array(),
	'z-hero--compact'
);
?>
<div class="z-container">
	<?php zamin_render_stays_search(); ?>
	<div class="z-toolbar"><span class="z-toolbar__count"><?php printf( esc_html__( '%d stays found', 'zamin' ), absint( $GLOBALS['wp_query']->found_posts ) ); ?></span><?php zamin_sort_select(); ?></div>
	<?php if ( have_posts() ) : ?>
		<div class="z-listing-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				zamin_listing_card( get_post(), 'stay' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<?php zamin_empty( __( 'No stays listed yet.', 'zamin' ), __( 'Stays are being onboarded across Hunza, Gojal, Skardu, Naltar and Ghizer — check back soon.', 'zamin' ) ); ?>
	<?php endif; ?>
</div>
<?php
get_footer();
