<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function isWooCommerceVersionGte( $version ) {

	if ( defined( 'WC_VERSION' ) && WC_VERSION ) {
		return version_compare( WC_VERSION, $version, '>=' );
	} else if ( defined( 'WOOCOMMERCE_VERSION' ) && WOOCOMMERCE_VERSION ) {
		return version_compare( WOOCOMMERCE_VERSION, $version, '>=' );
	} else {
		return false;
	}

}

/**
 * @param \WC_Product|\WP_Post $product
 *
 * @return bool
 */
function wooProductIsType( $product, $type ) {

	if ( isWooCommerceVersionGte( '2.7' ) ) {
		return $type == $product->is_type( $type );
	} else {
		return $product->product_type == $type;
	}

}

function setupWooPayPalData() {

	if ( ! isWooCommerceActive() ) {
		return;
	}

	$params = array();

	// collect adapted params
	foreach ( PYS()->getRegisteredPixels() as $pixel ) {
		/** @var Pixel|Settings $pixel */

		$eventData = $pixel->getEventData( 'woo_paypal' );

		// event is disabled or not supported for the pixel
		if ( false === $eventData ) {
			continue;
		}

		$params[ $pixel->getSlug() ] = sanitizeParams( $eventData['data'] );

	}

	if ( empty( $params ) ) {
		return;
	}

	$params = json_encode( $params );

	?>

	<script type="text/javascript">
        /* <![CDATA[ */
        window.pysWooPayPalData = window.pysWooPayPalData || [];
        window.pysWooPayPalData = <?php echo $params; ?>;
        /* ]]> */
	</script>

	<?php
}

function getWooProductPrice( $product_id, $qty = 1 ) {

	$product = wc_get_product( $product_id );

	if( false == $product ) {
		return 0;
	}

	$include_tax = PYS()->getOption( 'woo_tax_option' ) == 'included' ? true : false;

	if ( $product->is_taxable() && $include_tax ) {

		if ( isWooCommerceVersionGte( '3.0' ) ) {
			$value = wc_get_price_including_tax( $product, array(
				'price' => $product->get_price(),
				'qty' => $qty
			) );
		} else {
			$value = $product->get_price_including_tax();
		}

	} else {

		if ( isWooCommerceVersionGte( '3.0' ) ) {
			$value = wc_get_price_excluding_tax( $product, array(
				'price' => $product->get_price(),
				'qty' => $qty
			) );
		} else {
			$value = $product->get_price_excluding_tax();
		}

	}

	return $value;

}

function getWooProductPriceToDisplay( $product_id, $qty = 1 ) {

	if ( ! $product = wc_get_product( $product_id ) ) {
		return 0;
	}

	if ( isWooCommerceVersionGte( '2.7' ) ) {

		return (float) wc_get_price_to_display( $product, array( 'qty' => $qty ) );

	} else {

		return 'incl' === get_option( 'woocommerce_tax_display_shop' )
			? $product->get_price_including_tax( $qty )
			: $product->get_price_excluding_tax( $qty );

	}

}

function getWooCartSubtotal() {

	// subtotal is always same value on front-end and depends on PYS options
	$include_tax = get_option( 'woocommerce_tax_display_cart' ) == 'incl';

	if ( $include_tax ) {

		if ( isWooCommerceVersionGte( '3.2.0' ) ) {
			$subtotal = (float) WC()->cart->get_subtotal() + (float) WC()->cart->get_subtotal_tax();
		} else {
			$subtotal = WC()->cart->subtotal;
		}

	} else {

		if ( isWooCommerceVersionGte( '3.2.0' ) ) {
			$subtotal = (float) WC()->cart->get_subtotal();
		} else {
			$subtotal = WC()->cart->subtotal_ex_tax;
		}

	}

	return $subtotal;

}

function getWooCartTotal() {

	$include_tax = PYS()->getOption( 'woo_tax_option' ) == 'included' ? true : false;

	if ( $include_tax ) {
		$total = WC()->cart->cart_contents_total + WC()->cart->tax_total;
	} else {
		$total = WC()->cart->cart_contents_total;
	}

	return $total;

}

/**
 * @param \WC_Order $order
 *
 * @return string
 */
function getWooOrderTotal( $order ) {

	$include_tax = PYS()->getOption( 'woo_tax_option' ) == 'included' ? true : false;
	$include_shipping = PYS()->getOption( 'woo_shipping_option' ) == 'included' ? true : false;

	if ( $include_shipping && $include_tax ) {

		$total = $order->get_total();   // full order price

	} elseif ( ! $include_shipping && ! $include_tax ) {

		$cart_subtotal  = $order->get_subtotal();

		if ( isWooCommerceVersionGte( '2.7' ) ) {
			$discount_total = (float) $order->get_discount_total( 'edit' );
		} else {
			$discount_total = $order->get_total_discount();
		}

		$total = $cart_subtotal - $discount_total;

	} elseif ( ! $include_shipping && $include_tax ) {

		if ( isWooCommerceVersionGte( '2.7' ) ) {
			$cart_total     = (float) $order->get_total( 'edit' );
			$shipping_total = (float) $order->get_shipping_total( 'edit' );
			$shipping_tax   = (float) $order->get_shipping_tax( 'edit' );
		} else {
			$cart_total     = $order->get_total();
			$shipping_total = $order->get_total_shipping();
			$shipping_tax   = $order->get_shipping_tax();
		}

		$total = $cart_total - $shipping_total - $shipping_tax;

	} else {
		// $include_shipping && !$include_tax

		$cart_subtotal  = $order->get_subtotal();

		if ( isWooCommerceVersionGte( '2.7' ) ) {
			$discount_total = (float) $order->get_discount_total( 'edit' );
			$shipping_total = (float) $order->get_shipping_total( 'edit' );
		} else {
			$discount_total = $order->get_total_discount();
			$shipping_total = $order->get_total_shipping();
		}

		$total = $cart_subtotal - $discount_total + $shipping_total;

	}

	//wc_get_price_thousand_separator is ignored
	return number_format( $total, wc_get_price_decimals(), '.', '' );

}

/**
 * @param String $valueOption
 * @param float $global
 * @param float $percent
 * @param int $product_id
 * @param int $qty
 * @return false|float|int
 */

function getWooEventValue( $valueOption, $global, $percent, $product_id,$qty ) {


    $product = wc_get_product($product_id);

    if(!$product) return 0;

    if($valueOption == 'cog' && isPixelCogActive()) {

        $args = array( 'qty'   => $qty, 'price' => $product->get_price());
        if(get_option( '_pixel_cog_tax_calculating')  == 'no') {
            $amount = wc_get_price_excluding_tax($product, $args);
        } else {
            $amount = wc_get_price_including_tax($product,$args);
        }

        $cog = getAvailableProductCog($product);

        if ($cog['val']) {
            if ($cog['type'] == 'fix') {
                $value = round((float)$amount - (float)$cog['val'], 2);
            } else {
                $value = round((float)$amount - ((float)$amount * (float)$cog['val'] / 100), 2);
            }
        } else {
            $value = (float)$amount;
        }
        return $value;
    }

    if ( PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
        $amount = getWooProductPrice( $product_id, $qty );
    } else {
        $amount = getWooProductPriceToDisplay( $product_id, $qty );
    }

	switch ( $valueOption ) {
		case 'global': $value = $global; break;
		case 'percent':
			$percents = (float) $percent;
			$percents = str_replace( '%', null, $percents );
			$percents = (float) $percents / 100;
			$value    = (float) $amount * $percents;
            break;
        default:$value = (float)$amount;
	}

	return $value;

}

/**
 * @param $valueOption
 * @param \WC_Order $order
 * @param $global
 * @param $order_id
 * @param $content_ids
 * @param int $percent
 * @return float|int
 */
function getWooEventValueOrder( $valueOption, $order, $global, $percent = 100 ) {

    if ( PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
        $amount = getWooOrderTotal( $order );
    } else {
        $amount = $order->get_total();
    }
	switch ( $valueOption ) {
		case 'global':
			$value = (float) $global;
			break;

		case 'cog':
			$cog_value = getAvailableProductCogOrder($order->get_id());
			($cog_value !== '') ? $value = (float) round($cog_value, 2) : $value = (float) $amount;
			if ( !isPixelCogActive() ) $value = (float) $amount;
			break;

		case 'percent':
			$percents = (float) $percent;
			$percents = str_replace( '%', null, $percents );
			$percents = (float) $percents / 100;
			$value    = (float) $amount * $percents;
			break;

		default:    // "price" option
			$value = (float) $amount;
	}

	return $value;

}

function getWooEventValueCart( $valueOption, $global, $percent = 100 ) {


    if($valueOption == 'cog' && isPixelCogActive()) {
        $cog_value = getAvailableProductCogCart();
        if($cog_value !== '')
            return (float) round($cog_value, 2) ;

        if ( get_option( '_pixel_cog_tax_calculating')  == 'no' ) {
            return WC()->cart->cart_contents_total;
        }

        return WC()->cart->cart_contents_total + WC()->cart->tax_total;
    }


    if ( PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
        $amount = getWooCartTotal();
    } else {
        $amount = $params['value'] = WC()->cart->subtotal;
    }

	switch ( $valueOption ) {
		case 'global':
			$value = (float) $global;
			break;

		case 'percent':
			$percents = (float) $percent;
			$percents = str_replace( '%', null, $percents );
			$percents = (float) $percents / 100;
			$value    = (float) $amount * $percents;
			break;

		default:    // "price" option
			$value = (float) $amount;
	}

	return $value;
}

function getWooCustomerTotals() {
	global $wpdb;

	$totals = array(
		'orders_count' => 0,
		'avg_order_value' => 0,
		'ltv' => 0,
	);

	$user_id = get_current_user_id();

	if ( $user_id ) {

		// get customer orders
		$order_ids = $wpdb->get_col( $wpdb->prepare( "
            SELECT post_id 
            FROM $wpdb->postmeta 
            WHERE   meta_key = '_customer_user' 
              AND   meta_value = '%d'
            ", $user_id ) );

	} else {
        $key = sanitize_key($_REQUEST['key']);
		// get last order for guests
		$order_ids = array( (int) wc_get_order_id_by_order_key( $key ) );

	}

	if( empty( $order_ids ) ) {
		return $totals;
	}

	$order_statues = PYS()->getOption( 'woo_ltv_order_statuses' );
	$order_statues = array_filter( $order_statues );

	if ( empty( $order_statues ) ) {
		$order_statues = array_keys( wc_get_order_statuses() );
	}

	$post_ids_placeholder = implode( ', ', array_fill( 0, count( $order_ids ), '%d' ) );
	$post_statuses_placeholder = implode( ', ', array_fill( 0, count( $order_statues ), '%s' ) );

	// calculate totals
	$query = $wpdb->prepare( "
        SELECT  SUM(meta_value) AS ltv, AVG(meta_value) as avg_order_value, COUNT(meta_value) AS orders_count 
        FROM    $wpdb->postmeta AS pm
        JOIN    $wpdb->posts AS p ON pm.post_id = p.ID
        WHERE   p.ID IN ({$post_ids_placeholder})
                AND p.post_status IN ({$post_statuses_placeholder})
                AND pm.meta_key = '_order_total'
        GROUP BY meta_key
    ", array_merge( $order_ids, $order_statues ) );

	$results = $wpdb->get_results( $query );

	if ( null === $results || empty( $results ) ) {
		return $totals;
	} else {
		return array(
			'orders_count'    => (int) $results[0]->orders_count,
			'avg_order_value' => round( (float) $results[0]->avg_order_value, 2),
			'ltv'             => round( (float) $results[0]->ltv, 2),
		);
	}

}

function wooExportCustomAudiences() {
	global $wpdb;
	
	ob_clean();
	
	$csv_data = array();
	
	$order_statues = PYS()->getOption( 'woo_ltv_order_statuses', array() );
	
	if ( empty( $order_statues ) ) {
		$order_statues = array_keys( wc_get_order_statuses() );
	}
	
	$order_statues_placeholders = implode( ', ', array_fill( 0, count( $order_statues ), '%s' ) );
	
	// collect all unique customers by email
	$query = $wpdb->prepare( "
        SELECT  postmeta.meta_value AS email, postmeta.post_id
        FROM    $wpdb->postmeta AS postmeta
        JOIN    $wpdb->posts AS posts ON postmeta.post_id = posts.ID
        WHERE   posts.post_type = 'shop_order'
                AND posts.post_status IN ({$order_statues_placeholders})
                AND postmeta.meta_key = '_billing_email'
    ", $order_statues );
	
	$results = $wpdb->get_results( $query );
	
	$customers = array();
	
	// format data as email => [ order_ids ]
	foreach ( $results as $row ) {
		
		$order_ids   = isset( $customers[ $row->email ] ) ? $customers[ $row->email ] : array();
		$order_ids[] = (int) $row->post_id;
		
		$customers[ $row->email ] = $order_ids;
		
	}
	
	@ini_set( 'max_execution_time', 180 );
	
	// collect data per each customer
	foreach ( $customers as $email => $order_ids ) {
		
		$order_ids_placeholders = implode( ',', array_fill( 0, count( $order_ids ), '%d' ) );
		
		// calculate customer LTV
		$query = $wpdb->prepare( "
            SELECT  SUM( meta_value )
            FROM    $wpdb->postmeta
            WHERE   post_id IN ( {$order_ids_placeholders} )
                    AND meta_key = '_order_total'
        ", $order_ids );
		
		$customer_ltv = $wpdb->get_col( $query );
		
		// query customer data from last order
		$query = $wpdb->prepare( "
            SELECT  meta_key, meta_value
            FROM    $wpdb->postmeta
            WHERE   post_id = %d
                    AND meta_key IN ( '_billing_first_name', '_billing_last_name', '_billing_city', '_billing_state',
                    '_billing_postcode', '_billing_country', '_billing_phone' )
        ", end( $order_ids ) );
		
		$results = $wpdb->get_results( $query );
		
		$customer_meta          = wp_list_pluck( $results, 'meta_value', 'meta_key' );
		$customer_meta['ltv']   = (float) $customer_ltv[0];
		$customer_meta['email'] = $email;
		
		$csv_data[] = $customer_meta;
		
	}
	
	// generate file name
	$site_name = site_url();
	$site_name = str_replace( array( 'http://', 'https://' ), '', $site_name );
	$site_name = strtolower( preg_replace( "/[^A-Za-z]/", '_', $site_name ) );
	$file_name = strftime( '%Y%m%d' ) . '_' . $site_name . '_woo_customers.csv';
	
	// output CSV
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=' . $file_name );
	
	$output = fopen( 'php://output', 'w' );
	
	// headings
	fputcsv( $output, array( 'email', 'phone', 'fn', 'ln', 'ct', 'st', 'country', 'zip', 'value' ) );
	
	// rows
	foreach ( $csv_data as $row ) {
		
		fputcsv( $output, array(
			$row['email'],
			isset( $row['_billing_phone'] ) ? $row['_billing_phone'] : '',
			isset( $row['_billing_first_name'] ) ? $row['_billing_first_name'] : '',
			isset( $row['_billing_last_name'] ) ? $row['_billing_last_name'] : '',
			isset( $row['_billing_city'] ) ? $row['_billing_city'] : '',
			isset( $row['_billing_state'] ) ? $row['_billing_state'] : '',
			isset( $row['_billing_country'] ) ? $row['_billing_country'] : '',
			isset( $row['_billing_postcode'] ) ? $row['_billing_postcode'] : '',
			$row['ltv']
		) );
		
	}
	
	exit;
	
}