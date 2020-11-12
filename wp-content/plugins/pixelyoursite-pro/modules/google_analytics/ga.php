<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/** @noinspection PhpIncludeInspection */
require_once PYS_PATH . '/modules/google_analytics/function-helpers.php';

use PixelYourSite\GA\Helpers;

class GA extends Settings implements Pixel {
	
	private static $_instance;
	
	private $configured;

	/** @var array $wooOrderParams Cached WooCommerce Purchase and AM events params */
	private $wooOrderParams = array();
	
	public static function instance() {
		
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
		
	}
	
    public function __construct() {
		
        parent::__construct( 'ga' );
	
	    $this->locateOptions(
		    PYS_PATH . '/modules/google_analytics/options_fields.json',
		    PYS_PATH . '/modules/google_analytics/options_defaults.json'
	    );
	    
	    add_action( 'pys_register_pixels', function( $core ) {
		    /** @var PYS $core */
		    $core->registerPixel( $this );
	    } );
    
        add_action( 'wp_head', array( $this, 'outputOptimizeSnippet' ), 1 );
    }
	
	public function enabled() {
		return $this->getOption( 'enabled' );
	}
	
	public function configured() {

        $license_status = PYS()->getOption( 'license_status' );
        $tracking_id = $this->getPixelIDs();

        $this->configured = $this->enabled()
                            && ! empty( $license_status ) // license was activated before
                            && count( $tracking_id ) > 0
                            && !empty($tracking_id[0])
                            && ! apply_filters( 'pys_pixel_disabled', false, $this->getSlug() );

		
		return $this->configured;

	}
	
	public function getPixelIDs() {

		$ids = (array) $this->getOption( 'tracking_id' );
		
		if ( isSuperPackActive() && SuperPack()->getOption( 'enabled' ) && SuperPack()->getOption( 'additional_ids_enabled' ) ) {
			return apply_filters("pys_ga_ids",$ids);
		} else {
			return apply_filters("pys_ga_ids",(array) reset( $ids )); // return first id only
		}
		
	}
    
    public function getPixelOptions() {
        
        return array(
            'trackingIds'                   => $this->getPixelIDs(),
            'enhanceLinkAttr'               => $this->getOption( 'enhance_link_attribution' ),
            'anonimizeIP'                   => $this->getOption( 'anonimize_ip' ),
            'clickEventEnabled'             => $this->getOption( 'click_event_enabled' ),
            'watchVideoEnabled'             => $this->getOption( 'watchvideo_event_enabled' ),
            'commentEventEnabled'           => $this->getOption( 'comment_event_enabled' ),
            'formEventEnabled'              => $this->getOption( 'form_event_enabled' ),
            'downloadEnabled'               => $this->getOption( 'download_event_enabled' ),
            'clickEventNonInteractive'      => $this->getOption( 'click_event_non_interactive' ),
            'watchVideoEventNonInteractive' => $this->getOption( 'watchvideo_event_non_interactive' ),
            'formEventNonInteractive'       => $this->getOption( 'form_event_non_interactive' ),
            'commentEventNonInteractive'    => $this->getOption( 'comment_event_non_interactive' ),
            'downloadEventNonInteractive'   => $this->getOption( 'download_event_non_interactive' ),
            'retargetingLogic'              => PYS()->getOption( 'google_retargeting_logic' ),
            'crossDomainEnabled'            => $this->getOption( 'cross_domain_enabled' ),
            'crossDomainAcceptIncoming'     => $this->getOption( 'cross_domain_accept_incoming' ),
            'crossDomainDomains'            => $this->getOption( 'cross_domain_domains' ),
            'wooVariableAsSimple'           => $this->getOption( 'woo_variable_as_simple' ),
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

            case 'woo_view_item_list_single':
                return $this->getWooViewItemListSingleParams();

            case "woo_view_item_list_search":
                return $this->getWooViewItemListSearch();

            case "woo_view_item_list_shop":
                return $this->getWooViewItemListShop();

            case "woo_view_item_list_tag":
                return $this->getWooViewItemListTag();

			case 'woo_initiate_checkout':
				return $this->getWooInitiateCheckoutEventParams();

            case 'woo_initiate_set_checkout_option':
                return $this->getWooSetСheckoutOptionEventParams();

            case 'woo_initiate_checkout_progress_f':
            case 'woo_initiate_checkout_progress_l':
            case 'woo_initiate_checkout_progress_e':
            case 'woo_initiate_checkout_progress_o':
                return $this->getWooСheckoutProgressEventParams($eventType);


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

            case "woo_select_content":
                return $this->getWooSelectContent($args);

			default:
				return false;   // event does not supported
		}

	}
	
	public function outputNoScriptEvents() {
		
		if ( ! $this->configured() ) {
			return;
		}
		
		$eventsManager = PYS()->getEventsManager();
		
		foreach ( $eventsManager->getStaticEvents( 'ga' ) as $eventName => $events ) {
			foreach ( $events as $event ) {
				foreach ( $this->getPixelIDs() as $pixelID ) {
					
					$args = array(
						'v'   => 1,
						'tid' => $pixelID,
						't'   => 'event',
						'aip' => $this->getOption( 'anonimize_ip' ),
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
		
	}
	
	public function outputOptimizeSnippet() {
	    
	    $optimize_id = $this->getOption( 'optimize_id' );
	    
        if ( $this->configured() && $this->getOption( 'optimize_enabled' ) && ! empty( $optimize_id ) ) {
            $optimizeError ="";
            ob_start();

            if($this->getOption( 'enable_anti_flicker' )):
                $optimizeError='onerror="dataLayer.hide.end && dataLayer.hide.end()"';
                $timeOut = $this->getOption( 'anti_flicker_timeout' );
                ?>
                <style>.async-hide { opacity: 0 !important} </style>
                <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
                h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
                (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
                })(window,document.documentElement,'async-hide','dataLayer',<?=$timeOut?>,
                {'<?=$optimize_id?>':true});</script>
            <?php endif; ?>

            <script async src="https://www.googleoptimize.com/optimize.js?id=<?=$optimize_id?>" <?=$optimizeError?>></script>
            <?php
    
            $snippet = ob_get_clean();
          //  $snippet = sprintf( $snippet, $optimize_id,$optimize_id );
            
            echo $snippet;
        }
        
    }
	
	private function getPageViewEventParams() {
		
		if ( PYS()->getEventsManager()->doingAMP ) {
			
			return array(
				'name' => 'PageView',
				'data' => array(),
			);
			
		} else {
			return false; // PageView is fired by tag itself
		}
		
	}

	private function getSearchEventData() {
		global $posts;

		if ( ! $this->getOption( 'search_event_enabled' ) ) {
			return false;
		}

		$params['event_category'] = 'WordPress Search';
		$params['search_term']    = empty( $_GET['s'] ) ? null : $_GET['s'];

		if ( isWooCommerceActive() && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {
			$params['event_category'] = 'WooCommerce Search';
		}
		
		$params['non_interaction'] = $this->getOption( 'search_event_non_interactive' );
		
		$product_ids = array();
		$total_value = 0;
		
		for ( $i = 0; $i < count( $posts ); $i ++ ) {
			
			if ( $posts[ $i ]->post_type == 'product' ) {
				$total_value += getWooProductPriceToDisplay( $posts[ $i ]->ID );
			} elseif ( $posts[ $i ]->post_type == 'download' ) {
				$total_value += getEddDownloadPriceToDisplay( $posts[ $i ]->ID );
			} else {
				continue;
			}
			
			$product_ids[] = $posts[ $i ]->ID;
			
		}

		$dyn_remarketing = array(
			'product_id'  => $product_ids,
			'page_type'   => 'search',
			'total_value' => $total_value,
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params          = array_merge( $params, $dyn_remarketing );

		return array(
			'name'  => 'search',
			'data'  => $params,
		);

	}

	/**
	 * @param CustomEvent $event
	 *
	 * @return array|bool
	 */
	private function getCustomEventData( $event ) {
		
		$ga_action = $event->getGoogleAnalyticsAction();

		if ( ! $event->isGoogleAnalyticsEnabled() || empty( $ga_action ) ) {
			return false;
		}
		
		$params = array(
			'event_category'  => $event->ga_event_category,
			'event_label'     => $event->ga_event_label,
			'value'           => $event->ga_event_value,
			'non_interaction' => $event->ga_non_interactive,
		);
		
		// SuperPack Dynamic Params feature
		$params = apply_filters( 'pys_superpack_dynamic_params', $params, 'ga' );

		return array(
			'name'  => $event->getGoogleAnalyticsAction(),
			'data'  => $params,
			'delay' => $event->getDelay(),
		);

	}

	private function getWooViewItemListTag() {
        global $posts;

        if ( ! $this->getOption( 'woo_view_category_enabled' ) ) {
            return false;
        }

        $list_name =  single_tag_title( '', false )." - Tag";

        $items = array();

        for ( $i = 0; $i < count( $posts ); $i ++ ) {

            if ( $posts[ $i ]->post_type !== 'product' ) {
                continue;
            }

            $item = array(
                'id'            => Helpers\getWooProductContentId($posts[ $i ]->ID),
                'name'          => $posts[ $i ]->post_title,
                'category'      => implode( '/', getObjectTerms( 'product_cat', $posts[ $i ]->ID ) ),
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $posts[ $i ]->ID ),
                'list_position' => $i + 1,
                'list_name'      => $list_name,
            );

            $items[] = $item;

        }

        $params = array(
            'event_category'  => 'ecommerce',
            'event_label'     => $list_name,
            'items'           => $items,
        );

        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );
    }

	private function getWooViewItemListShop() {
        /**
         * @var \WC_Product $product
         * @var $related_products \WC_Product[]
         */

        global $posts;

        if ( ! $this->getOption( 'woo_view_category_enabled' ) ) {
            return false;
        }


        $list_name = woocommerce_page_title(false);

        $items = array();
        $i = 0;

        foreach ( $posts as $post) {
            if( $post->post_type != 'product') continue;
            $item = array(
                'id'            => Helpers\getWooProductContentId($post->ID),
                'name'          => $post->post_title ,
                'category'      => implode( '/', getObjectTerms( 'product_cat', $post->ID ) ),
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $post->ID ),
                'list_position' => $i + 1,
                'list_name'     => $list_name,
            );

            $items[] = $item;
            $i++;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'event_label'     => $list_name,
            'items'           => $items,
        );


        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );
    }

    private function getWooViewItemListSearch() {
        /**
         * @var \WC_Product $product
         * @var $related_products \WC_Product[]
         */

        global $posts;

        if ( ! $this->getOption( 'woo_view_category_enabled' ) ) {
            return false;
        }



        $list_name = "WooCommerce Search";

        $items = array();
        $i = 0;

        foreach ( $posts as $post) {
            if( $post->post_type != 'product') continue;
            $item = array(
                'id'            => Helpers\getWooProductContentId($post->ID),
                'name'          => $post->post_title ,
                'category'      => implode( '/', getObjectTerms( 'product_cat', $post->ID ) ),
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $post->ID ),
                'list_position' => $i + 1,
                'list_name'          => $list_name,
            );

            $items[] = $item;
            $i++;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'event_label'     => $list_name,
            'items'           => $items,
        );


        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );
    }


    private function getWooSelectContent($type) {

        $items = array();

	    if($type == "search" || $type == "shop") {
            global $posts;

            if($type == "shop") {
                $list_name =  woocommerce_page_title(false);
            } else {
                $list_name = "WooCommerce Search";
            }

            $i = 0;
            foreach ($posts as $post) {
                if( $post->post_type != 'product') continue;
                $item = array(
                    'id'            => Helpers\getWooProductContentId($post->ID),
                    'name'          => $post->post_title ,
                    'category'      => implode( '/', getObjectTerms( 'product_cat', $post->ID ) ),
                    'quantity'      => 1,
                    'price'         => getWooProductPriceToDisplay( $post->ID ),
                    'list_position' => $i + 1,
                    'list_name'     => $list_name,
                );

                $items[$post->ID] = $item;
                $i++;
            }
        }
        if($type == "single") {

            $product = wc_get_product( get_the_ID() );

            $args = array(
                'posts_per_page' => 4,
                'columns'        => 4,
            );
            $args = apply_filters( 'woocommerce_output_related_products_args', $args );

            $related_products = array_map( 'wc_get_product', Helpers\custom_wc_get_related_products( get_the_ID(), $args['posts_per_page'],$product->get_upsell_ids() ));
            $related_products = wc_products_array_orderby( $related_products, 'rand', 'desc' );



            $list_name = $product->get_name()." - Related products";
            $i = 0;

            foreach ( $related_products as $relate) {

                if(!$relate) continue;

                $item = array(
                    'id'            => Helpers\getWooProductContentId($relate->get_id()),
                    'name'          => $relate->get_title(),
                    'category'      => implode( '/', getObjectTerms( 'product_cat', $relate->get_id() ) ),
                    'quantity'      => 1,
                    'price'         => getWooProductPriceToDisplay( $relate->get_id() ),
                    'list_position' => $i + 1,
                    'list_name'          => $list_name,
                );

                $items[$relate->get_id()] = $item;
                $i++;
            }
        }

        if($type == "category") {
            global $posts;
            $product_category = "";
            $term = get_term_by( 'slug', get_query_var( 'term' ), 'product_cat' );
            if ( $term ) {
                $product_category = $term->name;
            }

            $list_name =  $product_category." - Category";



            for ( $i = 0; $i < count( $posts ); $i ++ ) {

                if ( $posts[ $i ]->post_type !== 'product' ) {
                    continue;
                }

                $item = array(
                    'id'            => Helpers\getWooProductContentId($posts[ $i ]->ID),
                    'name'          => $posts[ $i ]->post_title,
                    'category'      => implode( '/', getObjectTerms( 'product_cat', $posts[ $i ]->ID ) ),
                    'quantity'      => 1,
                    'price'         => getWooProductPriceToDisplay( $posts[ $i ]->ID ),
                    'list_position' => $i + 1,
                    'list_name'     => $list_name,
                );

                $items[$posts[ $i ]->ID] = $item;
            }
        }

        if($type == "tag") {
            global $posts;

            $list_name = single_tag_title( '', false )." - Tag";

            for ( $i = 0; $i < count( $posts ); $i ++ ) {

                if ( $posts[ $i ]->post_type !== 'product' ) {
                    continue;
                }

                $item = array(
                    'id'            => Helpers\getWooProductContentId($posts[ $i ]->ID),
                    'name'          => $posts[ $i ]->post_title,
                    'category'      => implode( '/', getObjectTerms( 'product_cat', $posts[ $i ]->ID ) ),
                    'quantity'      => 1,
                    'price'         => getWooProductPriceToDisplay( $posts[ $i ]->ID ),
                    'list_position' => $i + 1,
                    'list_name'     => $list_name,
                );

                $items[$posts[ $i ]->ID] = $item;
            }
        }

        return $items;
    }


	private function getWooViewItemListSingleParams() {
        /**
         * @var \WC_Product $product
         * @var $related_products \WC_Product[]
         */
        $product = wc_get_product( get_the_ID() );

	    if ( !$product || ! $this->getOption( 'woo_view_category_enabled' ) ) {
            return false;
        }

        $related_products = array();

        $args = array(
            'posts_per_page' => 4,
            'columns'        => 4,
        );
        $args = apply_filters( 'woocommerce_output_related_products_args', $args );

        $ids =  Helpers\custom_wc_get_related_products( get_the_ID(), $args['posts_per_page'] );

        foreach ( $ids as $id) {
            $rel = wc_get_product($id);
            if($rel) {
                $related_products[] = $rel;
            }
        }



        $list_name = $product->get_name()." - Related products";

        $items = array();
        $i = 0;

        foreach ( $related_products as $relate) {

            $item = array(
                'id'            => Helpers\getWooProductContentId($relate->get_id()),
                'name'          => $relate->get_title(),
                'category'      => implode( '/', getObjectTerms( 'product_cat', $relate->get_id() ) ),
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $relate->get_id() ),
                'list_position' => $i + 1,
                'list_name'     => $list_name,
            );

            $items[] = $item;
            $i++;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'event_label'     => $list_name,
            'items'           => $items,
            'non_interaction' => $this->getOption( 'woo_view_category_non_interactive' ),
        );


        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );
    }

	private function getWooViewCategoryEventParams() {
		global $posts;

		if ( ! $this->getOption( 'woo_view_category_enabled' ) ) {
			return false;
		}
        
        $product_category = "";
		$term = get_term_by( 'slug', get_query_var( 'term' ), 'product_cat' );
		
		if ( $term ) {
            $product_category = $term->name;
        }

        $list_name =  $product_category." - Category";

		$items = array();

		for ( $i = 0; $i < count( $posts ); $i ++ ) {
			
			if ( $posts[ $i ]->post_type !== 'product' ) {
				continue;
			}

			$item = array(
				'id'            => Helpers\getWooProductContentId($posts[ $i ]->ID),
				'name'          => $posts[ $i ]->post_title,
				'category'      => implode( '/', getObjectTerms( 'product_cat', $posts[ $i ]->ID ) ),
				'quantity'      => 1,
				'price'         => getWooProductPriceToDisplay( $posts[ $i ]->ID ),
				'list_position' => $i + 1,
				'list_name'          => $list_name,
			);

			$items[] = $item;

		}
		
		$params = array(
			'event_category'  => 'ecommerce',
			'event_label'     => $list_name,
			'items'           => $items,
			'non_interaction' => $this->getOption( 'woo_view_category_non_interactive' ),
		);

		return array(
			'name'  => 'view_item_list',
			'data'  => $params,
		);

	}

	private function getWooViewContentEventParams() {
		global $post;

		if ( ! $this->getOption( 'woo_view_content_enabled' ) ) {
			return false;
		}
        $productId = Helpers\getWooProductContentId($post->ID);
		$params = array(
			'event_category'  => 'ecommerce',
			'items'           => array(
				array(
					'id'       => $productId,
					'name'     => $post->post_title,
					'category' => implode( '/', getObjectTerms( 'product_cat', $post->ID ) ),
					'quantity' => 1,
					'price'    => getWooProductPriceToDisplay( $post->ID ),
				),
			),
			'non_interaction' => $this->getOption( 'woo_view_content_non_interactive' ),
		);
		
		$dyn_remarketing = array(
			'product_id'  => $productId,
			'page_type'   => 'product',
			'total_value' => getWooProductPriceToDisplay( $post->ID ),
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params = array_merge( $params, $dyn_remarketing );

		return array(
			'name'  => 'view_item',
			'data'  => $params,
			'delay' => (int) PYS()->getOption( 'woo_view_content_delay' ),
		);

	}

	private function getWooAddToCartOnButtonClickEventParams( $product_id ) {

		if ( ! $this->getOption( 'woo_add_to_cart_enabled' )  || ! PYS()->getOption( 'woo_add_to_cart_on_button_click' ) ) {
			return false;
		}
        $contentId = Helpers\getWooProductContentId($product_id);
		$product = wc_get_product( $product_id );
        if(!$product) return false;
		$price = getWooProductPriceToDisplay( $product_id, 1 );

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
			'items'           => array(
				array(
					'id'       => $contentId,
					'name'     => $name,
					'category' => $category,
					'quantity' => 1,
					'price'    => $price,
                    'variant'  => $variation_name,
				),
			),
			'non_interaction' => $this->getOption( 'woo_add_to_cart_non_interactive' ),
		);
		
		$dyn_remarketing = array(
			'product_id'  => $contentId,
			'page_type'   => 'cart',
			'total_value' => $price,
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params = array_merge( $params, $dyn_remarketing );
		
		return array(
			'data'  => $params,
		);

	}

	private function getWooAddToCartOnCartEventParams() {

		if ( ! $this->getOption( 'woo_add_to_cart_enabled' ) ) {
			return false;
		}
		
		$params = $this->getWooCartParams();
		$params['non_interaction'] = true;
		
		return array(
			'name' => 'add_to_cart',
			'data' => $params
		);

	}

	private function getWooRemoveFromCartParams( $cart_item ) {

		if ( ! $this->getOption( 'woo_remove_from_cart_enabled' ) ) {
			return false;
		}


        $product_id = Helpers\getWooCartItemId( $cart_item );
        $content_id = Helpers\getWooProductContentId( $product_id );
        $price = getWooProductPriceToDisplay( $product_id, $cart_item['quantity'] );

        $product = get_post( $product_id );

		if ( ! empty( $cart_item['variation_id'] ) ) {
			$variation = wc_get_product( (int) $cart_item['variation_id'] );
            if(is_a($variation, 'WC_Product_Variation')) {
                $parentId = $variation->get_parent_id();
                $name = $variation->get_title();
                $categories = implode( '/', getObjectTerms( 'product_cat', $parentId ) );
                $variation_name = implode("/", $variation->get_variation_attributes());
            } else {
                $name = $product->post_title;
                $variation_name = null;
                $categories = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
            }
		} else {
            $name = $product->post_title;
			$variation_name = null;
            $categories = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
		}


		return array(
			'data' => array(
				'event_category'  => 'ecommerce',
				'currency'        => get_woocommerce_currency(),
				'items'           => array(
					array(
						'id'       => $content_id,
						'name'     => $name,
						'category' => $categories,
						'quantity' => $cart_item['quantity'],
						'price'    => $price,
						'variant'  => $variation_name,
					),
				),
				'non_interaction' => $this->getOption( 'woo_remove_from_cart_non_interactive' ),
			),
		);

	}

	private function getWooInitiateCheckoutEventParams() {

		if ( ! $this->getOption( 'woo_initiate_checkout_enabled' ) ) {
			return false;
		}
		
		$params = $this->getWooCartParams( 'checkout' );
		$params['non_interaction'] = false; //$this->getOption( 'woo_initiate_checkout_non_interactive' );
		
		return array(
			'name'  => 'begin_checkout',
			'data'  => $params
		);

	}

    private function getWooSetСheckoutOptionEventParams() {

        if ( ! $this->getOption( 'woo_initiate_checkout_enabled' ) ) {
            return false;
        }
        $user = wp_get_current_user();
        if ( $user->ID !== 0 ) {
            $user_roles = implode( ',', $user->roles );
        } else {
            $user_roles = 'guest';
        }

        $params = array (
            'event_category'=> 'ecommerce',
            'event_label'     => $user_roles,
            'checkout_step'   => '1',
            'checkout_option' => $user_roles,
        );
        $params['non_interaction'] = false;
        return array(
            'name'  => 'set_checkout_option',
            'data'  => $params
        );


    }

    private function getWooСheckoutProgressEventParams($type) {

        if ( ! $this->getOption( 'woo_initiate_checkout_enabled' ) || ! $this->getOption( $type."_enabled" ) ) {
            return false;
        }

        $params = [];
        $params['non_interaction'] = false;
        $params['event_category'] = "ecommerce";
        $cartParams = $this->getWooCartParams( 'checkoutProgress' );
        $params['items'] = $cartParams['items'];

        switch ($type) {
            case 'woo_initiate_checkout_progress_f': {
                $params['event_label'] = $params['checkout_option'] = "Add First Name";
                break;
            }
            case 'woo_initiate_checkout_progress_l': {
                $params['event_label'] = $params['checkout_option'] = "Add Last Name";
                break;
            }
            case 'woo_initiate_checkout_progress_e': {
                $params['event_label'] = $params['checkout_option'] = "Add Email";
                break;
            }
            case 'woo_initiate_checkout_progress_o': {
                $params['event_label'] = "Click Place Order";
                $params['coupon'] = $cartParams['coupon'];
                if( !empty($cartParams['shipping']) )
                    $params['checkout_option'] = $cartParams['shipping'];
                break;
            }
        }

        return array(
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
					'id'       => $product_id,
					'name'     => $product->post_title,
					'category' => implode( '/', getObjectTerms( 'product_cat', $product_id ) ),
					'quantity' => 1,
					'price'    => getWooProductPriceToDisplay( $product_id, 1 ),
				),
			),
			'non_interaction' => $this->getOption( 'woo_affiliate_non_interactive' ),
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
		$params['non_interaction'] = $this->getOption( 'woo_paypal_non_interactive' );
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
		$order_id = (int) wc_get_order_id_by_order_key( $order_key );
		
		$order = new \WC_Order( $order_id );
		$items = array();
		$product_ids = array();
		$total_value = 0;
		
		foreach ( $order->get_items( 'line_item' ) as $line_item ) {

            $product_id  = Helpers\getWooCartItemId( $line_item );
            $content_id  = Helpers\getWooProductContentId( $product_id );

			$post    = get_post( $product_id );
			$product = wc_get_product( $product_id);
            if(!$product) continue;

			if ( $line_item['variation_id'] ) {

                $variation = wc_get_product( (int) $line_item['variation_id'] );

                if(is_a($variation, 'WC_Product_Variation')) {
                    $name = $variation->get_title();
                    $categories = implode( '/', getObjectTerms( 'product_cat', $variation->get_parent_id() ) );
                    $variation_name = implode("/", $variation->get_variation_attributes());
                } else {
                    $name = $post->post_title;
                    $categories = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
                    $variation_name = null;
                }
			} else {
                $name = $post->post_title;
			    $categories = implode( '/', getObjectTerms( 'product_cat', $product_id ) );
				$variation_name = null;
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
			
			$qty = $line_item['qty'];
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
				'category' => $categories,
				'quantity' => $qty,
				'price'    => $price,
				'variant'  => $variation_name,
			);
			
			$items[] = $item;
			$product_ids[] = $item['id'];
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
			'non_interaction' => $this->getOption( 'woo_purchase_non_interactive' ),
		);
		
		$dyn_remarketing = array(
			'product_id'  => $product_ids,
			'page_type'   => 'purchase',
			'total_value' => $total_value,
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params = array_merge( $params, $dyn_remarketing );
		
		return array(
			'name' => 'purchase',
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
				$non_interactive = $this->getOption( 'woo_frequent_shopper_non_interactive' );
				break;

			case 'woo_vip_client':
				$eventName = 'VipClient';
				$non_interactive = $this->getOption( 'woo_vip_client_non_interactive' );
				break;

			default:
				$eventName = 'BigWhale';
				$non_interactive = $this->getOption( 'woo_big_whale_non_interactive' );
		}

		$params = $this->getWooOrderParams();

		$params['event_category'] = 'marketing';
		$params['non_interaction'] = $non_interactive;

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
		$product_ids = array();
		$total_value = 0;

		foreach ( WC()->cart->cart_contents as $cart_item_key => $cart_item ) {

			$product = get_post( $cart_item['product_id'] );

            $product_id = Helpers\getWooCartItemId( $cart_item );
            $content_id = Helpers\getWooProductContentId( $product_id );
            $price = getWooProductPriceToDisplay( $product_id );

			if ( $cart_item['variation_id'] ) {
                $variation = wc_get_product( (int) $cart_item['variation_id'] );

                if(is_a($variation, 'WC_Product_Variation')) {
                    $name = $variation->get_title();
                    $category = implode('/', getObjectTerms('product_cat', $variation->get_parent_id()));
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
			);

			$items[] = $item;
			$product_ids[] = $item['id'];
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
			'items' => $items,
			'coupon' => $coupon
		);
		
		// dynamic remarketing not supported for paypal event
		if ( $context == 'cart' || $context == 'checkout' ) {
			
			$dyn_remarketing = array(
				'product_id'  => $product_ids,
				'page_type'   => $context,
				'total_value' => $total_value,
			);
			
			$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
			$params = array_merge( $params, $dyn_remarketing );
			
		}

        if($context == "checkoutProgress") {

            $params["shipping"] = "";
            $shipping_id = WC()->session->get( 'chosen_shipping_methods' )[0];
            $shipping_id = explode(":",$shipping_id)[0];
            if(isset(WC()->shipping->get_shipping_methods()[$shipping_id])) {
                $params["shipping"] = WC()->shipping->get_shipping_methods()[$shipping_id]->method_title;
            }
        }

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

			$post = get_post( $line_item['product_id'] );

			if ( $line_item['variation_id'] ) {
                $variation = wc_get_product( (int) $line_item['variation_id'] );
                if(is_a($variation, 'WC_Product_Variation')) {
                    $name = $variation->get_title();
                    $categories = implode( '/', getObjectTerms( 'product_cat', $variation->get_parent_id() ) );
                    $variation_name = implode("/", $variation->get_variation_attributes());
                } else {
                    $name = $post->post_title;
                    $variation_name = null;
                    $categories = implode( '/', getObjectTerms( 'product_cat', $post->ID ) );
                }

			} else {
                $name = $post->post_title;
				$variation_name = null;
                $categories = implode( '/', getObjectTerms( 'product_cat', $post->ID ) );
			}
			
			$item = array(
				'id'       => $post->ID,
				'name'     => $name,
				'category' => $categories,
				'quantity' => $line_item['qty'],
				'price'    => getWooProductPriceToDisplay( $post->ID ),
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
				'event_category'  => 'engagement',
				'method'          => $commonParams['user_roles'],
				'non_interaction' => $this->getOption( 'complete_registration_event_non_interactive' ),
			),
		);

	}

	private function getEddViewContentEventParams() {
		global $post;

		if ( ! $this->getOption( 'edd_view_content_enabled' ) ) {
			return false;
		}

		$params = array(
			'event_category'  => 'ecommerce',
			'items'           => array(
				array(
					'id'       => Helpers\getEddDownloadContentId($post->ID),
					'name'     => $post->post_title,
					'category' => implode( '/', getObjectTerms( 'download_category', $post->ID ) ),
					'quantity' => 1,
					'price'    => getEddDownloadPriceToDisplay( $post->ID ),
				),
			),
			'non_interaction' => $this->getOption( 'edd_view_content_non_interactive' ),
		);
		
		$dyn_remarketing = array(
			'product_id'  => Helpers\getEddDownloadContentId($post->ID),
			'page_type'   => 'product',
			'total_value' => getEddDownloadPriceToDisplay( $post->ID ),
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params = array_merge( $params, $dyn_remarketing );

		return array(
			'name'  => 'view_item',
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
		
		$params = array(
			'event_category'  => 'ecommerce',
			'items'           => array(
				array(
					'id'       => Helpers\getEddDownloadContentId($download_id),
					'name'     => $download_post->post_title,
					'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
					'quantity' => 1,
					'price'    => getEddDownloadPriceToDisplay( $download_id, $price_index ),
				),
			),
			'non_interaction' => $this->getOption( 'edd_add_to_cart_non_interactive' ),
		);
		
		$dyn_remarketing = array(
			'product_id'  => Helpers\getEddDownloadContentId($download_id),
			'page_type'   => 'cart',
			'total_value' => getEddDownloadPriceToDisplay( $download_id, $price_index )
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params          = array_merge( $params, $dyn_remarketing );

		return array(
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
		$product_ids = array();
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

			$download_content_id = Helpers\getEddDownloadContentId($download_id);
			$item = array(
				'id'       => $download_content_id,
				'name'     => $download_post->post_title,
				'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
				'quantity' => $cart_item['quantity'],
				'price'    => $price
//				'variant'  => $variation_name,
			);

			$items[] = $item;
			$product_ids[] = $download_content_id;
			$total_value += $price;

		}

		$params = array(
			'event_category' => 'ecommerce',
			'items' => $items,
		);
		
		if ( $context == 'add_to_cart' ) {
			$params['non_interaction'] = true;
		} elseif ( $context == 'begin_checkout' ) {
			$params['non_interaction'] = $this->getOption( 'edd_initiate_checkout_non_interactive' );
		} elseif ( $context == 'purchase' ) {
			$params['non_interaction'] = $this->getOption( 'edd_purchase_non_interactive' );
		}

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
		
		if ( $context == 'add_to_cart' ) {
			$page_type = 'cart';
		} elseif ( $context == 'begin_checkout' ) {
			$page_type = 'checkout';
		} else {
			$page_type = 'purchase';
		}
		
		$dyn_remarketing = array(
			'product_id'  => $product_ids,
			'page_type'   => $page_type,
			'total_value' => $total_value,
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params = array_merge( $params, $dyn_remarketing );
		
		return array(
			'name' => $context,
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
		
		return array(
			'data' => array(
				'event_category'  => 'ecommerce',
				'currency'        => edd_get_currency(),
				'items'           => array(
					array(
						'id'       => Helpers\getEddDownloadContentId($download_id),
						'name'     => $download_post->post_title,
						'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
						'quantity' => $cart_item['quantity'],
						'price'    => getEddDownloadPriceToDisplay( $download_id, $price_index ),
//						'variant'  => $variation_name,
					),
				),
				'non_interaction' => $this->getOption( 'edd_remove_from_cart_non_interactive' ),
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
		$product_ids = array();
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
			);

			$items[] = $item;
			$product_ids[] = $item['id'];
			$total_value += $item['price'];

		}
		
		$params = array(
			'event_category'  => 'ecommerce',
			'event_label'     => $list_name,
			'items'           => $items,
			'non_interaction' => $this->getOption( 'edd_view_category_non_interactive' ),
		);
		
		$dyn_remarketing = array(
			'product_id'  => $product_ids,
			'page_type'   => 'category',
			'total_value' => $total_value,
		);
		
		$dyn_remarketing = Helpers\adaptDynamicRemarketingParams( $dyn_remarketing );
		$params = array_merge( $params, $dyn_remarketing );

		return array(
			'name'  => 'view_item_list',
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
				$non_interactive = $this->getOption( 'edd_frequent_shopper_non_interactive' );
				break;

			case 'edd_vip_client':
				$eventName = 'VipClient';
				$non_interactive = $this->getOption( 'edd_vip_client_non_interactive' );
				break;

			default:
				$eventName = 'BigWhale';
				$non_interactive = $this->getOption( 'edd_big_whale_non_interactive' );
		}

		$params = $this->getEddCartEventParams( $eventName );
		$params['non_interaction'] = $non_interactive;

		return array(
			'name' => $eventName,
			'data' => $params['data'],
		);

	}

}

/**
 * @return GA
 */
function GA() {
	return GA::instance();
}

GA();