<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use PixelYourSite\Ads\Helpers as AdsHelpers;

?>

<h2 class="section-title">EasyDigitalDownloads Settings</h2>

<!-- Enable EDD -->
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
                <?php PYS()->render_switcher_input( 'edd_enabled' ); ?>
                <h4 class="switcher-label">Enable EasyDigitalDownloads set-up</h4>
            </div>
        </div>
    </div>
</div>

<!-- Semafors -->
<div class="card card-static">
    <div class="card-header">
        Advanced Data Tracking
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-11">
                <div class="indicator">ON</div>
                <h4 class="indicator-label">Facebook Advanced Matching parameters</h4>
            </div>
            <div class="col-1">
                <?php renderPopoverButton( 'edd_facebook_am_params' ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="indicator">ON</div>
                <h4 class="indicator-label">Facebook & Pinterest PRO parameters</h4>
            </div>
            <div class="col-1">
                <?php renderPopoverButton( 'edd_facebook_and_pinterest_params' ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="indicator">ON</div>
                <h4 class="indicator-label">Facebook & Pinterest PRO parameters for Purchase event</h4>
            </div>
            <div class="col-1">
                <?php renderPopoverButton( 'edd_facebook_and_pinterest_purchase_params' ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="indicator">ON</div>
                <h4 class="indicator-label">Google Analytics Enhanced Ecommerce</h4>
            </div>
            <div class="col-1">
                <?php renderPopoverButton( 'edd_ga_enhanced_ecommerce_params' ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="indicator">ON</div>
                <h4 class="indicator-label">Google Ads Enhanced Ecommerce</h4>
            </div>
            <div class="col-1">
             <?php renderPopoverButton( 'edd_google_ads_enhanced_ecommerce_params' ); ?>
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
                   <?php PYS()->render_checkbox_input( 'edd_add_to_cart_on_button_click', 'On Add To Cart button clicks' ); ?>
                   <?php PYS()->render_checkbox_input( 'edd_add_to_cart_on_checkout_page', 'On Checkout Page' ); ?>
               </div>
           </div>
       </div>
   </div>
</div>

<?php if ( Facebook()->enabled() ) : ?>

<!-- Facebook ID -->
<div class="card card-static">
    <div class="card-header">
        Facebook ID setting
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col col-offset-left form-inline">
                <label>content_id</label>
                <?php Facebook()->render_select_input( 'edd_content_id',
                    array(
                        'download_id' => 'Download ID',
                        'download_sku' => 'Download SKU',
                    )
                ); ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-offset-left form-inline">
                <label>content_id prefix</label><?php Facebook()->render_text_input( 'edd_content_id_prefix', '(optional)' ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col col-offset-left form-inline">
                <label>content_id suffix</label><?php Facebook()->render_text_input( 'edd_content_id_suffix', '(optional)' ); ?>
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
                <div class="col col-offset-left form-inline">
                    <label>ecomm_prodid</label>
                    <?php GA()->render_select_input( 'edd_content_id',
                        array(
                            'download_id' => 'Download ID',
                            'download_sku'   => 'Download SKU',
                        )
                    ); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ecomm_prodid prefix</label><?php GA()->render_text_input( 'edd_content_id_prefix', '(optional)' ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col col-offset-left form-inline">
                    <label>ecomm_prodid suffix</label><?php GA()->render_text_input( 'edd_content_id_suffix', '(optional)' ); ?>
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
                <div class="col col-offset-left form-inline">
                    <label>ID</label>
                    <?php Ads()->render_select_input( 'edd_content_id',
                        array(
                            'download_id' => 'Download ID',
                            'download_sku'   => 'Download SKU',
                        )
                    ); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-11 col-offset-left form-inline">
                    <label>ID prefix</label><?php Ads()->render_text_input( 'edd_content_id_prefix',
                        '(optional)' ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-11 col-offset-left form-inline">
                    <label>ID suffix</label><?php Ads()->render_text_input( 'edd_content_id_suffix',
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
                <div class="col col-offset-left form-inline">
                    <label>ID</label>
                    <?php Pinterest()->render_select_input( 'edd_content_id',
                        array(
                            'download_id' => 'Download ID',
                            'download_sku'   => 'Download SKU',
                        )
                    ); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-11 col-offset-left form-inline">
                    <label>ID prefix</label><?php Pinterest()->render_text_input( 'edd_content_id_prefix',
                        '(optional)' ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-11 col-offset-left form-inline">
                    <label>ID suffix</label><?php Pinterest()->render_text_input( 'edd_content_id_suffix',
                        '(optional)' ); ?>
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
            Bing ID setting
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col col-offset-left form-inline">
                    <label>ID</label>
                    <?php Bing()->render_select_input( 'edd_content_id',
                        array(
                            'download_id' => 'Download ID',
                            'download_sku'   => 'Download SKU',
                        )
                    ); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-11 col-offset-left form-inline">
                    <label>ID prefix</label><?php Bing()->render_text_input( 'edd_content_id_prefix',
                        '(optional)' ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-11 col-offset-left form-inline">
                    <label>ID suffix</label><?php Bing()->render_text_input( 'edd_content_id_suffix',
                        '(optional)' ); ?>
                </div>
            </div>
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
                  <?php PYS()->render_radio_input( 'google_retargeting_logic', 'ecomm',
                  'Use Retail Vertical  (select this if you have access to Google Merchant)' ); ?>
                  <?php PYS()->render_radio_input( 'google_retargeting_logic', 'dynx',
                  'Use Custom Vertical (select this if Google Merchant is not available for your country)' ); ?>
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
                   <?php PYS()->render_radio_input( 'edd_event_value', 'price', 'Use EasyDigitalDownloads price settings' ); ?>
                   <?php PYS()->render_radio_input( 'edd_event_value', 'custom', 'Customize Tax' ); ?>
               </div>
           </div>
       </div>
       <div class="row mb-3 edd-event-value-option" style="display: none;">
        <div class="col col-offset-left form-inline">
            <?php PYS()->render_select_input( 'edd_tax_option',
               array(
                  'included' => 'Include Tax',
                  'excluded' => 'Exclude Tax',
              )
          ); ?>
      </div>
  </div>
  <div class="row">
    <div class="col">
        <h4 class="label">Lifetime Customer Value</h4>
        <?php PYS()->render_multi_select_input( 'edd_ltv_order_statuses', edd_get_payment_statuses() ); ?>
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
            <?php Facebook()->render_switcher_input( 'edd_frequent_shopper_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_frequent_shopper_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'edd_frequent_shopper_enabled' ); ?>
        <h4 class="switcher-label">Enable on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col col-offset-left form-inline">
        <label>Fire this event when the client has at least </label>
        <?php PYS()->render_number_input( 'edd_frequent_shopper_transactions' ); ?>
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
            <?php Facebook()->render_switcher_input( 'edd_vip_client_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_vip_client_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'edd_vip_client_enabled' ); ?>
        <h4 class="switcher-label">Enable on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col col-offset-left form-inline">
        <label>Fire this event when the client has at least</label>
        <?php PYS()->render_number_input( 'edd_vip_client_transactions' ); ?>
        <label>transactions and average order is at least</label>
        <?php PYS()->render_number_input( 'edd_vip_client_average_value' ); ?>
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
            <?php Facebook()->render_switcher_input( 'edd_big_whale_enabled' ); ?>
            <h4 class="switcher-label">Send the event to Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_big_whale_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Send the event to Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Enable on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'edd_big_whale_enabled' ); ?>
        <h4 class="switcher-label">Enable on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col col-offset-left form-inline">
        <label>Fire this event when the client has LTV at least</label>
        <?php PYS()->render_number_input( 'edd_big_whale_ltv' ); ?>
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
               <?php PYS()->render_checkbox_input( 'edd_purchase_on_transaction', 'Fire the event on transaction only' ); ?>
           </div>
           <div class="col-1">
             <?php renderPopoverButton( 'edd_purchase_on_transaction' ); ?>
         </div>
     </div>
     
     <?php if ( Facebook()->enabled() ) : ?>
     <div class="row mb-1">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'edd_purchase_enabled' ); ?>
            <h4 class="switcher-label">Enable the Purchase event on Facebook (required for DPA)</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_checkout_enabled' ); ?>
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
     <?php renderPopoverButton( 'edd_purchase_event_value' ); ?>
 </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div>
            <div class="collapse-inner">
                <div class="custom-controls-stacked">
                 <?php PYS()->render_radio_input( 'edd_purchase_value_option', 'price',
                 'Downloads price (total)' ); ?>
                 <?php PYS()->render_radio_input( 'edd_purchase_value_option', 'percent',
                 'Percent of downloads value (total)' ); ?>
                 <div class="form-inline">
                    <?php PYS()->render_number_input( 'edd_purchase_value_percent' ); ?>
                </div>
                <?php PYS()->render_radio_input( 'edd_purchase_value_option', 'global',
                'Use Global value' ); ?>
                <div class="form-inline">
                    <?php PYS()->render_number_input( 'edd_purchase_value_global' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_purchase_enabled' ); ?>
        <h4 class="switcher-label">Enable the purchase event on Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_purchase_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_purchase_enabled' ); ?>
        <h4 class="switcher-label">Enable the purchase event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'edd_purchase' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col-11">
        <?php Bing()->render_switcher_input( 'edd_purchase_enabled' ); ?>
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
        <p class="mb-0">*This event will be fired on the order-received, the default Easy Digital Downloads
            "thank you page". If you use PayPal, make sure that auto-return is ON. If you want to use "custom
            thank you pages", you must configure them with our
            <a href="https://www.pixelyoursite.com/super-pack" target="_blank">Super Pack</a>.
        </p>
    </div>
</div>
</div>
</div>

<!-- InitiateCheckout -->
<div class="card">
    <div class="card-header">
        Track the Checkout Page <?php cardCollapseBtn(); ?>
    </div>
    <div class="card-body">
       
       <?php if ( Facebook()->enabled() ) : ?>
       <div class="row">
        <div class="col">
            <?php Facebook()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
            <h4 class="switcher-label">Enable the InitiateCheckout event on Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
        <h4 class="switcher-label">Enable the InitiateCheckout on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col-11 col-offset-left">
        <?php PYS()->render_switcher_input( 'edd_initiate_checkout_value_enabled', true ); ?>
        <h4 class="indicator-label">Event value on Facebook and Pinterest</h4>
    </div>
    <div class="col-1">
      <?php renderPopoverButton( 'edd_initiate_checkout_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'edd_initiate_checkout_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                 <?php PYS()->render_radio_input( 'edd_initiate_checkout_value_option', 'price',
                 'Downloads price (subtotal)' ); ?>
                 <?php PYS()->render_radio_input( 'edd_initiate_checkout_value_option', 'percent',
                 'Percent of downloads value (subtotal)' ); ?>
                 <div class="form-inline">
                    <?php PYS()->render_number_input( 'edd_initiate_checkout_value_percent' ); ?>
                </div>
                <?php PYS()->render_radio_input( 'edd_initiate_checkout_value_option', 'global',
                'Use Global value' ); ?>
                <div class="form-inline">
                    <?php PYS()->render_number_input( 'edd_initiate_checkout_value_global' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
        <h4 class="switcher-label">Enable the begin_checkout event on Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_initiate_checkout_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
        <h4 class="switcher-label">Enable the begin_checkout event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'edd_initiate_checkout' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
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
            <?php Facebook()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
            <h4 class="switcher-label">Enable the RemoveFromCart event on Facebook</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the remove_from_cart event on Google Analytics</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_remove_from_cart_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the remove_from_cart event on Google Ads</h4>
    </div>
</div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
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
            <?php Facebook()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
            <h4 class="switcher-label">Enable the AddToCart event on Facebook (required for DPA)</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the AddToCart event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col-11 col-offset-left">
        <?php PYS()->render_switcher_input( 'edd_add_to_cart_value_enabled', true ); ?>
        <h4 class="indicator-label">Tracking Value</h4>
    </div>
    <div class="col-1">
      <?php renderPopoverButton( 'edd_add_to_cart_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'edd_add_to_cart_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                 <?php PYS()->render_radio_input( 'edd_add_to_cart_value_option', 'price', 'Downloads price (subtotal)' ); ?>
                 <?php PYS()->render_radio_input( 'edd_add_to_cart_value_option', 'percent',
                 'Percent of downloads value (subtotal)' ); ?>
                 <div class="form-inline">
                    <?php PYS()->render_number_input( 'edd_add_to_cart_value_percent' ); ?>
                </div>
                <?php PYS()->render_radio_input( 'edd_add_to_cart_value_option', 'global',
                'Use Global value' ); ?>
                <div class="form-inline">
                    <?php PYS()->render_number_input( 'edd_add_to_cart_value_global' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the add_to_cart event on Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_add_to_cart_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
        <h4 class="switcher-label">Enable the add_to_cart event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'edd_add_to_cart' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
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
            <?php Facebook()->render_switcher_input( 'edd_view_content_enabled' ); ?>
            <h4 class="switcher-label">Enable the ViewContent on Facebook (required for DPA)</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_page_visit_enabled' ); ?>
        <h4 class="switcher-label">Enable the PageVisit event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<div class="row my-3">
    <div class="col col-offset-left form-inline">
        <label>Delay</label>
        <?php PYS()->render_number_input( 'edd_view_content_delay' ); ?>
        <label>seconds</label>
    </div>
</div>
<div class="row mb-3">
    <div class="col-11 col-offset-left">
        <?php PYS()->render_switcher_input( 'edd_view_content_value_enabled', true ); ?>
        <h4 class="indicator-label">Tracking Value</h4>
    </div>
    <div class="col-1">
      <?php renderPopoverButton( 'edd_view_content_event_value' ); ?>
  </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <div <?php renderCollapseTargetAttributes( 'edd_view_content_value_enabled', PYS() ); ?>>
            <div class="collapse-inner pt-0">
                <label class="label-inline">Facebook and Pinterest value parameter settings:</label>
                <div class="custom-controls-stacked">
                 <?php PYS()->render_radio_input( 'edd_view_content_value_option', 'price', 'Download price'
             ); ?>
             <?php PYS()->render_radio_input( 'edd_view_content_value_option', 'percent', 'Percent of download price' ); ?>
             <div class="form-inline">
                <?php PYS()->render_number_input( 'edd_view_content_value_percent' ); ?>
            </div>
            <?php PYS()->render_radio_input( 'edd_view_content_value_option', 'global', 'Use Global value' ); ?>
            <div class="form-inline">
                <?php PYS()->render_number_input( 'edd_view_content_value_global' ); ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_view_content_enabled' ); ?>
        <h4 class="switcher-label">Enable the view_item event on Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_view_content_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_view_content_enabled' ); ?>
        <h4 class="switcher-label">Enable the view_item event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'edd_view_content' ); ?>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'edd_view_content_enabled' ); ?>
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
            <?php Facebook()->render_switcher_input( 'edd_view_category_enabled' ); ?>
            <h4 class="switcher-label">Enable the ViewCategory event on Facebook Analytics (used for DPA)</h4>
        </div>
    </div>
<?php endif; ?>

<?php if ( GA()->enabled() ) : ?>
<div class="row mb-1">
    <div class="col">
        <?php GA()->render_switcher_input( 'edd_view_category_enabled' ); ?>
        <h4 class="switcher-label">Enable the view_item_list event on Google Analytics</h4>
    </div>
</div>
<div class="row">
    <div class="col col-offset-left">
        <?php GA()->render_checkbox_input( 'edd_view_category_non_interactive',
        'Non-interactive event' ); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Ads()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Ads()->render_switcher_input( 'edd_view_category_enabled' ); ?>
        <h4 class="switcher-label">Enable the view_item_list event on Google Ads</h4>
    </div>
</div>
<?php AdsHelpers\renderConversionLabelInputs( 'edd_view_category' ); ?>
<?php endif; ?>

<?php if ( Pinterest()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Pinterest()->render_switcher_input( 'edd_view_category_enabled' ); ?>
        <h4 class="switcher-label">Enable the ViewCategory event on Pinterest</h4>
        <?php Pinterest()->renderAddonNotice(); ?>
    </div>
</div>
<?php endif; ?>

<?php if ( Bing()->enabled() ) : ?>
<div class="row">
    <div class="col">
        <?php Bing()->render_switcher_input( 'edd_view_category_enabled' ); ?>
        <h4 class="switcher-label">Enable the ViewCategory event on Bing</h4>
        <?php Bing()->renderAddonNotice(); ?>
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