<?php
/**
 * Site header.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'zamin' ); ?></a>

<header class="z-site-header">
	<div class="z-container z-header-inner">
		<a class="z-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="z-brand__mark" aria-hidden="true">Z</span>
				<span class="z-brand__text">
					<span class="z-brand__name">ZAMIN</span>
					<span class="z-brand__sub"><?php esc_html_e( 'Real Estate & Consultants', 'zamin' ); ?></span>
				</span>
			<?php endif; ?>
		</a>

		<nav class="z-primary-nav" id="zamin-primary-nav" aria-label="<?php echo esc_attr__( 'Primary navigation', 'zamin' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => '',
					'fallback_cb'    => 'zamin_fallback_menu',
					'depth'          => 3,
				)
			);
			?>
		</nav>

		<div class="z-header-actions">
			<div class="z-header-phone">
				<span><?php esc_html_e( 'Call our advisory desk', 'zamin' ); ?></span>
				<a href="<?php echo esc_url( zamin_phone_href() ); ?>"><?php echo esc_html( zamin_setting( 'phone' ) ); ?></a>
			</div>
			<a class="z-btn z-btn--dark z-btn--sm" href="<?php echo esc_url( zamin_page_url( 'sell-your-property' ) ); ?>"><?php esc_html_e( 'List Property', 'zamin' ); ?></a>
			<button type="button" class="z-menu-toggle" aria-controls="zamin-primary-nav" aria-expanded="false" aria-label="<?php echo esc_attr__( 'Open menu', 'zamin' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<main id="main">
