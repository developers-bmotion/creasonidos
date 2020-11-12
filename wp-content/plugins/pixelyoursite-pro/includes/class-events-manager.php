<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\Content;

class EventsManager {
	
	public $doingAMP = false;
	
	private $staticEvents = array();

	private $dynamicEventsParams = array();

	private $dynamicEventsTriggers = array();

	private $wooCustomerTotals = array();

	private $eddCustomerTotals = array();

	private $facebookServerEventTypes = array("edd_purchase","woo_purchase","init_event","woo_view_content",
        "edd_view_content","edd_initiate_checkout","woo_initiate_checkout");

	private static $hours = ['00-01', '01-02', '02-03', '03-04', '04-05', '05-06', '06-07', '07-08',
        '08-09', '09-10', '10-11', '11-12', '12-13', '13-14', '14-15', '15-16', '16-17',
        '17-18', '18-19', '19-20', '20-21', '21-22', '22-23', '23-24'
    ];

	static public $facebookServerEvents = array();


	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

		add_action( 'wp_head', array( $this, 'setupEventsParams' ), 3 );
		add_action( 'wp_head', array( $this, 'outputData' ), 4 );
		add_action( 'wp_footer', array( $this, 'outputNoScriptData' ), 10 );

	}

	public function enqueueScripts() {
		
		wp_register_script( 'vimeo', PYS_URL . '/dist/scripts/vimeo.min.js' );
		wp_register_script( 'jquery-bind-first', PYS_URL . '/dist/scripts/jquery.bind-first-0.2.3.min.js', array( 'jquery' ) );
		wp_register_script( 'js-cookie', PYS_URL . '/dist/scripts/js.cookie-2.1.3.min.js', array(), '2.1.3' );
		
		wp_enqueue_script( 'js-cookie' );
		wp_enqueue_script( 'jquery-bind-first' );

		if ( isEventEnabled( 'watchvideo_event_enabled' ) ) {
			wp_enqueue_script( 'vimeo' );
		}
		
		wp_enqueue_script( 'pys', PYS_URL . '/dist/scripts/public.js',
			array( 'jquery', 'js-cookie', 'jquery-bind-first' ), PYS_VERSION );

	}

	public function outputData() {
		global $post;

		$data = array(
			'staticEvents'          => $this->staticEvents,
			'dynamicEventsParams'   => $this->dynamicEventsParams,
			'dynamicEventsTriggers' => $this->dynamicEventsTriggers,
		);

		// collect options for configured pixel
		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */
			
			if ( $pixel->configured() ) {
				$data[ $pixel->getSlug() ] = $pixel->getPixelOptions();
			}
			
		}
		
		$options = array(
			'debug'                => PYS()->getOption( 'debug_enabled' ),
			'siteUrl'              => site_url(),
			'ajaxUrl'              => admin_url( 'admin-ajax.php' ),
			'commonEventParams'    => getCommonEventParams(),
			'clickEventEnabled'    => isEventEnabled( 'click_event_enabled' ),
			'adSenseEventEnabled'  => isEventEnabled( 'adsense_enabled' ),
			'watchVideoEnabled'    => isEventEnabled( 'watchvideo_event_enabled' ),
			'commentEventEnabled'  => isEventEnabled( 'comment_event_enabled' ),
			'formEventEnabled'     => isEventEnabled( 'form_event_enabled' ),
			'downloadEventEnabled' => isEventEnabled( 'download_event_enabled' ),
			'downloadExtensions'   => PYS()->getOption( 'download_event_extensions' ),
			'trackUTMs'            => PYS()->getOption( 'track_utms' ),
			'trackTrafficSource'   => PYS()->getOption( 'track_traffic_source' ),
			'postType'			   => get_post_type()
		);
		
		$options['gdpr'] = array(
			'ajax_enabled'              => PYS()->getOption( 'gdpr_ajax_enabled' ),
			'all_disabled_by_api'       => apply_filters( 'pys_disable_by_gdpr', false ),
			'facebook_disabled_by_api'  => apply_filters( 'pys_disable_facebook_by_gdpr', false ),
			'analytics_disabled_by_api' => apply_filters( 'pys_disable_analytics_by_gdpr', false ),
			'google_ads_disabled_by_api' => apply_filters( 'pys_disable_google_ads_by_gdpr', false ),
			'pinterest_disabled_by_api' => apply_filters( 'pys_disable_pinterest_by_gdpr', false ),
			'bing_disabled_by_api' => apply_filters( 'pys_disable_bing_by_gdpr', false ),
			
			'facebook_prior_consent_enabled'   => PYS()->getOption( 'gdpr_facebook_prior_consent_enabled' ),
			'analytics_prior_consent_enabled'  => PYS()->getOption( 'gdpr_analytics_prior_consent_enabled' ),
			'google_ads_prior_consent_enabled' => PYS()->getOption( 'gdpr_google_ads_prior_consent_enabled' ),
			'pinterest_prior_consent_enabled'  => PYS()->getOption( 'gdpr_pinterest_prior_consent_enabled' ),
			'bing_prior_consent_enabled' => PYS()->getOption( 'gdpr_bing_prior_consent_enabled' ),
			
			'cookiebot_integration_enabled'         => isCookiebotPluginActivated() && PYS()->getOption( 'gdpr_cookiebot_integration_enabled' ),
			'cookiebot_facebook_consent_category'   => PYS()->getOption( 'gdpr_cookiebot_facebook_consent_category' ),
			'cookiebot_analytics_consent_category'  => PYS()->getOption( 'gdpr_cookiebot_analytics_consent_category' ),
			'cookiebot_google_ads_consent_category' => PYS()->getOption( 'gdpr_cookiebot_google_ads_consent_category' ),
			'cookiebot_pinterest_consent_category'  => PYS()->getOption( 'gdpr_cookiebot_pinterest_consent_category' ),
			'cookiebot_bing_consent_category' => PYS()->getOption( 'gdpr_cookiebot_bing_consent_category' ),
			
			'ginger_integration_enabled' => isGingerPluginActivated() && PYS()->getOption( 'gdpr_ginger_integration_enabled' ),
			'cookie_notice_integration_enabled' => isCookieNoticePluginActivated() && PYS()->getOption( 'gdpr_cookie_notice_integration_enabled' ),
			'cookie_law_info_integration_enabled' => isCookieLawInfoPluginActivated() && PYS()->getOption( 'gdpr_cookie_law_info_integration_enabled' ),
		);
		
		$options['woo'] = array(
			'enabled'                       => isWooCommerceActive() && PYS()->getOption( 'woo_enabled' ),
			'addToCartOnButtonEnabled'      => isEventEnabled( 'woo_add_to_cart_enabled' ) && PYS()->getOption( 'woo_add_to_cart_on_button_click' ),
			'addToCartOnButtonValueEnabled' => PYS()->getOption( 'woo_add_to_cart_value_enabled' ),
			'addToCartOnButtonValueOption'  => PYS()->getOption( 'woo_add_to_cart_value_option' ),
			'singleProductId'               => isWooCommerceActive() && is_singular( 'product' ) ? $post->ID : null,
			'removeFromCartEnabled'         => isEventEnabled( 'woo_remove_from_cart_enabled' ),
			'affiliateEnabled'              => isEventEnabled( 'woo_affiliate_enabled' ),
			'payPalEnabled'                 => isEventEnabled( 'woo_paypal_enabled' ),
			'removeFromCartSelector'        => isWooCommerceVersionGte( '3.0.0' )
			? 'form.woocommerce-cart-form .remove'
			: '.cart .product-remove .remove',
            'checkoutProgressEnabled'       => isWooCommerceActive() && is_checkout() && ! is_wc_endpoint_url() && $this->isCheckOutProgressEnable(),
            'selectContentEnabled'       => $this->isSelectContentEnable()
		);

		$options['edd'] = array(
			'enabled'                       => isEddActive() && PYS()->getOption( 'edd_enabled' ),
			'addToCartOnButtonEnabled'      => isEventEnabled( 'edd_add_to_cart_enabled' ) && PYS()->getOption( 'edd_add_to_cart_on_button_click' ),
			'addToCartOnButtonValueEnabled' => PYS()->getOption( 'edd_add_to_cart_value_enabled' ),
			'addToCartOnButtonValueOption'  => PYS()->getOption( 'edd_add_to_cart_value_option' ),
			'removeFromCartEnabled'         => isEventEnabled( 'edd_remove_from_cart_enabled' ),
		);

		$woo_affiliate_custom_event_type = PYS()->getOption( 'woo_affiliate_custom_event_type' );
		
		if ( PYS()->getOption( 'woo_affiliate_event_type' ) == 'custom' && ! empty( $woo_affiliate_custom_event_type ) ) {
			$options['woo']['affiliateEventName'] = sanitizeKey( PYS()->getOption( 'woo_affiliate_custom_event_type' ) );
		} else {
			$options['woo']['affiliateEventName'] = PYS()->getOption( 'woo_affiliate_event_type' );
		}
		
		$woo_paypal_custom_event_type = PYS()->getOption( 'woo_paypal_custom_event_type' );

		if ( PYS()->getOption( 'woo_paypal_event_type' ) == 'custom' && ! empty( $woo_paypal_custom_event_type ) ) {
			$options['woo']['paypalEventName'] = sanitizeKey( PYS()->getOption( 'woo_paypal_custom_event_type' ) );
		} else {
			$options['woo']['paypalEventName'] = PYS()->getOption( 'woo_paypal_event_type' );
		}

		$data = array_merge( $data, $options );

		wp_localize_script( 'pys', 'pysOptions', $data );

	}
	
	public function outputNoScriptData() {
		
		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */
			$pixel->outputNoScriptEvents();
		}
		
	}

	public function setupEventsParams() {

        EventsManager::$facebookServerEvents = array();
		// initial event
		$this->addStaticEvent( 'init_event' );

		if ( isEventEnabled( 'general_event_enabled' ) ) {
			$this->addStaticEvent( 'general_event' );
		}

		if ( isEventEnabled( 'search_event_enabled' ) && is_search() ) {
			$this->addStaticEvent( 'search_event' );
		}

		if ( PYS()->getOption( 'custom_events_enabled' ) ) {

			$this->setupCustomEvents();

			add_filter( 'the_content', 'PixelYourSite\filterContentUrls', 1000 );
			add_filter( 'widget_text', 'PixelYourSite\filterContentUrls', 1000 );

		}

        $this->setupFDPEvents();

		if ( isWooCommerceActive() && PYS()->getOption( 'woo_enabled' ) ) {
			$this->setupWooCommerceEvents();

		}



		if ( isEddActive() && PYS()->getOption( 'edd_enabled' ) ) {
			$this->setupEddEvents();
		}

		if ( isEventEnabled( 'complete_registration_event_enabled' ) && $user_id = get_current_user_id() ) {

			if ( get_user_meta( $user_id, 'pys_complete_registration', true ) ) {

				$this->addStaticEvent( 'complete_registration' );
				delete_user_meta( $user_id, 'pys_complete_registration' );

			}

		}


        if(count(EventsManager::$facebookServerEvents)>0 && Facebook()->enabled()) {
            Facebook()->trackEventByServerApi(EventsManager::$facebookServerEvents);
        }
	}

	public function getWooCustomerTotals() {

		// setup and cache params
		if ( empty( $this->wooCustomerTotals ) ) {
			$this->wooCustomerTotals = getWooCustomerTotals();
		}

		return $this->wooCustomerTotals;

	}

	public function getEddCustomerTotals() {

		// setup and cache params
		if ( empty( $this->eddCustomerTotals ) ) {
			$this->eddCustomerTotals = getEddCustomerTotals();
		}

		return $this->eddCustomerTotals;

	}
	
	public function getStaticEvents( $context ) {
		return isset( $this->staticEvents[ $context ] ) ? $this->staticEvents[ $context ] : array();
	}

    /**
     * Add static event for each pixel
     *
     * @param string $eventType Event name for internal usage
     * @param CustomEvent|null $customEvent
     * @param string|null  $filterPixelSlug add static event only for one pixel
     */
	private function addStaticEvent( $eventType, $customEvent = null ,$filterPixelSlug = null) {

		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */

			if($filterPixelSlug != null && $filterPixelSlug != $pixel->getSlug()) {
			    continue;
            }

			$eventData = $pixel->getEventData( $eventType, $customEvent );

			if ( false === $eventData ) {
				continue; // event is disabled or not supported for the pixel
			}

			$eventName = $eventData['name'];
			$ids = isset( $eventData['ids'] ) ? $eventData['ids'] : array();
            $data = array(
				'params' => sanitizeParams( $eventData['data'] ),
				'delay'  => isset( $eventData['delay'] ) ? $eventData['delay'] : 0,
				'ids'    => $ids,
                'hasTimeWindow'    => isset( $customEvent ) ? $customEvent->hasTimeWindow() : false,
                'timeWindow'    => isset( $customEvent ) ? $customEvent->getTimeWindow() : 0,
                'isFdpa' => isset( $eventData['isFdpa'] ) ? $eventData['isFdpa'] : false, // send this event with custom fb id
			);
            if(isset( $eventData['ids'] )) {
                if(isset( $customEvent )) {
                    $data["conversion_labels"] = $eventData['ids'];
                } else {
                    $data["ids"] = $eventData['ids'];
                }
            }
            $this->staticEvents[ $pixel->getSlug() ][ $eventName ][] = $data;

            // fire fb server api event
            if($pixel->getSlug() == "facebook" && in_array($eventType,$this->facebookServerEventTypes)) {
                if($eventData != null && (!isset($eventData['delay']) || $eventData['delay'] == 0)) {
                    $this->addEventToFacebookServerApi($pixel,$eventType,$eventData);
                }
            }
		}
	}

	function addEventToFacebookServerApi($pixel,$eventType,$eventData) {

        $isDisabled = $this->isGdprPluginEnabled();


        if( !$isDisabled ) {
            $name = $eventData['name'];
			    $data = $eventData['data'];

			    if(isset($data['contents'])) {
                    $contents = json_decode(stripslashes($data['contents']));
                    $data['contents']=$contents;
                }


                EventsManager::sendFbApiEvent($pixel,$name,$data);
        }


    }

	static function sendFbApiEvent($pixel,$name,$data,$async = true) {

	    if(!$pixel->isServerApiEnabled() || !isset($data['eventID'])) return;

	    // create Server event
        $event = ServerEventHelper::newEvent($name,$data['eventID']);

        $event->setEventTime(time());

        // prepare data
        if(isset($data['contents']) && is_array($data['contents'])) {
            $contents = array();
            foreach ($data['contents'] as $c) {
                $content = array();
                $content['product_id'] = $c->id;
                $content['quantity'] = $c->quantity;
                $content['item_price'] = $c->item_price;
                $contents[] = new Content($content);
            }
            $data['contents'] = $contents;
        } else {
            $data['contents'] = array();
        }

        // prepare custom data
        $customData = new CustomData($data);
        $customProperties = getCommonEventParams();
        $customProperties['event_day'] = date("l");
        $customProperties['event_month'] = date("F");
        $customProperties['event_hour'] = EventsManager::$hours[date("G")];
        if(PYS()->getOption( 'track_traffic_source' ))
            $customProperties['traffic_source'] = getTrafficSource();


        if(PYS()->getOption( 'track_utms' )) {
            $customProperties = array_merge($customProperties,getUtms());
        }

        if( isset($data['tags']) ) {
            $customProperties['tags'] = $data['tags'];
        }
        $customData->setCustomProperties($customProperties);
        if(isset($data['category_name'])) {
            $customData->setContentCategory($data['category_name']);
        }

        $event->setCustomData($customData);

        // send event
        if($async) {
            EventsManager::$facebookServerEvents[]=$event;
        } else {
            Facebook::sendServerRequest(array($event));
        }

    }

	static function sendApiEvent() {

	    $pixelName = $_POST['pixel'];
	    $event = $_POST['event'];
	    $data = $_POST['data'];

	    if($event == "hCR") $event="CompleteRegistration"; // de mask completer registration event if it was hidden

	    switch ($pixelName) {
            case 'facebook': {
                if(isset($data['content_ids'])) {
                    $content_ids = json_decode(stripslashes($data['content_ids']));
                    $data['content_ids']=$content_ids;
                }
                if(isset($data['contents'])) {
                    if(is_array($data['contents'])) {
                        $contents = json_decode(json_encode($data['contents']));
                    } else {
                        $contents = json_decode(stripslashes($data['contents']));
                    }

                    $data['contents']=$contents;
                }
                EventsManager::sendFbApiEvent(Facebook::instance(),$event,$data,false);
                break;
            }
        }
       /* echo "hi";
        wp_die();*/
    }


	private function isSelectContentEnable() {
	    return isWooCommerceActive() &&
            isEventEnabled( 'woo_select_content_enabled' ) &&
            (is_tax( 'product_cat' ) || is_product() || is_search() || is_shop() || is_product_tag());
    }

	private function setupWooSelectContent($type) {

	    foreach ( PYS()->getRegisteredPixels() as $pixel ) {
            /** @var Pixel|Settings $pixel */

            $eventData = $pixel->getEventData("woo_select_content", $type);

            if (false === $eventData) {
                continue; // event is disabled or not supported for the pixel
            }

            ?>
            <script type="text/javascript">
                /* <![CDATA[ */
                window.pysWooSelectContentData = window.pysWooSelectContentData || [];
            <?php
                foreach ($eventData as $product_id => $item) {

                    $items = Array();
                    $items[] = $item;
                    $params = array(
                        'event_category'  => 'ecommerce',
                        'content_type'     => "product",
                        'items'           => $items,
                    ); ?>

                        window.pysWooSelectContentData[ <?=$product_id;?> ] = <?= json_encode($params); ?>;

                    <?php
                }
            ?>
                /* ]]> */
            </script>
            <?php
	    }
    }

    /**
     * @param FDPEvent $event
     * @param $triggers
     */

    private function addFDPDynamicEvent( $event ) {

        foreach ( PYS()->getRegisteredPixels() as $pixel ) {
            /** @var Pixel|Settings $pixel */

            $eventData = $pixel->getEventData( 'fdp_event', $event );
            if ( false === $eventData ) {
                continue;
            }

            if ( $pixel->getSlug() == 'facebook' ) {

                $this->dynamicEventsParams[ $event->event_name ]['facebook'] = array(
                    'name'   => $eventData['name'],
                    'params' => sanitizeParams( $eventData['data'] ),
                    'hasTimeWindow'    => $event->hasTimeWindow(),
                    'timeWindow'    => $event->getTimeWindow(),
                    'isFdpa' => isset( $eventData['isFdpa'] ) ? $eventData['isFdpa'] : false,
                );
            }

            $this->dynamicEventsTriggers[ $event->trigger_type ][ $event->event_name ][] = $event->trigger_value;
        }
    }

	/**
	 * Add dynamic event for each pixel
	 *
	 * @param CustomEvent $customEvent
	 * @param array       $triggers
	 */
	private function addDynamicEvent( $customEvent, $triggers ) {

		// collect adapted params
		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */

			$eventData = $pixel->getEventData( 'custom_event', $customEvent );

			// event is disabled or not supported for the pixel
			if ( false === $eventData ) {
				continue;
			}

			// push event params
			if ( $pixel->getSlug() == 'ga' ) {

				$this->dynamicEventsParams[ $customEvent->getPostId() ]['ga'] = array(
					'action' => $customEvent->getGoogleAnalyticsAction(),
					'params' => sanitizeParams( $eventData['data'] ),
                    'hasTimeWindow'    => $customEvent->hasTimeWindow(),
                    'timeWindow'    => $customEvent->getTimeWindow(),
				);

			} elseif ( $pixel->getSlug() == 'google_ads' ) {
				
				$this->dynamicEventsParams[ $customEvent->getPostId() ]['google_ads'] = array(
					'action' => $customEvent->getGoogleAdsAction(),
					'params' => sanitizeParams( $eventData['data'] ),
					'conversion_labels' => $eventData['ids'],
                    'hasTimeWindow'    => $customEvent->hasTimeWindow(),
                    'timeWindow'    => $customEvent->getTimeWindow(),
				);
				
			} elseif ( $pixel->getSlug() == 'facebook' ) {

				$this->dynamicEventsParams[ $customEvent->getPostId() ]['facebook'] = array(
					'name'   => $customEvent->getFacebookEventType(),
					'params' => sanitizeParams( $eventData['data'] ),
                    'hasTimeWindow'    => $customEvent->hasTimeWindow(),
                    'timeWindow'    => $customEvent->getTimeWindow(),
				);

			} else {
				
				$this->dynamicEventsParams[ $customEvent->getPostId() ]['pinterest'] = array(
					'name'   => $customEvent->getPinterestEventType(),
					'params' => sanitizeParams( $eventData['data'] ),
                    'hasTimeWindow'    => $customEvent->hasTimeWindow(),
                    'timeWindow'    => $customEvent->getTimeWindow(),
				);
				
			}

			// push event triggers
			foreach ( $triggers as $trigger ) {
				$this->dynamicEventsTriggers[ $customEvent->getTriggerType() ][ $customEvent->getPostId() ][] = $trigger['value'];
			}

		}

	}

	private function setupFDPEvents() {

        if(PYS()->getRegisteredPixels()['facebook'] == null ) return;

        $pixel = PYS()->getRegisteredPixels()['facebook'];

        foreach ( $pixel->getFDPEvents() as $event ) {

            if ( 'fdp_view_content' == $event->event_name && is_single() && get_post_type() == 'post') {
                $this->addStaticEvent( 'fdp_event', $event );
            }

            if ( 'fdp_view_category' == $event->event_name && is_category() ) {
                $this->addStaticEvent( 'fdp_event', $event );
            }

            if ( 'fdp_add_to_cart' == $event->event_name && is_single() && get_post_type() == 'post') {

                $this->addFDPDynamicEvent( $event );
            }

            if ( 'fdp_purchase' == $event->event_name && is_single() && get_post_type() == 'post' ) {

                $this->addFDPDynamicEvent( $event );
            }
        }

    }

	private function setupCustomEvents() {

		foreach ( CustomEventFactory::get( 'active' ) as $event ) {
			/** @var CustomEvent $event */

			switch ( $event->getTriggerType() ) {
				case 'page_visit':
				$triggers = $event->getPageVisitTriggers();
				break;

				case 'url_click':
				$triggers = $event->getURLClickTriggers();
				break;

				case 'css_click':
				$triggers = $event->getCSSClickTriggers();
				break;

				case 'css_mouseover':
				$triggers = $event->getCSSMouseOverTriggers();
				break;

				case 'scroll_pos':
				$triggers = $event->getScrollPosTriggers();
				break;

				default:
				$triggers = array();
			}



            if ( 'post_type' == $event->getTriggerType() ) {
                if($event->getPostTypeValue() != get_post_type()  ) {
                    continue;
                }

                $this->addStaticEvent( 'custom_event', $event );
                continue;
            }
            // no triggers were defined
            if ( empty( $triggers ) ) {
                continue;
            }

			if ( 'page_visit' == $event->getTriggerType() ) {
				// match triggers with current page URL
				if ( ! compareURLs( $triggers ) ) {
					continue;
				}
                $this->addStaticEvent( 'custom_event', $event );
                continue;
			}

			$urlFilters = $event->getURLFilters();

			// match URL filters with current page URL
			if ( ! empty( $urlFilters ) && ! compareURLs( $urlFilters ) ) {
				continue;
			}

            $this->addDynamicEvent( $event, $triggers );
		}

	}

	private function setupWooCommerceEvents() {

		// Advanced Marketing events
		if ( is_order_received_page() ) {

			$customerTotals = $this->getWooCustomerTotals();

			// FrequentShopper
			if ( isEventEnabled( 'woo_frequent_shopper_enabled' ) ) {

				$orders_count = (int) PYS()->getOption( 'woo_frequent_shopper_transactions' );

				if ( $customerTotals['orders_count'] >= $orders_count ) {
					$this->addStaticEvent( 'woo_frequent_shopper' );
				}

			}

			// VIPClient
			if ( isEventEnabled( 'woo_vip_client_enabled' ) ) {

				$orders_count = (int) PYS()->getOption( 'woo_vip_client_transactions' );
				$avg = (int) PYS()->getOption( 'woo_vip_client_average_value' );

				if ( $customerTotals['orders_count'] >= $orders_count && $customerTotals['avg_order_value'] >= $avg ) {
					$this->addStaticEvent( 'woo_vip_client' );
				}

			}

			// BigWhale
			if ( isEventEnabled( 'woo_big_whale_enabled' ) ) {

				$ltv = (int) PYS()->getOption( 'woo_big_whale_ltv' );

				if ( $customerTotals['ltv'] >= $ltv ) {
					$this->addStaticEvent( 'woo_big_whale' );
				}

			}

		}

		// AddToCart on button and Affiliate
		if ( isEventEnabled( 'woo_add_to_cart_enabled') && PYS()->getOption( 'woo_add_to_cart_on_button_click' )
			|| isEventEnabled( 'woo_affiliate_enabled') ) {

			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'setupWooLoopProductData' ) );
            add_filter( 'woocommerce_blocks_product_grid_item_html', array( $this, 'setupWooBlocksProductData' ), 10, 3 );

            if(is_product()) {
                if(PYS()->getOption('woo_add_to_cart_on_single_product') == 'add_cart_hook') {
                    add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'setupWooSingleProductData' ) );
                } else {
                    $this->setupWooSingleProductData();
                }
            } else {
                add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'setupWooSingleProductData' ) );
            }
	}

		// ViewContent
	if ( isEventEnabled( 'woo_view_content_enabled' ) && is_product() ) {
		$this->addStaticEvent( 'woo_view_content' );
	}

		// ViewCategory
		//@todo: +7.1.0+ maybe fire on Shop page as well? review GA 'list' param then
	if ( isEventEnabled( 'woo_view_category_enabled' )) {
	    if( is_tax( 'product_cat' )) {
            $this->addStaticEvent( 'woo_view_category' );
        }

        if(is_product()) {
            $this->addStaticEvent( 'woo_view_item_list_single' );
        }

        if(is_search()) {
            $this->addStaticEvent( 'woo_view_item_list_search' );
        }

        if(is_shop() && !is_search()) {
            $this->addStaticEvent( 'woo_view_item_list_shop' );
        }

        if(is_product_tag()) {
            $this->addStaticEvent( 'woo_view_item_list_tag' );
        }
	}

	if(isEventEnabled( 'woo_select_content_enabled' ) && !$this->doingAMP) {
        if( is_tax( 'product_cat' )) {
            $this->setupWooSelectContent("category");
        }
        if(is_product()) {
            $this->setupWooSelectContent("single");
        }
        if(is_search()) {
            $this->setupWooSelectContent("search");
        }
        if(is_shop()&& !is_search()) {
            $this->setupWooSelectContent("shop");
        }
        if(is_product_tag()) {
            $this->setupWooSelectContent("tag");
        }
    }

		// AddToCart on Cart page
	if ( isEventEnabled( 'woo_add_to_cart_enabled' ) && PYS()->getOption( 'woo_add_to_cart_on_cart_page' )
		&& is_cart() ) {

		$this->addStaticEvent( 'woo_add_to_cart_on_cart_page' );

}

		// AddToCart on Checkout page
if ( isEventEnabled( 'woo_add_to_cart_enabled' ) && PYS()->getOption( 'woo_add_to_cart_on_checkout_page' )
	&& is_checkout() && ! is_wc_endpoint_url() ) {

	$this->addStaticEvent( 'woo_add_to_cart_on_checkout_page' );

}

		// RemoveFromCart
if ( isEventEnabled( 'woo_remove_from_cart_enabled') && is_cart() ) {
	add_action( 'woocommerce_after_cart', array( $this, 'setupWooRemoveFromCartData' ) );
}

		// InitiateCheckout Event
if ( isEventEnabled( 'woo_initiate_checkout_enabled' ) && is_checkout() && ! is_wc_endpoint_url() ) {
	$this->addStaticEvent( 'woo_initiate_checkout' );
}

		// PayPal
if ( isEventEnabled( 'woo_paypal_enabled' ) && is_checkout() && ! is_wc_endpoint_url() ) {
	setupWooPayPalData();
}

		// Purchase Event
if ( isEventEnabled( 'woo_purchase_enabled' ) && is_order_received_page() && isset( $_REQUEST['key'] ) ) {

    $order_key = sanitize_key($_REQUEST['key']);
	$order_id = (int) wc_get_order_id_by_order_key( $order_key );

	$order = wc_get_order($order_id);
	if(!$order) return;
	$status = "wc-".$order->get_status("edit");

	$disabledStatuses = (array)PYS()->getOption("woo_order_purchase_disabled_status");

	if( in_array($status,$disabledStatuses)) {
	    return;
    }

	// skip if event was fired before
	if ( PYS()->getOption( 'woo_purchase_on_transaction' ) && get_post_meta( $order_id, '_pys_purchase_event_fired', true ) ) {
		return;
	}

	update_post_meta( $order_id, '_pys_purchase_event_fired', true );

	$this->addStaticEvent( 'woo_purchase' );

    /**
     * Add complete registration event
     */
    if ( Facebook()->enabled() && isEventEnabled( 'complete_registration_event_enabled' ) &&
        Facebook()->getOption("woo_complete_registration_fire_every_time")
    ) {
        $isGdprEnabled = $this->isGdprPluginEnabled();

        if(Facebook()->isServerApiEnabled()) {
            if(!Facebook()->getOption("woo_complete_registration_send_from_server") ) {
                $this->addStaticEvent('complete_registration', null, "facebook");
            } else {
                if($isGdprEnabled) {
                    $this->addStaticEvent('hCR', null, "facebook");
                }
            }

            // send by server api
            $eventData = Facebook()->getEventData( 'complete_registration',null );
            if($eventData != null) {
                $this->addEventToFacebookServerApi(Facebook(),'complete_registration',$eventData);
            }

        } else {
            $this->addStaticEvent('complete_registration', null, "facebook");
        }
    }
}


        // InitiateSetCheckOutOption Event
        if ( isEventEnabled( 'woo_initiate_set_checkout_option_enabled' ) && is_checkout() && ! is_wc_endpoint_url() ) {
            $this->addStaticEvent( 'woo_initiate_set_checkout_option' );
        }

        // Chekout Steps
        if(is_checkout() && $this->isCheckOutProgressEnable()) {
            $this->setupCheckoutProgress();
        }


}

    function isCheckOutProgressEnable() {
        return isEventEnabled( "woo_initiate_checkout_enabled" );
    }

    function setupCheckoutProgress() {
        if(! is_checkout() || PYS()->getRegisteredPixels()['ga'] == null ) return;

        /** @var GA $ga */
        $ga = PYS()->getRegisteredPixels()['ga'];
        $data = array();
        $steps = [
            "first_name" => "woo_initiate_checkout_progress_f",
            "last_name" => "woo_initiate_checkout_progress_l",
            "email" => "woo_initiate_checkout_progress_e",
            "place_order" => "woo_initiate_checkout_progress_o"];

        $step = 1;
        foreach ($steps as $key => $value) {
            if ( isEventEnabled( $value.'_enabled' )  ) {
                $step ++;
                $eventData = $ga->getEventData( $value );
                $eventData['data']['checkout_step'] = $step;
                $data[$key] = $eventData;
            }
        }

        ?>

        <script type="text/javascript">
            /* <![CDATA[ */
            window.pysWooCheckoutProgress = window.pysWooCheckoutProgress || [];
            window.pysWooCheckoutProgress = <?php echo json_encode( $data ); ?>;
            /* ]]> */
        </script>

        <?php
    }


    public function setupWooLoopProductData()
    {
        global $product;
        $this->setupWooProductData($product);
    }

    public function setupWooBlocksProductData($html, $data, $product)
    {
        $this->setupWooProductData($product);
        return $html;
    }

    public function setupWooProductData($product) {
	    if ( wooProductIsType( $product, 'variable' ) ) {
			return; // skip variable products
		} elseif ( wooProductIsType( $product, 'external' ) ) {
			$eventType = 'woo_affiliate_enabled';
		} else {
			$eventType = 'woo_add_to_cart_on_button_click';
		}

		/** @var \WC_Product $product */
		if ( isWooCommerceVersionGte( '2.6' ) ) {
			$product_id = $product->get_id();
		} else {
			$product_id = $product->post->ID;
		}

		$params = array();
		
		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */

			$eventData = $pixel->getEventData( $eventType, $product_id );

			if ( false === $eventData ) {
				continue; // event is disabled or not supported for the pixel
			}
            if($pixel->getSlug() == "google_ads") {
                $params[ $pixel->getSlug() ] =array(
                    "params" =>  sanitizeParams( $eventData['data'] ),
                    "ids"   =>   isset($eventData['ids']) ? sanitizeParams( $eventData['ids'] ) : array()
                );
            } else {
                $params[$pixel->getSlug()] = sanitizeParams($eventData['data']);
            }

		}

		if ( empty( $params ) ) {
			return;
		}

		$params = json_encode( $params );

		?>

		<script type="text/javascript">
			/* <![CDATA[ */
			window.pysWooProductData = window.pysWooProductData || [];
			window.pysWooProductData[ <?php echo $product_id; ?> ] = <?php echo $params; ?>;
			/* ]]> */
		</script>

		<?php

	}

	public function setupWooSingleProductData() {
		global $product;

        if ( ! is_object( $product)) $product = wc_get_product( get_the_ID() );

        if(!$product) return;

		if ( wooProductIsType( $product, 'external' ) ) {
			$eventType = 'woo_affiliate_enabled';
		} else {
			$eventType = 'woo_add_to_cart_on_button_click';
		}

		/** @var \WC_Product $product */
		if ( isWooCommerceVersionGte( '2.6' ) ) {
			$product_id = $product->get_id();
		} else {
			$product_id = $product->post->ID;
		}

		// main product id
		$product_ids[] = $product_id;

		// variations ids
		if ( wooProductIsType( $product, 'variable' ) ) {

			/** @var \WC_Product_Variable $variation */
			foreach ( $product->get_available_variations() as $variation ) {

				$variation = wc_get_product( $variation['variation_id'] );
                if(!$variation) continue;

				if ( isWooCommerceVersionGte( '2.6' ) ) {
					$product_ids[] = $variation->get_id();
				} else {
					$product_ids[] = $variation->post->ID;
				}

			}

		}

		$params = array();

		foreach ( $product_ids as $product_id ) {
			foreach ( PYS()->getRegisteredPixels() as $pixel ) {
				/** @var Pixel|Settings $pixel */

				$eventData = $pixel->getEventData( $eventType, $product_id );

				if ( false === $eventData ) {
					continue; // event is disabled or not supported for the pixel
				}
                if($pixel->getSlug() == "google_ads") {
                    $params[ $product_id ][ $pixel->getSlug() ] =array(
                            "params" =>  sanitizeParams( $eventData['data'] ),
                            "ids"   =>  isset($eventData) && isset($eventData['ids']) ? sanitizeParams( $eventData['ids'] ) : array()
                    );
                } else {
                    $params[ $product_id ][ $pixel->getSlug() ] = sanitizeParams( $eventData['data'] );
                }


			}
		}

		if ( empty( $params ) ) {
			return;
		}

		?>

		<script type="text/javascript">
			/* <![CDATA[ */
			window.pysWooProductData = window.pysWooProductData || [];
			<?php foreach ( $params as $product_id => $product_data ) : ?>
				window.pysWooProductData[<?php echo $product_id; ?>] = <?php echo json_encode( $product_data ); ?>;
			<?php endforeach; ?>
			/* ]]> */
		</script>

		<?php

	}

	public function setupWooRemoveFromCartData() {

		$data = array();

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

			$item_data = array();
			
			foreach ( PYS()->getRegisteredPixels() as $pixel ) {
				/** @var Pixel|Settings $pixel */

				$eventData = $pixel->getEventData( 'woo_remove_from_cart', $cart_item );

				if ( false === $eventData ) {
					continue; // event is disabled or not supported for the pixel
				}

				$item_data[ $pixel->getSlug() ] = sanitizeParams( $eventData['data'] );

			}

			if ( ! empty( $item_data ) ) {
				$data[ $cart_item_key ] = $item_data;
			}

		}

		?>

		<script type="text/javascript">
			/* <![CDATA[ */
			window.pysWooRemoveFromCartData = window.pysWooRemoveFromCartData || [];
			window.pysWooRemoveFromCartData = <?php echo json_encode( $data ); ?>;
			/* ]]> */
		</script>

		<?php

	}

	private function setupEddEvents() {

		// Advanced Marketing events
		if ( edd_is_success_page() ) {

			$customerTotals = $this->getEddCustomerTotals();

			// FrequentShopper
			if ( isEventEnabled( 'edd_frequent_shopper_enabled' ) ) {

				$orders_count = (int) PYS()->getOption( 'edd_frequent_shopper_transactions' );

				if ( $customerTotals['orders_count'] >= $orders_count ) {
					$this->addStaticEvent( 'edd_frequent_shopper' );
				}

			}

			// VIPClient
			if ( isEventEnabled( 'edd_vip_client_enabled' ) ) {

				$orders_count = (int) PYS()->getOption( 'edd_vip_client_transactions' );
				$avg = (int) PYS()->getOption( 'edd_vip_client_average_value' );

				if ( $customerTotals['orders_count'] >= $orders_count && $customerTotals['avg_order_value'] >= $avg ) {
					$this->addStaticEvent( 'edd_vip_client' );
				}

			}

			// BigWhale
			if ( isEventEnabled( 'edd_big_whale_enabled' ) ) {

				$ltv = (int) PYS()->getOption( 'edd_big_whale_ltv' );

				if ( $customerTotals['ltv'] >= $ltv ) {
					$this->addStaticEvent( 'edd_big_whale' );
				}

			}

		}

		// AddToCart on button
		if ( isEventEnabled( 'edd_add_to_cart_enabled') && PYS()->getOption( 'edd_add_to_cart_on_button_click' ) ) {
			add_action( 'edd_purchase_link_end', array( $this, 'setupEddSingleDownloadData' ) );
		}

		// ViewContent
		if ( isEventEnabled( 'edd_view_content_enabled' ) && is_singular( 'download' ) ) {

			$this->addStaticEvent( 'edd_view_content' );
			return;

		}

		// ViewCategory
		//@todo: +7.1.0+  maybe fire on Shop page as well? review GA 'list' param then
		if ( isEventEnabled( 'edd_view_category_enabled' ) && is_tax( 'download_category' ) ) {

			$this->addStaticEvent( 'edd_view_category' );
			return;

		}

		// AddToCart on Checkout page
		if ( isEventEnabled( 'edd_add_to_cart_enabled' ) && PYS()->getOption( 'edd_add_to_cart_on_checkout_page' )
			&& edd_is_checkout() ) {

			$this->addStaticEvent( 'edd_add_to_cart_on_checkout_page' );

	}

		// RemoveFromCart
	if ( isEventEnabled( 'edd_remove_from_cart_enabled') && edd_is_checkout() ) {
		add_action( 'edd_cart_items_after', array( $this, 'setupEddRemoveFromCartData' ) );
	}

		// InitiateCheckout Event
	if ( isEventEnabled( 'edd_initiate_checkout_enabled' ) && edd_is_checkout() ) {

		$this->addStaticEvent( 'edd_initiate_checkout' );
		return;

	}

		// Purchase Event
	if ( isEventEnabled( 'edd_purchase_enabled' ) && edd_is_success_page() ) {
		
			/**
			 * When a payment gateway used, user lands to Payment Confirmation page first, which does automatic
			 * redirect to Purchase Confirmation page. We filter Payment Confirmation to avoid double Purchase event.
			 */
			if ( isset( $_GET['payment-confirmation'] ) ) {
				//@fixme: some users will not reach success page and event will not be fired
				//return;
			}

			$payment_key = getEddPaymentKey();
			$order_id = (int) edd_get_purchase_id_by_key( $payment_key );
			$status = edd_get_payment_status( $order_id );

			// pending payment status used because we can't fire event on IPN
			if ( strtolower( $status ) != 'publish' && strtolower( $status ) != 'pending' ) {
				return;
			}

			// skip if event was fired before
			if ( PYS()->getOption( 'edd_purchase_on_transaction' ) && get_post_meta( $order_id, '_pys_purchase_event_fired', true ) ) {
				return;
			}

			update_post_meta( $order_id, '_pys_purchase_event_fired', true );

			$this->addStaticEvent( 'edd_purchase' );
			return;

		}

	}

	public function setupEddSingleDownloadData() {
		global $post;

		$download_ids = array();

		if ( edd_has_variable_prices( $post->ID ) ) {

			$prices = edd_get_variable_prices( $post->ID );

			foreach ( $prices as $price_index => $price_data ) {
				$download_ids[] = $post->ID . '_' . $price_index;
			}

		} else {

			$download_ids[] = $post->ID;

		}

		$params = array();

		foreach ( $download_ids as $download_id ) {
			foreach ( PYS()->getRegisteredPixels() as $pixel ) {
				/** @var Pixel|Settings $pixel */

				$eventData = $pixel->getEventData( 'edd_add_to_cart_on_button_click', $download_id );

				if ( false === $eventData ) {
					continue; // event is disabled or not supported for the pixel
				}
                if($pixel->getSlug() == "google_ads" ) {
                    $params[ $download_id ][ $pixel->getSlug() ] = array(
                            "params" => sanitizeParams( $eventData['data'] ),
                        "ids" => sanitizeParams( $eventData['ids'] )
                    );
                } else {
                    $params[ $download_id ][ $pixel->getSlug() ] = sanitizeParams( $eventData['data'] );
                }


			}
		}

		if ( empty( $params ) ) {
			return;
		}

		/**
		 * Format is pysEddProductData[ id ][ id ] or pysEddProductData[ id ] [ id_1, id_2, ... ]
		 */

		?>

		<script type="text/javascript">
			/* <![CDATA[ */
			window.pysEddProductData = window.pysEddProductData || [];
			window.pysEddProductData[<?php echo $post->ID; ?>] = <?php echo json_encode( $params ); ?>;
			/* ]]> */
		</script>

		<?php

	}

	public function setupEddRemoveFromCartData() {

		$data = array();

		foreach ( edd_get_cart_contents() as $cart_item_key => $cart_item ) {

			$item_data = array();
			
			foreach ( PYS()->getRegisteredPixels() as $pixel ) {
				/** @var Pixel|Settings $pixel */

				$eventData = $pixel->getEventData( 'edd_remove_from_cart', $cart_item );

				if ( false === $eventData ) {
				    continue; // event is disabled or not supported for the pixel
				}

				$item_data[ $pixel->getSlug() ] = sanitizeParams( $eventData['data'] );

			}

			if ( ! empty( $item_data ) ) {
				$data[ $cart_item_key ] = $item_data;
			}

		}

		?>

		<script type="text/javascript">
			/* <![CDATA[ */
			window.pysEddRemoveFromCartData = window.pysEddRemoveFromCartData || [];
			window.pysEddRemoveFromCartData = <?php echo json_encode( $data ); ?>;
			/* ]]> */
		</script>

		<?php

	}

	function isGdprPluginEnabled() {
        return apply_filters( 'pys_disable_by_gdpr', false ) ||
        apply_filters( 'pys_disable_facebook_by_gdpr', false ) ||
        isCookiebotPluginActivated() && PYS()->getOption( 'gdpr_cookiebot_integration_enabled' ) ||
        isGingerPluginActivated() && PYS()->getOption( 'gdpr_ginger_integration_enabled' ) ||
        isCookieNoticePluginActivated() && PYS()->getOption( 'gdpr_cookie_notice_integration_enabled' ) ||
        isCookieLawInfoPluginActivated() && PYS()->getOption( 'gdpr_cookie_law_info_integration_enabled' );
    }

}