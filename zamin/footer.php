<?php
/**
 * Site footer.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="z-site-footer">
	<div class="z-container">
		<div class="z-footer-grid">
			<div class="z-footer-brand">
				<a class="z-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="z-brand__mark" aria-hidden="true">Z</span>
					<span class="z-brand__text">
						<span class="z-brand__name">ZAMIN</span>
						<span class="z-brand__sub"><?php esc_html_e( 'Real Estate & Consultants', 'zamin' ); ?></span>
					</span>
				</a>
				<p><?php esc_html_e( 'Trusted real estate and verified mountain stays across Hunza, Gilgit, Skardu, Nagar, Ghizer and Chilas. Local knowledge, transparent pricing and genuine local expertise.', 'zamin' ); ?></p>
			</div>

			<div class="z-footer-col">
				<h4><?php esc_html_e( 'Explore', 'zamin' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => '',
						'fallback_cb'    => 'zamin_fallback_footer_menu',
						'depth'          => 1,
					)
				);
				?>
			</div>

			<div class="z-footer-col">
				<h4><?php esc_html_e( 'Property', 'zamin' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( zamin_page_url( 'properties-for-sale' ) ); ?>"><?php esc_html_e( 'Properties for Sale', 'zamin' ); ?></a></li>
					<li><a href="<?php echo esc_url( zamin_page_url( 'properties-for-rent' ) ); ?>"><?php esc_html_e( 'Properties for Rent', 'zamin' ); ?></a></li>
					<li><a href="<?php echo esc_url( zamin_page_url( 'valuation' ) ); ?>"><?php esc_html_e( 'Free Valuation', 'zamin' ); ?></a></li>
					<li><a href="<?php echo esc_url( zamin_page_url( 'services' ) ); ?>"><?php esc_html_e( 'Our Services', 'zamin' ); ?></a></li>
					<li><a href="<?php echo esc_url( zamin_page_url( 'privacy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'zamin' ); ?></a></li>
				</ul>
			</div>

			<div class="z-footer-col">
				<h4><?php esc_html_e( 'Get in Touch', 'zamin' ); ?></h4>
				<div class="z-footer-contact">
					<a href="<?php echo esc_url( zamin_phone_href() ); ?>"><?php echo esc_html( zamin_setting( 'phone' ) ); ?></a>
					<a href="mailto:<?php echo esc_attr( zamin_setting( 'email' ) ); ?>"><?php echo esc_html( zamin_setting( 'email' ) ); ?></a>
					<span><?php echo esc_html( zamin_setting( 'hours' ) ); ?></span>
					<span><?php echo esc_html( zamin_setting( 'address' ) ); ?></span>
					<a href="<?php echo esc_url( zamin_whatsapp_href() ); ?>"><?php esc_html_e( 'Chat on WhatsApp', 'zamin' ); ?></a>
				</div>
			</div>
		</div>

		<div class="z-footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'zamin' ); ?></span>
			<span><?php esc_html_e( 'Hunza · Gilgit · Skardu · Nagar · Ghizer · Chilas', 'zamin' ); ?></span>
		</div>
	</div>
</footer>

<div class="z-float-actions">
	<a class="z-float-actions__call" href="<?php echo esc_url( zamin_phone_href() ); ?>" aria-label="<?php echo esc_attr__( 'Call Now', 'zamin' ); ?>" title="<?php echo esc_attr__( 'Call Now', 'zamin' ); ?>">&#9742;</a>
	<a class="z-float-actions__wa" href="<?php echo esc_url( zamin_whatsapp_href() ); ?>" aria-label="<?php echo esc_attr__( 'WhatsApp', 'zamin' ); ?>" title="<?php echo esc_attr__( 'WhatsApp', 'zamin' ); ?>">WA</a>
</div>

<?php wp_footer(); ?>
</body>
</html>
