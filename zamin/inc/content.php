<?php
/**
 * Page sections and shortcodes. All copy mirrors zaminzameen.com.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'zamin_home', 'zamin_sc_home' );
add_shortcode( 'zamin_properties', 'zamin_sc_properties' );
add_shortcode( 'zamin_sell', 'zamin_sc_sell' );
add_shortcode( 'zamin_valuation', 'zamin_sc_valuation' );
add_shortcode( 'zamin_services_page', 'zamin_sc_services' );
add_shortcode( 'zamin_contact', 'zamin_sc_contact' );
add_shortcode( 'zamin_privacy', 'zamin_sc_privacy' );
add_shortcode( 'zamin_stays_home', 'zamin_sc_stays' );
add_shortcode( 'zamin_destination', 'zamin_sc_destination' );
add_shortcode( 'zamin_host', 'zamin_sc_host' );
add_shortcode( 'zamin_managed', 'zamin_sc_managed' );
add_shortcode( 'zamin_host_apply', 'zamin_sc_host_apply' );
add_shortcode( 'zamin_form', 'zamin_sc_form' );
add_shortcode( 'zamin_alert_band', 'zamin_sc_alert_band' );
add_shortcode( 'zamin_consult_band', 'zamin_sc_consult_band' );

/**
 * Capture echoed markup for shortcode return values.
 *
 * @param callable $callback Render function.
 * @param array    $args     Arguments.
 * @return string
 */
function zamin_capture( $callback, $args = array() ) {
	ob_start();
	call_user_func_array( $callback, $args );
	return ob_get_clean();
}

/**
 * @return string
 */
function zamin_sc_home() {
	return zamin_capture( 'zamin_render_home' );
}

/**
 * @param array $atts Shortcode attributes.
 * @return string
 */
function zamin_sc_properties( $atts ) {
	$atts = shortcode_atts( array( 'purpose' => 'sale' ), $atts, 'zamin_properties' );
	$purpose = in_array( $atts['purpose'], array( 'sale', 'rent' ), true ) ? $atts['purpose'] : 'sale';
	return zamin_capture( 'zamin_render_properties_page', array( $purpose ) );
}

/**
 * @return string
 */
function zamin_sc_sell() {
	return zamin_capture( 'zamin_render_sell_page' );
}

/**
 * @return string
 */
function zamin_sc_valuation() {
	return zamin_capture( 'zamin_render_valuation_page' );
}

/**
 * @return string
 */
function zamin_sc_services() {
	return zamin_capture( 'zamin_render_services_page' );
}

/**
 * @return string
 */
function zamin_sc_contact() {
	return zamin_capture( 'zamin_render_contact_page' );
}

/**
 * @return string
 */
function zamin_sc_privacy() {
	return zamin_capture( 'zamin_render_privacy_page' );
}

/**
 * @return string
 */
function zamin_sc_stays() {
	return zamin_capture( 'zamin_render_stays_page' );
}

/**
 * @param array $atts Shortcode attributes.
 * @return string
 */
function zamin_sc_destination( $atts ) {
	$atts = shortcode_atts( array( 'key' => 'hunza' ), $atts, 'zamin_destination' );
	return zamin_capture( 'zamin_render_destination_page', array( $atts['key'] ) );
}

/**
 * @return string
 */
function zamin_sc_host() {
	return zamin_capture( 'zamin_render_host_page' );
}

/**
 * @return string
 */
function zamin_sc_managed() {
	return zamin_capture( 'zamin_render_managed_page' );
}

/**
 * @return string
 */
function zamin_sc_host_apply() {
	return zamin_capture( 'zamin_render_host_apply_page' );
}

/**
 * @param array $atts Shortcode attributes.
 * @return string
 */
function zamin_sc_form( $atts ) {
	$atts = shortcode_atts( array( 'type' => 'contact', 'panel' => 'true' ), $atts, 'zamin_form' );
	return zamin_capture( 'zamin_render_form', array( $atts['type'], 'false' !== $atts['panel'] ) );
}

/**
 * @return string
 */
function zamin_sc_alert_band() {
	return zamin_capture( 'zamin_render_alert_band' );
}

/**
 * @return string
 */
function zamin_sc_consult_band() {
	return zamin_capture( 'zamin_render_consult_band' );
}

/* -------------------------------------------------------------------------
   Shared markup helpers
   ------------------------------------------------------------------------- */

/**
 * Section heading.
 *
 * @param string $eyebrow Eyebrow text.
 * @param string $title   Heading.
 * @param string $lead    Optional lead paragraph.
 * @param bool   $center  Centered layout.
 */
function zamin_head( $eyebrow, $title, $lead = '', $center = false ) {
	echo '<div class="z-section__head' . ( $center ? ' z-section__head--center' : '' ) . '">';
	if ( $eyebrow ) {
		echo '<span class="z-eyebrow">' . esc_html( $eyebrow ) . '</span>';
	}
	echo '<h2>' . esc_html( $title ) . '</h2>';
	if ( $lead ) {
		echo '<p class="z-lead">' . esc_html( $lead ) . '</p>';
	}
	echo '</div>';
}

/**
 * A simple button link.
 *
 * @param string $label Label.
 * @param string $url   URL.
 * @param string $style zamin-btn modifier.
 * @param string $size  Optional 'sm'.
 */
function zamin_btn( $label, $url, $style = 'dark', $size = '' ) {
	$class = 'z-btn z-btn--' . $style . ( $size ? ' z-btn--' . $size : '' );
	echo '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
}

/**
 * Hero band.
 *
 * @param string $image_key Named image.
 * @param string $eyebrow   Eyebrow.
 * @param string $title     H1.
 * @param string $lead      Lead paragraph.
 * @param array  $buttons   Buttons: array( label, url, style ).
 * @param string $modifier  Extra hero class.
 */
function zamin_hero( $image_key, $eyebrow, $title, $lead, $buttons = array(), $modifier = '' ) {
	echo '<section class="z-hero ' . esc_attr( $modifier ) . '"' . zamin_bg( $image_key ) . '>';
	echo '<div class="z-container z-hero__inner"><div class="z-hero__content">';
	echo '<span class="z-eyebrow">' . esc_html( $eyebrow ) . '</span>';
	echo '<h1>' . esc_html( $title ) . '</h1>';
	echo '<p>' . esc_html( $lead ) . '</p>';
	if ( $buttons ) {
		echo '<div class="z-btn-group">';
		foreach ( $buttons as $button ) {
			zamin_btn( $button[0], $button[1], isset( $button[2] ) ? $button[2] : 'primary' );
		}
		echo '</div>';
	}
	echo '</div></div></section>';
}

/**
 * Common closing CTA band.
 *
 * @param string $eyebrow Eyebrow.
 * @param string $title   Heading.
 * @param string $lead    Lead.
 * @param string $primary Primary button label.
 * @param string $primary_url Primary button URL.
 * @param string $secondary Secondary button label.
 * @param string $secondary_url Secondary button URL.
 * @param string $image_key Background.
 */
function zamin_band( $eyebrow, $title, $lead, $primary, $primary_url, $secondary = '', $secondary_url = '', $image_key = 'consult' ) {
	echo '<section class="z-section z-section--tight"><div class="z-container">';
	echo '<div class="z-banner z-banner--center"' . zamin_bg( $image_key ) . '><div class="z-banner__inner">';
	echo '<span class="z-eyebrow">' . esc_html( $eyebrow ) . '</span>';
	echo '<h2>' . esc_html( $title ) . '</h2>';
	echo '<p>' . esc_html( $lead ) . '</p>';
	echo '<div class="z-btn-group" style="justify-content:center">';
	zamin_btn( $primary, $primary_url, 'primary' );
	if ( $secondary ) {
		zamin_btn( $secondary, $secondary_url, 'light' );
	}
	echo '</div></div></div></div></section>';
}

/**
 * Alert signup band.
 */
function zamin_render_alert_band() {
	echo '<section class="z-section z-section--tight"' . zamin_bg( 'alerts', 'background-size:cover;background-position:center' ) . '>';
	echo '<div class="z-container"><div class="z-two-col-form">';
	echo '<div><span class="z-eyebrow" style="color:#e5c992">' . esc_html__( 'Property Alerts', 'zamin' ) . '</span>';
	echo '<h2 style="color:#fff">' . esc_html__( 'Get property alerts', 'zamin' ) . '</h2>';
	echo '<p>' . esc_html__( 'Be first to know when new homes, plots and rentals hit the market across Hunza, Gilgit, Skardu and beyond. Fresh listings and local market updates, straight to your inbox.', 'zamin' ) . '</p>';
	echo '</div>';
	zamin_render_form( 'alert' );
	echo '</div></div></section>';
}

/**
 * Consultation CTA band.
 */
function zamin_render_consult_band() {
	zamin_band(
		__( 'Ready When You Are', 'zamin' ),
		__( 'Speak With a Property Consultant', 'zamin' ),
		__( 'Tell us what you need — buying, selling, renting, valuation or investment — and a Zamin advisor will guide you with no obligation.', 'zamin' ),
		__( 'Talk to a Consultant', 'zamin' ),
		zamin_page_url( 'contact' ),
		__( 'Call Now', 'zamin' ),
		zamin_phone_href()
	);
}

/**
 * Stay CTA band used across ZAMIN Stays pages.
 */
function zamin_render_stays_band() {
	zamin_band(
		'Hunza · Gojal · Skardu · Naltar · Ghizer',
		__( 'Your next stay in Gilgit-Baltistan starts here', 'zamin' ),
		__( 'Tell us where you want to go and how you like to travel. Our local team will match you with the right verified stay — or help you list your own.', 'zamin' ),
		__( 'Plan My Stay', 'zamin' ),
		zamin_page_url( 'contact' ),
		__( 'List Your Property', 'zamin' ),
		zamin_page_url( 'stays/host' ),
		'stays_cta'
	);
}

/**
 * Property search form used on home and listing pages.
 *
 * @param string $purpose sale|rent|all.
 */
function zamin_render_property_search( $purpose = 'all' ) {
	$current = zamin_current_purpose();
	$action  = zamin_page_url( 'sale' === $purpose ? 'properties-for-sale' : ( 'rent' === $purpose ? 'properties-for-rent' : ( 'rent' === $current ? 'properties-for-rent' : 'properties-for-sale' ) ) );
	$location = zamin_input( $_GET, 'location' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$type     = zamin_input( $_GET, 'type' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$price    = zamin_input( $_GET, 'price' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$beds     = zamin_input( $_GET, 'beds' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	echo '<form class="z-search-card" method="get" action="' . esc_url( $action ) . '">';
	echo '<div class="z-search-card__title"><h3>' . esc_html__( 'Find your place in the mountains', 'zamin' ) . '</h3>';
	echo '<div class="z-purpose-tabs">';
	echo '<a class="' . ( 'sale' === $current ? 'is-active' : '' ) . '" href="' . esc_url( zamin_page_url( 'properties-for-sale' ) ) . '">' . esc_html__( 'Buy', 'zamin' ) . '</a>';
	echo '<a class="' . ( 'rent' === $current ? 'is-active' : '' ) . '" href="' . esc_url( zamin_page_url( 'properties-for-rent' ) ) . '">' . esc_html__( 'Rent', 'zamin' ) . '</a>';
	echo '</div></div>';
	echo '<div class="z-filters">';

	zamin_search_select( __( 'Location', 'zamin' ), 'location', array(
		'' => __( 'All Areas', 'zamin' ), 'Hunza' => 'Hunza', 'Gilgit' => 'Gilgit', 'Skardu' => 'Skardu',
		'Nagar' => 'Nagar', 'Ghizer' => 'Ghizer', 'Chilas' => 'Chilas',
	), $location );
	zamin_search_select( __( 'Property Type', 'zamin' ), 'type', array(
		'' => __( 'All Types', 'zamin' ), 'House' => 'House', 'Apartment' => 'Apartment', 'Land' => 'Land', 'Commercial' => 'Commercial',
	), $type );
	zamin_search_select( __( 'Price Range', 'zamin' ), 'price', array(
		'' => __( 'Any Price', 'zamin' ),
		'under-1' => __( 'Under 1 Crore', 'zamin' ),
		'1-3' => __( '1 – 3 Crore', 'zamin' ),
		'3-5' => __( '3 – 5 Crore', 'zamin' ),
		'over-5' => __( 'Above 5 Crore', 'zamin' ),
	), $price );
	zamin_search_select( __( 'Bedrooms', 'zamin' ), 'beds', array(
		'' => __( 'Any', 'zamin' ), '1' => '1+', '2' => '2+', '3' => '3+', '4' => '4+',
	), $beds );

	echo '<button type="submit" class="z-btn z-btn--dark">' . esc_html__( 'Search', 'zamin' ) . '</button>';
	echo '</div>';
	if ( 'all' !== $purpose ) {
		echo '<input type="hidden" name="purpose" value="' . esc_attr( $purpose ) . '">';
	}
	echo '</form>';
}

/**
 * Render one search select.
 *
 * @param string $label   Label.
 * @param string $name    Field name.
 * @param array  $options Options.
 * @param string $current Selected value.
 */
function zamin_search_select( $label, $name, $options, $current = '' ) {
	echo '<div class="z-field"><label for="zamin-search-' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
	echo '<select id="zamin-search-' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">';
	foreach ( $options as $value => $text ) {
		echo '<option value="' . esc_attr( $value ) . '"' . selected( $current, $value, false ) . '>' . esc_html( $text ) . '</option>';
	}
	echo '</select></div>';
}

/**
 * Stays search form.
 */
function zamin_render_stays_search() {
	$destination = zamin_input( $_GET, 'destination' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$checkin     = zamin_input( $_GET, 'checkin' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$checkout    = zamin_input( $_GET, 'checkout' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$guests      = zamin_input( $_GET, 'guests' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	echo '<form class="z-search-card" method="get" action="' . esc_url( zamin_page_url( 'stays' ) ) . '">';
	echo '<div class="z-search-card__title"><h3>' . esc_html__( 'Find your stay', 'zamin' ) . '</h3>';
	echo '<span class="z-small z-muted">' . esc_html__( 'Local hosts. Verified stays. Local support.', 'zamin' ) . '</span></div>';
	echo '<div class="z-filters">';
	zamin_search_select( __( 'Destination', 'zamin' ), 'destination', zamin_destination_options(), $destination );
	echo '<div class="z-field"><label for="zamin-checkin">' . esc_html__( 'Check-in', 'zamin' ) . '</label><input type="date" id="zamin-checkin" name="checkin" value="' . esc_attr( $checkin ) . '"></div>';
	echo '<div class="z-field"><label for="zamin-checkout">' . esc_html__( 'Check-out', 'zamin' ) . '</label><input type="date" id="zamin-checkout" name="checkout" value="' . esc_attr( $checkout ) . '"></div>';
	zamin_search_select( __( 'Guests', 'zamin' ), 'guests', array( '' => __( 'Guests', 'zamin' ) ) + array_combine( range( 1, 12 ), array_map( function ( $n ) {
		/* translators: %d: number of guests */
		return sprintf( _n( '%d guest', '%d guests', $n, 'zamin' ), $n );
	}, range( 1, 12 ) ) ), $guests );
	echo '<button type="submit" class="z-btn z-btn--dark">' . esc_html__( 'Search Stays', 'zamin' ) . '</button>';
	echo '</div></form>';
}

/**
 * Build a property WP_Query from request parameters.
 *
 * @param string $purpose sale|rent.
 * @return WP_Query
 */
function zamin_property_query( $purpose = 'sale' ) {
	$location = zamin_input( $_GET, 'location' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$type     = zamin_input( $_GET, 'type' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$price    = zamin_input( $_GET, 'price' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$beds     = absint( zamin_input( $_GET, 'beds' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$sort     = zamin_input( $_GET, 'sort' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	$args = array(
		'post_type'      => 'zamin_property',
		'posts_per_page' => 9,
		'paged'          => max( 1, absint( get_query_var( 'paged' ) ) ),
		'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'relation' => 'AND',
			array(
				'key'     => '_zamin_purpose',
				'value'   => $purpose,
				'compare' => '=',
			),
		),
	);

	if ( $location ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'zamin_location',
			'field'    => 'slug',
			'terms'    => sanitize_title( $location ),
		);
	}
	if ( $type ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'zamin_property_type',
			'field'    => 'slug',
			'terms'    => sanitize_title( $type ),
		);
	}

	$ranges = array(
		'under-1' => array( 0, 10000000 ),
		'1-3'     => array( 10000000, 30000000 ),
		'3-5'     => array( 30000000, 50000000 ),
		'over-5'  => array( 50000000, PHP_INT_MAX ),
	);
	if ( isset( $ranges[ $price ] ) ) {
		$args['meta_query'][] = array(
			'key'     => '_zamin_price',
			'value'   => $ranges[ $price ],
			'type'    => 'NUMERIC',
			'compare' => 'BETWEEN',
		);
	}
	if ( $beds ) {
		$args['meta_query'][] = array(
			'key'     => '_zamin_bedrooms',
			'value'   => $beds,
			'type'    => 'NUMERIC',
			'compare' => '>=',
		);
	}

	if ( 'price_asc' === $sort || 'price_desc' === $sort ) {
		$args['meta_key'] = '_zamin_price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'price_asc' === $sort ? 'ASC' : 'DESC';
	} elseif ( 'newest' === $sort ) {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	} else {
		$args['meta_key'] = '_zamin_featured'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$args['orderby']  = array( 'meta_value' => 'DESC', 'date' => 'DESC' );
	}

	return new WP_Query( $args );
}

/**
 * Build a stay WP_Query from request parameters.
 *
 * @param string $destination Destination slug.
 * @param string $area        Area name.
 * @param bool   $featured    Featured only.
 * @return WP_Query
 */
function zamin_stay_query( $destination = '', $area = '', $featured = false ) {
	$destination = $destination ? $destination : zamin_input( $_GET, 'destination' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$area        = $area ? $area : zamin_input( $_GET, 'area' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$type        = zamin_input( $_GET, 'type' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$guests      = absint( zamin_input( $_GET, 'guests' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$sort        = zamin_input( $_GET, 'sort' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	$args = array(
		'post_type'      => 'zamin_stay',
		'posts_per_page' => 9,
		'paged'          => max( 1, absint( get_query_var( 'paged' ) ) ),
		'meta_query'     => array( 'relation' => 'AND' ), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
	);

	if ( $destination ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'zamin_destination',
			'field'    => 'slug',
			'terms'    => sanitize_title( $destination ),
		);
	}
	if ( $area ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'zamin_stay_area',
			'field'    => 'name',
			'terms'    => $area,
		);
	}
	if ( $type ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'zamin_stay_type',
			'field'    => 'slug',
			'terms'    => sanitize_title( $type ),
		);
	}
	if ( $guests ) {
		$args['meta_query'][] = array(
			'key'     => '_zamin_max_guests',
			'value'   => $guests,
			'type'    => 'NUMERIC',
			'compare' => '>=',
		);
	}
	if ( $featured ) {
		$args['meta_query'][] = array(
			'key'     => '_zamin_featured',
			'value'   => '1',
			'compare' => '=',
		);
	}

	if ( 'price_asc' === $sort || 'price_desc' === $sort ) {
		$args['meta_key'] = '_zamin_price_per_night'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'price_asc' === $sort ? 'ASC' : 'DESC';
	} elseif ( 'newest' === $sort ) {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	} else {
		$args['meta_key'] = '_zamin_featured'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$args['orderby']  = array( 'meta_value' => 'DESC', 'date' => 'DESC' );
	}

	return new WP_Query( $args );
}

/**
 * Render a listing card.
 *
 * @param WP_Post $post Post object.
 * @param string  $kind property|stay.
 */
function zamin_listing_card( $post, $kind = 'property' ) {
	$image = has_post_thumbnail( $post ) ? get_the_post_thumbnail_url( $post, 'large' ) : zamin_image( 'property' === $kind ? 'listing_hero' : 'stays_hero' );
	$location = 'property' === $kind ? zamin_terms_label( $post->ID, 'zamin_location' ) : zamin_terms_label( $post->ID, 'zamin_destination' );

	echo '<article class="z-listing-card" data-listing-id="' . esc_attr( $post->ID ) . '">';
	echo '<div class="z-listing-card__media"' . ( $image ? ' style="background-image:url(\'' . esc_url( $image ) . '\')"' : '' ) . '>';
	echo '<div class="z-listing-card__badges">';
	if ( get_post_meta( $post->ID, '_zamin_verified', true ) ) {
		echo '<span class="z-badge z-badge--gold">' . esc_html__( 'Verified', 'zamin' ) . '</span>';
	}
	if ( 'stay' === $kind && get_post_meta( $post->ID, '_zamin_hosting_model', true ) === 'managed' ) {
		echo '<span class="z-badge">' . esc_html__( 'ZAMIN Managed', 'zamin' ) . '</span>';
	}
	echo '</div>';
	echo '<button type="button" class="z-listing-card__save" data-save-listing="' . esc_attr( $post->ID ) . '" aria-label="' . esc_attr__( 'Save listing', 'zamin' ) . '">&#9825;</button>';
	echo '</div>';
	echo '<div class="z-listing-card__body">';
	if ( $location && '&mdash;' !== $location ) {
		echo '<span class="z-listing-card__location">' . esc_html( $location ) . '</span>';
	}
	echo '<h3><a href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html( get_the_title( $post ) ) . '</a></h3>';
	echo '<div class="z-listing-card__meta">';
	if ( 'property' === $kind ) {
		$beds = get_post_meta( $post->ID, '_zamin_bedrooms', true );
		$area = get_post_meta( $post->ID, '_zamin_area_marla', true );
		if ( $beds ) {
			echo '<span>' . esc_html( $beds . ' ' . __( 'bedrooms', 'zamin' ) ) . '</span>';
		}
		if ( $area ) {
			echo '<span>' . esc_html( $area . ' ' . __( 'marla', 'zamin' ) ) . '</span>';
		}
		echo '<span>' . esc_html( ucfirst( (string) get_post_meta( $post->ID, '_zamin_purpose', true ) ) ) . '</span>';
	} else {
		$guests = get_post_meta( $post->ID, '_zamin_max_guests', true );
		$beds   = get_post_meta( $post->ID, '_zamin_bedrooms', true );
		if ( $guests ) {
			echo '<span>' . esc_html( $guests . ' ' . __( 'guests', 'zamin' ) ) . '</span>';
		}
		if ( $beds ) {
			echo '<span>' . esc_html( $beds . ' ' . __( 'bedrooms', 'zamin' ) ) . '</span>';
		}
		echo '<span>' . esc_html( zamin_terms_label( $post->ID, 'zamin_stay_type' ) ) . '</span>';
	}
	echo '</div>';
	echo '<div class="z-listing-card__price">';
	echo '<strong>' . esc_html( zamin_price( get_post_meta( $post->ID, 'property' === $kind ? '_zamin_price' : '_zamin_price_per_night', true ), 'stay' === $kind ? __( '/ night', 'zamin' ) : '' ) ) . '</strong>';
	echo '<a class="z-text-link" href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html__( 'View details', 'zamin' ) . '</a>';
	echo '</div></div></article>';
}

/**
 * Empty state.
 *
 * @param string $title   Title.
 * @param string $message Message.
 * @param array  $buttons Buttons.
 */
function zamin_empty( $title, $message, $buttons = array() ) {
	echo '<div class="z-empty-state"><div class="z-empty-state__icon">&#10022;</div>';
	echo '<h3>' . esc_html( $title ) . '</h3><p>' . esc_html( $message ) . '</p>';
	if ( $buttons ) {
		echo '<div class="z-btn-group">';
		foreach ( $buttons as $button ) {
			zamin_btn( $button[0], $button[1], isset( $button[2] ) ? $button[2] : 'dark' );
		}
		echo '</div>';
	}
	echo '</div>';
}

/**
 * Sort dropdown.
 */
function zamin_sort_select() {
	$sort = zamin_input( $_GET, 'sort' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	echo '<div class="z-sort"><label for="zamin-sort">' . esc_html__( 'Sort by', 'zamin' ) . '</label>';
	echo '<select id="zamin-sort" data-sort-select>';
	foreach ( array(
		'featured'   => __( 'Featured', 'zamin' ),
		'newest'     => __( 'Newest', 'zamin' ),
		'price_asc'  => __( 'Price: Low to High', 'zamin' ),
		'price_desc' => __( 'Price: High to Low', 'zamin' ),
	) as $value => $label ) {
		echo '<option value="' . esc_attr( $value ) . '"' . selected( $sort, $value, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select></div>';
}

/**
 * Pagination for a query.
 *
 * @param WP_Query $query Query.
 */
function zamin_pagination( $query ) {
	if ( $query->max_num_pages > 1 ) {
		echo '<nav class="z-pagination" aria-label="' . esc_attr__( 'Listing pages', 'zamin' ) . '">';
		echo paginate_links(
			array(
				'current'   => max( 1, absint( get_query_var( 'paged' ) ) ),
				'total'     => $query->max_num_pages,
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
			)
		);
		echo '</nav>';
	}
}

/* -------------------------------------------------------------------------
   Home
   ------------------------------------------------------------------------- */

/**
 * Render homepage.
 */
function zamin_render_home() {
	zamin_hero(
		'hero',
		__( 'Trusted Real Estate Across Gilgit-Baltistan', 'zamin' ),
		__( "Find a Place You'll Be Proud to Call Home", 'zamin' ),
		__( 'Buying, selling and renting property across Hunza, Gilgit, Skardu, Nagar, Ghizer and the surrounding valleys — with transparent pricing and genuine local expertise.', 'zamin' ),
		array(
			array( __( 'Explore Properties', 'zamin' ), zamin_page_url( 'properties-for-sale' ), 'primary' ),
			array( __( 'List Your Property', 'zamin' ), zamin_page_url( 'sell-your-property' ), 'light' ),
		)
	);

	echo '<div class="z-container">';
	zamin_render_property_search();
	echo '</div>';

	/* Stats */
	echo '<section class="z-section z-section--tight z-section--forest"><div class="z-container">';
	echo '<div class="z-grid z-grid--4">';
	$stats = array(
		array( zamin_count( 'zamin_property' ), __( 'Published Properties', 'zamin' ) ),
		array( zamin_count( 'zamin_stay' ), __( 'Published Stays', 'zamin' ) ),
		array( '6', __( 'Valleys Covered', 'zamin' ) ),
		array( '2014', __( 'Est. Gilgit-Baltistan Advisory', 'zamin' ) ),
	);
	foreach ( $stats as $stat ) {
		echo '<div class="z-stat"><span class="z-stat__value">' . esc_html( $stat[0] ) . '</span><span class="z-stat__label">' . esc_html( $stat[1] ) . '</span></div>';
	}
	echo '</div></div></section>';

	/* Featured properties */
	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'Buy, Rent & Featured Properties', 'zamin' ), __( 'Featured Properties', 'zamin' ), __( 'Hand-picked homes, apartments, land, and commercial properties across Gilgit-Baltistan.', 'zamin' ) );

	echo '<div class="z-grid z-grid--2" style="margin-bottom:32px">';
	echo '<a class="z-feature-card" href="' . esc_url( zamin_page_url( 'properties-for-sale' ) ) . '"><span class="z-feature-card__icon">&#127968;</span><h3>' . esc_html__( 'Buy Property in Gilgit-Baltistan', 'zamin' ) . '</h3><p>' . esc_html__( 'Verified houses, residential & orchard land, apartments, and commercial plots.', 'zamin' ) . '</p><span class="z-text-link">' . esc_html__( 'Explore listings', 'zamin' ) . '</span></a>';
	echo '<a class="z-feature-card" href="' . esc_url( zamin_page_url( 'properties-for-rent' ) ) . '"><span class="z-feature-card__icon">&#128273;</span><h3>' . esc_html__( 'Rent Long-Term Homes & Offices', 'zamin' ) . '</h3><p>' . esc_html__( 'Screened residential, family, NGO, and commercial leases with clear agreements.', 'zamin' ) . '</p><span class="z-text-link">' . esc_html__( 'Explore rentals', 'zamin' ) . '</span></a>';
	echo '</div>';

	$featured = zamin_property_query( 'sale' );
	if ( $featured->have_posts() ) {
		echo '<div class="z-listing-grid">';
		while ( $featured->have_posts() ) {
			$featured->the_post();
			zamin_listing_card( get_post(), 'property' );
		}
		echo '</div>';
		wp_reset_postdata();
	} else {
		zamin_empty(
			__( 'No properties available yet. Check back soon.', 'zamin' ),
			__( 'Our Gilgit-Baltistan advisors are currently verifying title deeds and onboarding new properties. List your property or request a tailored match from our team.', 'zamin' ),
			array(
				array( __( 'List Your Property', 'zamin' ), zamin_page_url( 'sell-your-property' ), 'dark' ),
				array( __( 'Request Property Match', 'zamin' ), zamin_page_url( 'contact' ), 'outline-dark' ),
			)
		);
	}
	echo '</div></section>';

	/* Stays promo */
	echo '<section class="z-section z-section--cream"><div class="z-container">';
	echo '<div class="z-split">';
	echo '<div><span class="z-eyebrow">' . esc_html__( 'ZAMIN Stays', 'zamin' ) . '</span>';
	echo '<h2>' . esc_html__( 'Curated Mountain Stays & Popular Destinations', 'zamin' ) . '</h2>';
	echo '<p class="z-lead">' . esc_html__( 'Book verified villas, lakeside cabins, and heritage homes directly with trusted Gilgit-Baltistan hosts across Hunza, Gojal, Skardu, Naltar, and Ghizer.', 'zamin' ) . '</p>';
	echo '<div class="z-btn-group"><a class="z-btn z-btn--dark" href="' . esc_url( zamin_page_url( 'stays' ) ) . '">' . esc_html__( 'Explore ZAMIN Stays', 'zamin' ) . '</a><a class="z-btn z-btn--outline-dark" href="' . esc_url( zamin_page_url( 'stays/host' ) ) . '">' . esc_html__( 'Become a Host', 'zamin' ) . '</a></div>';
	echo '</div>';
	echo '<div class="z-banner"' . zamin_bg( 'stays_hero' ) . '><div class="z-banner__inner"><span class="z-eyebrow">' . esc_html__( 'Hunza · Gojal · Skardu · Naltar · Ghizer', 'zamin' ) . '</span><h2>' . esc_html__( 'Stay somewhere worth remembering', 'zamin' ) . '</h2><p>' . esc_html__( 'Local hosts. Verified stays. Local support.', 'zamin' ) . '</p></div></div>';
	echo '</div>';

	echo '<h3 style="margin:60px 0 22px">' . esc_html__( 'Popular Stay Destinations', 'zamin' ) . '</h3>';
	zamin_render_destination_cards();

	$stays = zamin_stay_query( '', '', true );
	if ( $stays->have_posts() ) {
		echo '<div class="z-listing-grid" style="margin-top:40px">';
		while ( $stays->have_posts() ) {
			$stays->the_post();
			zamin_listing_card( get_post(), 'stay' );
		}
		echo '</div>';
		wp_reset_postdata();
	} else {
		echo '<p class="z-muted" style="margin-top:28px">' . esc_html__( 'No stays listed yet.', 'zamin' ) . '</p>';
	}

	echo '<div class="z-banner"' . zamin_bg( 'stays_cta', 'margin-top:50px' ) . '><div class="z-banner__inner">';
	echo '<h2>' . esc_html__( 'Own a villa, cottage, or guesthouse in Gilgit-Baltistan?', 'zamin' ) . '</h2>';
	echo '<p>' . esc_html__( 'We are actively inspecting and onboarding verified mountain stays across Hunza, Gojal, Skardu, Naltar, and Ghizer. List directly or let ZAMIN manage guest bookings end-to-end.', 'zamin' ) . '</p>';
	echo '<div class="z-btn-group">';
	zamin_btn( __( 'Apply to Host', 'zamin' ), zamin_page_url( 'stays/host/apply' ), 'primary' );
	zamin_btn( __( 'Managed Hosting', 'zamin' ), zamin_page_url( 'stays/managed-hosting' ), 'light' );
	echo '</div></div></div>';
	echo '</div></section>';

	/* Locations */
	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'Regions We Serve', 'zamin' ), __( 'Browse by Location', 'zamin' ), __( 'Every valley in Gilgit-Baltistan has its own character, climate and rhythm. Explore the places we know best.', 'zamin' ) );
	zamin_render_location_cards();
	echo '</div></section>';

	/* Services */
	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'What We Do', 'zamin' ), __( 'Our Services', 'zamin' ), __( 'One trusted partner for buying, selling, renting and investing in property across Gilgit-Baltistan.', 'zamin' ) );
	zamin_render_service_cards();
	echo '<div class="z-banner"' . zamin_bg( 'consult', 'margin-top:44px' ) . '><div class="z-banner__inner"><h3>' . esc_html__( 'Not sure where to start?', 'zamin' ) . '</h3><p>' . esc_html__( "Tell us what you need and we'll point you in the right direction — free of charge.", 'zamin' ) . '</p>' . '</div><div class="z-btn-group" style="position:relative;z-index:1;margin-top:20px"><a class="z-btn z-btn--primary" href="' . esc_url( zamin_page_url( 'contact' ) ) . '">' . esc_html__( 'Speak with a consultant', 'zamin' ) . '</a></div></div>';
	echo '</div></section>';

	/* Why choose */
	echo '<section class="z-section"><div class="z-container z-split">';
	echo '<div class="z-banner"' . zamin_bg( 'why', 'min-height:560px' ) . '><div class="z-banner__inner"></div></div>';
	echo '<div><span class="z-eyebrow">' . esc_html__( 'Why Choose Zamin', 'zamin' ) . '</span>';
	echo '<h2>' . esc_html__( 'Your Property, Our Priority', 'zamin' ) . '</h2>';
	echo '<p class="z-lead">' . esc_html__( "We're not just agents — we're your neighbours who understand Gilgit-Baltistan's unique property landscape. Clients trust us because we put their interests first.", 'zamin' ) . '</p>';
	zamin_render_benefits( false );
	echo '</div></div></section>';

	/* Advisors */
	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'Our Advisors', 'zamin' ), __( 'Meet Our Property Advisors', 'zamin' ), __( 'Work directly with verified ZAMIN advisors for property inspections, valuations, and transparent transactions across Gilgit-Baltistan.', 'zamin' ) );
	zamin_empty(
		__( 'Our agent directory is coming soon.', 'zamin' ),
		__( 'Individual advisor profiles will appear here as our Gilgit-Baltistan team publishes verified profiles. In the meantime, connect directly with our Danyore, Gilgit desk.', 'zamin' ),
		array(
			array( __( 'Speak with an Advisor', 'zamin' ), zamin_page_url( 'contact' ), 'dark' ),
			array( __( 'Request Valuation', 'zamin' ), zamin_page_url( 'valuation' ), 'outline-dark' ),
		)
	);
	echo '</div></section>';

	/* Testimonials */
	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'Client Stories', 'zamin' ), __( 'What Our Clients Say', 'zamin' ), '', true );
	zamin_empty( __( 'No client testimonials published yet.', 'zamin' ), __( 'Verified reviews from property buyers, sellers, and ZAMIN Stays guests appear here as transactions and stays are completed.', 'zamin' ) );
	echo '</div></section>';

	zamin_render_alert_band();

	/* Final CTA */
	zamin_band(
		'',
		__( 'Thinking About Selling, Renting, or Investing in Gilgit-Baltistan?', 'zamin' ),
		__( 'Get a free professional valuation or speak directly with our Danyore, Gilgit advisory desk. Transparent commission, verified titles, no obligation.', 'zamin' ),
		__( 'Get a Free Valuation', 'zamin' ),
		zamin_page_url( 'valuation' ),
		__( 'Contact Us', 'zamin' ),
		zamin_page_url( 'contact' )
	);
}

/**
 * Location cards.
 */
function zamin_render_location_cards() {
	$locations = array(
		'Hunza'  => __( 'Valley homes and orchard retreats', 'zamin' ),
		'Gilgit' => __( "The region's administrative & commercial hub", 'zamin' ),
		'Skardu' => __( 'Lakes, valleys, and mountain investments', 'zamin' ),
		'Nagar'  => __( 'Traditional villages and mountain plots', 'zamin' ),
		'Ghizer' => __( 'Open farmland and riverside residences', 'zamin' ),
		'Chilas' => __( 'Strategic gateway on the Karakoram Highway', 'zamin' ),
	);
	echo '<div class="z-grid z-grid--3">';
	foreach ( $locations as $name => $description ) {
		$image = zamin_image_url(
			$name . ' Gilgit Baltistan Pakistan mountain valley landscape with traditional village and snow capped peaks cinematic warm light',
			900, 600, 'zamin-loc-' . strtolower( $name )
		);
		echo '<a class="z-image-card" style="background-image:url(\'' . esc_url( $image ) . '\')" href="' . esc_url( add_query_arg( 'location', $name, zamin_page_url( 'properties-for-sale' ) ) ) . '">';
		echo '<span class="z-image-card__body"><h3>' . esc_html( $name ) . '</h3><p>' . esc_html( $description ) . '</p><span class="z-text-link">' . esc_html__( 'Explore', 'zamin' ) . ' ' . esc_html( $name ) . '</span></span></a>';
	}
	echo '</div>';
}

/**
 * Stay destination cards.
 */
function zamin_render_destination_cards() {
	echo '<div class="z-grid z-grid--3">';
	foreach ( zamin_destination_data() as $key => $data ) {
		$image = zamin_image_url(
			$data['label'] . ' Gilgit Baltistan Pakistan mountain landscape travel photography warm cinematic light',
			900, 600, 'zamin-dest-' . $key
		);
		echo '<a class="z-image-card" style="background-image:url(\'' . esc_url( $image ) . '\')" href="' . esc_url( zamin_page_url( 'stays/' . $key ) ) . '">';
		echo '<span class="z-image-card__body"><h3>' . esc_html( $data['label'] ) . '</h3><p>' . esc_html( $data['desc'] ) . '</p><span class="z-text-link">' . esc_html__( 'Explore destination', 'zamin' ) . '</span></span></a>';
	}
	echo '</div>';
}

/**
 * Service cards.
 */
function zamin_render_service_cards() {
	$services = array(
		array( __( 'Buying Assistance', 'zamin' ), __( 'Find the right property with expert local guidance.', 'zamin' ), zamin_page_url( 'services' ) . '#buying-assistance' ),
		array( __( 'Property Sales', 'zamin' ), __( 'Sell faster, at the right price, with full transparency.', 'zamin' ), zamin_page_url( 'services' ) . '#property-sales' ),
		array( __( 'Rental Services', 'zamin' ), __( 'Reliable tenants and quality rentals, quickly.', 'zamin' ), zamin_page_url( 'services' ) . '#rental-services' ),
		array( __( 'Property Valuation', 'zamin' ), __( 'Know exactly what your property is worth.', 'zamin' ), zamin_page_url( 'valuation' ) ),
		array( __( 'Investment Advisory', 'zamin' ), __( "Build a portfolio tuned to Gilgit-Baltistan’s growth.", 'zamin' ), zamin_page_url( 'services' ) . '#investment-advisory' ),
	);
	echo '<div class="z-grid z-grid--3">';
	foreach ( $services as $service ) {
		echo '<a class="z-feature-card" href="' . esc_url( $service[2] ) . '"><span class="z-feature-card__icon">&#9670;</span><h3>' . esc_html( $service[0] ) . '</h3><p>' . esc_html( $service[1] ) . '</p><span class="z-text-link">' . esc_html__( 'Learn more', 'zamin' ) . '</span></a>';
	}
	echo '</div>';
}

/**
 * Why-choose bullets.
 *
 * @param bool $compact Use compact cards.
 */
function zamin_render_benefits( $compact = true ) {
	$benefits = array(
		array( __( 'Verified Listings', 'zamin' ), __( 'Every property is checked for ownership, documentation and true condition before we recommend it.', 'zamin' ) ),
		array( __( 'Local Expertise', 'zamin' ), __( 'On-the-ground knowledge of Hunza, Gilgit, Skardu, Nagar, Ghizer and Chilas markets.', 'zamin' ) ),
		array( __( 'Transparent Commission', 'zamin' ), __( '2.5%–3% on sales and one month rent for rentals. Clear pricing, no hidden fees — ever.', 'zamin' ) ),
		array( __( 'Professional Guidance', 'zamin' ), __( 'Experienced advisors walk you through viewings, negotiation and every legal step.', 'zamin' ) ),
		array( __( 'Hassle-Free Process', 'zamin' ), __( 'From valuation to paperwork, we handle the complex parts so you can focus on the outcome.', 'zamin' ) ),
	);
	if ( $compact ) {
		echo '<div class="z-grid z-grid--3">';
		foreach ( $benefits as $benefit ) {
			echo '<div class="z-card"><h3>' . esc_html( $benefit[0] ) . '</h3><p>' . esc_html( $benefit[1] ) . '</p></div>';
		}
		echo '</div>';
		return;
	}
	echo '<div class="z-stack">';
	foreach ( $benefits as $benefit ) {
		echo '<div class="z-feature-card"><h3>' . esc_html( $benefit[0] ) . '</h3><p>' . esc_html( $benefit[1] ) . '</p></div>';
	}
	echo '</div>';
}

/* -------------------------------------------------------------------------
   Property listing pages
   ------------------------------------------------------------------------- */

/**
 * Render a property listing page.
 *
 * @param string $purpose sale|rent.
 */
function zamin_render_properties_page( $purpose ) {
	$is_sale = 'sale' === $purpose;
	zamin_hero(
		'listing_hero',
		'',
		$is_sale ? __( 'Properties for Sale in Gilgit-Baltistan', 'zamin' ) : __( 'Properties for Rent in Gilgit-Baltistan', 'zamin' ),
		$is_sale
			? __( 'Browse verified houses, apartments, land and commercial properties for sale across Hunza, Gilgit, Skardu, Nagar, Ghizer and Chilas.', 'zamin' )
			: __( 'Discover houses and apartments available for rent across Gilgit-Baltistan, with transparent one-month-rent commission and reliable landlord service.', 'zamin' ),
		array(),
		'z-hero--compact'
	);

	echo '<div class="z-container">';
	zamin_render_property_search( $purpose );
	$query = zamin_property_query( $purpose );
	echo '<div class="z-toolbar"><span class="z-toolbar__count">' . sprintf( esc_html( _n( '%d property found', '%d properties found', $query->found_posts, 'zamin' ) ), $query->found_posts ) . '</span>';
	zamin_sort_select();
	echo '</div>';

	if ( $query->have_posts() ) {
		echo '<div class="z-listing-grid">';
		while ( $query->have_posts() ) {
			$query->the_post();
			zamin_listing_card( get_post(), 'property' );
		}
		echo '</div>';
		zamin_pagination( $query );
		wp_reset_postdata();
	} else {
		zamin_empty(
			__( 'No properties available yet. Check back soon.', 'zamin' ),
			__( 'Verified Gilgit-Baltistan listings appear here automatically as soon as they are published by our advisors.', 'zamin' ),
			array(
				array( __( 'List Your Property', 'zamin' ), zamin_page_url( 'sell-your-property' ), 'dark' ),
				array( __( 'Speak with an Advisor', 'zamin' ), zamin_page_url( 'contact' ), 'outline-dark' ),
			)
		);
	}
	echo '</div>';

	zamin_render_alert_band();
}

/* -------------------------------------------------------------------------
   Sell, valuation, services
   ------------------------------------------------------------------------- */

/**
 * Render sell your property page.
 */
function zamin_render_sell_page() {
	zamin_hero(
		'sell_hero',
		__( 'Free Valuation · Transparent 2.5%–3% Commission', 'zamin' ),
		__( 'Sell Your Property With Local Experts', 'zamin' ),
		__( 'List your property with Zamin and reach thousands of qualified buyers and tenants across Gilgit-Baltistan. We handle the valuation, marketing, negotiation and paperwork — you just decide when to say yes.', 'zamin' ),
		array(
			array( __( 'Get a Free Valuation', 'zamin' ), '#list-your-property', 'primary' ),
			array( __( 'Call an Agent', 'zamin' ), zamin_phone_href(), 'light' ),
		)
	);

	echo '<section class="z-section"><div class="z-container z-split">';
	echo '<div><span class="z-eyebrow">' . esc_html__( 'Why owners choose Zamin', 'zamin' ) . '</span><h2>' . esc_html__( 'Local knowledge, real results', 'zamin' ) . '</h2>';
	echo '<ul class="z-list-check">';
	foreach ( array(
		__( 'Verified local buyer network', 'zamin' ),
		__( 'Professional photography included', 'zamin' ),
		__( 'Fixed, transparent commission', 'zamin' ),
		__( 'Full documentation support', 'zamin' ),
	) as $item ) {
		echo '<li>' . esc_html( $item ) . '</li>';
	}
	echo '</ul></div>';
	echo '<div class="z-card"><h3>' . esc_html__( 'Our advisory desk', 'zamin' ) . '</h3><p>' . esc_html__( 'Speak to a local advisor in Danyore, Gilgit — no obligation, just straight answers.', 'zamin' ) . '</p><p><a class="z-text-link" href="' . esc_url( zamin_whatsapp_href() ) . '">' . esc_html__( 'WhatsApp Us', 'zamin' ) . '</a></p></div>';
	echo '</div></section>';

	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'How It Works', 'zamin' ), __( 'Selling Made Simple', 'zamin' ), __( 'A clear five-step process that takes the stress out of selling or renting your property.', 'zamin' ) );
	$steps = array(
		array( __( 'Submit Your Details', 'zamin' ), __( 'Share your property information through the form below in a couple of minutes.', 'zamin' ) ),
		array( __( 'Free Valuation', 'zamin' ), __( 'We visit, assess the property and give you a realistic market valuation.', 'zamin' ) ),
		array( __( 'We Market It', 'zamin' ), __( 'Professional photos and a targeted listing reach our buyers and tenants.', 'zamin' ) ),
		array( __( 'Viewings & Offers', 'zamin' ), __( 'We arrange viewings, qualify interest and negotiate the best deal.', 'zamin' ) ),
		array( __( 'Close & Handover', 'zamin' ), __( 'We manage documentation and transfer so closing is smooth and secure.', 'zamin' ) ),
	);
	echo '<div class="z-steps">';
	foreach ( $steps as $index => $step ) {
		echo '<div class="z-step"><div class="z-step__num">' . sprintf( '%02d', $index + 1 ) . '</div><h3>' . esc_html( $step[0] ) . '</h3><p>' . esc_html( $step[1] ) . '</p></div>';
	}
	echo '</div></div></section>';

	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'What You Get', 'zamin' ), __( 'Everything You Need to Sell Confidently', 'zamin' ), __( 'One dedicated team looking after your property from first valuation to final handover.', 'zamin' ) );
	zamin_render_benefits();
	echo '</div></section>';

	echo '<section class="z-section z-section--cream" id="list-your-property"><div class="z-container">';
	zamin_head( __( 'List Your Property', 'zamin' ), __( 'Submit Your Property Details', 'zamin' ), __( "Fill in the form below and we'll be in touch to arrange your free valuation. It only takes a couple of minutes.", 'zamin' ) );
	zamin_render_form( 'sell' );
	echo '</div></section>';
}

/**
 * Render valuation page.
 */
function zamin_render_valuation_page() {
	zamin_hero(
		'valuation_hero',
		__( 'Free Professional Valuation', 'zamin' ),
		__( 'Know What Your Property Is Worth', 'zamin' ),
		__( 'Get an accurate, no-obligation valuation based on real local market data. Share a few details and a Zamin advisor will arrange your free assessment.', 'zamin' ),
		array(),
		'z-hero--compact'
	);

	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'Why get a Zamin valuation?', 'zamin' ), '', '' );
	echo '<div class="z-grid z-grid--4">';
	foreach ( array(
		array( __( 'Realistic Market Value', 'zamin' ), __( 'Priced against genuine recent comparable sales in your area — not inflated guesswork.', 'zamin' ) ),
		array( __( 'Local Area Knowledge', 'zamin' ), __( 'Deep expertise across Hunza, Gilgit, Skardu, Nagar, Ghizer and Chilas.', 'zamin' ) ),
		array( __( 'Clear Written Report', 'zamin' ), __( 'A straightforward summary you can use to list, negotiate or plan with confidence.', 'zamin' ) ),
		array( __( 'Completely Free', 'zamin' ), __( 'No charge and no obligation, whether or not you decide to list with Zamin.', 'zamin' ) ),
	) as $item ) {
		echo '<div class="z-card"><h3>' . esc_html( $item[0] ) . '</h3><p>' . esc_html( $item[1] ) . '</p></div>';
	}
	echo '</div>';
	echo '<div class="z-grid z-grid--4" style="margin-top:50px">';
	foreach ( array( '1,200+' => __( 'Properties Valued', 'zamin' ), '10+' => __( 'Years Local', 'zamin' ), '48h' => __( 'Typical Turnaround', 'zamin' ), '100%' => __( 'Free & No Obligation', 'zamin' ) ) as $value => $label ) {
		echo '<div class="z-stat" style="border-color:#c9a86a;padding-left:22px"><span class="z-stat__value" style="color:#12352a">' . esc_html( $value ) . '</span><span class="z-stat__label" style="color:#66756e">' . esc_html( $label ) . '</span></div>';
	}
	echo '</div>';
	echo '<div class="z-card" style="margin-top:50px;max-width:520px"><h3>' . esc_html__( 'Prefer to talk it through?', 'zamin' ) . '</h3><p>' . esc_html__( "Call or WhatsApp us and we'll answer your questions right away.", 'zamin' ) . '</p><div class="z-btn-group"><a class="z-btn z-btn--dark z-btn--sm" href="' . esc_url( zamin_phone_href() ) . '">' . esc_html__( 'Call Now', 'zamin' ) . '</a><a class="z-btn z-btn--outline-dark z-btn--sm" href="' . esc_url( zamin_whatsapp_href() ) . '">' . esc_html__( 'WhatsApp Us', 'zamin' ) . '</a></div></div>';
	echo '</div></section>';

	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'Request Your Free Valuation', 'zamin' ), '', '' );
	zamin_render_form( 'valuation' );
	echo '</div></section>';

	zamin_band(
		__( 'Thinking of Selling?', 'zamin' ),
		__( 'Ready to List Once You Know Your Value?', 'zamin' ),
		__( 'Our sales team can market your property to qualified buyers and tenants across Gilgit-Baltistan and the diaspora.', 'zamin' ),
		__( 'List Your Property', 'zamin' ),
		zamin_page_url( 'sell-your-property' ),
		__( 'Explore Services', 'zamin' ),
		zamin_page_url( 'services' )
	);
}

/**
 * Render services page.
 */
function zamin_render_services_page() {
	zamin_hero(
		'services_hero',
		__( 'Full-Service Real Estate', 'zamin' ),
		__( 'Everything You Need to Buy, Sell, Rent & Invest', 'zamin' ),
		__( 'From finding your first home to marketing a property, arranging a valuation or structuring an investment — Zamin looks after every part of the journey across Hunza, Gilgit, Skardu, Nagar, Ghizer and Chilas.', 'zamin' ),
		array(
			array( __( 'Talk to a Consultant', 'zamin' ), zamin_page_url( 'contact' ), 'primary' ),
			array( __( 'Explore Properties', 'zamin' ), zamin_page_url( 'properties-for-sale' ), 'light' ),
		)
	);

	$services = array(
		array(
			'id' => 'buying-assistance', 'title' => __( 'Buying Assistance', 'zamin' ), 'image' => 'service_buying',
			'text' => __( 'From your first shortlist to final handover, we help you buy with confidence. We verify ownership, negotiate on your behalf and guide you through every legal step so there are no surprises.', 'zamin' ),
			'points' => array( __( 'Curated shortlists matching your budget', 'zamin' ), __( 'On-site viewings across Gilgit-Baltistan', 'zamin' ), __( 'Price negotiation and market insight', 'zamin' ), __( 'Ownership and document verification', 'zamin' ) ),
			'buttons' => array( array( __( 'Start Your Search', 'zamin' ), zamin_page_url( 'properties-for-sale' ), 'dark' ), array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline-dark' ) ),
		),
		array(
			'id' => 'property-sales', 'title' => __( 'Property Sales', 'zamin' ), 'image' => 'service_sales',
			'text' => __( 'We market your property to a qualified network of local and overseas buyers, handle the negotiations and manage the paperwork from listing to closing.', 'zamin' ),
			'points' => array( __( 'Free professional valuation', 'zamin' ), __( 'Quality photography and listing placement', 'zamin' ), __( 'Qualified buyer matching', 'zamin' ), __( 'Transparent 2.5%–3% commission', 'zamin' ) ),
			'buttons' => array( array( __( 'List Your Property', 'zamin' ), zamin_page_url( 'sell-your-property' ), 'dark' ), array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline-dark' ) ),
		),
		array(
			'id' => 'rental-services', 'title' => __( 'Rental Services', 'zamin' ), 'image' => 'service_rental',
			'text' => __( 'Whether you are a landlord seeking dependable tenants or a family looking for a home, we manage the entire rental process — screening, agreements and handover.', 'zamin' ),
			'points' => array( __( 'Tenant screening and references', 'zamin' ), __( 'Rental agreement drafting', 'zamin' ), __( 'Move-in and move-out inspections', 'zamin' ), __( 'One month rent commission, no hidden fees', 'zamin' ) ),
			'buttons' => array( array( __( 'Browse Rentals', 'zamin' ), zamin_page_url( 'properties-for-rent' ), 'dark' ), array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline-dark' ) ),
		),
		array(
			'id' => 'property-valuation', 'title' => __( 'Property Valuation', 'zamin' ), 'image' => 'service_valuation',
			'text' => __( 'Our valuation combines recent comparable sales, location analysis and current demand to give you a realistic, defensible figure before you list or invest.', 'zamin' ),
			'points' => array( __( 'On-site assessment', 'zamin' ), __( 'Comparable market analysis', 'zamin' ), __( 'Clear written valuation report', 'zamin' ), __( 'Completely free of charge', 'zamin' ) ),
			'buttons' => array( array( __( 'Request Free Valuation', 'zamin' ), zamin_page_url( 'valuation' ), 'dark' ), array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline-dark' ) ),
		),
		array(
			'id' => 'investment-advisory', 'title' => __( 'Investment Advisory', 'zamin' ), 'image' => 'service_investment',
			'text' => __( 'Tourism-driven demand is reshaping the region. We advise local and overseas investors on where to buy, what yields to expect and how to structure a sound investment.', 'zamin' ),
			'points' => array( __( 'Growth-area and yield analysis', 'zamin' ), __( 'Overseas investor support', 'zamin' ), __( 'Tourism rental strategy', 'zamin' ), __( 'Portfolio diversification guidance', 'zamin' ) ),
			'buttons' => array( array( __( 'Talk to an Advisor', 'zamin' ), zamin_page_url( 'contact' ), 'dark' ), array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline-dark' ) ),
		),
		array(
			'id' => 'property-marketing', 'title' => __( 'Property Marketing', 'zamin' ), 'image' => 'service_marketing',
			'text' => __( 'Professional photography, compelling descriptions and targeted exposure to buyers and tenants across Pakistan and the diaspora give your listing the attention it deserves.', 'zamin' ),
			'points' => array( __( 'Professional property photography', 'zamin' ), __( 'Written and visual listing creation', 'zamin' ), __( 'Multi-channel local and overseas reach', 'zamin' ), __( 'Regular performance updates', 'zamin' ) ),
			'buttons' => array( array( __( 'Get Started', 'zamin' ), zamin_page_url( 'sell-your-property' ), 'dark' ), array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline-dark' ) ),
		),
		array(
			'id' => 'documentation-assistance', 'title' => __( 'Documentation Assistance', 'zamin' ), 'image' => 'service_docs',
			'text' => __( 'Property transfers in Gilgit-Baltistan need care. Our team prepares and reviews documentation, coordinates with the relevant authorities and keeps the process moving.', 'zamin' ),
			'points' => array( __( 'Sale agreement preparation', 'zamin' ), __( 'Mutation and transfer coordination', 'zamin' ), __( 'Document review and verification', 'zamin' ), __( 'Guidance on registration requirements', 'zamin' ) ),
			'buttons' => array( array( __( 'Ask About Documents', 'zamin' ), zamin_page_url( 'contact' ), 'dark' ), array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline-dark' ) ),
		),
	);

	echo '<section class="z-section"><div class="z-container">';
	foreach ( $services as $index => $service ) {
		echo '<div class="z-service-row' . ( 1 === $index % 2 ? ' z-service-row--reverse' : '' ) . '" id="' . esc_attr( $service['id'] ) . '">';
		echo '<div><span class="z-eyebrow">' . esc_html__( 'What We Do', 'zamin' ) . '</span><h2>' . esc_html( $service['title'] ) . '</h2><p>' . esc_html( $service['text'] ) . '</p>';
		echo '<ul class="z-list-check">';
		foreach ( $service['points'] as $point ) {
			echo '<li>' . esc_html( $point ) . '</li>';
		}
		echo '</ul><div class="z-btn-group">';
		foreach ( $service['buttons'] as $button ) {
			zamin_btn( $button[0], $button[1], $button[2] );
		}
		echo '</div></div>';
		echo '<div class="z-service-row__media"' . zamin_bg( $service['image'] ) . '></div>';
		echo '</div>';
	}
	echo '</div></section>';

	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'Why Zamin', 'zamin' ), __( 'One Team, Every Step of the Way', 'zamin' ), __( 'Local knowledge, transparent pricing and genuine care — the reasons clients across Gilgit-Baltistan and the diaspora keep coming back.', 'zamin' ) );
	zamin_render_benefits();
	echo '</div></section>';

	zamin_render_consult_band();
}

/* -------------------------------------------------------------------------
   Contact and privacy
   ------------------------------------------------------------------------- */

/**
 * Render contact page.
 */
function zamin_render_contact_page() {
	zamin_hero(
		'contact_hero',
		__( "We're Here to Help", 'zamin' ),
		__( 'Get in Touch With Zamin', 'zamin' ),
		__( "Whether you're buying, selling, renting or just have a question, our Gilgit team is ready to help. Call, WhatsApp, email or send us a message below.", 'zamin' ),
		array(
			array( __( 'Call Now', 'zamin' ), zamin_phone_href(), 'primary' ),
			array( __( 'Email Us', 'zamin' ), 'mailto:' . zamin_setting( 'email' ), 'light' ),
			array( __( 'WhatsApp Us', 'zamin' ), zamin_whatsapp_href(), 'outline' ),
		),
		'z-hero--compact'
	);

	echo '<section class="z-section"><div class="z-container z-two-col-form">';
	echo '<div><h2>' . esc_html__( 'How Can We Help You?', 'zamin' ) . '</h2><p class="z-lead">' . esc_html__( 'Fill in the form below and one of our local specialists will respond within one business day.', 'zamin' ) . '</p>';
	echo '<div class="z-contact-info">';
	foreach ( array(
		array( __( 'Phone', 'zamin' ), zamin_setting( 'phone' ), zamin_phone_href() ),
		array( __( 'Email', 'zamin' ), zamin_setting( 'email' ), 'mailto:' . zamin_setting( 'email' ) ),
		array( __( 'Office Hours', 'zamin' ), zamin_setting( 'hours' ), '' ),
		array( __( 'Office Address', 'zamin' ), zamin_setting( 'address' ), '' ),
	) as $info ) {
		echo '<div class="z-contact-info__item"><span>' . esc_html( $info[0] ) . '</span>';
		if ( $info[2] ) {
			echo '<a href="' . esc_url( $info[2] ) . '">' . esc_html( $info[1] ) . '</a>';
		} else {
			echo '<strong>' . esc_html( $info[1] ) . '</strong>';
		}
		echo '</div>';
	}
	echo '</div>';
	echo '<div class="z-service-row__media" style="min-height:260px;margin-top:28px;background-image:url(\'https://maps.googleapis.com/maps/api/staticmap?center=Gilgit,Pakistan&zoom=12&size=640x320&markers=Gilgit,Pakistan\')" role="img" aria-label="' . esc_attr__( 'Map showing Gilgit, Gilgit-Baltistan', 'zamin' ) . '"></div>';
	echo '</div>';
	zamin_render_form( 'contact' );
	echo '</div></section>';
}

/**
 * Render privacy page.
 */
function zamin_render_privacy_page() {
	zamin_hero(
		'legal_hero',
		__( 'Legal', 'zamin' ),
		__( 'Privacy Policy', 'zamin' ),
		__( 'How Zamin Real Estate & Consultants collects, uses and protects your information when you browse, enquire or work with us.', 'zamin' ),
		array(),
		'z-hero--compact'
	);

	$sections = array(
		array( __( 'Introduction', 'zamin' ), array(
			__( 'Zamin Real Estate & Rentals ("we", "us" or "our") is committed to protecting the privacy of everyone who uses our website. This Privacy Policy explains what information we collect, how we use it, and the choices you have.', 'zamin' ),
			__( 'By using our website and services, you agree to the practices described in this policy. If you do not agree, please do not use the website.', 'zamin' ),
		) ),
		array( __( 'Information We Collect', 'zamin' ), array(
			__( 'Information you give us — such as your name, phone number, email address and message when you submit an enquiry, request a valuation, list a property or contact us.', 'zamin' ),
			__( 'Information collected automatically — such as your device type, browser, approximate location and the pages you view, gathered through standard analytics.', 'zamin' ),
			__( 'Information stored on your device — such as your saved properties, saved calculator reports and remembered search filters (see below).', 'zamin' ),
		) ),
		array( __( 'How We Use Your Information', 'zamin' ), array(
			__( 'Respond to your enquiries and connect you with the right property or adviser.', 'zamin' ),
			__( 'Arrange viewings, valuations and follow-up communication you have requested.', 'zamin' ),
			__( 'Improve our website, listings and services based on how they are used.', 'zamin' ),
			__( 'Send updates or offers where you have asked to receive them.', 'zamin' ),
			__( 'Comply with legal and regulatory obligations.', 'zamin' ),
		) ),
		array( __( 'Cookies & Local Storage', 'zamin' ), array(
			__( 'We use cookies and browser storage to keep the website working smoothly. This includes remembering preferences and, importantly, storing your saved properties, your saved calculator reports and your recent search filters.', 'zamin' ),
			__( 'This saved data is kept locally on your own device and is not stored on our servers or linked to your identity. Clearing your browser data will remove it.', 'zamin' ),
		) ),
		array( __( 'How We Share Information', 'zamin' ), array(
			__( 'We do not sell your personal information. We may share it with trusted partners only where necessary, such as our own advisers working on your enquiry, service providers who help us operate the website and send emails on our behalf, and authorities where we are legally required to do so.', 'zamin' ),
		) ),
		array( __( 'Data Retention', 'zamin' ), array(
			__( 'We keep enquiry and client information only for as long as it is needed to provide our services and meet legal requirements. When it is no longer needed, we securely delete or anonymise it.', 'zamin' ),
		) ),
		array( __( 'Your Rights', 'zamin' ), array(
			__( 'Subject to local law, you have the right to ask for a copy of the personal information we hold about you, ask us to correct information that is inaccurate or out of date, ask us to delete information we no longer need, and withdraw consent for marketing messages at any time.', 'zamin' ),
			sprintf( __( 'To exercise any of these rights, please email us at %s.', 'zamin' ), zamin_setting( 'email' ) ),
		) ),
		array( __( 'How We Protect Your Data', 'zamin' ), array(
			__( 'We take reasonable technical and organisational measures to protect your information against loss, misuse and unauthorised access. However, no method of transmission over the internet is completely secure, so we cannot guarantee absolute security.', 'zamin' ),
		) ),
		array( __( "Children's Privacy", 'zamin' ), array(
			__( 'Our services are intended for adults. We do not knowingly collect personal information from children. If you believe a child has provided us with information, please contact us so we can remove it.', 'zamin' ),
		) ),
		array( __( 'Third-Party Links', 'zamin' ), array(
			__( 'Our website may link to third-party sites, such as social media or mapping services. We are not responsible for their privacy practices, and we encourage you to read their policies.', 'zamin' ),
		) ),
		array( __( 'Changes to This Policy', 'zamin' ), array(
			__( 'We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated "last updated" date. We encourage you to review it periodically.', 'zamin' ),
		) ),
		array( __( 'Contact Us', 'zamin' ), array(
			__( 'If you have any questions about this Privacy Policy, please reach out to us.', 'zamin' ),
			sprintf( __( 'Email: %s', 'zamin' ), zamin_setting( 'email' ) ) . ' · ' . sprintf( __( 'Phone: %s', 'zamin' ), zamin_setting( 'phone' ) ) . ' · ' . zamin_setting( 'address' ),
		) ),
	);

	echo '<section class="z-section"><div class="z-container"><div class="z-prose">';
	echo '<p class="z-small z-muted"><strong>' . esc_html__( 'Last updated: 23 September 2026', 'zamin' ) . '</strong></p>';
	foreach ( $sections as $index => $section ) {
		echo '<h2>' . ( $index + 1 ) . '. ' . esc_html( $section[0] ) . '</h2>';
		foreach ( $section[1] as $paragraph ) {
			echo '<p>' . esc_html( $paragraph ) . '</p>';
		}
	}
	echo '<div class="z-card" style="margin-top:36px"><h3>' . esc_html__( 'Questions about this page?', 'zamin' ) . '</h3><p>' . esc_html__( 'Our team is happy to explain anything you need in plain language.', 'zamin' ) . '</p><div class="z-btn-group"><a class="z-btn z-btn--dark z-btn--sm" href="mailto:' . esc_attr( zamin_setting( 'email' ) ) . '">' . esc_html__( 'Email Us', 'zamin' ) . '</a><a class="z-btn z-btn--outline-dark z-btn--sm" href="' . esc_url( zamin_phone_href() ) . '">' . esc_html__( 'Call Now', 'zamin' ) . '</a></div></div>';
	echo '</div></div></section>';

	zamin_band(
		__( 'Buy & Sell With Confidence', 'zamin' ),
		__( 'Ready to Talk Property?', 'zamin' ),
		__( 'Whether you are buying, selling, renting or investing, our local advisers are here to help across Gilgit-Baltistan.', 'zamin' ),
		__( 'Contact Our Team', 'zamin' ),
		zamin_page_url( 'contact' ),
		__( 'Call Now', 'zamin' ),
		zamin_phone_href()
	);
}

/* -------------------------------------------------------------------------
   Stays
   ------------------------------------------------------------------------- */

/**
 * Render stays landing page.
 */
function zamin_render_stays_page() {
	zamin_hero(
		'stays_hero',
		__( 'Local hosts. Verified stays. Local support.', 'zamin' ),
		__( 'Stay Somewhere Worth Remembering', 'zamin' ),
		__( 'Handpicked stays across Gilgit-Baltistan — from Hunza orchards and Skardu lakes to the high passes of Gojal. Book directly with hosts ZAMIN knows and trusts.', 'zamin' ),
		array(),
		'z-hero--compact'
	);

	echo '<div class="z-container">';
	zamin_render_stays_search();
	$nights = 0;
	$checkin = zamin_input( $_GET, 'checkin' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$checkout = zamin_input( $_GET, 'checkout' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $checkin && $checkout ) {
		$nights = max( 0, (int) ( ( strtotime( $checkout ) - strtotime( $checkin ) ) / DAY_IN_SECONDS ) );
	}
	$guests = absint( zamin_input( $_GET, 'guests' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	echo '<p class="z-muted z-small" style="margin:18px 0 34px">' . esc_html( sprintf( '%d nights · %d guests · choose a destination or browse below', $nights ? $nights : 2, $guests ? $guests : 2 ) ) . '</p>';

	echo '<section class="z-section z-section--tight" style="padding-top:0"><div style="max-width:760px;margin-bottom:26px"><span class="z-eyebrow">' . esc_html__( 'Handpicked', 'zamin' ) . '</span><h2>' . esc_html__( 'Featured Stays', 'zamin' ) . '</h2><p class="z-lead">' . esc_html__( 'A selection of the stays our team loves most — verified, well-located and ready to book directly.', 'zamin' ) . '</p></div>';
	$query = zamin_stay_query();
	if ( $query->have_posts() ) {
		echo '<div class="z-listing-grid">';
		while ( $query->have_posts() ) {
			$query->the_post();
			zamin_listing_card( get_post(), 'stay' );
		}
		echo '</div>';
		zamin_pagination( $query );
		wp_reset_postdata();
	} else {
		zamin_empty( __( 'No stays listed yet.', 'zamin' ), __( 'Stays are being onboarded across Hunza, Gojal, Skardu, Naltar and Ghizer — check back soon.', 'zamin' ) );
	}
	echo '</div></section>';
	echo '</div>';

	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'Own a stay?', 'zamin' ), __( 'Be one of the first ZAMIN hosts', 'zamin' ), __( "We're onboarding verified stays across Hunza, Gojal, Skardu, Naltar and Ghizer right now. List your property — or let ZAMIN manage it end to end — and be featured here from day one.", 'zamin' ) );
	echo '<div class="z-btn-group"><a class="z-btn z-btn--dark" href="' . esc_url( zamin_page_url( 'stays/host' ) ) . '">' . esc_html__( 'Become a Host', 'zamin' ) . '</a><a class="z-btn z-btn--outline-dark" href="' . esc_url( zamin_page_url( 'stays/managed-hosting' ) ) . '">' . esc_html__( 'Managed Hosting', 'zamin' ) . '</a></div>';
	echo '</div></section>';

	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'Explore the region', 'zamin' ), __( 'Explore by Destination', 'zamin' ), __( 'Every stay sits in a real Gilgit-Baltistan destination — with the areas, valleys and viewpoints travellers actually search for.', 'zamin' ) );
	zamin_render_destination_cards();
	echo '</div></section>';

	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'Browse by stay type', 'zamin' ), __( 'Find Your Kind of Stay', 'zamin' ), __( "From entire homes and cosy cabins to homestays and workation-ready apartments — pick a type and we'll filter instantly.", 'zamin' ) );
	echo '<div class="z-tabs"><a class="z-tab is-active" href="' . esc_url( zamin_page_url( 'stays' ) ) . '">' . esc_html__( 'All stays', 'zamin' ) . '</a>';
	foreach ( zamin_stay_type_options() as $slug => $label ) {
		if ( ! $slug ) {
			continue;
		}
		echo '<a class="z-tab" href="' . esc_url( add_query_arg( 'type', sanitize_title( $label ), zamin_page_url( 'stays' ) ) ) . '">' . esc_html( $label ) . '</a>';
	}
	echo '</div>';
	echo '<p class="z-muted">' . esc_html__( 'Stays are being onboarded — check back soon.', 'zamin' ) . '</p>';
	echo '</div></section>';

	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'Why book with ZAMIN', 'zamin' ), __( 'Travel with People Who Know the Ground', 'zamin' ), __( "ZAMIN Stays isn't a faceless global marketplace — it's a Gilgit-Baltistan platform built on local knowledge and verified, inspected stays.", 'zamin' ) );
	echo '<div class="z-grid z-grid--3">';
	foreach ( array(
		array( __( 'Verified local properties', 'zamin' ), __( 'Every stay is reviewed by our Gilgit-Baltistan team — real photos, real locations, no surprises on arrival.', 'zamin' ) ),
		array( __( 'Local hosts & local support', 'zamin' ), __( 'We live here. Our team knows each valley and is on hand before, during and after your stay.', 'zamin' ) ),
		array( __( 'Direct bookings, fair pricing', 'zamin' ), __( 'Book straight with ZAMIN — no inflated third-party markups, with pricing shown clearly per night.', 'zamin' ) ),
		array( __( 'Managed hosting', 'zamin' ), __( 'Owners who prefer a hands-off approach can let ZAMIN run the entire short-term operation.', 'zamin' ) ),
		array( __( 'Built for the mountains', 'zamin' ), __( 'Heating, hot water, backup power and check-in times designed for high-altitude travel.', 'zamin' ) ),
		array( __( 'Guest support that answers', 'zamin' ), __( 'A real person on WhatsApp for check-in help, directions and any issue during your stay.', 'zamin' ) ),
	) as $item ) {
		echo '<div class="z-card"><h3>' . esc_html( $item[0] ) . '</h3><p>' . esc_html( $item[1] ) . '</p></div>';
	}
	echo '</div></section>';

	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'Host with ZAMIN', 'zamin' ), __( 'Two Ways to Host Your Property', 'zamin' ), __( 'Keep the keys and run it yourself, or hand the whole short-term operation to ZAMIN. Either way, your property stays verified and locally supported.', 'zamin' ) );
	echo '<div class="z-split">';
	echo '<div class="z-service-row__media"' . zamin_bg( 'host_listed' ) . '></div>';
	echo '<div><h3>' . esc_html__( 'ZAMIN Listed', 'zamin' ) . '</h3><p>' . esc_html__( 'You operate the property. ZAMIN gives you the listing, search visibility, booking platform, guest leads, payments, reviews and marketing.', 'zamin' ) . '</p><ul class="z-list-check"><li>' . esc_html__( 'Listing & search visibility', 'zamin' ) . '</li><li>' . esc_html__( 'Direct booking platform', 'zamin' ) . '</li><li>' . esc_html__( 'Guest leads & enquiries', 'zamin' ) . '</li><li>' . esc_html__( 'Reviews & marketing support', 'zamin' ) . '</li></ul><a class="z-btn z-btn--dark z-btn--sm" href="' . esc_url( zamin_page_url( 'stays/host' ) ) . '">' . esc_html__( 'Become a Host', 'zamin' ) . '</a></div>';
	echo '</div>';
	echo '<div class="z-split" style="margin-top:60px">';
	echo '<div><h3>' . esc_html__( 'ZAMIN Managed', 'zamin' ) . '</h3><p>' . esc_html__( 'Hand us the keys. We run the entire short-term operation and send you the returns — from photography and pricing to guests, cleaning and reporting.', 'zamin' ) . '</p><ul class="z-list-check"><li>' . esc_html__( 'Property assessment & onboarding', 'zamin' ) . '</li><li>' . esc_html__( 'Professional photography', 'zamin' ) . '</li><li>' . esc_html__( 'Listing creation & optimisation', 'zamin' ) . '</li><li>' . esc_html__( 'Dynamic pricing & calendar management', 'zamin' ) . '</li><li>' . esc_html__( 'Guest communication & check-in/out', 'zamin' ) . '</li><li>' . esc_html__( 'Cleaning & maintenance coordination', 'zamin' ) . '</li><li>' . esc_html__( 'Owner reporting & payouts', 'zamin' ) . '</li></ul><a class="z-btn z-btn--dark z-btn--sm" href="' . esc_url( zamin_page_url( 'stays/managed-hosting' ) ) . '">' . esc_html__( 'Get Your Property Evaluated', 'zamin' ) . '</a></div>';
	echo '<div class="z-service-row__media"' . zamin_bg( 'host_managed' ) . '></div>';
	echo '</div></section>';

	zamin_render_stays_band();
}

/**
 * Render a stay destination page.
 *
 * @param string $key Destination key.
 */
function zamin_render_destination_page( $key ) {
	$data = isset( zamin_destination_data()[ $key ] ) ? zamin_destination_data()[ $key ] : zamin_destination_data()['hunza'];
	zamin_hero( 'stays_hero', __( 'Gilgit-Baltistan', 'zamin' ), sprintf( __( 'Stays in %s', 'zamin' ), $data['label'] ), $data['desc'] . ' ' . __( 'Explore verified stays, local hosts and the areas travellers actually search for.', 'zamin' ), array(), 'z-hero--compact' );

	echo '<section class="z-section"><div class="z-container">';
	echo '<div class="z-grid z-grid--4" style="margin-bottom:34px"><div class="z-stat" style="border-color:#c9a86a;padding-left:18px"><span class="z-stat__value" style="color:#12352a">' . zamin_count( 'zamin_stay' ) . '</span><span class="z-stat__label" style="color:#66756e">' . esc_html__( 'Stays', 'zamin' ) . '</span></div><div class="z-stat" style="border-color:#c9a86a;padding-left:18px"><span class="z-stat__value" style="color:#12352a">' . count( $data['areas'] ) . '</span><span class="z-stat__label" style="color:#66756e">' . esc_html__( 'Areas', 'zamin' ) . '</span></div></div>';

	echo '<h3>' . esc_html__( 'Areas in', 'zamin' ) . ' ' . esc_html( $data['label'] ) . '</h3>';
	echo '<p class="z-muted">' . esc_html__( 'Pick an area to narrow down your stay.', 'zamin' ) . '</p>';
	echo '<div class="z-tabs"><a class="z-tab' . ( '' === zamin_input( $_GET, 'area' ) ? ' is-active' : '' ) . '" href="' . esc_url( zamin_page_url( 'stays/' . $key ) ) . '">' . esc_html__( 'All areas', 'zamin' ) . '</a>'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	foreach ( $data['areas'] as $area ) {
		$active = zamin_input( $_GET, 'area' ) === $area; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		echo '<a class="z-tab' . ( $active ? ' is-active' : '' ) . '" href="' . esc_url( add_query_arg( 'area', $area, zamin_page_url( 'stays/' . $key ) ) ) . '">' . esc_html( $area ) . '</a>';
	}
	echo '</div>';

	echo '<h3 style="margin-top:40px">' . esc_html__( 'Stays in', 'zamin' ) . ' ' . esc_html( $data['label'] ) . '</h3>';
	$query = zamin_stay_query( $key );
	if ( $query->have_posts() ) {
		echo '<div class="z-listing-grid" style="margin-top:24px">';
		while ( $query->have_posts() ) {
			$query->the_post();
			zamin_listing_card( get_post(), 'stay' );
		}
		echo '</div>';
		zamin_pagination( $query );
		wp_reset_postdata();
	} else {
		zamin_empty(
			__( 'No stays listed yet.', 'zamin' ),
			sprintf( __( 'Stays in %s are being onboarded — check back soon.', 'zamin' ), $data['label'] ),
			array( array( __( 'List a property here', 'zamin' ), zamin_page_url( 'stays/host' ), 'dark' ) )
		);
	}
	echo '</div></section>';
	zamin_render_stays_band();
}

/**
 * Render host landing page.
 */
function zamin_render_host_page() {
	zamin_hero(
		'host_hero',
		__( 'ZAMIN Stays · Host with us', 'zamin' ),
		__( 'Turn Your Property Into a Professionally Managed Stay', 'zamin' ),
		__( 'Hunza, Gojal, Skardu, Naltar and Ghizer are among the most sought-after destinations in Pakistan. List with ZAMIN — or let us manage everything — and put your property in front of real, verified travellers.', 'zamin' ),
		array(
			array( __( 'Start your application', 'zamin' ), zamin_page_url( 'stays/host/apply' ), 'primary' ),
			array( __( 'Chat with our team', 'zamin' ), zamin_whatsapp_href(), 'light' ),
		)
	);

	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'Two ways to host', 'zamin' ), __( 'Choose What Works for You', 'zamin' ), __( 'Every host is different. Pick the model that fits how hands-on you want to be — you can always change later.', 'zamin' ) );
	echo '<div class="z-grid z-grid--2">';
	echo '<div class="z-card"><h3>' . esc_html__( 'List with ZAMIN', 'zamin' ) . '</h3><p>' . esc_html__( 'You run the property day to day. ZAMIN gives you the listing, visibility, booking platform, guest leads, payments and reviews.', 'zamin' ) . '</p><ul class="z-list-check"><li>' . esc_html__( 'Verified listing on ZAMIN Stays', 'zamin' ) . '</li><li>' . esc_html__( 'Search visibility by destination & type', 'zamin' ) . '</li><li>' . esc_html__( 'Direct booking enquiries', 'zamin' ) . '</li><li>' . esc_html__( 'Payments and review support', 'zamin' ) . '</li></ul></div>';
	echo '<div class="z-card"><h3>' . esc_html__( 'Let ZAMIN manage everything', 'zamin' ) . '</h3><p>' . esc_html__( 'Hand over the keys. We run the entire short-term operation — pricing, guests, cleaning, maintenance and reporting.', 'zamin' ) . '</p><ul class="z-list-check"><li>' . esc_html__( 'Onboarding & professional photography', 'zamin' ) . '</li><li>' . esc_html__( 'Pricing & calendar management', 'zamin' ) . '</li><li>' . esc_html__( 'Guest communication & check-in/out', 'zamin' ) . '</li><li>' . esc_html__( 'Cleaning, maintenance & owner reporting', 'zamin' ) . '</li></ul><a class="z-text-link" href="' . esc_url( zamin_page_url( 'stays/managed-hosting' ) ) . '">' . esc_html__( 'Learn about managed hosting', 'zamin' ) . '</a></div>';
	echo '</div></div></section>';

	echo '<section class="z-section z-section--cream"><div class="z-container">';
	zamin_head( __( 'How it works', 'zamin' ), __( 'From Enquiry to Your First Guest', 'zamin' ), '' );
	echo '<div class="z-steps" style="grid-template-columns:repeat(4,minmax(0,1fr))">';
	foreach ( array(
		array( __( 'Tell us about your property', 'zamin' ), __( 'Share the location, size, rooms and photos. A quick call is usually all we need to get started.', 'zamin' ) ),
		array( __( 'ZAMIN reviews & inspects', 'zamin' ), __( 'We assess the property, verify ownership details and advise on pricing and presentation.', 'zamin' ) ),
		array( __( 'Photography & listing', 'zamin' ), __( 'We create your listing with proper photos, an accurate description and the right category.', 'zamin' ) ),
		array( __( 'Go live & get booked', 'zamin' ), __( 'Your verified stay goes live on ZAMIN Stays and you start receiving direct booking requests.', 'zamin' ) ),
	) as $step ) {
		echo '<div class="z-step"><h3>' . esc_html( $step[0] ) . '</h3><p>' . esc_html( $step[1] ) . '</p></div>';
	}
	echo '</div>';
	echo '<div class="z-card" style="margin-top:36px"><p>' . esc_html__( 'Every property is reviewed by our team before it goes live, and stays are only marked Verified by ZAMIN once we have actually checked them. Your private ownership documents are kept secure and never shown publicly.', 'zamin' ) . '</p><a class="z-btn z-btn--dark z-btn--sm" href="' . esc_url( zamin_page_url( 'stays/host/apply' ) ) . '">' . esc_html__( 'Start Your Application', 'zamin' ) . '</a></div>';
	echo '</div></section>';

	zamin_render_stays_band();
}

/**
 * Render managed hosting page.
 */
function zamin_render_managed_page() {
	zamin_hero(
		'managed_hero',
		__( 'ZAMIN Managed', 'zamin' ),
		__( 'Managed Short-Term Hosting, Done Properly', 'zamin' ),
		__( "Own a property in Gilgit-Baltistan but don't want to run it yourself? ZAMIN manages the entire short-term rental — from the first photo to the monthly payout report.", 'zamin' ),
		array(
			array( __( 'Get Your Property Evaluated', 'zamin' ), zamin_page_url( 'contact' ), 'primary' ),
			array( zamin_setting( 'phone' ), 'zamin', zamin_phone_href(), 'light' ),
		)
	);

	echo '<section class="z-section"><div class="z-container">';
	zamin_head( __( 'What we handle', 'zamin' ), __( 'Everything, End to End', 'zamin' ), __( 'You keep ownership and oversight. We take care of the day-to-day running, so your property earns without becoming a second job.', 'zamin' ) );
	echo '<div class="z-grid z-grid--4">';
	foreach ( array(
		array( __( 'Property assessment', 'zamin' ), __( 'We visit, measure and assess your property and its earning potential honestly.', 'zamin' ) ),
		array( __( 'Professional photography', 'zamin' ), __( 'Clean, bright photos that show your stay at its best on every device.', 'zamin' ) ),
		array( __( 'Listing optimisation', 'zamin' ), __( 'Accurate descriptions, categories and amenities that match what travellers search for.', 'zamin' ) ),
		array( __( 'Pricing strategy', 'zamin' ), __( 'Seasonal and demand-aware nightly pricing set together with you.', 'zamin' ) ),
		array( __( 'Guest support', 'zamin' ), __( 'We answer guests, handle check-in, directions and any issue during the stay.', 'zamin' ) ),
		array( __( 'Cleaning & maintenance', 'zamin' ), __( 'Coordinated housekeeping and upkeep between every set of guests.', 'zamin' ) ),
		array( __( 'Booking management', 'zamin' ), __( 'Calendar, availability and reservations handled end to end.', 'zamin' ) ),
		array( __( 'Owner reporting', 'zamin' ), __( 'Clear monthly reporting on bookings, revenue and occupancy.', 'zamin' ) ),
	) as $item ) {
		echo '<div class="z-card"><h3>' . esc_html( $item[0] ) . '</h3><p>' . esc_html( $item[1] ) . '</p></div>';
	}
	echo '</div></div></section>';

	echo '<section class="z-section z-section--cream"><div class="z-container z-split">';
	echo '<div><span class="z-eyebrow">' . esc_html__( 'For owners', 'zamin' ) . '</span><h2>' . esc_html__( 'Clear Terms, Clear Returns', 'zamin' ) . '</h2><p class="z-lead">' . esc_html__( 'Commissions and management fees are agreed with you up front and set by ZAMIN, never hidden. We report on real bookings — no inflated numbers.', 'zamin' ) . '</p><ul class="z-list-check"><li>' . esc_html__( 'Transparent management fee agreed before we start', 'zamin' ) . '</li><li>' . esc_html__( 'Monthly reporting on bookings, revenue and occupancy', 'zamin' ) . '</li><li>' . esc_html__( 'You keep full ownership and final say on pricing', 'zamin' ) . '</li><li>' . esc_html__( 'Local team on the ground in Hunza, Gilgit and Skardu', 'zamin' ) . '</li></ul><div class="z-btn-group"><a class="z-btn z-btn--dark" href="' . esc_url( zamin_page_url( 'contact' ) ) . '">' . esc_html__( 'Request an Evaluation', 'zamin' ) . '</a><a class="z-btn z-btn--outline-dark" href="' . esc_url( zamin_whatsapp_href() ) . '">' . esc_html__( 'WhatsApp Us', 'zamin' ) . '</a></div></div>';
	echo '<div class="z-service-row__media"' . zamin_bg( 'host_report' ) . '></div>';
	echo '</div></section>';

	zamin_render_stays_band();
}

/**
 * Render host application page.
 */
function zamin_render_host_apply_page() {
	echo '<section class="z-section"><div class="z-container">';
	echo '<div class="z-section__head"><span class="z-eyebrow">' . esc_html__( 'Host onboarding', 'zamin' ) . '</span><h1>' . esc_html__( 'List your property on ZAMIN Stays', 'zamin' ) . '</h1><p class="z-lead">' . esc_html__( 'Tell us about your property in Gilgit-Baltistan. Your application goes straight to our team as a pending review — we will get in touch to arrange an inspection and sort out pricing, photography and the listing.', 'zamin' ) . '</p></div>';
	echo '<div class="z-grid z-grid--3" style="margin-bottom:36px">';
	foreach ( array(
		array( __( 'Verified first', 'zamin' ), __( 'We inspect and approve before anything goes live.', 'zamin' ) ),
		array( __( 'Privacy kept', 'zamin' ), __( 'Ownership details stay private and are never shown.', 'zamin' ) ),
		array( __( 'No obligation', 'zamin' ), __( 'Submitting an application costs nothing.', 'zamin' ) ),
	) as $item ) {
		echo '<div class="z-card"><h3>' . esc_html( $item[0] ) . '</h3><p>' . esc_html( $item[1] ) . '</p></div>';
	}
	echo '</div>';
	zamin_render_form( 'host_apply' );
	echo '<div class="z-card" style="margin-top:24px"><p>' . esc_html__( 'Prefer to talk it through first? Call or message our team and we will walk you through the two hosting models.', 'zamin' ) . '</p><div class="z-btn-group"><a class="z-btn z-btn--dark z-btn--sm" href="' . esc_url( zamin_phone_href() ) . '">' . esc_html( zamin_setting( 'phone' ) ) . '</a><a class="z-btn z-btn--outline-dark z-btn--sm" href="' . esc_url( zamin_whatsapp_href() ) . '">' . esc_html__( 'WhatsApp', 'zamin' ) . '</a></div><p class="z-small z-muted" style="margin-top:16px">' . esc_html__( 'Not sure which model fits?', 'zamin' ) . ' <a href="' . esc_url( zamin_page_url( 'stays/managed-hosting' ) ) . '">' . esc_html__( 'Learn about managed hosting', 'zamin' ) . '</a>.</p></div>';
	echo '</div></section>';
}

/* -------------------------------------------------------------------------
   Single listing templates helper
   ------------------------------------------------------------------------- */

/**
 * Render a single property or stay (used by single templates).
 *
 * @param WP_Post $post Post object.
 * @param string  $kind property|stay.
 */
function zamin_render_single_listing( $post, $kind = 'property' ) {
	$image  = has_post_thumbnail( $post ) ? get_the_post_thumbnail_url( $post, 'full' ) : zamin_image( 'property' === $kind ? 'listing_hero' : 'stays_hero' );
	$is_stay = 'stay' === $kind;
	$price  = get_post_meta( $post->ID, $is_stay ? '_zamin_price_per_night' : '_zamin_price', true );

	echo '<section class="z-hero z-hero--compact"' . ( $image ? ' style="background-image:url(\'' . esc_url( $image ) . '\')"' : '' ) . '><div class="z-container z-hero__inner"><div class="z-hero__content">';
	echo '<span class="z-eyebrow">' . esc_html( $is_stay ? zamin_terms_label( $post->ID, 'zamin_destination' ) : zamin_terms_label( $post->ID, 'zamin_location' ) ) . '</span>';
	echo '<h1>' . esc_html( get_the_title( $post ) ) . '</h1>';
	echo '<p>' . esc_html( wp_strip_all_tags( get_the_excerpt( $post ) ) ) . '</p>';
	echo '</div></div></section>';

	echo '<section class="z-section"><div class="z-container z-two-col-form">';
	echo '<div><div class="z-detail-meta">';
	$meta_items = $is_stay
		? array(
			array( __( 'Max guests', 'zamin' ), get_post_meta( $post->ID, '_zamin_max_guests', true ) ),
			array( __( 'Bedrooms', 'zamin' ), get_post_meta( $post->ID, '_zamin_bedrooms', true ) ),
			array( __( 'Beds', 'zamin' ), get_post_meta( $post->ID, '_zamin_beds', true ) ),
			array( __( 'Bathrooms', 'zamin' ), get_post_meta( $post->ID, '_zamin_bathrooms', true ) ),
		)
		: array(
			array( __( 'Purpose', 'zamin' ), ucfirst( (string) get_post_meta( $post->ID, '_zamin_purpose', true ) ) ),
			array( __( 'Bedrooms', 'zamin' ), get_post_meta( $post->ID, '_zamin_bedrooms', true ) ),
			array( __( 'Bathrooms', 'zamin' ), get_post_meta( $post->ID, '_zamin_bathrooms', true ) ),
			array( __( 'Area', 'zamin' ), get_post_meta( $post->ID, '_zamin_area_marla', true ) ? get_post_meta( $post->ID, '_zamin_area_marla', true ) . ' marla' : '' ),
		);
	foreach ( $meta_items as $item ) {
		if ( $item[1] ) {
			echo '<div class="z-detail-meta__item"><span>' . esc_html( $item[0] ) . '</span><strong>' . esc_html( $item[1] ) . '</strong></div>';
		}
	}
	echo '</div>';
	echo '<div class="z-prose">' . wp_kses_post( apply_filters( 'the_content', $post->post_content ) ) . '</div>';
	if ( $is_stay ) {
		$amenities = get_post_meta( $post->ID, '_zamin_amenities', true );
		if ( is_array( $amenities ) && $amenities ) {
			echo '<h3 style="margin-top:32px">' . esc_html__( 'Amenities', 'zamin' ) . '</h3><ul class="z-list-check">';
			foreach ( $amenities as $amenity ) {
				echo '<li>' . esc_html( $amenity ) . '</li>';
			}
			echo '</ul>';
		}
	}
	echo '</div>';
	echo '<div><div class="z-form-panel"><span class="z-eyebrow">' . esc_html( $is_stay ? 'ZAMIN Stays' : __( 'Zamin Real Estate', 'zamin' ) ) . '</span>';
	echo '<h3 class="z-form-panel__title">' . esc_html( zamin_price( $price, $is_stay ? __( '/ night', 'zamin' ) : '' ) ) . '</h3>';
	if ( get_post_meta( $post->ID, '_zamin_verified', true ) ) {
		echo '<p><span class="z-badge z-badge--gold">' . esc_html__( 'Verified by ZAMIN', 'zamin' ) . '</span></p>';
	}
	echo '<p class="z-muted z-small">' . esc_html__( 'Enquiries are handled directly by our local team in Gilgit-Baltistan.', 'zamin' ) . '</p>';
	zamin_render_form( $is_stay ? 'booking' : 'viewing', false );
	echo '</div></div>';
	echo '</div></section>';

	zamin_band(
		'',
		__( 'Looking for something else?', 'zamin' ),
		__( 'Tell our local team what you need and we will find the right match across Gilgit-Baltistan.', 'zamin' ),
		__( 'Contact Us', 'zamin' ),
		zamin_page_url( 'contact' ),
		__( 'Call Now', 'zamin' ),
		zamin_phone_href()
	);
}
