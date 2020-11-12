<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use PixelYourSite\Facebook\Helpers;
use PixelYourSite\Ads\Helpers as AdsHelpers;

?>

<h2 class="section-title">WooCommerce Settings</h2>

<!-- Enable WooCommerce -->
<div class="card card-static">
    <div class="card-header">
        General
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <p>Fire e-commerce related events. On Facebook, the events will be Dynamic Ads Ready. Enhanced Ecommerce
                will be enabled for Google Analytics.</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
             <?php PYS()->render_switcher_input( 'woo_enabled' ); ?>
             <h4 class="switcher-label">Enable WooCommerce set-up</h4>
         </div>
     </div>
 </div>
</div>

<!-- Semafors -->
<!-- @todo: update section for Bing -->
<div class="card card-static">
    <div class="card-header">
        Advanced Data Tracking
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-11">
                <div class="indicator">ON</div>
                <h4 class="indicator-label">Facebook Dynamic Product Ads</h4>
            </div>
            <div class="col-1">
              <?php renderPopoverButton( 'woo_facebook_am_params' ); ?>
          </div>
      </div>
      <div class="row">
        <div class="col-11">
            <div class="indicator">ON</div>
            <h4 class="indicator-label">Facebook & Pinterest PRO parameters</h4>
        </div>
        <div class="col-1">
           <?php renderPopoverButton( 'woo_facebook_and_pinterest_params' ); ?>
       </div>
   </div>
   <div class="row">
    <div class="col-11">
        <div class="indicator">ON</div>
        <h4 class="indicator-label">Facebook & Pinterest PRO parameters for Purchase event</h4>
    </div>
    <div class="col-1">
       <?php renderPopoverButton( 'woo_facebook_and_pinterest_purchase_params' ); ?>
   </div>
</div>
<div class="row">
    <div class="col-11">
        <div class="indicator">ON</div>
        <h4 class="indicator-label">Google Analytics Enhanced Ecommerce</h4>
    </div>
    <div class="col-1">
       <?php renderPopoverButton( 'woo_ga_enhanced_ecommerce_params' ); ?>
   </div>
</div>
<div class="row">
    <div class="col-11">
        <div class="indicator">ON</div>
        <h4 class="indicator-label">Google Ads Enhanced Ecommerce</h4>
    </div>
    <div class="col-1">
       <?php renderPopoverButton( 'woo_google_ads_enhanced_ecommerce_params' ); ?>
   </div>
</div>
</div>
</div>

<!-- AddToCart -->
<div class="card card-static">
    <div class="card-header">
        How to capture Add To Cart action
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="custom-controls-stacked">
                    <?php PYS()->render_checkbox_input( 'woo_add_to_cart_on_button_click', 'On Add To Cart button clicks' ); ?>
                    <?php PYS()->render_checkbox_input( 'woo_add_to_cart_on_cart_page', 'On the Cart Page' ); ?>
                    <?php PYS()->render_checkbox_input( 'woo_add_to_cart_on_checkout_page', 'On Checkout Page' ); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col  form-inline">
                <label>Change this if the AddToCart event doesn't fire</label>
                <?php PYS()->render_select_input( 'woo_add_to_cart_on_single_product',
                    array('add_cart_hook'=>"Hook",
                        'single_template'=>"Single Template") ); ?>
            </div>
        </div>
    </div>
</div>

<h2 class="section-title">ID Settings</h2>

<!-- Facebook for WooCommerce -->
<?php if ( Facebook()->enabled() && Helpers\isFacebookForWooCommerceActive() ) : ?>

<!-- @todo: add notice output -->
<!-- @todo: add show/hide facebook content id section JS -->
<div class="card card-static">
    <div class="card-header">
        Facebook for WooCommerce Integration
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <p><strong>It looks like you're using both PixelYourSite and Facebook for WooCommerce Extension. Good, because
                they can do a great job together!</strong></p>
                <p>Facebook for WooCommerce Extension is a useful free tool that lets you import your products to a Facebook
                    shop and adds a very basic Facebook pixel on your site. PixelYourSite is a dedicated plugin that
                supercharges your Facebook Pixel with extremely useful features.</p>
                <p>We made it possible to use both plugins together. You just have to decide what ID to use for your events.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="custom-controls-stacked">
                    <?php Facebook()->render_radio_input( 'woo_content_id_logic', 'facebook_for_woocommerce', 'Use Facebook for WooCommerce extension content_id logic' ); ?>
                    <?php Facebook()->render_radio_input( 'woo_content_id_logic', 'default', 'Use PixelYourSite content_id logic' ); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><em>* If you plan to use the product catalog created by Facebook for WooCommerce Extension, use the
                    Facebook for WooCommerce Extension ID. If you plan to use older product catalogs, or new ones created
                with other plugins, it's better to keep the default PixelYourSite settings.</em></p>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>



<?php if ( Facebook()->enabled() ) : ?>

<?php $facebook_id_visibility = Helpers\isDefaultWooContentIdLogic() ? 'block' : 'none'; ?>

<div class="card card-static" id="pys-section-facebook-id" style="display: <?=$facebook_id_visibility ?>;">
    <div class="card-header">
        Facebook ID setting
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col">
                <?php Facebook()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                <h4 class="switcher-label">Treat variable products like simple products</h4>
                <p class="mt-3">Turn this option ON when your Product Catalog doesn't include the variants for variable
                products.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-offset-left form-inline">
                <label>content_id</label>
                <?php Facebook()->render_select_input( 'woo_content_id',
                    array(
                        'product_id' => 'Product ID',
                        'product_sku'   => 'Product SKU',
                    )
                ); ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-offset-left form-inline">
                <label>content_id prefix</label><?php Facebook()->render_text_input( 'woo_content_id_prefix', '(optional)' ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col col-offset-left form-inline">
                <label>content_id suffix</label><?php Facebook()->render_text_input( 'woo_content_id_suffix', '(optional)' ); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>

    <div class="card card-static" id="pys-section-ga-id">
        <div class="card-header">
            Google Analytics ID setting
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <?php GA()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                    <h4 class="switcher-label">Treat variable products like simple products</h4>
                    <p class="mt-3">If you enable this option, the main ID will be used instead of the variation ID.</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ecomm_prodid</label>
                    <?php GA()->render_select_input( 'woo_content_id',
                        array(
                            'product_id' => 'Product ID',
                            'product_sku'   => 'Product SKU',
                        )
                    ); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ecomm_prodid prefix</label><?php GA()->render_text_input( 'woo_content_id_prefix', '(optional)' ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col col-offset-left form-inline">
                    <label>ecomm_prodid suffix</label><?php GA()->render_text_input( 'woo_content_id_suffix', '(optional)' ); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php if ( Ads()->enabled() ) : ?>

<div class="card card-static">
    <div class="card-header">
        Google Ads Tag ID Settings
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col">
                <?php Ads()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                <h4 class="switcher-label">Treat variable products like simple products</h4>
                <p class="mt-3">If you enable this option, the main ID will be used instead of the variation ID.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-offset-left form-inline">
                <label>ID</label>
                <?php Ads()->render_select_input( 'woo_content_id',
                    array(
                        'product_id' => 'Product ID',
                        'product_sku'   => 'Product SKU',
                    )
                ); ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-11 col-offset-left form-inline">
                <label>ID prefix</label><?php Ads()->render_text_input( 'woo_item_id_prefix',
                '(optional)' ); ?>
            </div>
            <div class="col-1">
              <?php renderPopoverButton( 'ads_woo_item_id_prefix' ); ?>
          </div>
      </div>
      <div class="row">
        <div class="col-11 col-offset-left form-inline">
            <label>ID suffix</label><?php Ads()->render_text_input( 'woo_item_id_suffix',
            '(optional)' ); ?>
        </div>
    </div>
</div>
</div>
<?php endif; ?>


<?php if ( Pinterest()->enabled() ) : ?>

    <div class="card card-static" id="pys-section-ga-id">
        <div class="card-header">
            Pinterest Tag ID setting
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <?php Pinterest()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                    <h4 class="switcher-label">Treat variable products like simple products</h4>
                    <p class="mt-3">If you enable this option, the main ID will be used instead of the variation ID.</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ID</label>
                    <?php Pinterest()->render_select_input( 'woo_content_id',
                        array(
                            'product_id' => 'Product ID',
                            'product_sku'   => 'Product SKU',
                        )
                    ); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ID prefix</label><?php Pinterest()->render_text_input( 'woo_content_id_prefix', '(optional)' ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col col-offset-left form-inline">
                    <label>ID suffix</label><?php Pinterest()->render_text_input( 'woo_content_id_suffix', '(optional)' ); ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
<div class="card card-static" id="pys-section-ga-id">
    <div class="card-header">
        Pinterest Tag ID setting
        <a class="pys_external_link" href="https://www.pixelyoursite.com/pinterest-tag?utm_source=pys-free-plugin&utm_medium=pinterest-badge&utm_campaign=requiere-free-add-on" target="_blank">Requires free add-on <i class="fa fa-external-link"></i></a>
    </div>
</div>
<?php endif; ?>

<!-- @todo: update UI -->
<!-- @todo: hide for dummy Bing -->
<?php if ( Bing()->enabled() ) : ?>
    <div class="card card-static">
        <div class="card-header">
            Bing Tag ID setting
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col">
                    <?php Bing()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                    <h4 class="switcher-label">Treat variable products like simple products</h4>
                    <p class="mt-3">If you enable this option, the main ID will be used instead of the variation ID.</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ID</label>
                    <?php Bing()->render_select_input( 'woo_content_id',
                        array(
                            'product_id' => 'Product ID',
                            'product_sku'   => 'Product SKU',
                        )
                    ); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ID prefix</label><?php Bing()->render_text_input( 'woo_content_id_prefix', '(optional)' ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col col-offset-left form-inline">
                    <label>ID suffix</label><?php Bing()->render_text_input( 'woo_content_id_suffix', '(optional)' ); ?>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
<div class="card card-static">
    <div class="card-header">
        Bing Tag ID setting
        <a class="pys_external_link" href="https://www.pixelyoursite.com/bing-tag?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-bing" target="_blank">Requires paid add-on <i class="fa fa-external-link"></i></a>
    </div>
</div>
<?php endif; ?>

<!-- Google Dynamic Remarketing Vertical -->
<?php if ( GA()->enabled() || Ads()->enabled() ) : ?>

<div class="card card-static">
    <div class="card-header">
        Google Dynamic Remarketing Vertical
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-11">
                <div class="custom-controls-stacked">
                   <?php PYS()->render_radio_input( 'google_retargeting_logic', 'ecomm', 'Use Retail Vertical  (select this if you have access to Google Merchant)' ); ?>
                   <?php PYS()->render_radio_input( 'google_retargeting_logic', 'dynx', 'Use Custom Vertical (select this if Google Merchant is not available for your country)' ); ?>
               </div>
           </div>
           <div class="col-1">
             <?php renderPopoverButton( 'google_dynamic_remarketing_vertical' ); ?>
         </div>
     </div>
 </div>
</div>

<?php endif; ?>


<!-- Event Value -->
<div class="card card-static">
    <div class="card-header">
        Event Value Settings
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col">
                <div class="custom-controls-stacked">
                    <?php PYS()->render_radio_input( 'woo_event_value', 'price', 'Use WooCommerce price settings' ); ?>
                    <?php PYS()->render_radio_input( 'woo_event_value', 'custom', 'Customize Tax and Shipping' ); ?>
                </div>
            </div>
        </div>
        <div class="row mb-3 woo-event-value-option" style="display: none;">
            <div class="col col-offset-left form-inline">
             <?php PYS()->render_select_input( 'woo_tax_option',
              array(
               'included' => 'Include Tax',
               'excluded' => 'Exclude Tax',
           )
       ); ?>
       <label>and</label>
       <?php PYS()->render_select_input( 'woo_shipping_option',
          array(
           'included' => 'Include Shipping',
           'excluded' => 'Exclude Shipping',
       )
   ); ?>
</div>
</div>

<div class="row">
    <div class="col">
        <h4 class="label">Lifetime Customer Value</h4>
        <?php PYS()->render_multi_select_input( 'woo_ltv_order_statuses', wc_get_order_statuses() ); ?>
    </div>
</div>
</div>
</div>

<h2 class="section-title">Advanced Marketing Events</h2>


<!-- FrequentShopper -->
<div class="card">
    <div class="card-header">
        FrequentShopper Event <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_frequent_shopper_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_frequent_shopper_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'woo_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Enable on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col col-offset-left form-inline">
        <label>Fire this event when the client has at least </label>
        <?php PYS()->render_number_input( 'woo_frequent_shopper_transactions' ); ?>
        <label>transactions</label>
    </div>
</div>
</div>
</div>

<!-- VipClient -->
<div class="card">
    <div class="card-header">
        VIPClient Event <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_vip_client_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_vip_client_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'woo_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Enable on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col col-offset-left form-inline">
        <label>Fire this event when the client has at least</label>
        <?php PYS()->render_number_input( 'woo_vip_client_transactions' ); ?>
        <label>transactions and average order is at least</label>
        <?php PYS()->render_number_input( 'woo_vip_client_average_value' ); ?>
    </div>
</div>
</div>
</div>

<!-- BigWhale -->
<div class="card">
    <div class="card-header">
        BigWhale Event <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_big_whale_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_big_whale_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'woo_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Enable on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col col-offset-left form-inline">
        <label>Fire this event when the client has LTV at least</label>
        <?php PYS()->render_number_input( 'woo_big_whale_ltv' ); ?>
    </div>
</div>
</div>
</div>

<h2 class="section-title">Default E-Commerce events</h2>

<!-- Purchase -->
<div class="card">
    <div class="card-header">
        Track Purchases <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-11">
               <?php PYS()->render_checkbox_input( 'woo_purchase_on_transaction', 'Fire the event on transaction only' ); ?>
           </div>
           <div class="col-1">
              <?php renderPopoverButton( 'woo_purchase_on_transaction' ); ?>
          </div>
        </div>

        <div class="row mb-1">
            <div class="col">
                <label>Fire the Purchase Event for the following order status:</label>
                <div class="custom-controls-stacked ml-2">
                    <?php
                        $statuses = wc_get_order_statuses();
                        foreach ( $statuses as $status => $status_name) {
                            PYS()->render_checkbox_input_revert_array( 'woo_order_purchase_disabled_status', esc_html( $status_name ),esc_attr( $status ));
                        }
                    ?>
                </div>
                <label>The Purchase event fires when the client makes a transaction on your website. It won't fire on when the order status is modified afterwards.</label>
            </div>
        </div>

      <?php if ( Facebook()->enabled() ) : ?>
      <div class="row mb-1">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_purchase_enabled' ); ?>
            <h4 class="switcher-label">Enable the Purchase event on Facebook (required for DPA)</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_purchase_enabled' ); ?>
        <h4 class="switcher-label">Enable the Checkout event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col-11 col-offset-left">
        <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
    </div>
    <div class="col-1">
      <?php renderPopoverButton( 'woo_purchase_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div>
            <div class="collapse-inner">
                <div class="custom-controls-stacked">
                  <?php PYS()->render_radio_input( 'woo_purchase_value_option', 'price',
                  'Order\'s total' ); ?>
	                <?php  if ( !isPixelCogActive() ) { ?>
		                <?php PYS()->render_radio_input( 'woo_purchase_value_option', 'cog',
			                'Price minus Cost of Goods', true, true ); ?>
	                <?php } else { ?>
		                <?php PYS()->render_radio_input( 'woo_purchase_value_option', 'cog',
			                'Price minus Cost of Goods', false ); ?>
	                <?php } ?>
                  <?php PYS()->render_radio_input( 'woo_purchase_value_option', 'percent',
                  'Percent of the order\'s total' ); ?>
                  <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_purchase_value_percent' ); ?>
               </div>
               <?php PYS()->render_radio_input( 'woo_purchase_value_option', 'global',
               'Use Global value' ); ?>
               <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_purchase_value_global' ); ?>
               </div>
           </div>
       </div>
   </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_purchase_enabled' ); ?>
        <h4 class="switcher-label">Enable the purchase event on Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_purchase_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_purchase_enabled' ); ?>
        <h4 class="switcher-label">Enable the purchase event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'woo_purchase' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col-11">
        <?php Bing()->render_switcher_input( 'woo_purchase_enabled' ); ?>
        <h4 class="switcher-label">Enable the Purchase event on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
    <div class="col-1">
        <?php renderPopoverButton( 'woo_bing_enable_purchase' ); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col">
        <p class="mb-0">*This event will be fired on the order-received, the default WooCommerce "thank you
            page". If you use PayPal, make sure that auto-return is ON. If you want to use "custom thank you
            pages", you must configure them with our <a href="https://www.pixelyoursite.com/super-pack"
            target="_blank">Super Pack</a>.</p>
        </div>
    </div>
</div>
</div>

<!-- Checkout Behavior on Google Analytics -->
<?php if ( GA()->enabled() ) : ?>
    <div class="card">
        <div class="card-header">
            Track Checkout Behavior on Google Analytics <?php cardCollapseBtn(); ?>
        </div>
        <div class="card-body">

            <div class="row mb-1 woo_initiate_checkout_enabled">
                <div class="col-1 pr-0"><div class="step pt-2">STEP 1:</div></div>
                <div class="col pl-0">
                    <?php
                    $isInitiateCheckoutActive =  GA()->getOption( 'woo_initiate_checkout_enabled' );
                    GA()->render_switcher_input( 'woo_initiate_checkout_enabled' );

                    ?>
                    <h4 class="switcher-label">Enable the begin_checkout </h4>
                </div>
                <div class="col-1">
		            <?php renderPopoverButton( 'woo_initiate_checkout_event_value_1' ); ?>
                </div>
            </div>

            <div class="row mb-1" style="display: none">
                <div class="col">
                    <?php GA()->render_switcher_input( 'woo_initiate_set_checkout_option_enabled' ); ?>
                    <h4 class="switcher-label">Enable the set_checkout_option  </h4>
                </div>
            </div>
            <div class="row mb-1 woo_initiate_checkout_progress_f_enabled checkout_progress" >
                <div class="col-1 pr-0"><div class="step pt-2"></div></div>
                <div class="col pl-0 col-offset-left">
                    <?php GA()->render_switcher_input( 'woo_initiate_checkout_progress_f_enabled'); ?>
                    <h4 class="switcher-label">Enable checkout_progress when the First Name is added   </h4>
                </div>
            </div>
            <div class="row mb-1 woo_initiate_checkout_progress_l_enabled checkout_progress">
                <div class="col-1 pr-0"><div class="step pt-2"></div></div>
                <div class="col pl-0 col-offset-left">
                    <?php GA()->render_switcher_input( 'woo_initiate_checkout_progress_l_enabled' ); ?>
                    <h4 class="switcher-label">Enable checkout_progress when the Last Name is added   </h4>
                </div>
            </div>
            <div class="row mb-1 woo_initiate_checkout_progress_e_enabled checkout_progress">
                <div class="col-1 pr-0"><div class="step pt-2"></div></div>
                <div class="col pl-0 col-offset-left">
                    <?php GA()->render_switcher_input( 'woo_initiate_checkout_progress_e_enabled' ); ?>
                    <h4 class="switcher-label">Enable checkout_progress when the Email is added   </h4>
                </div>
            </div>
            <div class="row mb-1 woo_initiate_checkout_progress_o_enabled checkout_progress">
                <div class="col-1 pr-0"><div class="step pt-2"></div></div>
                <div class="col pl-0 col-offset-left">
                    <?php GA()->render_switcher_input( 'woo_initiate_checkout_progress_o_enabled' ); ?>
                    <h4 class="switcher-label">Enable checkout_progress when is Place Order is clicked </h4>
                </div>
            </div>



        </div>
    </div>
<?php endif; ?>

<!-- InitiateCheckout -->
<div class="card">
    <div class="card-header">
        Track the Checkout Page <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
            <h4 class="switcher-label">Enable the InitiateCheckout event on Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
        <h4 class="switcher-label">Enable the InitiateCheckout on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col-11 col-offset-left">
       <?php PYS()->render_switcher_input( 'woo_initiate_checkout_value_enabled', true ); ?>
       <h4 class="indicator-label">Event value on Facebook and Pinterest</h4>
   </div>
   <div class="col-1">
      <?php renderPopoverButton( 'woo_initiate_checkout_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'woo_initiate_checkout_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                  <?php PYS()->render_radio_input( 'woo_initiate_checkout_value_option', 'price',
                  'Products price (subtotal)' ); ?>
	                <?php  if ( !isPixelCogActive() ) { ?>
		                <?php PYS()->render_radio_input( 'woo_initiate_checkout_value_option', 'cog',
			                'Price minus Cost of Goods', true, true ); ?>
	                <?php } else { ?>
		                <?php PYS()->render_radio_input( 'woo_initiate_checkout_value_option', 'cog',
			                'Price minus Cost of Goods', false ); ?>
	                <?php } ?>
                  <?php PYS()->render_radio_input( 'woo_initiate_checkout_value_option', 'percent',
                  'Percent of products value (subtotal)' ); ?>
                  <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_initiate_checkout_value_percent' ); ?>
               </div>
               <?php PYS()->render_radio_input( 'woo_initiate_checkout_value_option', 'global',
               'Use Global value' ); ?>
               <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_initiate_checkout_value_global' ); ?>
               </div>
           </div>
       </div>
   </div>
</div>
</div>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
        <h4 class="switcher-label">Enable the begin_checkout event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'woo_initiate_checkout' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
        <h4 class="switcher-label">Enable the InitiateCheckout on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>
</div>
</div>

<!-- RemoveFromCart -->
<div class="card">
    <div class="card-header">
        Track remove from cart <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
            <h4 class="switcher-label">Enable the RemoveFromCart event on Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the remove_from_cart event on Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_remove_from_cart_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the remove_from_cart event on Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the RemoveFromCart event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

</div>
</div>

<!-- AddToCart -->
<div class="card">
    <div class="card-header">
        Track add to cart <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
            <h4 class="switcher-label">Enable the AddToCart event on Facebook (required for DPA)</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the AddToCart event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col-11 col-offset-left">
       <?php PYS()->render_switcher_input( 'woo_add_to_cart_value_enabled', true ); ?>
       <h4 class="indicator-label">Tracking Value</h4>
   </div>
   <div class="col-1">
      <?php renderPopoverButton( 'woo_add_to_cart_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'woo_add_to_cart_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                  <?php PYS()->render_radio_input( 'woo_add_to_cart_value_option', 'price', 'Products price (subtotal)' ); ?>
	                <?php  if ( !isPixelCogActive() ) { ?>
		                <?php PYS()->render_radio_input( 'woo_add_to_cart_value_option', 'cog',
			                'Price minus Cost of Goods', true, true ); ?>
	                <?php } else { ?>
		                <?php PYS()->render_radio_input( 'woo_add_to_cart_value_option', 'cog',
			                'Price minus Cost of Goods', false ); ?>
	                <?php } ?>
					<?php PYS()->render_radio_input( 'woo_add_to_cart_value_option', 'percent',
                  'Percent of products value (subtotal)' ); ?>
                  <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_add_to_cart_value_percent' ); ?>
               </div>
               <?php PYS()->render_radio_input( 'woo_add_to_cart_value_option', 'global',
               'Use Global value' ); ?>
               <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_add_to_cart_value_global' ); ?>
               </div>
           </div>
       </div>
   </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the add_to_cart event on Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_add_to_cart_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the add_to_cart event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'woo_add_to_cart' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the AddToCart event on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>
</div>
</div>

<!-- ViewContent -->
<div class="card">
    <div class="card-header">
        Track product pages <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_view_content_enabled' ); ?>
            <h4 class="switcher-label">Enable the ViewContent on Facebook (required for DPA)</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_view_content_enabled' ); ?>
        <h4 class="switcher-label">Enable the PageVisit event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col col-offset-left form-inline">
        <label>Delay</label>
        <?php PYS()->render_number_input( 'woo_view_content_delay' ); ?>
        <label>seconds</label>
    </div>
</div>
<div class="row mb-3">
    <div class="col-11 col-offset-left">
       <?php PYS()->render_switcher_input( 'woo_view_content_value_enabled', true ); ?>
       <h4 class="indicator-label">Tracking Value</h4>
   </div>
   <div class="col-1">
      <?php renderPopoverButton( 'woo_view_content_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'woo_view_content_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                  <?php PYS()->render_radio_input( 'woo_view_content_value_option', 'price', 'Product price' ); ?>
	                <?php  if ( !isPixelCogActive() ) { ?>
		                <?php PYS()->render_radio_input( 'woo_view_content_value_option', 'cog',
			                'Price minus Cost of Goods', true, true ); ?>
	                <?php } else { ?>
		                <?php PYS()->render_radio_input( 'woo_view_content_value_option', 'cog',
			                'Price minus Cost of Goods', false ); ?>
	                <?php } ?>
					<?php PYS()->render_radio_input( 'woo_view_content_value_option', 'percent', 'Percent of product price' ); ?>
                  <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_view_content_value_percent' ); ?>
               </div>
               <?php PYS()->render_radio_input( 'woo_view_content_value_option', 'global', 'Use Global value' ); ?>
               <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_view_content_value_global' ); ?>
               </div>
           </div>
       </div>
   </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_view_content_enabled' ); ?>
        <h4 class="switcher-label">Enable the view_item event on Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_view_content_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_view_content_enabled' ); ?>
        <h4 class="switcher-label">Enable the view_item event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'woo_view_content' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'woo_view_content_enabled' ); ?>
        <h4 class="switcher-label">Enable the PageVisit event on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>
</div>
</div>

<!-- ViewCategory -->
<div class="card">
    <div class="card-header">
        Track product category pages <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_view_category_enabled' ); ?>
            <h4 class="switcher-label">Enable the ViewCategory event on Facebook Analytics (used for DPA)</h4>
        </div>
    </div>
<?php endif; ?>



<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_view_category_enabled' ); ?>
        <h4 class="switcher-label">Enable the view_item_list event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'woo_view_category' ); ?>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_view_category_enabled' ); ?>
        <h4 class="switcher-label">Enable the ViewCategory event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'woo_view_category_enabled' ); ?>
        <h4 class="switcher-label">Enable the ViewCategory event on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

</div>
</div>

<div class="card">
    <div class="card-header">
        Track product list performance on Google Analytics<?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">
        <?php if ( GA()->enabled() ) : ?>
            <div class="row mb-1">
                <div class="col">
                    <?php GA()->render_switcher_input( 'woo_view_category_enabled' ); ?>
                    <h4 class="switcher-label">Enable the view_item_list event on Google Analytics(categories, related products, search, shortcodes)</h4>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col col-offset-left">
                    <?php GA()->render_checkbox_input( 'woo_view_category_non_interactive',
                        'Non-interactive event' ); ?>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col">
                    <?php GA()->render_switcher_input( 'woo_select_content_enabled' ); ?>
                    <h4 class="switcher-label">Enable the select_content event on Google Analytics(when a product is clicked on categories, related products, search, shortcodes)</h4>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-header">
        CompleteRegistration for the Facebook Pixel<?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">
        <?php if ( Facebook()->enabled() ) : ?>
            <div class="row mb-1">
                <div class="col">
                    <?php Facebook()->render_checkbox_input( 'woo_complete_registration_fire_every_time',
                        "Fire this event every time a transaction takes place"); ?>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col col-offset-left">
                    <?php Facebook()->render_switcher_input( 'woo_complete_registration_use_custom_value'); ?>
                    <h4 class="switcher-label">Event value on Facebook</h4>
                    <div class="row mt-2">
                        <div class="col col-offset-left">
                            <div class="collapse-inner pt-0">
                        <div class="custom-controls-stacked">
                            <?php Facebook()->render_radio_input("woo_complete_registration_custom_value","price",
                                "Order's total") ?>
                            <?php  if ( !isPixelCogActive() ) { ?>
                                <?php Facebook()->render_radio_input( 'woo_complete_registration_custom_value', 'cog',
                                    'Price minus Cost of Goods', true, true ); ?>
                            <?php } else { ?>
                                <?php Facebook()->render_radio_input( 'woo_complete_registration_custom_value', 'cog',
                                    'Price minus Cost of Goods', false ); ?>
                            <?php } ?>
                            <?php Facebook()->render_radio_input("woo_complete_registration_custom_value","percent",
                                "Percent of the order's total") ?>
                            <div class="form-inline">
                                <?php Facebook()->render_number_input( 'woo_complete_registration_percent_value' ); ?>
                            </div>
                            <?php Facebook()->render_radio_input("woo_complete_registration_custom_value","global",
                                "Use global value") ?>
                            <div class="form-inline">
                                <?php Facebook()->render_number_input( 'woo_complete_registration_global_value' ); ?>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <?php Facebook()->render_switcher_input( 'woo_complete_registration_send_from_server'); ?>
                    <h4 class="switcher-label">Send this from your server only. It won't be visible on your browser.</h4>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<h2 class="section-title">Extra E-Commerce events</h2>

<!-- Affiliate -->
<div class="card">
    <div class="card-header">
        Track WooCommerce affiliate button clicks <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_affiliate_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_affiliate_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col col-offset-left form-inline">
        <label>Event Type:</label><?php PYS()->render_select_input( 'woo_affiliate_event_type',
            array(
             'ViewContent'          => 'ViewContent',
             'AddToCart'            => 'AddToCart',
             'AddToWishlist'        => 'AddToWishlist',
             'InitiateCheckout'     => 'InitiateCheckout',
             'AddPaymentInfo'       => 'AddPaymentInfo',
             'Purchase'             => 'Purchase',
             'Lead'                 => 'Lead',
             'CompleteRegistration' => 'CompleteRegistration',
             'disabled'             => '',
             'custom'               => 'Custom',
         ), false, 'pys_core_woo_affiliate_custom_event_type', 'custom' ); ?>
         <?php PYS()->render_text_input( 'woo_affiliate_custom_event_type', 'Enter name', false, true ); ?>
     </div>
 </div>
 <div class="row mb-3">
    <div class="col-11 col-offset-left">
       <?php PYS()->render_switcher_input( 'woo_affiliate_value_enabled', true ); ?>
       <h4 class="indicator-label">Tracking Value</h4>
   </div>
   <div class="col-1">
      <?php renderPopoverButton( 'woo_affiliate_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'woo_affiliate_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                  <?php PYS()->render_radio_input( 'woo_affiliate_value_option', 'price', 'Product price' ); ?>
                  <?php PYS()->render_radio_input( 'woo_affiliate_value_option', 'global',
                  'Use Global value' ); ?>
                  <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_affiliate_value_global' ); ?>
               </div>
           </div>
       </div>
   </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_affiliate_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_affiliate_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_affiliate_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

</div>
</div>

<!-- PayPal -->
<div class="card">
    <div class="card-header">
        Track WooCommerce PayPal Standard clicks <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">

     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'woo_paypal_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'woo_paypal_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col col-offset-left form-inline">
        <label>Event Type:</label><?php PYS()->render_select_input( 'woo_paypal_event_type',
            array(
             'ViewContent'          => 'ViewContent',
             'AddToCart'            => 'AddToCart',
             'AddToWishlist'        => 'AddToWishlist',
             'InitiateCheckout'     => 'InitiateCheckout',
             'AddPaymentInfo'       => 'AddPaymentInfo',
             'Purchase'             => 'Purchase',
             'Lead'                 => 'Lead',
             'CompleteRegistration' => 'CompleteRegistration',
             'disabled'             => '',
             'custom'               => 'Custom',
         ), false, 'pys_core_woo_paypal_custom_event_type', 'custom' ); ?>
         <?php PYS()->render_text_input( 'woo_paypal_custom_event_type', 'Enter name', false, true ); ?>
     </div>
 </div>
 <div class="row mb-3">
    <div class="col-11 col-offset-left">
       <?php PYS()->render_switcher_input( 'woo_paypal_value_enabled', true ); ?>
       <h4 class="indicator-label">Tracking Value</h4>
   </div>
   <div class="col-1">
      <?php renderPopoverButton( 'woo_paypal_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'woo_paypal_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                  <?php PYS()->render_radio_input( 'woo_paypal_value_option', 'price', 'Product price' ); ?>
                  <?php PYS()->render_radio_input( 'woo_paypal_value_option', 'global',
                  'Use Global value' ); ?>
                  <div class="form-inline">
                   <?php PYS()->render_number_input( 'woo_paypal_value_global' ); ?>
               </div>
           </div>
       </div>
   </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'woo_paypal_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'woo_paypal_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'woo_paypal_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

</div>
</div>

<hr>
<div class="row justify-content-center">
	<div class="col-4">
		<button class="btn btn-block btn-sm btn-save">Save Settings</button>
	</div>
</div>