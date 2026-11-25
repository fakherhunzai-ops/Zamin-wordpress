<?php
/**
 * Editable listing meta boxes (no third-party plugins required).
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'zamin_add_meta_boxes' );
add_action( 'save_post', 'zamin_save_meta_boxes', 10, 2 );

/**
 * Amenities offered by stays in Gilgit-Baltistan.
 *
 * @return array
 */
function zamin_amenity_options() {
	return array(
		'High-Speed Wi-Fi',
		'Dedicated Workspace',
		'24/7 Solar / UPS Power',
		'24/7 Hot Water Geyser',
		'Private On-Site Parking',
		'Washer / Laundry',
		'Room Heating / Bukhari',
		'Panoramic Mountain View',
		'Private Lawn / Orchard',
		'Bonfire & Outdoor Sit-Out',
		'Equipped Guest Kitchen',
		'Local Breakfast Option',
		'On-Site Caretaker',
		'Airport Pickup (Request)',
		'First Aid & Safety Kit',
	);
}

/**
 * Meta box field definitions.
 *
 * @return array
 */
function zamin_meta_fields() {
	return array(
		'zamin_property' => array(
			'title'  => __( 'Property details', 'zamin' ),
			'fields' => array(
				array( 'key' => '_zamin_purpose', 'label' => __( 'Purpose', 'zamin' ), 'type' => 'select', 'options' => array( 'sale' => 'For sale', 'rent' => 'For rent' ) ),
				array( 'key' => '_zamin_price', 'label' => __( 'Price (PKR)', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_address', 'label' => __( 'Address / area', 'zamin' ), 'type' => 'text' ),
				array( 'key' => '_zamin_area_marla', 'label' => __( 'Area (marla)', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_bedrooms', 'label' => __( 'Bedrooms', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_bathrooms', 'label' => __( 'Bathrooms', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_verified', 'label' => __( 'Verified by Zamin', 'zamin' ), 'type' => 'checkbox' ),
				array( 'key' => '_zamin_featured', 'label' => __( 'Feature on homepage', 'zamin' ), 'type' => 'checkbox' ),
			),
		),
		'zamin_stay' => array(
			'title'  => __( 'Stay details', 'zamin' ),
			'fields' => array(
				array( 'key' => '_zamin_hosting_model', 'label' => __( 'Hosting model', 'zamin' ), 'type' => 'select', 'options' => array( 'listed' => 'Listed with ZAMIN', 'managed' => 'ZAMIN managed' ) ),
				array( 'key' => '_zamin_price_per_night', 'label' => __( 'Price per night (PKR)', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_max_guests', 'label' => __( 'Maximum guests', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_bedrooms', 'label' => __( 'Bedrooms', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_beds', 'label' => __( 'Beds', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_bathrooms', 'label' => __( 'Bathrooms', 'zamin' ), 'type' => 'number' ),
				array( 'key' => '_zamin_area', 'label' => __( 'Area / landmark', 'zamin' ), 'type' => 'text' ),
				array( 'key' => '_zamin_checkin', 'label' => __( 'Check-in time', 'zamin' ), 'type' => 'text' ),
				array( 'key' => '_zamin_checkout', 'label' => __( 'Check-out time', 'zamin' ), 'type' => 'text' ),
				array( 'key' => '_zamin_amenities', 'label' => __( 'Amenities', 'zamin' ), 'type' => 'multicheck', 'options' => zamin_amenity_options() ),
				array( 'key' => '_zamin_verified', 'label' => __( 'Verified by ZAMIN', 'zamin' ), 'type' => 'checkbox' ),
				array( 'key' => '_zamin_featured', 'label' => __( 'Feature on homepage', 'zamin' ), 'type' => 'checkbox' ),
			),
		),
	);
}

/**
 * Register meta boxes.
 */
function zamin_add_meta_boxes() {
	foreach ( zamin_meta_fields() as $post_type => $config ) {
		add_meta_box(
			'zamin_details',
			$config['title'],
			'zamin_render_meta_box',
			$post_type,
			'normal',
			'high',
			array( 'fields' => $config['fields'] )
		);
	}
}

/**
 * Render a meta box.
 *
 * @param WP_Post $post Post object.
 * @param array   $args Callback args.
 */
function zamin_render_meta_box( $post, $args ) {
	$fields = isset( $args['args']['fields'] ) ? $args['args']['fields'] : array();
	wp_nonce_field( 'zamin_save_details', 'zamin_details_nonce' );

	echo '<div class="zamin-meta-box">';
	foreach ( $fields as $field ) {
		$value = get_post_meta( $post->ID, $field['key'], true );
		echo '<p><label for="' . esc_attr( $field['key'] ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label><br>';

		if ( 'checkbox' === $field['type'] ) {
			echo '<input type="checkbox" id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '" value="1" ' . checked( $value, '1', false ) . '>';
		} elseif ( 'select' === $field['type'] ) {
			echo '<select id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '">';
			foreach ( $field['options'] as $option_value => $option_label ) {
				echo '<option value="' . esc_attr( $option_value ) . '" ' . selected( $value, $option_value, false ) . '>' . esc_html( $option_label ) . '</option>';
			}
			echo '</select>';
		} elseif ( 'multicheck' === $field['type'] ) {
			$selected = is_array( $value ) ? $value : array();
			echo '<span class="zamin-meta-checks">';
			foreach ( $field['options'] as $option ) {
				echo '<label style="display:block;margin:4px 0"><input type="checkbox" name="' . esc_attr( $field['key'] ) . '[]" value="' . esc_attr( $option ) . '" ' . checked( in_array( $option, $selected, true ), true, false ) . '> ' . esc_html( $option ) . '</label>';
			}
			echo '</span>';
		} elseif ( 'number' === $field['type'] ) {
			echo '<input type="number" min="0" step="1" id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '" value="' . esc_attr( $value ) . '" class="small-text">';
		} else {
			echo '<input type="text" id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '" value="' . esc_attr( $value ) . '" class="regular-text">';
		}
		echo '</p>';
	}
	echo '</div>';
}

/**
 * Save listing meta.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function zamin_save_meta_boxes( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['zamin_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['zamin_details_nonce'] ) ), 'zamin_save_details' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( ! isset( zamin_meta_fields()[ $post->post_type ] ) ) {
		return;
	}

	foreach ( zamin_meta_fields()[ $post->post_type ]['fields'] as $field ) {
		$key = $field['key'];
		if ( 'multicheck' === $field['type'] ) {
			$raw     = isset( $_POST[ $key ] ) && is_array( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : array();
			$allowed = $field['options'];
			$values  = array();
			foreach ( $raw as $item ) {
				$item = sanitize_text_field( $item );
				if ( in_array( $item, $allowed, true ) ) {
					$values[] = $item;
				}
			}
			update_post_meta( $post_id, $key, $values );
			continue;
		}

		if ( 'checkbox' === $field['type'] ) {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '' );
			continue;
		}

		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$value = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );
		if ( 'number' === $field['type'] ) {
			$value = '' === $value ? '' : absint( $value );
		}
		if ( 'select' === $field['type'] && ! array_key_exists( $value, $field['options'] ) ) {
			$value = '';
		}
		update_post_meta( $post_id, $key, $value );
	}
}
