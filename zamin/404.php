<?php
/**
 * 404 template.
 *
 * @package Zamin
 */

get_header();
?>
<section class="z-section"><div class="z-container">
	<?php
	zamin_empty(
		__( 'This page could not be found', 'zamin' ),
		__( 'The page you are looking for may have moved. Browse properties, stays or get in touch with our Gilgit team.', 'zamin' ),
		array(
			array( __( 'Back to Home', 'zamin' ), home_url( '/' ), 'dark' ),
			array( __( 'Explore Properties', 'zamin' ), zamin_page_url( 'properties-for-sale' ), 'outline-dark' ),
		)
	);
	?>
</div></section>
<?php
get_footer();
