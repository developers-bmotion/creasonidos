<?php 

function qcld_wpbot_updater_10_4_4(){

    require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/settings-fields.php" );

    foreach( $wpbot_languages as $key ){

        if( $option = get_option( $key ) ){

            $option = maybe_unserialize( $option );

            if( is_array( $option ) && ! array_key_exists( get_wpbot_locale() , $option ) ){
                $option = serialize( array( get_wpbot_locale() => $option ) );
                update_option( $key, $option );
            }elseif( ! is_array( $option ) ){
                $option = array( get_wpbot_locale() => $option );
                update_option( $key, $option );
            }

        }

    }
    update_option( 'enable_floating_icon', '1' );

    //Livechat data update
    $data = get_option('wbca_options');
    $livechatfields = array(
        'wbca_lg_ochat',
        'wbca_lg_online',
        'wbca_lg_offline',
        'wbca_lg_we_are_here',
        'wbca_lg_chat',
        'wbca_lg_sendq',
        'wbca_lg_subject',
        'wbca_lg_msg',
        'wbca_lg_send',
        'wbca_lg_fname',
        'wbca_lg_email',
        'wbca_msg_success',
        'wbca_msg_failed',
        'wbca_lg_chat_type',
        'wbca_lg_chat_welcome',
        'wbca_lg_please_wait',
    );
    foreach( $livechatfields as $livechatfield ){
        if( ! get_option( $livechatfield ) && isset( $data[$livechatfield] ) ){

            $option = array( get_wpbot_locale() => $data[$livechatfield] );
            update_option( $livechatfield, $option );

        }
    }
    
}
qcld_wpbot_updater_10_4_4();