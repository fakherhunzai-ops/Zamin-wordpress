<?php
/**
 * Search results template.
 *
 * @package Zamin
 */

get_header();
?>
<section class="z-section"><div class="z-container">
	<span class="z-eyebrow"><?php esc_html_e( 'Search', 'zamin' ); ?></span>
	<h1><?php printf( esc_html__( 'Results for “%s”', 'zamin' ), esc_html( get_search_query() ) ); ?></h1>
	<?php if ( have_posts() ) : ?>
		<div class="z-grid z-grid--3" style="margin-top:32px">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article class="z-card">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="z-small z-muted"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></p>
					<p><?php the_excerpt(); ?></p>
					<a class="z-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View details', 'zamin' ); ?></a>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<?php zamin_empty( __( 'No results found', 'zamin' ), __( 'Try a different search term or browse our properties and stays.', 'zamin' ), array( array( __( 'Explore Properties', 'zamin' ), zamin_page_url( 'properties-for-sale' ), 'dark' ) ) ); ?>
	<?php endif; ?>
</div></section>
<?php
get_footer();
