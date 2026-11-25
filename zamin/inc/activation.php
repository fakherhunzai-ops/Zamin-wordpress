<?php
/**
 * One-click setup: pages, menus, taxonomy terms and theme settings.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_switch_theme', 'zamin_activate_theme' );
add_action( 'admin_menu', 'zamin_add_settings_page' );
add_action( 'admin_init', 'zamin_register_settings' );
add_action( 'admin_post_zamin_create_pages', 'zamin_admin_create_pages' );
add_action( 'admin_notices', 'zamin_activation_notice' );

/**
 * Use pretty page permalinks so the URLs match zaminzameen.com.
 */
function zamin_ensure_permalinks() {
	$structure = get_option( 'permalink_structure' );
	if ( ! $structure || false !== strpos( $structure, '%year%' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	update_option( 'use_verbose_page_rules', true );
}

/**
 * Activation routine.
 */
function zamin_activate_theme() {
	zamin_seed_terms();
	zamin_create_pages();
	zamin_create_menus();

	zamin_ensure_permalinks();
	flush_rewrite_rules( false );
	set_transient( 'zamin_activated', 1, DAY_IN_SECONDS );
}

/**
 * Page definitions.
 *
 * @return array
 */
function zamin_page_definitions() {
	return array(
		'home'              => array( 'title' => __( 'Zamin Real Estate Gilgit-Baltistan', 'zamin' ), 'slug' => 'home', 'content' => '[zamin_home]', 'parent' => '' ),
		'properties-for-sale' => array( 'title' => __( 'Properties for Sale in Gilgit-Baltistan', 'zamin' ), 'slug' => 'properties-for-sale', 'content' => '[zamin_properties purpose="sale"]', 'parent' => '' ),
		'properties-for-rent' => array( 'title' => __( 'Properties for Rent in Gilgit-Baltistan', 'zamin' ), 'slug' => 'properties-for-rent', 'content' => '[zamin_properties purpose="rent"]', 'parent' => '' ),
		'sell-your-property' => array( 'title' => __( 'Sell or Rent Your Property', 'zamin' ), 'slug' => 'sell-your-property', 'content' => '[zamin_sell]', 'parent' => '' ),
		'valuation'         => array( 'title' => __( 'Property Valuation', 'zamin' ), 'slug' => 'valuation', 'content' => '[zamin_valuation]', 'parent' => '' ),
		'services'          => array( 'title' => __( 'Real Estate Services in Gilgit-Baltistan', 'zamin' ), 'slug' => 'services', 'content' => '[zamin_services_page]', 'parent' => '' ),
		'contact'           => array( 'title' => __( 'Contact Us', 'zamin' ), 'slug' => 'contact', 'content' => '[zamin_contact]', 'parent' => '' ),
		'privacy'           => array( 'title' => __( 'Privacy Policy', 'zamin' ), 'slug' => 'privacy', 'content' => '[zamin_privacy]', 'parent' => '' ),
		'stays'             => array( 'title' => __( 'ZAMIN Stays', 'zamin' ), 'slug' => 'stays', 'content' => '[zamin_stays_home]', 'parent' => '' ),
		'stays-host'        => array( 'title' => __( 'Become a Host', 'zamin' ), 'slug' => 'host', 'content' => '[zamin_host]', 'parent' => 'stays' ),
		'stays-host-apply'  => array( 'title' => __( 'Apply to Host Your Property', 'zamin' ), 'slug' => 'apply', 'content' => '[zamin_host_apply]', 'parent' => 'stays-host' ),
		'stays-managed'     => array( 'title' => __( 'Managed Hosting', 'zamin' ), 'slug' => 'managed-hosting', 'content' => '[zamin_managed]', 'parent' => 'stays' ),
		'stays-hunza'       => array( 'title' => __( 'Hunza — Verified Stays', 'zamin' ), 'slug' => 'hunza', 'content' => '[zamin_destination key="hunza"]', 'parent' => 'stays' ),
		'stays-gojal'       => array( 'title' => __( 'Upper Hunza (Gojal) — Verified Stays', 'zamin' ), 'slug' => 'gojal', 'content' => '[zamin_destination key="gojal"]', 'parent' => 'stays' ),
		'stays-skardu'      => array( 'title' => __( 'Skardu & Baltistan — Verified Stays', 'zamin' ), 'slug' => 'skardu', 'content' => '[zamin_destination key="skardu"]', 'parent' => 'stays' ),
		'stays-naltar'      => array( 'title' => __( 'Naltar Valley — Verified Stays', 'zamin' ), 'slug' => 'naltar', 'content' => '[zamin_destination key="naltar"]', 'parent' => 'stays' ),
		'stays-ghizer'      => array( 'title' => __( 'Ghizer & Phander — Verified Stays', 'zamin' ), 'slug' => 'ghizer', 'content' => '[zamin_destination key="ghizer"]', 'parent' => 'stays' ),
	);
}

/**
 * Create all pages that do not exist yet. Returns page IDs keyed by definition.
 *
 * @return array
 */
function zamin_create_pages() {
	$ids    = get_option( 'zamin_page_ids', array() );
	$ids    = is_array( $ids ) ? $ids : array();
	$defs   = zamin_page_definitions();
	$map    = array();

	foreach ( $defs as $key => $definition ) {
		$existing = isset( $ids[ $key ] ) ? get_post( absint( $ids[ $key ] ) ) : null;
		if ( $existing && 'page' === $existing->post_type ) {
			$map[ $key ] = $existing->ID;
			continue;
		}

		$parent_id = ! empty( $definition['parent'] ) && isset( $map[ $definition['parent'] ] ) ? $map[ $definition['parent'] ] : 0;
		$lookup    = get_page_by_path( $parent_id ? get_page_uri( $parent_id ) . '/' . $definition['slug'] : $definition['slug'], OBJECT, 'page' );
		if ( $lookup ) {
			$map[ $key ] = $lookup->ID;
			$ids[ $key ] = $lookup->ID;
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $definition['title'],
				'post_name'    => $definition['slug'],
				'post_content' => $definition['content'],
				'post_parent'  => $parent_id,
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			$map[ $key ] = $post_id;
			$ids[ $key ] = $post_id;
		}
	}

	update_option( 'zamin_page_ids', $ids );

	if ( isset( $map['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', absint( $map['home'] ) );
		update_option( 'page_for_posts', 0 );
	}

	return $map;
}

/**
 * Seed taxonomy terms used by filters.
 */
function zamin_seed_terms() {
	$terms = array(
		'zamin_location' => array(
			'Hunza' => 'hunza', 'Gilgit' => 'gilgit', 'Skardu' => 'skardu',
			'Nagar' => 'nagar', 'Ghizer' => 'ghizer', 'Chilas' => 'chilas',
		),
		'zamin_property_type' => array(
			'House' => 'house', 'Apartment' => 'apartment', 'Land' => 'land', 'Commercial' => 'commercial',
		),
		'zamin_destination' => array(
			'Hunza Valley' => 'hunza', 'Upper Hunza (Gojal)' => 'gojal', 'Skardu & Baltistan' => 'skardu',
			'Naltar Valley' => 'naltar', 'Ghizer & Phander' => 'ghizer',
		),
		'zamin_stay_area' => array(
			'Karimabad' => 'karimabad', 'Aliabad' => 'aliabad', 'Altit' => 'altit', 'Ganish' => 'ganish',
			"Duikar (Eagle's Nest)" => 'duikar', 'Attabad Lake' => 'attabad-lake', 'Passu' => 'passu',
			'Gulmit' => 'gulmit', 'Sost' => 'sost', 'Shimshal' => 'shimshal', 'Skardu Town' => 'skardu-town',
			'Shangrila' => 'shangrila', 'Shigar' => 'shigar', 'Khaplu' => 'khaplu', 'Katpana Desert' => 'katpana',
			'Naltar Bala' => 'naltar-bala', 'Naltar Pain' => 'naltar-pain', 'Bashim' => 'bashim',
			'Phander' => 'phander', 'Gupis' => 'gupis', 'Yasin' => 'yasin', 'Ishkoman' => 'ishkoman',
		),
	);

	foreach ( zamin_stay_type_options() as $slug => $label ) {
		if ( $slug ) {
			$terms['zamin_stay_type'][ $label ] = sanitize_title( $label );
		}
	}

	foreach ( $terms as $taxonomy => $items ) {
		foreach ( $items as $name => $slug ) {
			if ( ! term_exists( $name, $taxonomy ) ) {
				wp_insert_term( $name, $taxonomy, array( 'slug' => $slug ) );
			}
		}
	}
}

/**
 * Create the primary and footer menus.
 */
function zamin_create_menus() {
	$ids     = get_option( 'zamin_page_ids', array() );
	$primary = wp_get_nav_menu_object( 'Zamin Primary' );
	if ( ! $primary ) {
		$primary_id = wp_create_nav_menu( 'Zamin Primary' );
	} else {
		$primary_id = $primary->term_id;
	}

	$primary_items = array(
		array( 'home', __( 'Home', 'zamin' ) ),
		array( 'properties-for-sale', __( 'Buy', 'zamin' ) ),
		array( 'properties-for-rent', __( 'Rent', 'zamin' ) ),
		array( 'stays', __( 'ZAMIN Stays', 'zamin' ) ),
		array( 'services', __( 'Services', 'zamin' ) ),
		array( 'sell-your-property', __( 'Sell', 'zamin' ) ),
		array( 'valuation', __( 'Valuation', 'zamin' ) ),
		array( 'contact', __( 'Contact', 'zamin' ) ),
	);

	$stays_children = array( 'stays-hunza', 'stays-gojal', 'stays-skardu', 'stays-naltar', 'stays-ghizer' );
	$stays_parent_item = 0;
	$existing = wp_get_nav_menu_items( $primary_id );
	$by_object = array();
	foreach ( (array) $existing as $item ) {
		if ( 'page' === $item->object ) {
			$by_object[ $item->object_id ] = $item->ID;
		}
	}

	foreach ( $primary_items as $item ) {
		if ( empty( $ids[ $item[0] ] ) ) {
			continue;
		}
		$page_id = absint( $ids[ $item[0] ] );
		$menu_item_id = isset( $by_object[ $page_id ] ) ? $by_object[ $page_id ] : wp_update_nav_menu_item(
			$primary_id,
			0,
			array(
				'menu-item-title'     => $item[1],
				'menu-item-object-id' => $page_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
		if ( 'stays' === $item[0] ) {
			$stays_parent_item = $menu_item_id;
		}
	}

	if ( $stays_parent_item ) {
		foreach ( $stays_children as $key ) {
			if ( empty( $ids[ $key ] ) || isset( $by_object[ $ids[ $key ] ] ) ) {
				continue;
			}
			wp_update_nav_menu_item(
				$primary_id,
				0,
				array(
					'menu-item-title'     => get_the_title( absint( $ids[ $key ] ) ),
					'menu-item-object-id' => absint( $ids[ $key ] ),
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-parent-id' => $stays_parent_item,
					'menu-item-status'    => 'publish',
				)
			);
		}
	}

	$footer = wp_get_nav_menu_object( 'Zamin Footer' );
	if ( ! $footer ) {
		$footer_id = wp_create_nav_menu( 'Zamin Footer' );
	} else {
		$footer_id = $footer->term_id;
	}
	$footer_items = array( 'properties-for-sale', 'properties-for-rent', 'sell-your-property', 'valuation', 'services', 'stays', 'stays-host', 'stays-managed', 'privacy' );
	foreach ( $footer_items as $key ) {
		if ( empty( $ids[ $key ] ) ) {
			continue;
		}
		$page_id = absint( $ids[ $key ] );
		$footer_existing = wp_get_nav_menu_items( $footer_id );
		$already = false;
		foreach ( (array) $footer_existing as $item ) {
			if ( 'page' === $item->object && absint( $item->object_id ) === $page_id ) {
				$already = true;
				break;
			}
		}
		if ( $already ) {
			continue;
		}
		wp_update_nav_menu_item(
			$footer_id,
			0,
			array(
				'menu-item-title'     => get_the_title( $page_id ),
				'menu-item-object-id' => $page_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	set_theme_mod(
		'nav_menu_locations',
		array(
			'primary' => $primary_id,
			'footer'  => $footer_id,
		)
	);
}

/**
 * Register the settings page.
 */
function zamin_add_settings_page() {
	add_theme_page(
		__( 'Zamin Settings', 'zamin' ),
		__( 'Zamin Settings', 'zamin' ),
		'manage_options',
		'zamin-settings',
		'zamin_render_settings_page'
	);
}

/**
 * Register settings.
 */
function zamin_register_settings() {
	register_setting( 'zamin_settings_group', 'zamin_settings', 'zamin_sanitize_settings' );
}

/**
 * Sanitize settings.
 *
 * @param array $input Raw settings.
 * @return array
 */
function zamin_sanitize_settings( $input ) {
	$output = array();
	foreach ( zamin_default_settings() as $key => $default ) {
		$output[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( wp_unslash( $input[ $key ] ) ) : $default;
	}
	$output['email']              = sanitize_email( $output['email'] );
	$output['notification_email'] = sanitize_email( $output['notification_email'] );
	return $output;
}

/**
 * Render settings page.
 */
function zamin_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$settings = get_option( 'zamin_settings', zamin_default_settings() );
	?>
	<div class="wrap">
		<h1><?php echo esc_html__( 'Zamin Settings', 'zamin' ); ?></h1>
		<p><?php echo esc_html__( 'These details appear in the header, footer, contact page and on all enquiry forms.', 'zamin' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'zamin_settings_group' ); ?>
			<table class="form-table" role="presentation">
				<?php
				$labels = array(
					'phone'              => __( 'Phone (display)', 'zamin' ),
					'phone_digits'       => __( 'Phone (tel: link digits)', 'zamin' ),
					'email'              => __( 'Email', 'zamin' ),
					'whatsapp'           => __( 'WhatsApp number (digits only)', 'zamin' ),
					'address'            => __( 'Office address', 'zamin' ),
					'hours'              => __( 'Office hours', 'zamin' ),
					'notification_email' => __( 'Send form notifications to', 'zamin' ),
				);
				foreach ( $labels as $key => $label ) :
					?>
					<tr>
						<th scope="row"><label for="zamin-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
						<td><input type="text" class="regular-text" id="zamin-<?php echo esc_attr( $key ); ?>" name="zamin_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( isset( $settings[ $key ] ) ? $settings[ $key ] : '' ); ?>"></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button(); ?>
		</form>
		<hr>
		<h2><?php echo esc_html__( 'Pages & menus', 'zamin' ); ?></h2>
		<p><?php echo esc_html__( 'The theme creates all pages and menus when activated. Use this button if any of them were deleted or if you want to refresh their content.', 'zamin' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="zamin_create_pages">
			<?php wp_nonce_field( 'zamin_create_pages' ); ?>
			<?php submit_button( __( 'Create / restore pages and menus', 'zamin' ), 'secondary' ); ?>
		</form>
	</div>
	<?php
}

/**
 * Handle manual page creation.
 */
function zamin_admin_create_pages() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'zamin_create_pages' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'zamin' ) );
	}
	zamin_seed_terms();
	zamin_create_pages();
	zamin_create_menus();
	zamin_ensure_permalinks();
	flush_rewrite_rules( false );
	wp_safe_redirect( admin_url( 'themes.php?page=zamin-settings&zamin_pages=created' ) );
	exit;
}

/**
 * Show a short activation notice.
 */
function zamin_activation_notice() {
	if ( get_transient( 'zamin_activated' ) ) {
		delete_transient( 'zamin_activated' );
		echo '<div class="notice notice-success is-dismissible"><p>' . sprintf(
			/* translators: %s: settings page link */
			esc_html__( 'Zamin theme activated. All pages, menus and listings types are ready. Review %s.', 'zamin' ),
			'<a href="' . esc_url( admin_url( 'themes.php?page=zamin-settings' ) ) . '">' . esc_html__( 'Zamin Settings', 'zamin' ) . '</a>'
		) . '</p></div>';
	}
	if ( isset( $_GET['zamin_pages'] ) && 'created' === $_GET['zamin_pages'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Zamin pages and menus have been created.', 'zamin' ) . '</p></div>';
	}
}
