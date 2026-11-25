<?php
/**
 * Blog index fallback.
 *
 * @package Zamin
 */

get_header();
?>
<section class="z-section"><div class="z-container">
	<h1><?php echo esc_html( is_home() ? __( 'Latest News', 'zamin' ) : get_the_archive_title() ); ?></h1>
	<?php if ( have_posts() ) : ?>
		<div class="z-grid z-grid--3">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article class="z-card">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="z-small z-muted"><?php echo esc_html( get_the_date() ); ?></p>
					<p><?php the_excerpt(); ?></p>
					<a class="z-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'zamin' ); ?></a>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php
		the_posts_pagination();
	else :
		zamin_empty( __( 'Nothing published yet', 'zamin' ), __( 'Check back soon for news and market updates from our Gilgit-Baltistan team.', 'zamin' ) );
	endif;
	?>
</div></section>
<?php
get_footer();
