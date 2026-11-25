<?php
/**
 * Custom post types and taxonomies for listings, enquiries and subscribers.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'zamin_register_post_types', 0 );
add_action( 'init', 'zamin_register_taxonomies', 0 );
add_filter( 'manage_zamin_property_posts_columns', 'zamin_property_columns' );
add_action( 'manage_zamin_property_posts_custom_column', 'zamin_property_column_content', 10, 2 );
add_filter( 'manage_zamin_stay_posts_columns', 'zamin_stay_columns' );
add_action( 'manage_zamin_stay_posts_custom_column', 'zamin_stay_column_content', 10, 2 );
add_filter( 'manage_zamin_enquiry_posts_columns', 'zamin_enquiry_columns' );
add_action( 'manage_zamin_enquiry_posts_custom_column', 'zamin_enquiry_column_content', 10, 2 );
add_filter( 'manage_zamin_subscriber_posts_columns', 'zamin_subscriber_columns' );
add_action( 'manage_zamin_subscriber_posts_custom_column', 'zamin_subscriber_column_content', 10, 2 );

/**
 * Register all post types used by the theme.
 */
function zamin_register_post_types() {
	$labels = array(
		'name'               => __( 'Properties', 'zamin' ),
		'singular_name'      => __( 'Property', 'zamin' ),
		'add_new'            => __( 'Add New', 'zamin' ),
		'add_new_item'       => __( 'Add New Property', 'zamin' ),
		'edit_item'          => __( 'Edit Property', 'zamin' ),
		'new_item'           => __( 'New Property', 'zamin' ),
		'view_item'          => __( 'View Property', 'zamin' ),
		'search_items'       => __( 'Search Properties', 'zamin' ),
		'not_found'          => __( 'No properties found', 'zamin' ),
		'not_found_in_trash' => __( 'No properties found in trash', 'zamin' ),
		'all_items'          => __( 'All Properties', 'zamin' ),
	);

	register_post_type(
		'zamin_property',
		array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'menu_position' => 21,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
			'rewrite'      => array( 'slug' => 'properties', 'with_front' => false ),
			'taxonomies'   => array( 'zamin_location', 'zamin_property_type' ),
		)
	);

	register_post_type(
		'zamin_stay',
		array(
			'labels'       => array(
				'name'               => __( 'Stays', 'zamin' ),
				'singular_name'      => __( 'Stay', 'zamin' ),
				'add_new_item'       => __( 'Add New Stay', 'zamin' ),
				'edit_item'          => __( 'Edit Stay', 'zamin' ),
				'view_item'          => __( 'View Stay', 'zamin' ),
				'search_items'       => __( 'Search Stays', 'zamin' ),
				'not_found'          => __( 'No stays found', 'zamin' ),
				'all_items'          => __( 'All Stays', 'zamin' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-admin-home',
			'menu_position' => 22,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
			/* "stays" is a real page tree on the source site (/stays/hunza/ etc.),
			   so the post type uses the singular slug to avoid a rewrite clash. */
			'rewrite'      => array( 'slug' => 'stay', 'with_front' => false ),
			'taxonomies'   => array( 'zamin_destination', 'zamin_stay_area', 'zamin_stay_type' ),
		)
	);

	$private_args = array(
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'supports'            => array( 'title', 'editor', 'custom-fields' ),
		'capability_type'     => 'post',
	);

	register_post_type(
		'zamin_enquiry',
		array_merge(
			$private_args,
			array(
				'labels'     => array(
					'name'          => __( 'Enquiries', 'zamin' ),
					'singular_name' => __( 'Enquiry', 'zamin' ),
					'all_items'     => __( 'All Enquiries', 'zamin' ),
				),
				'menu_icon'  => 'dashicons-email-alt',
				'menu_position' => 25,
			)
		)
	);

	register_post_type(
		'zamin_subscriber',
		array_merge(
			$private_args,
			array(
				'labels'     => array(
					'name'          => __( 'Property Alerts', 'zamin' ),
					'singular_name' => __( 'Subscriber', 'zamin' ),
					'all_items'     => __( 'Property Alerts', 'zamin' ),
				),
				'menu_icon'  => 'dashicons-bell',
				'menu_position' => 26,
			)
		)
	);
}

/**
 * Register listing taxonomies.
 */
function zamin_register_taxonomies() {
	$taxonomies = array(
		'zamin_location' => array(
			'object_type' => array( 'zamin_property' ),
			'labels'      => array(
				'name'          => __( 'Locations', 'zamin' ),
				'singular_name' => __( 'Location', 'zamin' ),
				'all_items'     => __( 'All Locations', 'zamin' ),
			),
			'slug'        => 'property-location',
		),
		'zamin_property_type' => array(
			'object_type' => array( 'zamin_property' ),
			'labels'      => array(
				'name'          => __( 'Property Types', 'zamin' ),
				'singular_name' => __( 'Property Type', 'zamin' ),
				'all_items'     => __( 'All Property Types', 'zamin' ),
			),
			'slug'        => 'property-type',
		),
		'zamin_destination' => array(
			'object_type' => array( 'zamin_stay' ),
			'labels'      => array(
				'name'          => __( 'Destinations', 'zamin' ),
				'singular_name' => __( 'Destination', 'zamin' ),
				'all_items'     => __( 'All Destinations', 'zamin' ),
			),
			'slug'        => 'stay-destination',
		),
		'zamin_stay_area' => array(
			'object_type' => array( 'zamin_stay' ),
			'labels'      => array(
				'name'          => __( 'Stay Areas', 'zamin' ),
				'singular_name' => __( 'Stay Area', 'zamin' ),
				'all_items'     => __( 'All Stay Areas', 'zamin' ),
			),
			'slug'        => 'stay-area',
		),
		'zamin_stay_type' => array(
			'object_type' => array( 'zamin_stay' ),
			'labels'      => array(
				'name'          => __( 'Stay Types', 'zamin' ),
				'singular_name' => __( 'Stay Type', 'zamin' ),
				'all_items'     => __( 'All Stay Types', 'zamin' ),
			),
			'slug'        => 'stay-type',
		),
	);

	foreach ( $taxonomies as $taxonomy => $args ) {
		register_taxonomy(
			$taxonomy,
			$args['object_type'],
			array(
				'labels'            => $args['labels'],
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => $args['slug'], 'with_front' => false ),
				'show_admin_column' => true,
			)
		);
	}
}

/**
 * Property admin columns.
 *
 * @param array $columns Columns.
 * @return array
 */
function zamin_property_columns( $columns ) {
	unset( $columns['date'] );
	$columns['zamin_purpose']   = __( 'Purpose', 'zamin' );
	$columns['zamin_price']     = __( 'Price', 'zamin' );
	$columns['zamin_location']  = __( 'Location', 'zamin' );
	$columns['zamin_status']    = __( 'Status', 'zamin' );
	$columns['date']            = __( 'Date', 'zamin' );
	return $columns;
}

/**
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function zamin_property_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'zamin_purpose':
			echo esc_html( ucfirst( (string) get_post_meta( $post_id, '_zamin_purpose', true ) ) );
			break;
		case 'zamin_price':
			echo esc_html( zamin_price( get_post_meta( $post_id, '_zamin_price', true ) ) );
			break;
		case 'zamin_location':
			echo esc_html( zamin_terms_label( $post_id, 'zamin_location' ) );
			break;
		case 'zamin_status':
			echo get_post_meta( $post_id, '_zamin_verified', true ) ? esc_html__( 'Verified', 'zamin' ) : esc_html__( 'Pending', 'zamin' );
			break;
	}
}

/**
 * Stay admin columns.
 *
 * @param array $columns Columns.
 * @return array
 */
function zamin_stay_columns( $columns ) {
	unset( $columns['date'] );
	$columns['zamin_destination'] = __( 'Destination', 'zamin' );
	$columns['zamin_nightly']     = __( 'PKR / night', 'zamin' );
	$columns['zamin_guests']      = __( 'Max guests', 'zamin' );
	$columns['zamin_status']      = __( 'Status', 'zamin' );
	$columns['date']              = __( 'Date', 'zamin' );
	return $columns;
}

/**
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function zamin_stay_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'zamin_destination':
			echo esc_html( zamin_terms_label( $post_id, 'zamin_destination' ) );
			break;
		case 'zamin_nightly':
			echo esc_html( zamin_price( get_post_meta( $post_id, '_zamin_price_per_night', true ) ) );
			break;
		case 'zamin_guests':
			echo esc_html( (string) get_post_meta( $post_id, '_zamin_max_guests', true ) );
			break;
		case 'zamin_status':
			echo get_post_meta( $post_id, '_zamin_verified', true ) ? esc_html__( 'Verified', 'zamin' ) : esc_html__( 'Pending', 'zamin' );
			break;
	}
}

/**
 * Enquiry admin columns.
 *
 * @param array $columns Columns.
 * @return array
 */
function zamin_enquiry_columns( $columns ) {
	unset( $columns['date'] );
	$columns['zamin_type']  = __( 'Type', 'zamin' );
	$columns['zamin_name']  = __( 'Name', 'zamin' );
	$columns['zamin_email'] = __( 'Email', 'zamin' );
	$columns['date']        = __( 'Submitted', 'zamin' );
	return $columns;
}

/**
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function zamin_enquiry_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'zamin_type':
			echo esc_html( str_replace( '_', ' ', ucfirst( (string) get_post_meta( $post_id, '_zamin_form_type', true ) ) ) );
			break;
		case 'zamin_name':
			echo esc_html( (string) get_post_meta( $post_id, '_zamin_name', true ) );
			break;
		case 'zamin_email':
			echo esc_html( (string) get_post_meta( $post_id, '_zamin_email', true ) );
			break;
	}
}

/**
 * Subscriber admin columns.
 *
 * @param array $columns Columns.
 * @return array
 */
function zamin_subscriber_columns( $columns ) {
	unset( $columns['date'] );
	$columns['zamin_email']    = __( 'Email', 'zamin' );
	$columns['zamin_interest'] = __( 'Interest', 'zamin' );
	$columns['date']           = __( 'Subscribed', 'zamin' );
	return $columns;
}

/**
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function zamin_subscriber_column_content( $column, $post_id ) {
	if ( 'zamin_email' === $column ) {
		echo esc_html( (string) get_post_meta( $post_id, '_zamin_email', true ) );
	}
	if ( 'zamin_interest' === $column ) {
		echo esc_html( (string) get_post_meta( $post_id, '_zamin_interest', true ) );
	}
}

/**
 * Comma separated term names.
 *
 * @param int    $post_id  Post ID.
 * @param string $taxonomy Taxonomy slug.
 * @return string
 */
function zamin_terms_label( $post_id, $taxonomy ) {
	$terms = get_the_terms( $post_id, $taxonomy );
	if ( is_wp_error( $terms ) || ! $terms ) {
		return '&mdash;';
	}
	$names = wp_list_pluck( $terms, 'name' );
	return implode( ', ', $names );
}
