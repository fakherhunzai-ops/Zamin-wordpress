<?php
/**
 * Enquiry, valuation, alert and host application forms.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_zamin_form_submit', 'zamin_handle_form_submit' );
add_action( 'wp_ajax_nopriv_zamin_form_submit', 'zamin_handle_form_submit' );

/**
 * Destinations and their areas (used by search and host forms).
 *
 * @return array
 */
function zamin_destination_data() {
	return array(
		'hunza'  => array(
			'label' => __( 'Hunza Valley', 'zamin' ),
			'desc'  => __( 'Terraced apricot orchards beneath Rakaposhi and Ultar Sar', 'zamin' ),
			'areas' => array( 'Karimabad', 'Aliabad', 'Altit', 'Ganish', "Duikar (Eagle's Nest)" ),
		),
		'gojal'  => array(
			'label' => __( 'Upper Hunza (Gojal)', 'zamin' ),
			'desc'  => __( 'Turquoise Attabad Lake, Passu Cones, and high-altitude retreats', 'zamin' ),
			'areas' => array( 'Attabad Lake', 'Passu', 'Gulmit', 'Sost', 'Shimshal' ),
		),
		'skardu' => array(
			'label' => __( 'Skardu & Baltistan', 'zamin' ),
			'desc'  => __( 'Gateway to K2, Shangrila Lake, cold deserts, and Shigar forts', 'zamin' ),
			'areas' => array( 'Skardu Town', 'Shangrila', 'Shigar', 'Khaplu', 'Katpana Desert' ),
		),
		'naltar' => array(
			'label' => __( 'Naltar Valley', 'zamin' ),
			'desc'  => __( 'Alpine pine forests, emerald lakes, and winter ski slopes', 'zamin' ),
			'areas' => array( 'Naltar Bala', 'Naltar Pain', 'Bashim', 'Naltar Lakes' ),
		),
		'ghizer' => array(
			'label' => __( 'Ghizer & Phander', 'zamin' ),
			'desc'  => __( 'Trout-filled turquoise rivers and unhurried valley meadows', 'zamin' ),
			'areas' => array( 'Phander', 'Gupis', 'Yasin', 'Ishkoman', 'Ghizer River' ),
		),
	);
}

/**
 * Form definitions.
 *
 * @return array
 */
function zamin_form_configs() {
	$locations = array(
		''       => __( 'Select…', 'zamin' ),
		'Hunza'  => 'Hunza',
		'Gilgit' => 'Gilgit',
		'Skardu' => 'Skardu',
		'Nagar'  => 'Nagar',
		'Ghizer' => 'Ghizer',
		'Chilas' => 'Chilas',
		'Other'  => __( 'Other area', 'zamin' ),
	);

	$property_types = array(
		''           => __( 'Select…', 'zamin' ),
		'House'      => 'House',
		'Apartment'  => 'Apartment',
		'Land / Plot' => 'Land / Plot',
		'Commercial' => 'Commercial',
	);

	return array(
		'contact' => array(
			'title'   => __( 'Send Us a Message', 'zamin' ),
			'note'    => __( 'Fill in the form and a member of our team will get back to you.', 'zamin' ),
			'submit'  => __( 'Send Message', 'zamin' ),
			'success' => __( 'Thank you — your message has been sent. A Zamin advisor will be in touch shortly.', 'zamin' ),
			'store'   => 'enquiry',
			'fields'  => array(
				array( 'name' => 'name', 'label' => __( 'Name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array( 'name' => 'phone', 'label' => __( 'Phone', 'zamin' ), 'type' => 'tel', 'required' => true ),
				array( 'name' => 'email', 'label' => __( 'Email', 'zamin' ), 'type' => 'email', 'required' => true ),
				array(
					'name' => 'enquiry_type', 'label' => __( 'Enquiry Type', 'zamin' ), 'type' => 'select', 'required' => true,
					'options' => array(
						'' => __( 'Select a topic…', 'zamin' ),
						'Buying a Property' => __( 'Buying a Property', 'zamin' ),
						'Selling a Property' => __( 'Selling a Property', 'zamin' ),
						'Renting a Property' => __( 'Renting a Property', 'zamin' ),
						'Property Valuation' => __( 'Property Valuation', 'zamin' ),
						'Investment Advisory' => __( 'Investment Advisory', 'zamin' ),
						'General Enquiry' => __( 'General Enquiry', 'zamin' ),
					),
				),
				array( 'name' => 'message', 'label' => __( 'Message', 'zamin' ), 'type' => 'textarea', 'required' => true, 'full' => true, 'counter' => 500 ),
			),
		),
		'valuation' => array(
			'title'   => __( 'Request Your Free Valuation', 'zamin' ),
			'note'    => __( 'Fill in the details below and we will get straight back to you.', 'zamin' ),
			'submit'  => __( 'Request Free Valuation', 'zamin' ),
			'success' => __( 'Thanks — we have your valuation request. An advisor will arrange your free assessment.', 'zamin' ),
			'store'   => 'enquiry',
			'fields'  => array(
				array( 'name' => 'property_type', 'label' => __( 'Property Type', 'zamin' ), 'type' => 'select', 'required' => true, 'options' => $property_types ),
				array( 'name' => 'location', 'label' => __( 'Location', 'zamin' ), 'type' => 'select', 'required' => true, 'options' => $locations ),
				array( 'name' => 'area_marla', 'label' => __( 'Area (Marla)', 'zamin' ), 'type' => 'number', 'required' => true ),
				array( 'name' => 'bedrooms', 'label' => __( 'Bedrooms', 'zamin' ), 'type' => 'number' ),
				array(
					'name' => 'condition', 'label' => __( 'Property Condition', 'zamin' ), 'type' => 'select', 'required' => true,
					'options' => array(
						'' => __( 'Select…', 'zamin' ),
						'Excellent' => __( 'Excellent', 'zamin' ),
						'Good' => __( 'Good', 'zamin' ),
						'Fair' => __( 'Fair', 'zamin' ),
						'Needs renovation' => __( 'Needs renovation', 'zamin' ),
					),
				),
				array( 'name' => 'owner_name', 'label' => __( 'Owner Name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array( 'name' => 'phone', 'label' => __( 'Phone', 'zamin' ), 'type' => 'tel', 'required' => true ),
				array( 'name' => 'email', 'label' => __( 'Email', 'zamin' ), 'type' => 'email', 'required' => true, 'full' => true ),
			),
		),
		'sell' => array(
			'title'   => __( 'Submit Your Property Details', 'zamin' ),
			'note'    => __( 'Fill in the form below and we will be in touch to arrange your free valuation. It only takes a couple of minutes.', 'zamin' ),
			'submit'  => __( 'Submit Property', 'zamin' ),
			'success' => __( 'Your property details have been received. Our team will call to arrange a free valuation.', 'zamin' ),
			'store'   => 'enquiry',
			'fields'  => array(
				array( 'name' => 'owner_name', 'label' => __( 'Owner Name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array( 'name' => 'phone', 'label' => __( 'Phone', 'zamin' ), 'type' => 'tel', 'required' => true ),
				array( 'name' => 'email', 'label' => __( 'Email', 'zamin' ), 'type' => 'email', 'required' => true ),
				array(
					'name' => 'intent', 'label' => __( 'I want to', 'zamin' ), 'type' => 'select', 'required' => true,
					'options' => array( '' => __( 'Select…', 'zamin' ), 'Sell my property' => __( 'Sell my property', 'zamin' ), 'Rent out my property' => __( 'Rent out my property', 'zamin' ) ),
				),
				array( 'name' => 'property_type', 'label' => __( 'Property Type', 'zamin' ), 'type' => 'select', 'required' => true, 'options' => $property_types ),
				array( 'name' => 'location', 'label' => __( 'Location', 'zamin' ), 'type' => 'select', 'required' => true, 'options' => $locations ),
				array( 'name' => 'address', 'label' => __( 'Property Address / Area', 'zamin' ), 'type' => 'text', 'required' => true, 'full' => true ),
				array( 'name' => 'expected_price', 'label' => __( 'Expected Price (PKR)', 'zamin' ), 'type' => 'number', 'required' => true ),
				array( 'name' => 'area_marla', 'label' => __( 'Area (Marla)', 'zamin' ), 'type' => 'number', 'required' => true ),
				array( 'name' => 'bedrooms', 'label' => __( 'Bedrooms', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'bathrooms', 'label' => __( 'Bathrooms', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'description', 'label' => __( 'Description', 'zamin' ), 'type' => 'textarea', 'full' => true, 'counter' => 500 ),
				array(
					'name' => 'images', 'label' => __( 'Property Images', 'zamin' ), 'type' => 'file', 'full' => true,
					'hint' => __( 'Optional. You can also share photos with your agent after submitting.', 'zamin' ),
				),
			),
		),
		'alert' => array(
			'title'   => __( 'Get property alerts', 'zamin' ),
			'note'    => __( 'Be first to know when new homes, plots and rentals hit the market across Hunza, Gilgit, Skardu and beyond. Fresh listings and local market updates, straight to your inbox.', 'zamin' ),
			'submit'  => __( 'Get Alerts', 'zamin' ),
			'success' => __( 'You are subscribed. We will send new listings and market updates to your inbox.', 'zamin' ),
			'store'   => 'subscriber',
			'fields'  => array(
				array( 'name' => 'email', 'label' => __( 'Email address', 'zamin' ), 'type' => 'email', 'required' => true ),
				array(
					'name' => 'interest', 'label' => __( 'I am interested in', 'zamin' ), 'type' => 'select',
					'options' => array(
						'Buying' => __( 'Buying', 'zamin' ),
						'Renting' => __( 'Renting', 'zamin' ),
						'Investing' => __( 'Investing', 'zamin' ),
						'Selling' => __( 'Selling', 'zamin' ),
					),
				),
				array(
					'name' => 'consent', 'label' => __( 'I agree to receive Gilgit-Baltistan property alerts and market updates from ZAMIN Real Estate. Unsubscribe anytime.', 'zamin' ),
					'type' => 'checkbox', 'required' => true, 'full' => true,
					'note' => sprintf( '<a href="%s">%s</a>', esc_url( zamin_page_url( 'privacy' ) ), esc_html__( 'Privacy Policy', 'zamin' ) ),
				),
			),
		),
		'host_apply' => array(
			'title'   => __( 'List your property on ZAMIN Stays', 'zamin' ),
			'note'    => __( 'Tell us about your property in Gilgit-Baltistan. Your application goes straight to our team as a pending review — we will get in touch to arrange an inspection.', 'zamin' ),
			'submit'  => __( 'Submit for review', 'zamin' ),
			'success' => __( 'Application received. Our stays team will contact you to arrange an inspection. Submitting does not publish your property.', 'zamin' ),
			'store'   => 'enquiry',
			'fields'  => array(
				array( 'name' => 'full_name', 'label' => __( 'Full name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array( 'name' => 'phone', 'label' => __( 'Phone / WhatsApp', 'zamin' ), 'type' => 'tel', 'required' => true ),
				array( 'name' => 'email', 'label' => __( 'Email', 'zamin' ), 'type' => 'email' ),
				array( 'name' => 'property_name', 'label' => __( 'Property name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array(
					'name' => 'hosting_model', 'label' => __( 'Hosting model', 'zamin' ), 'type' => 'radio',
					'options' => array(
						'Listed with ZAMIN' => __( 'List with ZAMIN — you run the property; we bring the guests.', 'zamin' ),
						'ZAMIN managed' => __( 'ZAMIN manages it — we handle pricing, guests, cleaning.', 'zamin' ),
					),
					'full' => true,
				),
				array( 'name' => 'destination', 'label' => __( 'Destination', 'zamin' ), 'type' => 'select', 'required' => true, 'dependent' => 'area', 'options' => zamin_destination_options() ),
				array( 'name' => 'area', 'label' => __( 'Area', 'zamin' ), 'type' => 'select', 'hint' => __( 'Choose a destination first', 'zamin' ), 'options' => array( '' => __( 'Choose a destination first', 'zamin' ) ) ),
				array( 'name' => 'stay_type', 'label' => __( 'Stay type', 'zamin' ), 'type' => 'select', 'options' => zamin_stay_type_options() ),
				array( 'name' => 'address', 'label' => __( 'Address / landmark', 'zamin' ), 'type' => 'text', 'full' => true ),
				array( 'name' => 'bedrooms', 'label' => __( 'Bedrooms', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'beds', 'label' => __( 'Beds', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'bathrooms', 'label' => __( 'Bathrooms', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'max_guests', 'label' => __( 'Max guests', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'price_per_night', 'label' => __( 'PKR / night', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'description', 'label' => __( 'Description', 'zamin' ), 'type' => 'textarea', 'full' => true, 'counter' => 500 ),
				array( 'name' => 'amenities', 'label' => __( 'Amenities', 'zamin' ), 'type' => 'multicheck', 'full' => true, 'options' => zamin_amenity_options() ),
				array( 'name' => 'house_rules', 'label' => __( 'House rules', 'zamin' ), 'type' => 'textarea', 'full' => true, 'counter' => 500 ),
				array(
					'name' => 'ownership', 'label' => __( 'Ownership / authorization', 'zamin' ), 'type' => 'text', 'full' => true,
					'hint' => __( 'Kept private and used only for verification — never shown publicly.', 'zamin' ),
				),
			),
		),
		'booking' => array(
			'title'   => __( 'Enquire About This Stay', 'zamin' ),
			'note'    => __( 'Send your dates and questions to the Zamin Stays team.', 'zamin' ),
			'submit'  => __( 'Send Enquiry', 'zamin' ),
			'success' => __( 'Thanks — our stays team will confirm availability and pricing shortly.', 'zamin' ),
			'store'   => 'enquiry',
			'fields'  => array(
				array( 'name' => 'name', 'label' => __( 'Name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array( 'name' => 'email', 'label' => __( 'Email', 'zamin' ), 'type' => 'email', 'required' => true ),
				array( 'name' => 'phone', 'label' => __( 'Phone / WhatsApp', 'zamin' ), 'type' => 'tel' ),
				array( 'name' => 'checkin', 'label' => __( 'Check-in', 'zamin' ), 'type' => 'date' ),
				array( 'name' => 'checkout', 'label' => __( 'Check-out', 'zamin' ), 'type' => 'date' ),
				array( 'name' => 'guests', 'label' => __( 'Guests', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'message', 'label' => __( 'Message', 'zamin' ), 'type' => 'textarea', 'full' => true, 'counter' => 500 ),
			),
		),
		'viewing' => array(
			'title'   => __( 'Request a Viewing', 'zamin' ),
			'note'    => __( 'Ask a question or arrange a viewing with a local Zamin advisor.', 'zamin' ),
			'submit'  => __( 'Request Viewing', 'zamin' ),
			'success' => __( 'Thanks — an advisor will contact you about this property shortly.', 'zamin' ),
			'store'   => 'enquiry',
			'fields'  => array(
				array( 'name' => 'name', 'label' => __( 'Name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array( 'name' => 'phone', 'label' => __( 'Phone', 'zamin' ), 'type' => 'tel', 'required' => true ),
				array( 'name' => 'email', 'label' => __( 'Email', 'zamin' ), 'type' => 'email', 'required' => true ),
				array( 'name' => 'message', 'label' => __( 'Message', 'zamin' ), 'type' => 'textarea', 'full' => true, 'counter' => 500 ),
			),
		),
		'stay_match' => array(
			'title'   => __( 'Plan My Stay', 'zamin' ),
			'note'    => __( 'Tell us where you want to go and how you like to travel. Our local team will match you with the right verified stay.', 'zamin' ),
			'submit'  => __( 'Send Request', 'zamin' ),
			'success' => __( 'Thanks — our stays team will be in touch with matched stays shortly.', 'zamin' ),
			'store'   => 'enquiry',
			'fields'  => array(
				array( 'name' => 'name', 'label' => __( 'Name', 'zamin' ), 'type' => 'text', 'required' => true ),
				array( 'name' => 'email', 'label' => __( 'Email', 'zamin' ), 'type' => 'email', 'required' => true ),
				array( 'name' => 'destination', 'label' => __( 'Destination', 'zamin' ), 'type' => 'select', 'options' => zamin_destination_options() ),
				array( 'name' => 'guests', 'label' => __( 'Guests', 'zamin' ), 'type' => 'number' ),
				array( 'name' => 'message', 'label' => __( 'Message', 'zamin' ), 'type' => 'textarea', 'full' => true, 'counter' => 500 ),
			),
		),
	);
}

/**
 * Destination options for select fields.
 *
 * @return array
 */
function zamin_destination_options() {
	$options = array( '' => __( 'Anywhere in Gilgit-Baltistan', 'zamin' ) );
	foreach ( zamin_destination_data() as $key => $data ) {
		$options[ $key ] = $data['label'];
	}
	return $options;
}

/**
 * Stay type options.
 *
 * @return array
 */
function zamin_stay_type_options() {
	$types = array(
		'Mountain Villa', 'Cabin & Chalet', 'Lakeside Retreat', 'Boutique Lodge',
		'Heritage Home', 'Orchard Cottage', 'Family Homestay', 'Serviced Apartment',
		'Workation Stay', 'Glamping & Dome', 'Riverside Stay', 'Eco Retreat',
		'Guest House', 'Farm Stay', 'Winter & Ski Stay', 'Group Estate',
	);
	$options = array( '' => __( 'Select a type', 'zamin' ) );
	foreach ( $types as $type ) {
		$options[ $type ] = $type;
	}
	return $options;
}

/**
 * Render a form.
 *
 * @param string $type Form key.
 * @param bool   $panel Whether to wrap in a form panel.
 */
function zamin_render_form( $type, $panel = true ) {
	$configs = zamin_form_configs();
	if ( ! isset( $configs[ $type ] ) ) {
		return;
	}
	$config = $configs[ $type ];

	if ( $panel ) {
		echo '<div class="z-form-panel">';
	}
	echo '<h3 class="z-form-panel__title">' . esc_html( $config['title'] ) . '</h3>';
	echo '<p class="z-form-panel__note">' . esc_html( $config['note'] ) . '</p>';
	echo '<form class="zamin-form" method="post" enctype="multipart/form-data" data-zamin-form="' . esc_attr( $type ) . '">';
	wp_nonce_field( 'zamin-form', 'zamin_nonce' );
	echo '<div class="z-field z-field--honeypot" aria-hidden="true"><label for="zamin_website">' . esc_html__( 'Website', 'zamin' ) . '</label><input type="text" id="zamin_website" name="zamin_website" tabindex="-1" autocomplete="off"></div>';
	echo '<input type="hidden" name="zamin_form" value="' . esc_attr( $type ) . '">';
	echo '<div class="z-form-grid">';

	foreach ( $config['fields'] as $field ) {
		zamin_render_form_field( $field );
	}

	echo '</div>';
	echo '<div class="z-form-actions"><button type="submit" class="z-btn z-btn--primary">' . esc_html( $config['submit'] ) . '</button>';
	if ( 'sell' === $type ) {
		echo '<small>' . esc_html__( 'Fields marked * are required.', 'zamin' ) . '</small>';
	}
	if ( 'host_apply' === $type ) {
		echo '<small>' . esc_html__( "Submitting doesn't publish your property — our team reviews every application first.", 'zamin' ) . '</small>';
	}
	echo '</div>';
	echo '<div class="z-form-message" data-form-message role="status" aria-live="polite"></div>';
	echo '</form>';
	if ( $panel ) {
		echo '</div>';
	}
}

/**
 * Render one form field.
 *
 * @param array $field Field config.
 */
function zamin_render_form_field( $field ) {
	$name     = isset( $field['name'] ) ? $field['name'] : '';
	$type     = isset( $field['type'] ) ? $field['type'] : 'text';
	$label    = isset( $field['label'] ) ? $field['label'] : '';
	$required = ! empty( $field['required'] );
	$full     = ! empty( $field['full'] );
	$id       = 'zamin-field-' . $name;
	$classes  = 'z-field' . ( $full ? ' z-field--full' : '' );
	$attrs    = '';

	if ( 'checkbox' === $type || 'radio' === $type || 'multicheck' === $type ) {
		$classes .= ' z-field--full';
	}
	if ( isset( $field['dependent'] ) ) {
		$attrs .= ' data-dependent="' . esc_attr( $field['dependent'] ) . '"';
	}
	if ( 'select' === $type && isset( $field['options'] ) ) {
		$attrs .= ' data-options="' . esc_attr( wp_json_encode( $field['options'] ) ) . '"';
	}
	if ( 'select' === $type && 'area' === ( isset( $field['dependent'] ) ? $field['dependent'] : '' ) ) {
		$area_map = array();
		foreach ( zamin_destination_data() as $destination_key => $destination ) {
			$area_map[ $destination_key ] = $destination['areas'];
		}
		$attrs .= ' data-area-map="' . esc_attr( wp_json_encode( $area_map ) ) . '"';
	}

	echo '<div class="' . esc_attr( $classes ) . '"' . $attrs . '>';

	if ( in_array( $type, array( 'radio', 'multicheck' ), true ) ) {
		echo '<span class="z-field-label">' . esc_html( $label ) . ( $required ? ' <span class="z-required">*</span>' : '' ) . '</span>';
	} else {
		echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . ( $required ? ' <span class="z-required">*</span>' : '' ) . '</label>';
	}

	if ( 'select' === $type ) {
		echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" ' . ( $required ? 'required' : '' ) . '>';
		foreach ( (array) ( isset( $field['options'] ) ? $field['options'] : array() ) as $value => $option_label ) {
			echo '<option value="' . esc_attr( $value ) . '">' . esc_html( $option_label ) . '</option>';
		}
		echo '</select>';
	} elseif ( 'textarea' === $type ) {
		echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" ' . ( $required ? 'required' : '' );
		if ( isset( $field['counter'] ) ) {
			echo ' maxlength="' . (int) $field['counter'] . '" data-counter';
		}
		echo '></textarea>';
		if ( isset( $field['counter'] ) ) {
			echo '<span class="z-field__counter">0/' . (int) $field['counter'] . '</span>';
		}
	} elseif ( 'multicheck' === $type ) {
		echo '<div class="z-check-grid">';
		foreach ( (array) ( isset( $field['options'] ) ? $field['options'] : array() ) as $option ) {
			echo '<label><input type="checkbox" name="' . esc_attr( $name ) . '[]" value="' . esc_attr( $option ) . '"> ' . esc_html( $option ) . '</label>';
		}
		echo '</div>';
	} elseif ( 'radio' === $type ) {
		foreach ( (array) ( isset( $field['options'] ) ? $field['options'] : array() ) as $value => $option_label ) {
			echo '<label class="z-field--inline"><input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '"> <span>' . esc_html( $option_label ) . '</span></label>';
		}
	} elseif ( 'checkbox' === $type ) {
		echo '<div class="z-field--inline"><input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="1" ' . ( $required ? 'required' : '' ) . '><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . ( $required ? ' <span class="z-required">*</span>' : '' ) . '</label></div>';
	} elseif ( 'file' === $type ) {
		echo '<input type="file" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '[]" accept="image/*" multiple>';
	} else {
		$input_type = in_array( $type, array( 'email', 'tel', 'number', 'date' ), true ) ? $type : 'text';
		echo '<input type="' . esc_attr( $input_type ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" ' . ( $required ? 'required' : '' );
		if ( 'number' === $input_type ) {
			echo ' min="0" step="1"';
		}
		echo '>';
	}

	if ( isset( $field['hint'] ) ) {
		echo '<span class="z-field__hint">' . esc_html( $field['hint'] ) . '</span>';
	}
	if ( isset( $field['note'] ) ) {
		echo '<span class="z-field__hint">' . wp_kses_post( $field['note'] ) . '</span>';
	}
	echo '</div>';
}

/**
 * Handle AJAX form submissions.
 */
function zamin_handle_form_submit() {
	if ( ! check_ajax_referer( 'zamin-form', 'zamin_nonce', false ) ) {
		wp_send_json_error( array( 'message' => __( 'Your session expired. Please refresh the page and try again.', 'zamin' ) ), 403 );
	}

	// Honeypot: silently accept spam.
	if ( '' !== zamin_input( $_POST, 'zamin_website' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		wp_send_json_success( array( 'message' => __( 'Thank you.', 'zamin' ) ) );
	}

	$type   = zamin_input( $_POST, 'zamin_form' ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
	$configs = zamin_form_configs();
	if ( ! isset( $configs[ $type ] ) ) {
		wp_send_json_error( array( 'message' => __( 'Unknown form.', 'zamin' ) ), 400 );
	}
	$config = $configs[ $type ];

	$values = array();
	foreach ( $config['fields'] as $field ) {
		$name = $field['name'];
		if ( 'multicheck' === $field['type'] ) {
			$raw = isset( $_POST[ $name ] ) && is_array( $_POST[ $name ] ) ? wp_unslash( $_POST[ $name ] ) : array();
			$values[ $name ] = array_map( 'sanitize_text_field', $raw );
			continue;
		}
		if ( 'file' === $field['type'] ) {
			continue;
		}
		if ( ! isset( $_POST[ $name ] ) ) {
			$values[ $name ] = '';
			continue;
		}
		$raw = wp_unslash( $_POST[ $name ] );
		if ( 'textarea' === $field['type'] ) {
			$values[ $name ] = sanitize_textarea_field( $raw );
		} elseif ( 'email' === $field['type'] ) {
			$values[ $name ] = sanitize_email( $raw );
		} else {
			$values[ $name ] = sanitize_text_field( $raw );
		}

		if ( ! empty( $field['required'] ) && '' === $values[ $name ] ) {
			wp_send_json_error(
				array(
					'message' => sprintf(
						/* translators: %s: field label */
						__( 'Please complete the required field: %s', 'zamin' ),
						$field['label']
					),
				),
				400
			);
		}
	}

	$title = isset( $values['name'] ) ? $values['name'] : ( isset( $values['full_name'] ) ? $values['full_name'] : ( isset( $values['owner_name'] ) ? $values['owner_name'] : ( isset( $values['email'] ) ? $values['email'] : __( 'Website enquiry', 'zamin' ) ) ) );
	$context = isset( $values['property_name'] ) ? $values['property_name'] : ( isset( $values['enquiry_type'] ) ? $values['enquiry_type'] : '' );
	$post_title = trim( ucfirst( str_replace( '_', ' ', $type ) ) . ' — ' . $title . ( $context ? ' — ' . $context : '' ) );

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'subscriber' === $config['store'] ? 'zamin_subscriber' : 'zamin_enquiry',
			'post_status'  => 'publish',
			'post_title'   => $post_title,
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'We could not save your submission. Please try again or call us.', 'zamin' ) ), 500 );
	}

	foreach ( $values as $key => $value ) {
		update_post_meta( $post_id, '_zamin_' . $key, $value );
	}
	update_post_meta( $post_id, '_zamin_form_type', $type );
	update_post_meta( $post_id, '_zamin_source', isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '' );

	$uploaded = zamin_handle_form_uploads( $post_id );
	if ( is_wp_error( $uploaded ) ) {
		update_post_meta( $post_id, '_zamin_upload_error', $uploaded->get_error_message() );
	}

	zamin_notify_submission( $type, $values, $post_id, $uploaded );

	wp_send_json_success( array( 'message' => $config['success'] ) );
}

/**
 * Store up to five uploaded images and return their URLs.
 *
 * @param int $post_id Post ID.
 * @return array|WP_Error
 */
function zamin_handle_form_uploads( $post_id ) {
	if ( empty( $_FILES ) || empty( $_FILES['images'] ) || empty( $_FILES['images']['name'][0] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return array();
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';

	$urls   = array();
	$files  = $_FILES['images']; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	$count  = min( 5, count( (array) $files['name'] ) );
	$errors = new WP_Error();

	for ( $i = 0; $i < $count; $i++ ) {
		if ( empty( $files['name'][ $i ] ) ) {
			continue;
		}
		$allowed = array( 'jpg', 'jpeg', 'png', 'webp' );
		$ext     = strtolower( pathinfo( $files['name'][ $i ], PATHINFO_EXTENSION ) );
		if ( ! in_array( $ext, $allowed, true ) ) {
			$errors->add( 'invalid_file', __( 'Some images were skipped because only JPG, PNG and WEBP files are accepted.', 'zamin' ) );
			continue;
		}

		$file = array(
			'name'     => $files['name'][ $i ],
			'type'     => $files['type'][ $i ],
			'tmp_name' => $files['tmp_name'][ $i ],
			'error'    => $files['error'][ $i ],
			'size'     => $files['size'][ $i ],
		);

		$result = wp_handle_upload(
			$file,
			array(
				'test_form' => false,
				'mimes'     => array(
					'jpg|jpeg' => 'image/jpeg',
					'png'      => 'image/png',
					'webp'     => 'image/webp',
				),
			)
		);
		if ( isset( $result['url'] ) ) {
			$urls[] = esc_url_raw( $result['url'] );
		}
	}

	update_post_meta( $post_id, '_zamin_files', $urls );
	return $errors->has_errors() ? $errors : $urls;
}

/**
 * Email the team about a new submission.
 *
 * @param string         $type    Form key.
 * @param array          $values  Submitted values.
 * @param int            $post_id Stored post ID.
 * @param array|WP_Error $uploads Uploaded file URLs.
 */
function zamin_notify_submission( $type, $values, $post_id, $uploads ) {
	$to = sanitize_email( zamin_setting( 'notification_email' ) );
	if ( ! $to ) {
		return;
	}

	$lines = array(
		sprintf( __( 'New %s submitted on %s', 'zamin' ), ucfirst( str_replace( '_', ' ', $type ) ), get_bloginfo( 'name' ) ),
		'',
	);
	foreach ( $values as $key => $value ) {
		$display = is_array( $value ) ? implode( ', ', $value ) : $value;
		$lines[] = ucwords( str_replace( '_', ' ', $key ) ) . ': ' . $display;
	}
	if ( is_array( $uploads ) && $uploads ) {
		$lines[] = '';
		$lines[] = __( 'Images:', 'zamin' ) . ' ' . implode( ', ', $uploads );
	}
	$lines[] = '';
	$lines[] = sprintf( __( 'View in WordPress: %s', 'zamin' ), admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );

	wp_mail(
		$to,
		sprintf( __( '[%s] New %s', 'zamin' ), get_bloginfo( 'name' ), str_replace( '_', ' ', $type ) ),
		implode( "\n", $lines ),
		array( 'Content-Type: text/plain; charset=UTF-8' )
	);
}
