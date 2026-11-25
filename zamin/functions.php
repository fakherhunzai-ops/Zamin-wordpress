<?php
/**
 * Zamin Real Estate theme bootstrap.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ZAMIN_THEME_VERSION', '1.0.0' );
define( 'ZAMIN_THEME_PATH', get_template_directory() );
define( 'ZAMIN_THEME_URI', get_template_directory_uri() );

require_once ZAMIN_THEME_PATH . '/inc/helpers.php';
require_once ZAMIN_THEME_PATH . '/inc/post-types.php';
require_once ZAMIN_THEME_PATH . '/inc/meta-boxes.php';
require_once ZAMIN_THEME_PATH . '/inc/forms.php';
require_once ZAMIN_THEME_PATH . '/inc/content.php';
require_once ZAMIN_THEME_PATH . '/inc/activation.php';

add_action( 'after_setup_theme', 'zamin_theme_setup' );
add_action( 'wp_enqueue_scripts', 'zamin_enqueue_assets' );
add_action( 'widgets_init', 'zamin_register_sidebars' );
add_filter( 'body_class', 'zamin_body_classes' );
add_filter( 'excerpt_length', 'zamin_excerpt_length' );
add_filter( 'excerpt_more', 'zamin_excerpt_more' );

/**
 * Theme supports and menus.
 */
function zamin_theme_setup() {
	load_theme_textdomain( 'zamin', ZAMIN_THEME_PATH . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'custom-background',
		array( 'default-color' => 'ffffff' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'zamin' ),
			'footer'  => __( 'Footer menu', 'zamin' ),
		)
	);
}

/**
 * Front-end assets. All assets are local to the theme.
 */
function zamin_enqueue_assets() {
	wp_enqueue_style( 'zamin-style', get_stylesheet_uri(), array(), ZAMIN_THEME_VERSION );
	wp_enqueue_script( 'zamin-theme', ZAMIN_THEME_URI . '/assets/js/theme.js', array(), ZAMIN_THEME_VERSION, true );

	wp_localize_script(
		'zamin-theme',
		'zaminConfig',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'savedLabel'   => __( 'Saved', 'zamin' ),
			'searchLabel'  => __( 'Search', 'zamin' ),
			'nonce'        => wp_create_nonce( 'zamin-form' ),
		)
	);
}

/**
 * Register widget areas used by the default WordPress post/blog views.
 */
function zamin_register_sidebars() {
	register_sidebar(
		array(
			'name'          => __( 'Blog sidebar', 'zamin' ),
			'id'            => 'zamin-blog',
			'description'   => __( 'Shown next to standard blog posts.', 'zamin' ),
			'before_widget' => '<div id="%1$s" class="z-card %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
}

/**
 * Helper body classes.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function zamin_body_classes( $classes ) {
	$classes[] = 'zamin-theme';
	if ( is_front_page() ) {
		$classes[] = 'zamin-front-page';
	}
	return $classes;
}

/**
 * Shorter excerpts on listing and blog cards.
 *
 * @return int
 */
function zamin_excerpt_length() {
	return 22;
}

/**
 * @return string
 */
function zamin_excerpt_more() {
	return '&hellip;';
}
