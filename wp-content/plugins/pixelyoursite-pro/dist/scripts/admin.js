jQuery(document).ready(function(c){function n(e){var t=c("#"+e.data("target"));e.val()===e.data("value")?t.removeClass("form-control-hidden"):t.addClass("form-control-hidden")}function e(){"price"===c('input[name="pys[core][woo_event_value]"]:checked').val()?c(".woo-event-value-option").hide():c(".woo-event-value-option").show()}function t(){"price"===c('input[name="pys[core][edd_event_value]"]:checked').val()?c(".edd-event-value-option").hide():c(".edd-event-value-option").show()}function a(){var e=c("#pys_event_trigger_type").val(),t="#"+e+"_panel";c(".event_triggers_panel").hide(),c(t).show(),"page_visit"===e?c("#url_filter_panel").hide():c("#url_filter_panel").show();var n=c(t),a=n.data("trigger_type");0==c(".event_trigger",n).length-1&&s(n,a)}function s(e,t){var n=c(".event_trigger",e),a=c(n[0]).clone(!0),s=c(n[n.length-1]).data("trigger_id")+1,i="pys[event]["+t+"_triggers]["+s+"]";a.data("trigger_id",s),c("select",a).attr("name",i+"[rule]"),c("input",a).attr("name",i+"[value]"),a.css("display","block"),a.insertBefore(c(".insert-marker",e))}function i(){"page_visit"===c("#pys_event_trigger_type").val()?c(".event-delay").css("visibility","visible"):c(".event-delay").css("visibility","hidden")}function o(){c("#pys_event_facebook_enabled").is(":checked")?c("#facebook_panel").show():c("#facebook_panel").hide()}function _(){"CustomEvent"===c("#pys_event_facebook_event_type").val()?c(".facebook-custom-event-type").css("visibility","visible"):c(".facebook-custom-event-type").css("visibility","hidden")}function r(){c("#pys_event_facebook_params_enabled").is(":checked")?c("#facebook_params_panel").show():c("#facebook_params_panel").hide()}function p(){var e=c("#pys_event_facebook_event_type").val();c("#facebook_params_panel").removeClass().addClass(e)}function l(){"custom"===c("#pys_event_facebook_params_currency").val()?c(".facebook-custom-currency").css("visibility","visible"):c(".facebook-custom-currency").css("visibility","hidden")}function v(){c("#pys_event_pinterest_enabled").is(":checked")?c("#pinterest_panel").show():c("#pinterest_panel").hide()}function d(){"CustomEvent"===c("#pys_event_pinterest_event_type").val()?c(".pinterest-custom-event-type").css("visibility","visible"):c(".pinterest-custom-event-type").css("visibility","hidden")}function u(){c("#pys_event_pinterest_params_enabled").is(":checked")?c("#pinterest_params_panel").show():c("#pinterest_params_panel").hide()}function m(){var e=c("#pys_event_pinterest_event_type").val();c("#pinterest_params_panel").removeClass().addClass(e)}function y(){"custom"===c("#pys_event_pinterest_params_currency").val()?c(".pinterest-custom-currency").css("visibility","visible"):c(".pinterest-custom-currency").css("visibility","hidden")}function g(){c("#pys_event_ga_enabled").is(":checked")?c("#analytics_panel").show():c("#analytics_panel").hide()}function f(){"_custom"===c("#pys_event_ga_event_action").val()?c("#ga-custom-action").css("visibility","visible"):c("#ga-custom-action").css("visibility","hidden")}function h(){c("#pys_event_google_ads_enabled").is(":checked")?c("#google_ads_panel").show():c("#google_ads_panel").hide()}function b(){"_custom"===c("#pys_event_google_ads_event_action").val()?c("#pys_event_google_ads_custom_event_action").css("visibility","visible"):c("#pys_event_google_ads_custom_event_action").css("visibility","hidden")}function k(){c("#pys_event_bing_enabled").is(":checked")?c("#bing_panel").show():c("#bing_panel").hide()}c(function(){c('[data-toggle="pys-popover"]').popover({container:"#pys",html:!0,content:function(){return c("#pys-"+c(this).data("popover_id")).html()}})}),c(".pys-select2").select2(),c(".pys-tags-select2").select2({tags:!0,tokenSeparators:[","," "]}),c("select.controls-visibility").on("change",function(e){n(c(this))}).each(function(e,t){n(c(t))}),c(".card-collapse").click(function(){var e=c(this).closest(".card").find(".card-body");e.hasClass("show")?e.hide().removeClass("show"):e.show().addClass("show")}),c(".collapse-control .custom-switch-input").change(function(){var e=c(this),t=c("."+e.data("target"));0<t.length&&(e.prop("checked")?t.show():t.hide())}).trigger("change"),e(),c('input[name="pys[core][woo_event_value]"]').change(function(){e()}),t(),c('input[name="pys[core][edd_event_value]"]').change(function(){t()}),c("#pys_select_all_events").change(function(){c(this).prop("checked")?c(".pys-select-event").prop("checked","checked"):c(".pys-select-event").prop("checked",!1)}),i(),a(),c("#pys_event_trigger_type").change(function(){i(),a()}),c(".add-event-trigger").click(function(){var e=c(this).closest(".event_triggers_panel"),t=e.data("trigger_type");s(e,t)}),c(".add-url-filter").click(function(){s(c(this).closest(".event_triggers_panel"),"url_filter")}),c(".remove-row").click(function(e){c(this).closest(".row.event_trigger, .row.facebook-custom-param, .row.pinterest-custom-param, .row.google_ads-custom-param").remove()}),o(),_(),r(),p(),l(),c("#pys_event_facebook_enabled").click(function(){o()}),c("#pys_event_facebook_event_type").change(function(){_(),p()}),c("#pys_event_facebook_params_enabled").click(function(){r()}),c("#pys_event_facebook_params_currency").change(function(){l()}),c(".add-facebook-parameter").click(function(){var e=c("#facebook_params_panel"),t=c(".facebook-custom-param",e),n=c(t[0]).clone(!0),a=c(t[t.length-1]).data("param_id")+1,s="pys[event][facebook_custom_params]["+a+"]";n.data("param_id",a),c("input.custom-param-name",n).attr("name",s+"[name]"),c("input.custom-param-value",n).attr("name",s+"[value]"),n.css("display","flex"),n.insertBefore(c(".insert-marker",e))}),v(),d(),u(),m(),y(),c("#pys_event_pinterest_enabled").click(function(){v()}),c("#pys_event_pinterest_event_type").change(function(){d(),m()}),c("#pys_event_pinterest_params_enabled").click(function(){u()}),c("#pys_event_pinterest_params_currency").change(function(){y()}),c(".add-pinterest-parameter").click(function(){var e=c("#pinterest_params_panel"),t=c(".pinterest-custom-param",e),n=c(t[0]).clone(!0),a=c(t[t.length-1]).data("param_id")+1,s="pys[event][pinterest_custom_params]["+a+"]";n.data("param_id",a),c("input.custom-param-name",n).attr("name",s+"[name]"),c("input.custom-param-value",n).attr("name",s+"[value]"),n.css("display","flex"),n.insertBefore(c(".insert-marker",e))}),g(),f(),c("#pys_event_ga_enabled").click(function(){g()}),c("#pys_event_ga_event_action").change(function(){f()}),h(),b(),c("#pys_event_google_ads_enabled").click(function(){h()}),c("#pys_event_google_ads_event_action").change(function(){b()}),c(".add-google_ads-parameter").click(function(){var e=c("#google_ads_params_panel"),t=c(".google_ads-custom-param",e),n=c(t[0]).clone(!0),a=c(t[t.length-1]).data("param_id")+1,s="pys[event][google_ads_custom_params]["+a+"]";n.data("param_id",a),c("input.custom-param-name",n).attr("name",s+"[name]"),c("input.custom-param-value",n).attr("name",s+"[value]"),n.css("display","flex"),n.insertBefore(c(".insert-marker",e))}),k(),c("#pys_event_bing_enabled").click(function(){k()})});


jQuery( document ).ready(function($) {


    checkStepActive();
    calculateStepsNums();

    $('.woo_initiate_checkout_enabled input[type="checkbox"]').change(function() {
        checkStepActive()
    });
    $('.checkout_progress input[type="checkbox"]').change(function () {
        calculateStepsNums();
    });

    function calculateStepsNums() {
        var step = 2;
        $('.checkout_progress').each(function (index,value) {
            if($(value).find("input:checked").length > 0) {
                $(value).find(".step").text("STEP "+step+": ");
                step++;
            } else {
                $(value).find(".step").text("");
            }
        });
    }

    function checkStepActive() {
        if($('.woo_initiate_checkout_enabled input[type="checkbox"]').is(':checked')) {
            $('.checkout_progress .custom-switch').removeClass("disabled");
            $('.checkout_progress input[type="checkbox"]').removeAttr("disabled");
            $('.woo_initiate_checkout_enabled .step').text("STEP 1:");
        } else {
            $('.checkout_progress input').prop('checked',false);
            $('.checkout_progress .custom-switch').addClass("disabled");
            $('.checkout_progress input[type="checkbox"]').attr("disabled","disabled");
            $('.woo_initiate_checkout_enabled .step').text("");
        }
        calculateStepsNums();
    }
    updatePurchaseFDPValue($("#pys_facebook_fdp_purchase_event_fire"));
    $("#pys_facebook_fdp_purchase_event_fire").change(function () {

        updatePurchaseFDPValue(this);
    });

    updateAddToCartFDPValue($("#pys_facebook_fdp_add_to_cart_event_fire"));
    $("#pys_facebook_fdp_add_to_cart_event_fire").change(function () {

        updateAddToCartFDPValue(this);
    });
    updatePostEventFields();
    $("#pys_event_trigger_type").change(function(){
        updatePostEventFields();
    });

});

function updatePostEventFields() {
    if($("#pys_event_trigger_type").val() == "post_type") {
        $(".event-delay").css("visibility","visible");
        $(".triger_post_type").show();
        $("#url_filter_panel").hide();
    } else {
        $(".triger_post_type").hide();
    }
}
function updateAddToCartFDPValue(input) {
    if($(input).val() == "scroll_pos") {
        $("#fdp_add_to_cart_event_fire_scroll_block").show();
        $("#pys_facebook_fdp_add_to_cart_event_fire_css").hide()
    } else  if($(input).val() == "css_click") {
        $("#fdp_add_to_cart_event_fire_scroll_block").hide();
        $("#pys_facebook_fdp_add_to_cart_event_fire_css").show()
    } else {
        $("#fdp_add_to_cart_event_fire_scroll_block").hide();
        $("#pys_facebook_fdp_add_to_cart_event_fire_css").hide()
    }
}
function updatePurchaseFDPValue(input) {
    if($(input).val() == "scroll_pos") {
        $("#fdp_purchase_event_fire_scroll_block").show();
        $("#pys_facebook_fdp_purchase_event_fire_css").hide()
    } else  if($(input).val() == "css_click") {
        $("#fdp_purchase_event_fire_scroll_block").hide();
        $("#pys_facebook_fdp_purchase_event_fire_css").show()
    } else {
        $("#fdp_purchase_event_fire_scroll_block").hide();
        $("#pys_facebook_fdp_purchase_event_fire_css").hide()
    }
}
