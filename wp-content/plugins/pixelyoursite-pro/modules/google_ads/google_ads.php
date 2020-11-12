<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/** @noinspection PhpIncludeInspection */
require_once PYS_PATH . '/modules/google_analytics/function-helpers.php';
/** @noinspection PhpIncludeInspection */
require_once PYS_PATH . '/modules/google_ads/function-helpers.php';

use PixelYourSite\Ads\Helpers;

class GoogleAds extends Settings implements Pixel {

	private static $_instance;

	private $configured;

	/** @var array $wooOrderParams Cached WooCommerce Purchase and AM events params */
	private $wooOrderParams = array();

	private $googleBusinessVertical;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {

		parent::__construct( 'google_ads' );

		$this->locateOptions(
			PYS_PATH . '/modules/google_ads/options_fields.json',
			PYS_PATH . '/modules/google_ads/options_defaults.json'
		);

		add_action( 'pys_register_pixels', function( $core ) {
			/** @var PYS $core */
			$core->registerPixel( $this );
		} );

		// cache value
		$this->googleBusinessVertical = PYS()->getOption( 'google_retargeting_logic' ) == 'ecomm' ? 'retail' : 'custom';

        add_filter('pys_google_ads_settings_sanitize_ads_ids_field', 'PixelYourSite\Ads\Helpers\sanitizeTagIDs');
	}

	public function enabled() {
		return $this->getOption( 'enabled' );
	}

	public function configured() {

        $license_status = PYS()->getOption( 'license_status' );
        $ads_ids = $this->getPixelIDs();

        $this->configured = $this->enabled()
                            && ! empty( $license_status ) // license was activated before
                            && count( $ads_ids ) > 0
                            && !empty($ads_ids[0])
                            && ! apply_filters( 'pys_pixel_disabled', false, $this->getSlug() );

		return $this->configured;

	}

	public function getPixelIDs() {

		$ids = (array) $this->getOption( 'ads_ids' );

		if ( isSuperPackActive() && SuperPack()->getOption( 'enabled' ) && SuperPack()->getOption( 'additional_ids_enabled' ) ) {
			return apply_filters("pys_google_ads_ids",$ids);
		} else {
			return apply_filters("pys_google_ads_ids",(array) reset( $ids )); // return first id only
		}

	}

	public function getPixelOptions() {

		return array(
			'conversion_ids'      => $this->getPixelIDs(),
			'clickEventEnabled'   => $this->getOption( 'click_event_enabled' ),
			'watchVideoEnabled'   => $this->getOption( 'watchvideo_event_enabled' ),
			'commentEventEnabled' => $this->getOption( 'comment_event_enabled' ),
			'formEventEnabled'    => $this->getOption( 'form_event_enabled' ),
			'downloadEnabled'     => $this->getOption( 'download_event_enabled' ),
		);

	}

	public function getEventData( $eventType, $args = null ) {

        if ( ! $this->configured() ) {
            return false;
        }

        switch ( $eventType ) {
            case 'init_event':
                return $this->getPageViewEventParams();

            case 'search_event':
                return $this->getSearchEventData();

            case 'custom_event':
                return $this->getCustomEventData( $args );

            case 'woo_view_content':
                return $this->getWooViewContentEventParams();

            case 'woo_add_to_cart_on_button_click':
                return $this->getWooAddToCartOnButtonClickEventParams( $args );

            case 'woo_add_to_cart_on_cart_page':
            case 'woo_add_to_cart_on_checkout_page':
                return $this->getWooAddToCartOnCartEventParams();

            case 'woo_remove_from_cart':
                return $this->getWooRemoveFromCartParams( $args );

            case 'woo_view_category':
                return $this->getWooViewCategoryEventParams();

            case 'woo_initiate_checkout':
                return $this->getWooInitiateCheckoutEventParams();

            case 'woo_affiliate_enabled':
                return $this->getWooAffiliateEventParams( $args );

            case 'woo_purchase':
                return $this->getWooPurchaseEventParams();

            case 'woo_paypal':
                return $this->getWooPayPalEventParams();

            case 'woo_frequent_shopper':
            case 'woo_vip_client':
            case 'woo_big_whale':
                return $this->getWooAdvancedMarketingEventParams( $eventType );

            case 'edd_view_content':
                return $this->getEddViewContentEventParams();

            case 'edd_add_to_cart_on_button_click':
                return $this->getEddAddToCartOnButtonClickEventParams( $args );

            case 'edd_add_to_cart_on_checkout_page':
                return $this->getEddCartEventParams( 'add_to_cart' );

            case 'edd_remove_from_cart':
                return $this->getEddRemoveFromCartParams( $args );

            case 'edd_view_category':
                return $this->getEddViewCategoryEventParams();

            case 'edd_initiate_checkout':
                return $this->getEddCartEventParams( 'begin_checkout' );

            case 'edd_purchase':
                return $this->getEddCartEventParams( 'purchase' );

            case 'edd_frequent_shopper':
            case 'edd_vip_client':
            case 'edd_big_whale':
                return $this->getEddAdvancedMarketingEventParams( $eventType );

            case 'complete_registration':
                return $this->getCompleteRegistrationEventParams();

            default:
                return false;   // event does not supported
        }


    }

    public function outputNoScriptEvents() {

	    /* dont send google ads no script events to google analytics
        if ( ! $this->configured() ) {
            return;
        }

        $eventsManager = PYS()->getEventsManager();

        foreach ( $eventsManager->getStaticEvents( 'google_ads' ) as $eventName => $events ) {
            foreach ( $events as $event ) {
                foreach ( $this->getPixelIDs() as $pixelID ) {

                    $args = array(
                        'v'   => 1,
                        'tid' => $pixelID,
                        't'   => 'event',
                    );

                    //@see: https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ec
                    if ( isset( $event['params']['event_category'] ) ) {
                        $args['ec'] = urlencode( $event['params']['event_category'] );
                    }

                    if ( isset( $event['params']['event_action'] ) ) {
                        $args['ea'] = urlencode( $event['params']['event_action'] );
                    }

                    if ( isset( $event['params']['event_label'] ) ) {
                        $args['el'] = urlencode( $event['params']['event_label'] );
                    }

                    if ( isset( $event['params']['value'] ) ) {
                        $args['ev'] = urlencode( $event['params']['value'] );
                    }

                    if ( isset( $event['params']['items'] ) ) {

                        foreach ( $event['params']['items'] as $key => $item ) {

                            @$args["pr{$key}id" ] = urlencode( $item['id'] );
                            @$args["pr{$key}nm"] = urlencode( $item['name'] );
                            @$args["pr{$key}ca"] = urlencode( $item['category'] );
                            //@$args["pr{$key}va"] = urlencode( $item['id'] ); // variant
                            @$args["pr{$key}pr"] = urlencode( $item['price'] );
                            @$args["pr{$key}qt"] = urlencode( $item['quantity'] );

                        }

                        //@todo: not tested
                        //https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pa
                        $args["pa"] = 'detail'; // required

                    }

                    // ALT tag used to pass ADA compliance
                    printf( '<noscript><img height="1" width="1" style="display: none;" src="%s" alt="google_analytics"></noscript>',
                        add_query_arg( $args, 'https://www.google-analytics.com/collect' ) );

                    echo "\r\n";

                }
            }
        }
        */
    }

    private function getPageViewEventParams() {
        if ( PYS()->getEventsManager()->doingAMP ) {

            return array(
                'name' => 'PageView',
                'data' => array(),
            );

        }

        $allowedContentTypes = array(
            'on_posts_enabled'      => PYS()->getOption( 'general_event_on_posts_enabled' ),
            'on_pages_enables'      => PYS()->getOption( 'general_event_on_pages_enabled' ),
            'on_taxonomies_enabled' => PYS()->getOption( 'general_event_on_tax_enabled' ),
            'on_cpt_enabled'        => PYS()->getOption( 'general_event_on_' . get_post_type() . '_enabled', false ),
            'on_woo_enabled'        => PYS()->getOption( 'general_event_on_woo_enabled' ),
            'on_edd_enabled'        => PYS()->getOption( 'general_event_on_edd_enabled' ),
        );

        $params = getTheContentParams( $allowedContentTypes );
        $user = wp_get_current_user();

        if ( $user->ID !== 0 ) {
            $user_roles = implode( ',', $user->roles );
        } else {
            $user_roles = 'guest';
        }
        $params['user_role'] = $user_roles;

        return array(
            'name'  => 'page_view',
            'data'  => $params,
        );

    }

    private function getSearchEventData() {
        global $posts;

        if ( ! $this->getOption( 'search_event_enabled' ) ) {
            return false;
        }

        $params['event_category'] = 'WordPress Search';
        $params['search_term'] = empty( $_GET['s'] ) ? null : $_GET['s'];
        $params['items'] = [];

        if ( isWooCommerceActive() && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {
            $params['event_category'] = 'WooCommerce Search';
        }

        $total_value = 0;

        for ( $i = 0; $i < count( $posts ); $i ++ ) {

            $item = [
                'google_business_vertical' => $this->googleBusinessVertical,
            ];

            if ( $posts[ $i ]->post_type == 'product' ) {
                $total_value += getWooProductPriceToDisplay( $posts[ $i ]->ID );
                $item['id'] = Helpers\getWooFullItemId( $posts[ $i ]->ID );
            } elseif ( $posts[ $i ]->post_type == 'download' ) {
                $total_value += getEddDownloadPriceToDisplay( $posts[ $i ]->ID );
                $item['id'] = $posts[ $i ]->ID;
            } else {
                continue;
            }

            $params['items'][] = $item;
        }

        $params['value'] = $total_value;

        return array(
            'name'  => 'view_search_results',
            'data'  => $params,
        );

    }

    /**
     * @param CustomEvent $event
     *
     * @return array|bool
     */
    private function getCustomEventData( $event ) {

        $ads_action = $event->getGoogleAdsAction();

        if ( ! $event->isGoogleAdsEnabled() || empty( $ads_action ) ) {
            return false;
        }

        $params = array(
            'event_category'  => $event->google_ads_event_category,
            'event_label'     => $event->google_ads_event_label,
            'value'           => $event->google_ads_event_value,
        );

	    // add custom params
	    foreach ( $event->getGoogleAdsCustomParams() as $custom_param ) {
		    $params[ $custom_param['name'] ] = $custom_param['value'];
	    }

        // SuperPack Dynamic Params feature
        $params = apply_filters( 'pys_superpack_dynamic_params', $params, 'google_ads' );

	    // ids
	    $ids = array();

	    $conversion_label = $event->google_ads_conversion_label;
	    $conversion_id = $event->google_ads_conversion_id;

	    if ( $conversion_id == '_all' ) {
		    $ids = $this->getPixelIDs();
	    } else {
	    	$ids[] = $conversion_id;
	    }

	    // AW-12345678 => AW-12345678/da324asDvas
	    if ( ! empty( $conversion_label ) ) {
		    foreach ( $ids as $key => $value ) {
			    $ids[ $key ] = $value . '/' . $conversion_label;
		    }
	    }

	    return array(
		    'name'  => $ads_action,
		    'data'  => $params,
		    'delay' => $event->getDelay(),
		    'ids'   => $ids,
	    );

    }

    private function getWooViewCategoryEventParams() {
        global $posts;

        if ( ! $this->getOption( 'woo_view_category_enabled' ) ) {
            return false;
        }

        $term = get_term_by( 'slug', get_query_var( 'term' ), 'product_cat' );
        if(!is_a($term,"WP_Term"))
            return false;
        $parent_ids = get_ancestors( $term->term_id, 'product_cat', 'taxonomy' );

        $product_categories = array();
        $product_categories[] = $term->name;

        foreach ( $parent_ids as $term_id ) {
            $parent_term = get_term_by( 'id', $term_id, 'product_cat' );
            $product_categories[] = $parent_term->name;
        }

        $list_name = implode( '/', array_reverse( $product_categories ) );

        $items = array();
        $total_value = 0;

        for ( $i = 0; $i < count( $posts ); $i ++ ) {

            if ( $posts[ $i ]->post_type !== 'product' ) {
                continue;
            }

            $item = array(
                'id'            => Helpers\getWooFullItemId( $posts[ $i ]->ID ),
                'name'          => $posts[ $i ]->post_title,
                'category'      => implode( '/', getObjectTerms( 'product_cat', $posts[ $i ]->ID ) ),
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $posts[ $i ]->ID ),
                'list_position' => $i + 1,
                'list'          => $list_name,
                'google_business_vertical' => $this->googleBusinessVertical,
            );

            $items[] = $item;
            $total_value += $item['price'];

        }

        $params = array(
            'event_category' => 'ecommerce',
            'event_label'    => $list_name,
            'value'          => $total_value,
            'items'          => $items,
        );

        return array(
            'name'  => 'view_item_list',
            'ids' => Helpers\getConversionIDs( 'woo_view_category' ),
            'data'  => $params,
        );

    }

    private function getWooViewContentEventParams() {
        global $post;

        if ( ! $this->getOption( 'woo_view_content_enabled' ) ) {
            return false;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'value' => getWooProductPriceToDisplay( $post->ID ),
            'items'           => array(
                array(
                    'id'       => Helpers\getWooFullItemId( $post->ID ),
                    'name'     => $post->post_title,
                    'category' => implode( '/', getObjectTerms( 'product_cat', $post->ID ) ),
                    'quantity' => 1,
                    'price'    => getWooProductPriceToDisplay( $post->ID ),
                    'google_business_vertical' => $this->googleBusinessVertical,
                ),
            ),
        );

        return array(
            'name'  => 'view_item',
            'data'  => $params,
            'ids'   => Helpers\getConversionIDs( 'woo_view_content' ),
            'delay' => (int) PYS()->getOption( 'woo_view_content_delay' ),
        );

    }

    private function getWooAddToCartOnButtonClickEventParams( $product_id ) {

        if ( ! $this->getOption( 'woo_add_to_cart_enabled' )  || ! PYS()->getOption( 'woo_add_to_cart_on_button_click' ) ) {
            return false;
        }

        $product = wc_get_product( $product_id );
        if(!$product) return false;
        $price = getWooProductPriceToDisplay( $product_id, 1 );
        $contentId = Helpers\getWooFullItemId( $product_id );

        if ( $product->get_type() == 'variation' ) {
            $parentId = $product->get_parent_id();
            $name = $product->get_title();
            $category = implode( '/', getObjectTerms( 'product_cat', $parentId ) );
            $variation_name = implode("/", $product->get_variation_attributes());
        } else {
            $name = $product->get_name();
            $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
            $variation_name = null;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'value' => $price,
            'items'           => array(
                array(
                    'id'       => $contentId,
                    'name'     => $name,
                    'category' => $category,
                    'quantity' => 1,
                    'price'    => $price,
                    'variant'  => $variation_name,
                    'google_business_vertical' => $this->googleBusinessVertical,
                ),
            ),
        );

        return array(
            'ids' => Helpers\getConversionIDs( 'woo_add_to_cart' ),
            'data'  => $params,
        );

    }

    private function getWooAddToCartOnCartEventParams() {

        if ( ! $this->getOption( 'woo_add_to_cart_enabled' ) ) {
            return false;
        }

        $params = $this->getWooCartParams();

        return array(
            'name' => 'add_to_cart',
            'ids' => Helpers\getConversionIDs( 'woo_add_to_cart' ),
            'data' => $params
        );

    }

    private function getWooRemoveFromCartParams( $cart_item ) {

        if ( ! $this->getOption( 'woo_remove_from_cart_enabled' ) ) {
            return false;
        }
        $product_id = Helpers\getWooCartItemId( $cart_item );
        $content_id = Helpers\getWooFullItemId( $product_id );


        $product = get_post( $product_id );

        if ( ! empty( $cart_item['variation_id'] ) ) {
            $variation = wc_get_product( (int) $cart_item['variation_id'] );
            if(is_a($variation, 'WC_Product_Variation')) {
                $parentId = $variation->get_parent_id();
                $name = $variation->get_title();
                $category = implode( '/', getObjectTerms( 'product_cat', $parentId ) );
                $variation_name = implode("/", $variation->get_variation_attributes());
            } else {
                $name = $product->post_title;
                $variation_name = null;
                $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
            }

        } else {
            $name = $product->post_title;
            $variation_name = null;
            $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
        }

        $price = getWooProductPriceToDisplay( $product_id, $cart_item['quantity'] );


        return array(
            'data' => array(
                'event_category'  => 'ecommerce',
                'currency'        => get_woocommerce_currency(),
                'value' => $price,
                'items'           => array(
                    array(
                        'id'       => $content_id,
                        'name'     => $name,
                        'category' => $category,
                        'quantity' => $cart_item['quantity'],
                        'price'    => $price,
                        'variant'  => $variation_name,
                        'google_business_vertical' => $this->googleBusinessVertical,
                    ),
                ),
            ),
        );

    }

    private function getWooInitiateCheckoutEventParams() {

        if ( ! $this->getOption( 'woo_initiate_checkout_enabled' ) ) {
            return false;
        }

        $params = $this->getWooCartParams( 'checkout' );

        return array(
            'name'  => 'begin_checkout',
            'ids' => Helpers\getConversionIDs( 'woo_initiate_checkout' ),
            'data'  => $params
        );

    }

    private function getWooAffiliateEventParams( $product_id ) {

        if ( ! $this->getOption( 'woo_affiliate_enabled' ) ) {
            return false;
        }

        $product = get_post( $product_id );

        $params = array(
            'event_category'  => 'ecommerce',
            'items'           => array(
                array(
                    'id'       => Helpers\getWooFullItemId( $product_id ),
                    'name'     => $product->post_title,
                    'category' => implode( '/', getObjectTerms( 'product_cat', $product_id ) ),
                    'quantity' => 1,
                    'price'    => getWooProductPriceToDisplay( $product_id, 1 ),
                ),
            ),
        );

        return array(
            'data'  => $params,
        );

    }

    private function getWooPayPalEventParams() {

        if ( ! $this->getOption( 'woo_paypal_enabled' ) ) {
            return false;
        }

        $params = $this->getWooCartParams( 'paypal' );
        unset( $params['coupon'] );

        return array(
            'name' => '', // will be set on front-end
            'data' => $params,
        );

    }

    private function getWooPurchaseEventParams() {

        if ( ! $this->getOption( 'woo_purchase_enabled' ) ) {
            return false;
        }
        $order_key = sanitize_key( $_REQUEST['key']);
        $order_id = (int) wc_get_order_id_by_order_key($order_key );

        $order = new \WC_Order( $order_id );
        $items = array();
        $total_value = 0;

        foreach ( $order->get_items( 'line_item' ) as $line_item ) {

            $product_id = Helpers\getWooCartItemId( $line_item );
            $content_id = Helpers\getWooFullItemId( $product_id );

            $post    = get_post( $product_id );
            $product = wc_get_product( $product_id );
            if(!$product) continue;
            if ( $line_item['variation_id'] ) {
                $variation = wc_get_product( (int) $line_item['variation_id'] );
                if(is_a($variation, 'WC_Product_Variation')) {
                    $name = $variation->get_title();
                    $category = implode( '/', getObjectTerms( 'product_cat', $variation->get_parent_id() ) );
                    $variation_name = implode("/", $variation->get_variation_attributes());
                } else {
                    $name = $post->post_title;
                    $variation_name = null;
                    $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
                }


            } else {
                $name = $post->post_title;
                $variation_name = null;
                $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
            }

            /**
             * Discounted price used instead of price as is on Purchase event only to avoid wrong numbers in
             * Analytic's Product Performance report.
             */
	        if ( isWooCommerceVersionGte( '3.0' ) ) {
		        $price = $line_item['total'] + $line_item['total_tax'];
	        } else {
		        $price = $line_item['line_total'] + $line_item['line_tax'];
	        }

	        $qty   = $line_item['qty'];
	        $price = $price / $qty;

            if ( isWooCommerceVersionGte( '3.0' ) ) {

                if ( 'yes' === get_option( 'woocommerce_prices_include_tax' ) ) {
                    $price = wc_get_price_including_tax( $product, array( 'qty' => 1, 'price' => $price ) );
                } else {
                    $price = wc_get_price_excluding_tax( $product, array( 'qty' => 1, 'price' => $price ) );
                }

            } else {

                if ( 'yes' === get_option( 'woocommerce_prices_include_tax' ) ) {
                    $price = $product->get_price_including_tax( 1, $price );
                } else {
                    $price = $product->get_price_excluding_tax( 1, $price );
                }

            }



            $item = array(
                'id'       => $content_id,
                'name'     => $name,
                'category' => $category,
                'quantity' => $qty,
                'price'    => $price,
                'variant'  => $variation_name,
                'google_business_vertical' => $this->googleBusinessVertical,
            );

            $items[] = $item;
            $total_value   += $item['price'];

        }

        // calculate value
        if ( PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
            $value = getWooOrderTotal( $order );
        } else {
            $value = $order->get_total();
        }

        if ( isWooCommerceVersionGte( '2.7' ) ) {
            $tax      = (float) $order->get_total_tax( 'edit' );
            $shipping = (float) $order->get_shipping_total( 'edit' );
        } else {
            $tax      = $order->get_total_tax();
            $shipping = $order->get_total_shipping();
        }

        // coupons
        if ( $coupons = $order->get_items( 'coupon' ) ) {
            $coupon = reset( $coupons );
            $coupon = $coupon['name'];
        } else {
            $coupon = null;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'transaction_id'  => $order_id,
            'value'           => $value,
            'currency'        => get_woocommerce_currency(),
            'items'           => $items,
            'tax'             => $tax,
            'shipping'        => $shipping,
            'coupon'          => $coupon,
        );

        return array(
            'name' => 'purchase',
            'ids' => Helpers\getConversionIDs( 'woo_purchase' ),
            'data' => $params
        );

    }

    private function getWooAdvancedMarketingEventParams( $eventType ) {

        if ( ! $this->getOption( $eventType . '_enabled' ) ) {
            return false;
        }

        switch ( $eventType ) {
            case 'woo_frequent_shopper':
                $eventName = 'FrequentShopper';
                break;

            case 'woo_vip_client':
                $eventName = 'VipClient';
                break;

            default:
                $eventName = 'BigWhale';
        }

        $params = $this->getWooOrderParams();

        $params['event_category'] = 'marketing';

        unset( $params['value'] );
        unset( $params['currency'] );
        unset( $params['tax'] );
        unset( $params['shipping'] );

        return array(
            'name'  => $eventName,
            'data'  => $params,
        );

    }

    private function getWooCartParams( $context = 'cart' ) {

        $items = array();
        $total_value = 0;

        foreach ( WC()->cart->cart_contents as $cart_item_key => $cart_item ) {

            $product_id = Helpers\getWooCartItemId( $cart_item );
            $content_id = Helpers\getWooFullItemId( $product_id );
            $price = getWooProductPriceToDisplay( $product_id );
            $product = get_post( $product_id );

            if ( $cart_item['variation_id'] ) {
                $variation = wc_get_product( (int) $cart_item['variation_id'] );
                if(is_a($variation, 'WC_Product_Variation')) {
                    $name = $variation->get_title();
                    $category = implode( '/', getObjectTerms( 'product_cat', $variation->get_parent_id() ) );
                    $variation_name = implode("/", $variation->get_variation_attributes());
                } else {
                    $name = $product->post_title;
                    $variation_name = null;
                    $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
                }

            } else {
                $name = $product->post_title;
                $variation_name = null;
                $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
            }



            $item = array(
                'id'       => $content_id,
                'name'     => $name,
                'category' => $category,
                'quantity' => $cart_item['quantity'],
                'price'    => $price,
                'variant'  => $variation_name,
                'google_business_vertical' => $this->googleBusinessVertical,
            );

            $items[] = $item;
            $total_value += $item['price'];

        }
        $coupons =  WC()->cart->get_applied_coupons();
        if ( count($coupons) > 0 ) {
            $coupon = $coupons[0];
        } else {
            $coupon = null;
        }

        $params = array(
            'event_category' => 'ecommerce',
            'value' => $total_value,
            'items' => $items,
            'coupon' => $coupon
        );

        return $params;

    }

    private function getWooOrderParams() {

        if ( ! empty( $this->wooOrderParams ) ) {
            return $this->wooOrderParams;
        }
        $order_key = sanitize_key( $_REQUEST['key']);
        $order_id = (int) wc_get_order_id_by_order_key( $order_key );

        $order = new \WC_Order( $order_id );
        $items = array();

        foreach ( $order->get_items( 'line_item' ) as $line_item ) {

            $product_id = Helpers\getWooCartItemId( $line_item );
            $content_id = Helpers\getWooFullItemId( $product_id );

            $post = get_post( $product_id );

            if ( $line_item['variation_id'] ) {
                $variation = wc_get_product( (int) $line_item['variation_id'] );
                if(is_a($variation, 'WC_Product_Variation')) {
                    $name = $variation->get_title();
                    $category = implode( '/', getObjectTerms( 'product_cat', $variation->get_parent_id() ) );
                    $variation_name = implode("/", $variation->get_variation_attributes());
                } else {
                    $name = $post->post_title;
                    $variation_name = null;
                    $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
                }

            } else {
                $name = $post->post_title;
                $variation_name = null;
                $category = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
            }

            $item = array(
                'id'       => $content_id,
                'name'     => $name,
                'category' => $category,
                'quantity' => $line_item['qty'],
                'price'    => getWooProductPriceToDisplay( $product_id ),
                'variant'  => $variation_name,
            );

            $items[] = $item;

        }

        // calculate value
        if ( PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
            $value = getWooOrderTotal( $order );
        } else {
            $value = $order->get_total();
        }

        if ( isWooCommerceVersionGte( '2.7' ) ) {
            $tax = (float) $order->get_total_tax( 'edit' );
            $shipping = (float) $order->get_shipping_total( 'edit' );
        } else {
            $tax = $order->get_total_tax();
            $shipping = $order->get_total_shipping();
        }

        $this->wooOrderParams = array(
            'event_category' => 'ecommerce',
            'transaction_id' => $order_id,
            'value'          => $value,
            'currency'       => get_woocommerce_currency(),
            'items'          => $items,
            'tax'            => $tax,
            'shipping'       => $shipping
        );

        return $this->wooOrderParams;

    }

    private function getCompleteRegistrationEventParams() {

        if ( ! $this->getOption( 'complete_registration_event_enabled' ) ) {
            return false;
        }

        $commonParams = getCommonEventParams();

	    return array(
		    'name' => 'sign_up',
		    'data' => array(
			    'event_category' => 'engagement',
			    'method'         => $commonParams['user_roles'],
		    ),
	    );

    }

    private function getEddViewContentEventParams() {
        global $post;

        if ( ! $this->getOption( 'edd_view_content_enabled' ) ) {
            return false;
        }

        $price = getEddDownloadPriceToDisplay( $post->ID );

        $params = array(
            'event_category'  => 'ecommerce',
            'value' => $price,
            'items'           => array(
                array(
                    'id'       => Helpers\getEddDownloadContentId($post->ID),
                    'name'     => $post->post_title,
                    'category' => implode( '/', getObjectTerms( 'download_category', $post->ID ) ),
                    'quantity' => 1,
                    'price'    => $price,
                    'google_business_vertical' => $this->googleBusinessVertical,
                ),
            ),
        );

        return array(
            'name'  => 'view_item',
            'ids' => Helpers\getConversionIDs( 'edd_view_content' ),
            'data'  => $params,
            'delay' => (int) PYS()->getOption( 'edd_view_content_delay' ),
        );

    }

    private function getEddAddToCartOnButtonClickEventParams( $download_id ) {

        if ( ! $this->getOption( 'edd_add_to_cart_enabled' ) || ! PYS()->getOption( 'edd_add_to_cart_on_button_click' ) ) {
            return false;
        }

        // maybe extract download price id
        if ( strpos( $download_id, '_') !== false ) {
            list( $download_id, $price_index ) = explode( '_', $download_id );
        } else {
            $price_index = null;
        }

        $download_post = get_post( $download_id );
        $price = getEddDownloadPriceToDisplay( $download_id, $price_index );

        $params = array(
            'event_category'  => 'ecommerce',
            'value' => $price,
            'items'           => array(
                array(
                    'id'       => Helpers\getEddDownloadContentId($download_id),
                    'name'     => $download_post->post_title,
                    'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
                    'quantity' => 1,
                    'price'    => $price,
                    'google_business_vertical' => $this->googleBusinessVertical,
                ),
            ),
        );

        return array(
            'ids' => Helpers\getConversionIDs( 'edd_add_to_cart' ),
            'data' => $params,
        );

    }

    private function getEddCartEventParams( $context = 'add_to_cart' ) {

        if ( $context == 'add_to_cart' && ! $this->getOption( 'edd_add_to_cart_enabled' ) ) {
            return false;
        } elseif ( $context == 'begin_checkout' && ! $this->getOption( 'edd_initiate_checkout_enabled' ) ) {
            return false;
        } elseif ( $context == 'purchase' && ! $this->getOption( 'edd_purchase_enabled' ) ) {
            return false;
        } else {
            // AM events allowance checked by themselves
        }

        if ( $context == 'add_to_cart' || $context == 'begin_checkout' ) {
            $cart = edd_get_cart_contents();
        } else {
            $cart = edd_get_payment_meta_cart_details( edd_get_purchase_id_by_key( getEddPaymentKey() ), true );
        }

        $items = array();
        $total_value = 0;

        foreach ( $cart as $cart_item_key => $cart_item ) {

            $download_id   = (int) $cart_item['id'];
            $download_post = get_post( $download_id );

            if ( in_array( $context, array( 'purchase', 'FrequentShopper', 'VipClient', 'BigWhale' ) ) ) {
                $item_options = $cart_item['item_number']['options'];
            } else {
                $item_options = $cart_item['options'];
            }

            if ( ! empty( $item_options ) && $item_options['price_id'] !== 0 ) {
                $price_index = $item_options['price_id'];
            } else {
                $price_index = null;
            }

            /**
             * Price as is used for all events except Purchase to avoid wrong values in Product Performance report.
             */
            if ( $context == 'purchase' ) {

                $include_tax = PYS()->getOption( 'edd_tax_option' ) == 'included' ? true : false;

                $price = $cart_item['item_price'] - $cart_item['discount'];

                if ( $include_tax == false && edd_prices_include_tax() ) {
                    $price -= $cart_item['tax'];
                } elseif ( $include_tax == true && edd_prices_include_tax() == false ) {
                    $price += $cart_item['tax'];
                }

            } else {
                $price = getEddDownloadPriceToDisplay( $download_id, $price_index );
            }

            $item = array(
                'id'       => Helpers\getEddDownloadContentId($download_id),
                'name'     => $download_post->post_title,
                'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
                'quantity' => $cart_item['quantity'],
                'price'    => $price,
                'google_business_vertical' => $this->googleBusinessVertical,
//				'variant'  => $variation_name,
            );

            $items[] = $item;
            $total_value += $price;

        }

        $params = array(
            'event_category' => 'ecommerce',
            'value' => $total_value,
            'items' => $items,
        );

        if ( $context == 'purchase' ) {

            $payment_key = getEddPaymentKey();
            $payment_id = (int) edd_get_purchase_id_by_key( $payment_key );
            $user = edd_get_payment_meta_user_info( $payment_id );

            // coupons
            $coupons = isset( $user['discount'] ) && $user['discount'] != 'none' ? $user['discount'] : null;

            if ( ! empty( $coupons ) ) {
                $coupons = explode( ', ', $coupons );
                $params['coupon'] = $coupons[0];
            }

            $params['transaction_id'] = $payment_id;
            $params['currency'] = edd_get_currency();

            // calculate value
            if ( PYS()->getOption( 'edd_event_value' ) == 'custom' ) {
                $params['value'] = getEddOrderTotal( $payment_id );
            } else {
                $params['value'] = edd_get_payment_amount( $payment_id );
            }

            if ( edd_use_taxes() ) {
                $params['tax'] = edd_get_payment_tax( $payment_id );
            } else {
                $params['tax'] = 0;
            }

        }
        $ids = array();
        switch ($context) {
            case 'add_to_cart':
                $ids = Helpers\getConversionIDs( 'edd_add_to_cart' );
                break;

            case 'begin_checkout':
                $ids = Helpers\getConversionIDs( 'edd_initiate_checkout' );
                break;

            case 'purchase':
                $ids = Helpers\getConversionIDs( 'edd_purchase' );
                break;
        }

        return array(
            'name' => $context,
            'ids' => $ids,
            'data' => $params,
        );

    }

    private function getEddRemoveFromCartParams( $cart_item ) {

        if ( ! $this->getOption( 'edd_remove_from_cart_enabled' ) ) {
            return false;
        }

        $download_id = $cart_item['id'];
        $download_post = get_post( $download_id );

        $price_index = ! empty( $cart_item['options'] ) ? $cart_item['options']['price_id'] : null;
        $price = getEddDownloadPriceToDisplay( $download_id, $price_index );

        return array(
            'data' => array(
                'event_category'  => 'ecommerce',
                'currency'        => edd_get_currency(),
                'value' => $price,
                'items'           => array(
                    array(
                        'id'       => Helpers\getEddDownloadContentId($download_id),
                        'name'     => $download_post->post_title,
                        'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
                        'quantity' => $cart_item['quantity'],
                        'price'    => $price,
                        'google_business_vertical' => $this->googleBusinessVertical,
//						'variant'  => $variation_name,
                    ),
                ),
            ),
        );

    }

    private function getEddViewCategoryEventParams() {
        global $posts;

        if ( ! $this->getOption( 'edd_view_category_enabled' ) ) {
            return false;
        }

        $term = get_term_by( 'slug', get_query_var( 'term' ), 'download_category' );
        $parent_ids = get_ancestors( $term->term_id, 'download_category', 'taxonomy' );

        $download_categories = array();
        $download_categories[] = $term->name;

        foreach ( $parent_ids as $term_id ) {
            $parent_term = get_term_by( 'id', $term_id, 'download_category' );
            $download_categories[] = $parent_term->name;
        }

        $list_name = implode( '/', array_reverse( $download_categories ) );

        $items = array();
        $total_value = 0;

        for ( $i = 0; $i < count( $posts ); $i ++ ) {

            $item = array(
                'id'            => Helpers\getEddDownloadContentId($posts[ $i ]->ID),
                'name'          => $posts[ $i ]->post_title,
                'category'      => implode( '/', getObjectTerms( 'download_category', $posts[ $i ]->ID ) ),
                'quantity'      => 1,
                'price'         => getEddDownloadPriceToDisplay( $posts[ $i ]->ID ),
                'list_position' => $i + 1,
                'list'          => $list_name,
                'google_business_vertical' => $this->googleBusinessVertical,
            );

            $items[] = $item;
            $total_value += $item['price'];

        }

        $params = array(
            'event_category' => 'ecommerce',
            'event_label'    => $list_name,
            'value'          => $total_value,
            'items'          => $items,
        );

        return array(
            'name'  => 'view_item_list',
            'ids' => Helpers\getConversionIDs( 'edd_view_category' ),
            'data'  => $params,
        );

    }

    private function getEddAdvancedMarketingEventParams( $eventType ) {

        if ( ! $this->getOption( $eventType . '_enabled' ) ) {
            return false;
        }

        switch ( $eventType ) {
            case 'edd_frequent_shopper':
                $eventName = 'FrequentShopper';
                break;

            case 'edd_vip_client':
                $eventName = 'VipClient';
                break;

            default:
                $eventName = 'BigWhale';
        }

        $params = $this->getEddCartEventParams( $eventName );

        return array(
            'name' => $eventName,
            'data' => $params['data'],
        );

    }
}

/**
 * @return GoogleAds
 */
function Ads() {
	return GoogleAds::instance();
}

Ads();
