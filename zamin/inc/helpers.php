<?php
/**
 * Small shared helpers.
 *
 * @package Zamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default contact details, mirroring zaminzameen.com.
 *
 * @return array
 */
function zamin_default_settings() {
	return array(
		'phone'             => '+92 355 509 9430',
		'phone_digits'      => '+923555099430',
		'email'             => 'baqircustoms369@gmail.com',
		'whatsapp'          => '923555099430',
		'address'           => 'Sultanabad, Danyore Gilgit, Gilgit Baltistan',
		'hours'             => 'Mon–Sat: 9:00 AM – 7:00 PM',
		'notification_email' => 'baqircustoms369@gmail.com',
	);
}

/**
 * Read a theme setting.
 *
 * @param string $key Setting key.
 * @return string
 */
function zamin_setting( $key ) {
	$settings = get_option( 'zamin_settings', array() );
	$defaults = zamin_default_settings();

	if ( isset( $settings[ $key ] ) && '' !== $settings[ $key ] ) {
		return (string) $settings[ $key ];
	}

	return isset( $defaults[ $key ] ) ? (string) $defaults[ $key ] : '';
}

/**
 * Tel link for the configured phone number.
 *
 * @return string
 */
function zamin_phone_href() {
	return 'tel:' . str_replace( array( ' ', '-', '(', ')' ), '', zamin_setting( 'phone_digits' ) );
}

/**
 * WhatsApp link for the configured number.
 *
 * @param string $message Optional prefilled message.
 * @return string
 */
function zamin_whatsapp_href( $message = '' ) {
	$number = preg_replace( '/[^0-9]/', '', zamin_setting( 'whatsapp' ) );
	$url    = 'https://wa.me/' . $number;
	if ( $message ) {
		$url .= '?text=' . rawurlencode( $message );
	}
	return $url;
}

/**
 * Build a readdy.ai editorial image URL. The images used on the source site
 * are hosted there, so the same URLs are reused here.
 *
 * @param string $query       Image description.
 * @param int    $width       Image width.
 * @param int    $height      Image height.
 * @param string $seq         Unique image key.
 * @param string $orientation landscape|portrait.
 * @return string
 */
function zamin_image_url( $query, $width, $height, $seq, $orientation = 'landscape' ) {
	$url = 'https://readdy.ai/api/search-image?query=' . rawurlencode( $query );
	$url .= '&width=' . (int) $width . '&height=' . (int) $height;
	$url .= '&seq=' . rawurlencode( $seq ) . '&orientation=' . rawurlencode( $orientation );
	return $url;
}

/**
 * Named image library from the live site.
 *
 * @param string $key Image key.
 * @return string URL, empty when unknown.
 */
function zamin_image( $key ) {
	$images = array(
		'hero' => zamin_image_url(
			'Panoramic view of Hunza Valley in Gilgit-Baltistan Pakistan at golden hour, snow capped Rakaposhi and Karakoram peaks, terraced green fields and a traditional stone village, dramatic soft clouds, rich warm cinematic landscape photography, deep shadows for text contrast, premium editorial quality',
			1920, 1080, 'zamin-hero-premium'
		),
		'listing_hero' => zamin_image_url(
			'Panoramic view of Hunza Valley Gilgit Baltistan with mountains and green terrace fields soft warm light cinematic wide landscape photography',
			1600, 500, 'zamin-listing-hero'
		),
		'sell_hero' => zamin_image_url(
			'Traditional stone mountain house with a warm glowing window at dusk in Gilgit Baltistan Pakistan with mountains behind cinematic warm lighting premium real estate photography',
			1600, 600, 'zamin-sell-hero'
		),
		'valuation_hero' => zamin_image_url(
			'Traditional stone and wood house with terraced green fields and snow capped mountains behind in Gilgit Baltistan Pakistan, warm golden light, cinematic real estate landscape photography',
			1600, 600, 'zamin-valuation-hero'
		),
		'services_hero' => zamin_image_url(
			'Sweeping aerial panorama of Gilgit Baltistan mountain valleys with green fields and villages, soft warm afternoon light, cinematic wide landscape photography',
			1600, 600, 'zamin-services-hero'
		),
		'contact_hero' => zamin_image_url(
			'Gilgit city skyline nestled among mountains in Gilgit Baltistan Pakistan at soft golden light, wide cinematic landscape photography',
			1600, 600, 'zamin-contact-hero'
		),
		'legal_hero' => zamin_image_url(
			'Serene minimalist mountain valley in Gilgit Baltistan Pakistan with soft morning mist and muted green terraced fields, calm understated cinematic wide landscape photography with gentle natural light',
			1600, 600, 'zamin-legal-hero'
		),
		'why' => zamin_image_url(
			'Trusting family couple meeting a professional real estate agent outside a modern stone mountain home in Gilgit-Baltistan Pakistan, snow capped peaks behind, warm natural daylight, friendly welcoming atmosphere, premium editorial photography',
			1000, 1200, 'zamin-why-premium', 'portrait'
		),
		'alerts' => zamin_image_url(
			'Soft abstract artistic background of layered mountain silhouettes in deep forest green tones with subtle grain texture, minimal elegant gradient, clean modern premium aesthetic',
			1600, 700, 'zamin-alerts-band'
		),
		'consult' => zamin_image_url(
			'Soft abstract artistic background of layered mountain silhouettes in deep forest green and warm gold tones, minimal elegant gradient, subtle texture, clean modern premium aesthetic',
			1600, 700, 'zamin-consult-cta'
		),
		'service_buying' => zamin_image_url(
			'Happy couple reviewing property plans with a real estate advisor in a bright modern office with mountain views through the window, warm natural light, professional lifestyle photography, clean minimalist interior',
			900, 700, 'zamin-svc-buying'
		),
		'service_sales' => zamin_image_url(
			'Elegant traditional stone and wood house in Gilgit Baltistan Pakistan with a for sale sign, green garden and mountains behind, bright daylight, premium real estate photography',
			900, 700, 'zamin-svc-sales'
		),
		'service_rental' => zamin_image_url(
			'Handing over a house key to a happy family at the front door of a modern home with mountain scenery in Pakistan, warm welcoming light, lifestyle real estate photography',
			900, 700, 'zamin-svc-rental'
		),
		'service_valuation' => zamin_image_url(
			'Real estate professional with a clipboard and measuring tape assessing a property exterior in a green mountain valley in Pakistan, focused documentary style photography, bright natural light',
			900, 700, 'zamin-svc-valuation'
		),
		'service_investment' => zamin_image_url(
			'Modern wooden desk with property investment charts, a small architectural model and a laptop showing graphs, warm natural light, premium business editorial photography, clean minimal composition',
			900, 700, 'zamin-svc-investment'
		),
		'service_marketing' => zamin_image_url(
			'Photographer capturing a beautiful mountain property with a professional camera on a tripod at golden hour in Gilgit Baltistan Pakistan, behind the scenes editorial photography, warm cinematic light',
			900, 700, 'zamin-svc-marketing'
		),
		'service_docs' => zamin_image_url(
			'Close up of signing a property sale agreement with a pen on a wooden desk, official documents and keys nearby, soft warm natural light, professional business photography',
			900, 700, 'zamin-svc-docs'
		),
		'stays_hero' => zamin_image_url(
			'A cosy modern mountain lodge villa with warm glowing windows nestled among pine trees in Gilgit-Baltistan Pakistan at golden hour, dramatic snow capped Karakoram peaks behind, soft misty valley, rich warm cinematic travel photography with deep shadows for text contrast',
			1920, 1080, 'stays-hero-gb-v1'
		),
		'stays_cta' => zamin_image_url(
			'Serene wide mountain valley in Gilgit-Baltistan Pakistan at dusk, soft purple and amber sky over snow capped peaks and a quiet village with warm glowing windows, calm atmospheric travel photography with dark tones for text contrast',
			1920, 900, 'stays-cta-gb-v1'
		),
		'host_hero' => zamin_image_url(
			'Warm welcoming Gilgit-Baltistan homeowner couple standing outside their beautiful wooden guesthouse with apricot trees and mountains behind, genuine friendly smiles, soft golden natural light, authentic lifestyle travel photography with dark tones for text contrast',
			1920, 1080, 'stays-host-hero-v1'
		),
		'managed_hero' => zamin_image_url(
			'Elegantly styled modern mountain villa interior prepared for guests in Gilgit-Baltistan Pakistan, fresh white linens, warm wooden furniture, large windows with dramatic snow capped peaks, soft inviting daylight, premium editorial hospitality photography with dark tones for text contrast',
			1920, 1080, 'stays-managed-hero-v1'
		),
		'host_listed' => zamin_image_url(
			'Warm friendly local homeowner standing on the wooden veranda of a traditional guesthouse in Hunza Pakistan, orchards and mountains behind, natural inviting daylight, authentic lifestyle travel photography',
			1200, 700, 'stays-listed-owner-v1'
		),
		'host_managed' => zamin_image_url(
			'Professional hospitality team in smart uniforms preparing a beautifully styled mountain villa for guests in Gilgit-Baltistan Pakistan, fresh linens and warm interior, organised premium property management scene, editorial photography',
			1200, 700, 'stays-managed-team-v1'
		),
		'host_report' => zamin_image_url(
			'Property owner reviewing a clean monthly earnings and occupancy report on a tablet at a wooden desk, cup of tea beside, warm soft light through a window framing green mountain valley, calm professional lifestyle photography',
			1000, 1200, 'stays-managed-report-v1', 'portrait'
		),
	);

	return isset( $images[ $key ] ) ? $images[ $key ] : '';
}

/**
 * Inline background-image style for a named image.
 *
 * @param string $key   Image key.
 * @param string $extra Optional extra CSS declarations.
 * @return string
 */
function zamin_bg( $key, $extra = '' ) {
	$url    = zamin_image( $key );
	$styles = array();

	if ( $url ) {
		$styles[] = "background-image:url('" . esc_url( $url ) . "')";
	}
	if ( $extra ) {
		$styles[] = trim( $extra, ';' );
	}

	return $styles ? ' style="' . implode( ';', $styles ) . '"' : '';
}

/**
 * Count published items of a post type.
 *
 * @param string $post_type Post type slug.
 * @return int
 */
function zamin_count( $post_type ) {
	$count = wp_count_posts( $post_type );
	return isset( $count->publish ) ? (int) $count->publish : 0;
}

/**
 * URL of a page created by the theme, with a safe fallback.
 *
 * @param string $slug Page slug.
 * @return string
 */
function zamin_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page );
	}
	return home_url( '/' . ltrim( $slug, '/' ) . '/' );
}

/**
 * Format a PKR price for display.
 *
 * @param mixed  $value Price.
 * @param string $suffix Trailing label.
 * @return string
 */
function zamin_price( $value, $suffix = '' ) {
	$value = (float) $value;
	if ( $value <= 0 ) {
		return __( 'Price on request', 'zamin' );
	}
	$formatted = 'PKR ' . number_format( $value, 0, '.', ',' );
	return $suffix ? $formatted . ' ' . $suffix : $formatted;
}

/**
 * Sanitize a text field from $_GET / $_POST.
 *
 * @param array  $source Source array.
 * @param string $key    Field key.
 * @return string
 */
function zamin_input( $source, $key ) {
	if ( ! isset( $source[ $key ] ) || ! is_scalar( $source[ $key ] ) ) {
		return '';
	}
	return sanitize_text_field( wp_unslash( $source[ $key ] ) );
}

/**
 * Current property/stay listing purpose from the request.
 *
 * @return string
 */
function zamin_current_purpose() {
	$purpose = zamin_input( $_GET, 'purpose' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	return in_array( $purpose, array( 'sale', 'rent' ), true ) ? $purpose : 'sale';
}

/**
 * Fallback primary menu shown before theme setup has created menus.
 */
function zamin_fallback_menu() {
	echo '<ul>';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 3,
			'exclude'  => '',
		)
	);
	echo '</ul>';
}

/**
 * Fallback footer menu.
 */
function zamin_fallback_footer_menu() {
	echo '<ul>';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 8,
		)
	);
	echo '</ul>';
}
