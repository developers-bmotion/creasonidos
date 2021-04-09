<?php 
global $wpdb;
$table    = $wpdb->prefix.'wpbot_subscription';
?>
<div class="wrap">
    <h1 class="wpbot_header_h1"><?php echo esc_html__('WPBot', 'wpchatbot'); ?> </h1>
</div>
<div class="wp-chatbot-wrap">

    <form action="<?php echo esc_attr($action); ?>" method="POST" id="wp-chatbot-admin-form"
          enctype="multipart/form-data">
        <div class="container form-container">
            <header class="wp-chatbot-admin-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><?php echo esc_html__(wpbot_text().' Control Panel', 'wpchatbot'); ?><?php echo get_option('wp_chatbot_index_meta'); ?></h2>
                    </div>
                    <div class="col-sm-6 text-right wp-chatbot-version">
                        <h3><?php echo esc_html__('The Pro Version', 'wpchatbot'); ?></h3>
                        <?php qcld_wpbot_load_additional_validation_required(); ?>
                    </div>
                </div>
            </header>
            <section class="wp-chatbot-tab-container-inner">
                <div class="wp-chatbot-tabs wp-chatbot-tabs-style-flip">
                    <nav>
                        <ul>
                            <li tab-data="general"><a href="<?php echo esc_attr($action); ?>&tab=general">
                                    <span class="wpwbot-admin-tab-icon">
                                        <i class="fa fa-toggle-on"> </i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('GENERAL SETTINGS', 'wpchatbot'); ?></span>
                                </a></li>
                            <li tab-data="themes"><a href="<?php echo esc_attr($action); ?>&tab=themes">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-gear faa-spin"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('ICONS & THEMES', 'wpchatbot'); ?></span>
                                </a></li>

                            <li tab-data="app"><a href="<?php echo esc_attr($action); ?>&tab=app" title="MOBILE APP & IFRAME INTEGRATION">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-mobile"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Embed Code', 'wpchatbot'); ?></span>
                                </a></li>

                             <li tab-data="startmenu"><a href="<?php echo esc_attr($action); ?>&tab=startmenu">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-bars"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Start Menu', 'wpchatbot'); ?></span>
                                </a></li>

                                <li tab-data="target"><a href="<?php echo esc_attr($action); ?>&tab=target">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-retweet"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Retargeting ', 'wpchatbot'); ?></span>
                                </a></li>

                                <li tab-data="hours"><a href="<?php echo esc_attr($action); ?>&tab=hours">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Bot Activity Hour', 'wpchatbot'); ?></span>
                                </a></li>

                                

                                <li tab-data="social"><a href="<?php echo esc_attr($action); ?>&tab=social">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-share"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Button Integrations', 'wpchatbot'); ?></span>
                            </a></li>

                            <li tab-data="ai"><a href="<?php echo esc_attr($action); ?>&tab=ai">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-500px"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Dialogflow', 'wpchatbot'); ?></span>
                                </a></li>

                            <li tab-data="formbuilder"><a href="<?php echo esc_attr($action); ?>&tab=formbuilder">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Conversations & Form Maker', 'wpchatbot'); ?></span>
                                </a></li>


                            <li tab-data="support"><a href="<?php echo esc_attr($action); ?>&tab=support">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-life-ring"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('FAQ Builder', 'wpchatbot'); ?></span>
                                </a></li>
                            


                            <li tab-data="notification"><a href="<?php echo esc_attr($action); ?>&tab=notification">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-bell-o"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Notification Builder', 'wpchatbot'); ?></span>
                                </a></li>
                            
                            
                               
                            <li tab-data="custom"><a href="<?php echo esc_attr($action); ?>&tab=custom">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-code"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Custom CSS', 'wpchatbot'); ?> </span>
                                </a></li>
                            <?php if(!qcld_wpbot_is_active_white_label()): ?>
                            <li tab-data="addons"><a href="<?php echo esc_attr($action); ?>&tab=addons">
                                <span class="wpwbot-admin-tab-icon">
                                <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                                </span>
                                <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Addons', 'wpchatbot'); ?> </span>
                            </a></li>
                            <?php endif; ?>
                                
                                
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-flip-1">
                            <div class="top-section">
                                <!--                                row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <?php
                                                $url = get_site_url();
                                                $url = parse_url($url);
                                                $domain = $url['host'];
                                                
                                                $admin_email = get_option('admin_email');
                                                ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Emails Will be Sent to', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_admin_email"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email); ?>">
                                                <label for="disable_wp_chatbot"><?php echo esc_html__('Support and Call Back requests will be sent to this address', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										
										<div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                
                                                <h4 class="qc-opt-title"><?php echo esc_html__('From Name', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_from_name"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_from_name') != '' ? get_option('qlcd_wp_chatbot_from_name') : 'Wordpress'); ?>">
                                                <label for="qlcd_wp_chatbot_from_name"><?php echo esc_html__('From name for email address', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										
                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <?php

                                                $url = get_site_url();  
                                                $url = parse_url($url);
                                                $domain = $url['host'];
                                                
                                                $fromEmail = "wordpress@" . $domain;

                                                ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('From Email Address', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_from_email"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_from_email') != '' ? get_option('qlcd_wp_chatbot_from_email') : $fromEmail); ?>">
                                                <label for="qlcd_wp_chatbot_from_email"><?php echo esc_html__('All email will be send from this email address. If you change the From Email Address then please make sure the domain remain same otherwise the email would not send.', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										
										

                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <?php

                                                $url = get_site_url();
                                                $url = parse_url($url);
                                                $domain = $url['host'];
                                                
                                                $fromEmail = "wordpress@" . $domain;

                                                ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Reply To', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_reply_to_email"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_reply_to_email') != '' ? get_option('qlcd_wp_chatbot_reply_to_email') : ''); ?>">
                                                <label for="qlcd_wp_chatbot_reply_to_email"><?php echo esc_html__('Please set the Reply To address. By default Reply To address will by From Email Address.', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                               

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Bot', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot" type="checkbox"
                                                   name="disable_wp_chatbot" <?php echo(get_option('disable_wp_chatbot') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot"><?php echo esc_html__('Disable Bot to Load', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Bot Floating Icon', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_floating_icon" type="checkbox"
                                                   name="disable_wp_chatbot_floating_icon" <?php echo(get_option('disable_wp_chatbot_floating_icon') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_floating_icon"><?php echo esc_html__('Disable Bot Floating Icon on All Page', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Skip Greetings and Trigger an Intent', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="skip_wp_greetings_trigger_intent" type="checkbox"
                                                   name="skip_wp_greetings_trigger_intent" <?php echo(get_option('skip_wp_greetings_trigger_intent') == 1 ? 'checked' : ''); ?>>
                                            <label for="skip_wp_greetings_trigger_intent"><?php echo esc_html__('Skip Greetings and Trigger an Intent', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row qc_wp_intent_select" <?php echo(get_option('skip_wp_greetings_trigger_intent') == 1 ? 'style="display:block"' : 'style="display:none"') ?>>
                                    
                                        
                                            <?php 
                                                qcld_wpbot()->helper->render_intent_selection( esc_html__('Select an Intent for non logged in user', 'wpchatbot'), 'wpbot_trigger_intent' );
                                            ?>

                                        
                                </div>
								
								<div class="row qc_wp_intent_select" <?php echo(get_option('skip_wp_greetings_trigger_intent') == 1 ? 'style="display:block"' : 'style="display:none"') ?>>
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_intent_selection( esc_html__('Select an Intent for Logged in User', 'wpchatbot'), 'wpbot_trigger_intent_loggged_in' );
                                    ?>
                                </div>

								
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Skip Greetings and Show Start Menu', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="skip_wp_greetings" type="checkbox"
                                                   name="skip_wp_greetings" <?php echo(get_option('skip_wp_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="skip_wp_greetings"><?php echo esc_html__('Skip Greetings and Show Start Menu', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Show Start Menu After Greetings', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="show_menu_after_greetings" type="checkbox"
                                                   name="show_menu_after_greetings" <?php echo(get_option('show_menu_after_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="show_menu_after_greetings"><?php echo esc_html__('Show Start Menu After Greetings', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable First Message', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_first_msg" type="checkbox"
                                                   name="disable_first_msg" <?php echo(get_option('disable_first_msg') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_first_msg"><?php echo esc_html__('Disable First Message', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Asking for Name Confirmation', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="ask_name_confirmation" type="checkbox"
                                                   name="ask_name_confirmation" <?php echo(get_option('ask_name_confirmation') == 1 ? 'checked' : ''); ?>>
                                            <label for="ask_name_confirmation"><?php echo esc_html__('Enable Asking for Name Confirmation', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

								<div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Asking for Email', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="ask_email_wp_greetings" type="checkbox"
                                                   name="ask_email_wp_greetings" <?php echo(get_option('ask_email_wp_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="ask_email_wp_greetings"><?php echo esc_html__('Enable Asking for Email', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Email Subscription Offer', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="qc_email_subscription_offer" type="checkbox"
                                                   name="qc_email_subscription_offer" <?php echo(get_option('qc_email_subscription_offer') == 1 ? 'checked' : ''); ?>>
                                            <label for="qc_email_subscription_offer" style="width: 500px !important;"><?php echo esc_html__('If you enable this option, WPBot will send a eMail to the subscriber. Please edit the content of this eMail from the Language Center->Email Subscription tab . By including a coupon, eBook or other offer you can get more valid subscriptions this way.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Asking for Phone Number', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="ask_phone_wp_greetings" type="checkbox"
                                                   name="ask_phone_wp_greetings" <?php echo(get_option('ask_phone_wp_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="ask_phone_wp_greetings"><?php echo esc_html__('Enable Asking for Phone', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                            </div>

                            <?php if ( is_plugin_active( 'qc-crm/qc-crm.php' ) ) { ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Create ChatBot CRM Contact from Support Email', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="wpbot_support_mail_to_crm_contact" type="checkbox"
                                                   name="wpbot_support_mail_to_crm_contact" <?php echo(get_option('wpbot_support_mail_to_crm_contact') == 1 ? 'checked' : ''); ?>>
                                            <label for="wpbot_support_mail_to_crm_contact"><?php echo esc_html__('Create ChatBot CRM Contact from Support Email', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Bot on Mobile Device', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_on_mobile" type="checkbox"
                                                   name="disable_wp_chatbot_on_mobile" <?php echo(get_option('disable_wp_chatbot_on_mobile') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_on_mobile"><?php echo esc_html__('Disable Bot to Load on Mobile Device', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Auto Focus in Message Area', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_auto_focus_message_area" type="checkbox"
                                                   name="disable_auto_focus_message_area" <?php echo(get_option('disable_auto_focus_message_area') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_auto_focus_message_area"><?php echo esc_html__('Disable Auto Focus in Message Area', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Sound on Page Load', 'wpchatbot'); ?> </h4>
                                        <div class="form-group">
                                            <input value="1" id="enable_wp_chatbot_sound_initial" type="checkbox"
                                                   name="enable_wp_chatbot_sound_initial" <?php echo(get_option('enable_wp_chatbot_sound_initial') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_sound_initial"><?php echo esc_html__('Enable to play sound on initial page load (some browsers may prevent this sound for non user interaction)', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Sound on Each Message from the Bot', 'wpchatbot'); ?> </h4>
                                        <div class="form-group">
                                            <input value="1" id="enable_wp_chatbot_sound_botmessage" type="checkbox"
                                                   name="enable_wp_chatbot_sound_botmessage" <?php echo(get_option('enable_wp_chatbot_sound_botmessage') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_sound_botmessage"><?php echo esc_html__('Enable to play sound on every message from the bot.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Auto Open Chatbot Window For First Time Page Load', 'wpchatbot'); ?> </h4>
                                        <div class="form-group">
                                            <input value="1" id="enable_wp_chatbot_open_initial" type="checkbox"
                                                   name="enable_wp_chatbot_open_initial" <?php echo(get_option('enable_wp_chatbot_open_initial') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_open_initial"><?php echo esc_html__('Enable to open chatbot window automatically for first time page load.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Keep Chatbot Window Open When Browsing', 'wpchatbot'); ?> </h4>
                                        <div class="form-group">
                                            <input value="1" id="wp_keep_chat_window_open" type="checkbox"
                                                   name="wp_keep_chat_window_open" <?php echo(get_option('wp_keep_chat_window_open') == 1 ? 'checked' : ''); ?>>
                                            <label for="wp_keep_chat_window_open"><?php echo esc_html__('Keep Chatbot Window Open When Browsing', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Bot Icon Animation', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_icon_animation" type="checkbox"
                                                   name="disable_wp_chatbot_icon_animation" <?php echo(get_option('disable_wp_chatbot_icon_animation') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_icon_animation"><?php echo esc_html__('Disable Bot icon border animation', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Avatar Animation in Bot Window', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_agent_icon_animation" type="checkbox"
                                                   name="disable_wp_agent_icon_animation" <?php echo(get_option('disable_wp_agent_icon_animation') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_agent_icon_animation"><?php echo esc_html__('Disable avatar animation in bot window', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Persistent Chat History', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_history" type="checkbox"
                                                   name="disable_wp_chatbot_history" <?php echo(get_option('disable_wp_chatbot_history') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_history"><?php echo esc_html__('Disable Persistent Chat History', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Auto Scroll to Bottom', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="always_scroll_to_bottom" type="checkbox"
                                                   name="always_scroll_to_bottom" <?php echo(get_option('always_scroll_to_bottom') == 1 ? 'checked' : ''); ?>>
                                            <label for="always_scroll_to_bottom"><?php echo esc_html__('Auto Scroll to Botton', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Disable Notification', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_notification" type="checkbox"
                                                   name="disable_wp_chatbot_notification" <?php echo(get_option('disable_wp_chatbot_notification') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_notification"><?php echo esc_html__('Disable Opening notification messages', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
								
								<div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Disable Notification for Mobile', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_notification_mobile" type="checkbox"
                                                   name="disable_wp_chatbot_notification_mobile" <?php echo(get_option('disable_wp_chatbot_notification_mobile') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_notification_mobile"><?php echo esc_html__('Disable Opening notification messages for mobile', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable RTL', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_rtl" type="checkbox"
                                                   name="enable_wp_chatbot_rtl" <?php echo(get_option('enable_wp_chatbot_rtl') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_rtl"><?php echo esc_html__('Enable RTL (Right to Left language) Support for Chat', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Open Full Screen in Mobile', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_mobile_full_screen" type="checkbox"
                                                   name="enable_wp_chatbot_mobile_full_screen" <?php echo(get_option('enable_wp_chatbot_mobile_full_screen') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_mobile_full_screen"><?php echo esc_html__('Enable Open Full Screen in Mobile', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Number Of Search Result to Show', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="<?php echo(get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5); ?>" id="wpbot_search_result_number" type="text" name="wpbot_search_result_number" />
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Search Result Click to Open in New Window', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="wpbot_search_result_new_window" type="checkbox"
                                                   name="wpbot_search_result_new_window" <?php echo(get_option('wpbot_search_result_new_window') == 1 ? 'checked' : ''); ?>>
                                            <label for="wpbot_search_result_new_window"><?php echo esc_html__('Enable to open search result in new window', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Dialogflow Card Response Link Open in Same Window', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="wpbot_card_response_same_window" type="checkbox"
                                                   name="wpbot_card_response_same_window" <?php echo(get_option('wpbot_card_response_same_window') == 1 ? 'checked' : ''); ?>>
                                            <label for="wpbot_card_response_same_window"><?php echo esc_html__('Enable to open dialogflow card response link in same window', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Search Result Image Size', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                           
                                        

                                            <select name="wpbot_search_image_size">
                                                <option value="thumbnail" <?php echo(get_option('wpbot_search_image_size') == 'thumbnail' ? 'selected="selected"' : ''); ?>>Thumbnail</option>
                                                <option value="medium" <?php echo(get_option('wpbot_search_image_size') == 'medium' ? 'selected="selected"' : ''); ?>>Medium resolution</option>
                                                <option value="large" <?php echo(get_option('wpbot_search_image_size') == 'large' ? 'selected="selected"' : ''); ?>>Large resolution</option>
                                                <option value="full" <?php echo(get_option('wpbot_search_image_size') == 'full' ? 'selected="selected"' : ''); ?>>Full resolution</option>
                                            </select>
                                            
                                            
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable GDPR Compliance', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_gdpr_compliance" type="checkbox"
                                                   name="enable_wp_chatbot_gdpr_compliance" <?php echo(get_option('enable_wp_chatbot_gdpr_compliance') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_gdpr_compliance"><?php echo esc_html__('Click to Enable GDPR Compliance', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        
                                        <?php 
                                            qcld_wpbot()->helper->render_language_field(esc_html__('GDPR Compliance Text', 'wpchatbot'), 'wpbot_gdpr_text', 'We will never spam you! You can read our <a href="#" target="_blank">Privacy Policy here.</a>', '');
                                        ?>

                                    </div>
                                </div>

                                


								
								<div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Show Start Menu after (x) Times Attempt No Result', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input id="no_result_attempt_count" type="text"
                                                   name="no_result_attempt_count" value="<?php echo(get_option('no_result_attempt_count') > 0 ? get_option('no_result_attempt_count') : 3); ?>" >
                                            <label for="no_result_attempt_count"><?php echo esc_html__('Times', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Disable Repetitive  asking for – “You may choose an option from below.”', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="wpbot_disable_repeatative" type="checkbox"
                                                   name="wpbot_disable_repeatative" <?php echo(get_option('wpbot_disable_repeatative') == 1 ? 'checked' : ''); ?>>
                                            <label for="wpbot_disable_repeatative"><?php echo esc_html__('Enable to disable repetitive asking for – “You may choose an option from below.”', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Bot Response Delay', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                           
                                        

                                            <select name="wpbot_preloading_time" id="wpbot_preloading_time">
                                                <option value="100" <?php echo(get_option('wpbot_preloading_time') == '100' ? 'selected="selected"' : ''); ?>>0 Second</option>
                                                <option value="500" <?php echo(get_option('wpbot_preloading_time') == '500' ? 'selected="selected"' : ''); ?>>0.5 Second</option>
                                                <option value="1000" <?php echo(get_option('wpbot_preloading_time') == '1000' ? 'selected="selected"' : ''); ?>>1 Second</option>
                                                <option value="2000" <?php echo(get_option('wpbot_preloading_time') == '2000' ? 'selected="selected"' : ''); ?>>2 Second</option>
                                                <option value="3000" <?php echo(get_option('wpbot_preloading_time') == '3000' ? 'selected="selected"' : ''); ?>>3 Second</option>
                                                <option value="5000" <?php echo(get_option('wpbot_preloading_time') == '5000' ? 'selected="selected"' : ''); ?>>5 Second</option>
                                                <option value="7000" <?php echo(get_option('wpbot_preloading_time') == '7000' ? 'selected="selected"' : ''); ?>>7 Second</option>
                                            </select>
                                            <label for="wpbot_preloading_time"><?php echo esc_html__('Bot Response Delay', 'wpchatbot'); ?> </label>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row " >
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Floating Icon', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">

                                            <input value="1" id="enable_floating_icon" type="checkbox"
                                                   name="enable_floating_icon" <?php echo(get_option('enable_floating_icon') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_floating_icon"><?php echo esc_html__('Enable floating icon', 'wpchatbot'); ?> </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row " >
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable Chat Bar Position in Right', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">

                                            <input value="1" id="enable_chat_bar_position_right" type="checkbox"
                                                   name="enable_chat_bar_position_right" <?php echo(get_option('enable_chat_bar_position_right') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_chat_bar_position_right"><?php echo esc_html__('Enable Chat Bar Position in Right', 'wpchatbot'); ?> </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row " >
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Disable Notifications for Chat Bar in Right', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">

                                            <input value="1" id="disable_chat_bar_right_notification" type="checkbox"
                                                   name="disable_chat_bar_right_notification" <?php echo(get_option('disable_chat_bar_right_notification') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_chat_bar_right_notification"><?php echo esc_html__('Disable Notifications for Chat Bar in Right', 'wpchatbot'); ?> </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row " >
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable Chat Bar Position in Bottom', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">

                                            <input value="1" id="enable_chat_bar_position_bottom" type="checkbox"
                                                   name="enable_chat_bar_position_bottom" <?php echo(get_option('enable_chat_bar_position_bottom') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_chat_bar_position_bottom"><?php echo esc_html__('Enable Chat Bar Position in Bottom', 'wpchatbot'); ?> </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row " >
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Disable Notifications for Chat Bar in Bottom', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">

                                            <input value="1" id="disable_chat_bar_bottom_notification" type="checkbox"
                                                   name="disable_chat_bar_bottom_notification" <?php echo(get_option('disable_chat_bar_bottom_notification') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_chat_bar_bottom_notification"><?php echo esc_html__('Disable Notifications for Chat Bar in Bottom', 'wpchatbot'); ?> </label>

                                        </div>
                                    </div>
                                </div>
								
                                <!-- row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Override Icon\'s Position', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <?php
                                            $qcld_wb_chatbot_position_x = get_option('wp_chatbot_position_x');
                                            if ((!isset($qcld_wb_chatbot_position_x)) || ($qcld_wb_chatbot_position_x == "")) {
                                                $qcld_wb_chatbot_position_x = esc_html__("120", "wp_chatbot");
                                            }
                                            $qcld_wb_chatbot_position_y = get_option('wp_chatbot_position_y');
                                            if ((!isset($qcld_wb_chatbot_position_y)) || ($qcld_wb_chatbot_position_y == "")) {
                                                $qcld_wb_chatbot_position_y = esc_html__("120", "wp_chatbot");
                                            } ?>
                                            <input type="number" class="qc-opt-dcs-font"
                                                   name="wp_chatbot_position_x"
                                                   id=""
                                                   value="<?php echo esc_html($qcld_wb_chatbot_position_x); ?>"
                                                   placeholder="<?php echo esc_html__('From Right', 'wpchatbot'); ?>"> <span class="qc-opt-dcs-font"><?php echo esc_html__('From Right', 'wpchatbot'); ?></span>
                                            <input type="number" class="qc-opt-dcs-font"
                                                   name="wp_chatbot_position_y"
                                                   id=""
                                                   value="<?php echo esc_html($qcld_wb_chatbot_position_y); ?>"
                                                   placeholder="<?php echo esc_html__('From Bottom', 'wpchatbot'); ?>"> <span class="qc-opt-dcs-font"><?php echo esc_html__('From Bottom ', 'wpchatbot'); ?></span>
                                                   <span class="qc-opt-dcs-font"><?php echo esc_html__(' In ', 'wpchatbot'); ?></span>
                                            <select name="wp_chatbot_position_in">
                                                <option value="px" <?php echo (get_option('wp_chatbot_position_in')=='px'?'selected="selected"':''); ?>>Px</option>
                                                <option value="%" <?php echo (get_option('wp_chatbot_position_in')=='%'?'selected="selected"':''); ?>>Percent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--.col-sm-12-->
                                </div>
                                <!--                                row-->
								
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable YouTube link parse', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_youtube_parse" type="checkbox"
                                                   name="disable_youtube_parse" <?php echo(get_option('disable_youtube_parse') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_youtube_parse"><?php echo esc_html__('Disable YouTube link parse', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Loading Control Options', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <div class="row">
                                                <div class="col-sm-4 text-right">
                                                    <span class="qc-opt-title-font"><?php echo esc_html__('Show on Home Page', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="radio-inline">
                                                        <input id="wp-chatbot-show-home-page" type="radio"
                                                               name="wp_chatbot_show_home_page"
                                                               value="on" <?php echo(get_option('wp_chatbot_show_home_page') == 'on' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('YES', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input id="wp-chatbot-show-home-page" type="radio"
                                                               name="wp_chatbot_show_home_page"
                                                               value="off" <?php echo(get_option('wp_chatbot_show_home_page') == 'off' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('NO', 'wpchatbot'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!--  row-->
                                            <div class="row">
                                                <div class="col-sm-4 text-right">
                                                    <span class="qc-opt-title-font"><?php echo esc_html__('Show on blog posts', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-posts" type="radio"
                                                               name="wp_chatbot_show_posts"
                                                               value="on" <?php echo(get_option('wp_chatbot_show_posts') == 'on' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('YES', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-posts" type="radio"
                                                               name="wp_chatbot_show_posts"
                                                               value="off" <?php echo(get_option('wp_chatbot_show_posts') == 'off' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('NO', 'wpchatbot'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- row-->
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                    <span class="qc-opt-title-font"><?php echo esc_html__('Show on  pages', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-pages" type="radio"
                                                               name="wp_chatbot_show_pages"
                                                               value="on" <?php echo(get_option('wp_chatbot_show_pages') == 'on' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('All Pages', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-pages" type="radio"
                                                               name="wp_chatbot_show_pages"
                                                               value="off" <?php echo(get_option('wp_chatbot_show_pages') == 'off' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('Selected Pages Only ', 'wpchatbot'); ?></label>
                                                    <div id="wp-chatbot-show-pages-list">
                                                        <ul class="checkbox-list">
                                                            <?php
                                                            $wp_chatbot_pages = get_pages();
                                                            $wp_chatbot_select_pages = maybe_unserialize(get_option('wp_chatbot_show_pages_list'));
                                                            foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                                ?>
                                                                <li>
                                                                    <input
                                                                            id="wp_chatbot_show_page_<?php echo esc_html($wp_chatbot_page->ID); ?>"
                                                                            type="checkbox"
                                                                            name="wp_chatbot_show_pages_list[]"
                                                                            value="<?php echo esc_html($wp_chatbot_page->ID); ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                                        echo 'checked';
                                                                    } ?> >
                                                                    <label
                                                                            for="wp_chatbot_show_page_<?php echo esc_html($wp_chatbot_page->ID); ?>"> <?php echo esc_html($wp_chatbot_page->post_title); ?></label>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>


                                            <!--row-->
                                            <div class="row">
                                                <div class="col-sm-4 text-right"> <span class="qc-opt-title-font">
                                                <?php _e('Exclude from Pages', 'wpchatbot'); ?>
                                                </span></div>
                                                <div class="col-sm-8">
                                                <div id="wp-chatbot-exclude-pages-list">
                                                    <ul class="checkbox-list">
                                                    <?php
                                                        $wp_chatbot_pages = get_pages();
                                                        $wp_chatbot_select_pages = maybe_unserialize(get_option('wp_chatbot_exclude_pages_list'));
                                                        foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                            ?>
                                                    <li>
                                                        <input
                                                                    id="wp_chatbot_exclude_page_<?php echo $wp_chatbot_page->ID; ?>"
                                                                    type="checkbox"
                                                                    name="wp_chatbot_exclude_pages_list[]"
                                                                    value="<?php echo $wp_chatbot_page->ID; ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                                echo 'checked';
                                                            } ?> >
                                                        <label
                                                            for="wp_chatbot_exclude_page_<?php echo $wp_chatbot_page->ID; ?>"> <?php echo $wp_chatbot_page->post_title; ?></label>
                                                    </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- row--> 
                                            
                                            <!--row-->
                                            <div class="row">
                                                <div class="col-sm-4 text-right"> <span class="qc-opt-title-font">
                                                <?php _e('Exclude from Custom Post', 'wpchatbot'); ?>
                                                </span></div>
                                                <div class="col-sm-8">
                                                <div id="wp-chatbot-exclude-post-list">
                                                    <ul class="checkbox-list">
                                                    <?php
                                                            $get_cpt_args = array(
                                                                'public'   => true,
                                                                '_builtin' => false
                                                            );
                                                            
                                                            $post_types = get_post_types( $get_cpt_args, 'object' );
                                                            $wp_chatbot_exclude_post_list = maybe_unserialize(get_option('wp_chatbot_exclude_post_list'));
                                                            foreach ($post_types as $post_type) {
                                                                ?>
                                                    <li>
                                                        <input
                                                                    id="wp_chatbot_exclude_post_<?php echo $post_type->name; ?>"
                                                                    type="checkbox"
                                                                    name="wp_chatbot_exclude_post_list[]"
                                                                    value="<?php echo $post_type->name; ?>" <?php if (!empty($wp_chatbot_exclude_post_list) && in_array($post_type->name, $wp_chatbot_exclude_post_list) == true) {
                                                                echo 'checked';
                                                            } ?> >
                                                        <label
                                                            for="wp_chatbot_exclude_post_<?php echo $post_type->name; ?>"> <?php echo $post_type->name; ?></label>
                                                    </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- row--> 
											<!--row-->
                                            <div class="row">
                                                <div class="col-sm-4 text-right"> <span class="qc-opt-title-font">
                                                <?php _e('Display the ChatBot only for logged in users', 'wpchatbot'); ?>
                                                </span></div>
                                                <div class="col-sm-8">
                                                <div id="wp-chatbot-exclude-post-list">
                                                    <ul class="checkbox-list">

                                                    <li>
                                                        <input
                                                                    id="qc_display_for_loggedin_users"
                                                                    type="checkbox"
                                                                    name="qc_display_for_loggedin_users" <?php echo get_option('qc_display_for_loggedin_users')==1?'checked="checked"':''; ?>
                                                                    value="1" >
                                                        <label
                                                            for="qc_display_for_loggedin_users"> Enable this option to display the ChatBot only for logged in users</label>
                                                    </li>

                                                    </ul>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- row--> 

                                           
                                        </div>
                                        <!-- cxsc-settings-blocks-->
                                    </div>
                                    <!-- col-xs-12-->
                                </div>
                                <!--  row-->


								
                            </div>
                            <!-- top-section-->

                            


                        </section>
                        <section id="section-flip-2">


                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#wp-chatbot-icon-theme-settings"><?php echo esc_html__('Icons & Themes', 'wpchatbot'); ?></a></li>

								
                                <li><a data-toggle="tab" href="#wp-chatbot-custom-color-options"><?php echo esc_html__('Custom Color Options', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-bottom-icons-setting"><?php echo esc_html__('Bottom Icon Settings', 'wpchatbot'); ?></a></li>

                                
                            </ul>
                            <div class="tab-content">
                                
                                <div id="wp-chatbot-icon-theme-settings" class="tab-pane fade in active">

                                    <div class="top-section">
                                        <div class="row">
                                        <div class="col-xs-12">
                                                <?php qc_wpbot_theme_validation_fnc(); ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Bot on a Page', 'wpchatbot'); ?></h4>
                                                
                                                <div class="cxsc-settings-blocks">
                                                    <p class="qc-opt-title-font"><?php echo esc_html__('Paste the shortcode', 'wpchatbot'); ?>
                                                        <input disabled id="shirtcode-selector" type="text" value="[wpbot-page]"> <?php echo esc_html__('on any page to display Bot on that page.', 'wpchatbot'); ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Icons', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <ul class="radio-list">
                                                        <li><label for="wp_chatbot_icon_0" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-0.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_0" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-0.png' ? 'checked' : ''); ?>
                                                                                value="icon-0.png">
                                                            <?php echo esc_html__('Icon - 0', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_1" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-1.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_1" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-1.png' ? 'checked' : ''); ?>
                                                                                value="icon-1.png">
                                                            <?php echo esc_html__('Icon - 1', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_2" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-2.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_2" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-2.png' ? 'checked' : ''); ?>
                                                                                value="icon-2.png">
                                                            <?php echo esc_html__('Icon - 2', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_3" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-3.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_3" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-3.png' ? 'checked' : ''); ?>
                                                                                value="icon-3.png">
                                                            <?php echo esc_html__('Icon - 3', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_4" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-4.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_4" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-4.png' ? 'checked' : ''); ?>
                                                                                value="icon-4.png">
                                                            <?php echo esc_html__('Icon - 4', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_5" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-5.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_5" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-5.png' ? 'checked' : ''); ?>
                                                                                value="icon-5.png">
                                                            <?php echo esc_html__('Icon - 5', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_6" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-6.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_6" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-6.png' ? 'checked' : ''); ?>
                                                                                value="icon-6.png">
                                                            <?php echo esc_html__('Icon - 6', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_7" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-7.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_7" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-7.png' ? 'checked' : ''); ?>
                                                                                value="icon-7.png">
                                                            <?php echo esc_html__('Icon - 7', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_8" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-8.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_8" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-8.png' ? 'checked' : ''); ?>
                                                                                value="icon-8.png">
                                                            <?php echo esc_html__('Icon - 8', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_9" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-9.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_9" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-9.png' ? 'checked' : ''); ?>
                                                                                value="icon-9.png">
                                                            <?php echo esc_html__('Icon - 9', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_10" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-10.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_10" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-10.png' ? 'checked' : ''); ?>
                                                                                value="icon-10.png">
                                                            <?php echo esc_html__('Icon - 10', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_11" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-11.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_11" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-11.png' ? 'checked' : ''); ?>
                                                                                value="icon-11.png">
                                                            <?php echo esc_html__('Icon - 11', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_12" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-12.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_12" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-12.png' ? 'checked' : ''); ?>
                                                                                value="icon-12.png">
                                                            <?php echo esc_html__('Icon - 12', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                        <li>
                                                            <?php
                                                            if (get_option('wp_chatbot_custom_icon_path') != "") {
                                                                $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
                                                            } else {
                                                                $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
                                                            }
                                                            ?>
                                                            <label for="wp_chatbot_custom_icon_input" class="qc-opt-dcs-font">
                                                            <img id="wp_chatbot_custom_icon_src"
                                                                src="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>" alt="">
                                                            <input id="wp_chatbot_custom_icon_input" type="radio"
                                                                name="wp_chatbot_icon"
                                                                value="custom.png" <?php echo(get_option('wp_chatbot_icon') == 'custom.png' ? 'checked' : ''); ?>>
                                                            <?php echo esc_html__('Custom Icon', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <!--  cxsc-settings-blocks-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload custom Icon ', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_chatbot_custom_icon_path"
                                                        id="wp_chatbot_custom_icon_path"
                                                        value="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>"/>
                                                    <button type="button" class="wp_chatbot_custom_icon_button button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Agent Image', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <ul class="radio-list">
                                                        <li>
                                                            <label for="wp_chatbot_agent_image_def" class="qc-opt-dcs-font">
                                                            <img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'icon-0.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_agent_image_def" type="radio"
                                                                                name="wp_chatbot_agent_image" <?php echo(get_option('wp_chatbot_agent_image') == 'agent-0.png' ? 'checked' : ''); ?>
                                                                                value="agent-0.png">
                                                                            
                                                            <?php echo esc_html__('Default Agent', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                        <li>
                                                            <?php
                                                            if (get_option('wp_chatbot_custom_agent_path') != "") {
                                                                $wp_chatbot_custom_agent_path = get_option('wp_chatbot_custom_agent_path');
                                                            } else {
                                                                $wp_chatbot_custom_agent_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
                                                            }
                                                            ?>
                                                            <label for="wp_chatbot_agent_image_custom" class="qc-opt-dcs-font">
                                                                <img id="wp_chatbot_custom_agent_src"
                                                                src="<?php echo esc_url($wp_chatbot_custom_agent_path); ?>"
                                                                alt="Agent">
                                                            <input type="radio" name="wp_chatbot_agent_image"
                                                                id="wp_chatbot_agent_image_custom"
                                                                value="custom-agent.png" <?php echo(get_option('wp_chatbot_agent_image') == 'custom-agent.png' ? 'checked' : ''); ?>>
                                                            <?php echo esc_html__('Custom Agent', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <!--                                        cxsc-settings-blocks-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"> <?php echo esc_html__('Custom Agent Icon', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_chatbot_custom_agent_path"
                                                        id="wp_chatbot_custom_agent_path"
                                                        value="<?php echo esc_url($wp_chatbot_custom_agent_path); ?>"/>
                                                    <button type="button" class="wp_chatbot_custom_agent_button button"><?php echo esc_html__('Upload Agent Icon', 'wpchatbot'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Client Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 60x60</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_client_icon"
                                                        id="wp_custom_client_icon"
                                                        value="<?php echo (get_option('wp_custom_client_icon') != '' ? get_option('wp_custom_client_icon') : ''); ?>" />
                                                    <div id="wp_custom_client_icon_src">
                                                        <?php if(get_option('wp_custom_client_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_client_icon'); ?>" alt="" width="60" height="60" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_client_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_client_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_client_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Help Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 24x24</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_help_icon"
                                                        id="wp_custom_help_icon"
                                                        value="<?php echo (get_option('wp_custom_help_icon') != '' ? get_option('wp_custom_help_icon') : ''); ?>" />
                                                    <div id="wp_custom_help_icon_src">
                                                        <?php if(get_option('wp_custom_help_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_help_icon'); ?>" alt="" width="24" height="24" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_help_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_help_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_help_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Support Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 24x24</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_support_icon"
                                                        id="wp_custom_support_icon"
                                                        value="<?php echo (get_option('wp_custom_support_icon') != '' ? get_option('wp_custom_support_icon') : ''); ?>" />
                                                    <div id="wp_custom_support_icon_src">
                                                        <?php if(get_option('wp_custom_support_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_support_icon'); ?>" alt="" width="24" height="24" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_support_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_support_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_support_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Chat Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 35x35</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_chat_icon"
                                                        id="wp_custom_chat_icon"
                                                        value="<?php echo (get_option('wp_custom_chat_icon') != '' ? get_option('wp_custom_chat_icon') : ''); ?>" />
                                                    <div id="wp_custom_chat_icon_src">
                                                        <?php if(get_option('wp_custom_chat_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_chat_icon'); ?>" alt="" width="35" height="35" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_chat_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_chat_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_chat_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Bot Typing Animation Icon', 'wpchatbot'); ?></h4>
                                                
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_typing_icon"
                                                        id="wp_custom_typing_icon"
                                                        value="<?php echo (get_option('wp_custom_typing_icon') != '' ? get_option('wp_custom_typing_icon') : ''); ?>" />
                                                    <div id="wp_custom_typing_icon_src">
                                                        <?php if(get_option('wp_custom_typing_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_typing_icon'); ?>" alt=""  />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_typing_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_typing_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_typing_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div id="top-section">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="qc-opt-title"> <?php echo esc_html__('Themes', 'wpchatbot'); ?></h4>
                                            </div>
                                        </div>
                                        
                                        
                                        <?php if(qcld_wpbot_is_extended_ui_activate()): ?>
                                        <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="qcld_wb_chatbot_theme_6" >
                                                    <img class="thumbnail theme_prev"
                                                        src="<?php echo esc_url(qcld_chatbot_eui_root_url.'images/templates/template-6.png'); ?>"
                                                        alt="Theme Six">
                                                    <input id="qcld_wb_chatbot_theme_6" type="radio" name="qcld_wb_chatbot_theme"
                                                        value="template-06" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-06' ? 'checked' : ''); ?>>
                                                    <?php echo esc_html__('Theme Six', 'wpchatbot'); ?></label>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="qcld_wb_chatbot_theme_7" >
                                                    <img class="thumbnail theme_prev"
                                                        src="<?php echo esc_url(qcld_chatbot_eui_root_url.'images/templates/template-7.jpg'); ?>"
                                                        alt="Theme Seven">
                                                    <input id="qcld_wb_chatbot_theme_7" type="radio" name="qcld_wb_chatbot_theme"
                                                        value="template-07" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-07' ? 'checked' : ''); ?>>
                                                    <?php echo esc_html__('Theme Seven', 'wpchatbot'); ?></label>
                                                </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <br>
                                            <?php endif; ?>                                            
                                        

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_0">
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-00.JPG'); ?>"
                                                    alt="Theme Basic">
                                                <input id="qcld_wb_chatbot_theme_0" type="radio"
                                                    name="qcld_wb_chatbot_theme" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-00' ? 'checked' : ''); ?>
                                                    value="template-00">
                                                <?php echo esc_html__('Theme Basic', 'wpchatbot'); ?></label>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_1" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-01.JPG'); ?>"
                                                    alt="Theme one"> <input id="qcld_wb_chatbot_theme_1" type="radio"
                                                                            name="qcld_wb_chatbot_theme" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-01' ? 'checked' : ''); ?>
                                                                            value="template-01">
                                                <?php echo esc_html__('Theme One', 'wpchatbot'); ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_2" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-02.JPG'); ?>"
                                                    alt="Theme Two">
                                                <input id="qcld_wb_chatbot_theme_2" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-02" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-02' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Theme Two', 'wpchatbot'); ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_3" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-03.JPG'); ?>"
                                                    alt="Theme Three">
                                                <input id="qcld_wb_chatbot_theme_3" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-03" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-03' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Theme Three', 'wpchatbot'); ?></label>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="row">
                                        
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_4" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-04.jpg'); ?>"
                                                    alt="Theme Four">
                                                <input id="qcld_wb_chatbot_theme_4" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-04" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-04' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Theme Four', 'wpchatbot'); ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_5" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-05.jpg'); ?>"
                                                    alt="Theme Five">
                                                <input id="qcld_wb_chatbot_theme_5" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-05" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-05' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Mini Mode', 'wpchatbot'); ?></label>
                                            </div>

                                            
                                            

                                            
                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="top-section">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="qc-opt-title"> <?php echo esc_html__('Custom Backgroud', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="qcld_wb_chatbot_change_bg" type="checkbox"
                                                        name="qcld_wb_chatbot_change_bg" <?php echo(get_option('qcld_wb_chatbot_change_bg') == 1 ? 'checked' : ''); ?>>
                                                    <label for="qcld_wb_chatbot_change_bg"><?php echo esc_html__('Change the Bot message board background for Theme 2 and Theme 3.', 'wpchatbot'); ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row qcld-wp-chatbot-board-bg-container" <?php if (get_option('qcld_wb_chatbot_change_bg') != 1) {
                                            echo 'style="display:none"';
                                        } ?>>
                                            <div class="col-xs-6">
                                                <p class="wp-chatbot-settings-instruction"> <?php echo esc_html__('Upload Bot message board background (Ideal image size 376px X 688px).', 'wpchatbot'); ?> </p>
                                                <div class="cxsc-settings-blocks">
                                                    <?php
                                                    if (get_option('qcld_wb_chatbot_board_bg_path') != "") {
                                                        $qcld_wb_chatbot_board_bg_path = get_option('qcld_wb_chatbot_board_bg_path');
                                                    } else {
                                                        $qcld_wb_chatbot_board_bg_path = QCLD_wpCHATBOT_IMG_URL . 'background/background.png';
                                                    }
                                                    ?>
                                                    <input type="hidden" name="qcld_wb_chatbot_board_bg_path"
                                                        id="qcld_wb_chatbot_board_bg_path"
                                                        value="<?php echo esc_html($qcld_wb_chatbot_board_bg_path); ?>"/>
                                                    <button type="button" class="qcld_wb_chatbot_board_bg_button button"><?php echo esc_html__('Upload background.', 'wpchatbot'); ?></button>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-6">
                                                <p class="wp-chatbot-settings-instruction"> <?php echo esc_html__('Custom message board background', 'wpchatbot'); ?> </p>
                                                <img id="qcld_wb_chatbot_board_bg_image"
                                                    src="<?php echo esc_url($qcld_wb_chatbot_board_bg_path); ?>"
                                                    alt="Custom Background">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- Custom Color OPtions-->
                                <div id="wp-chatbot-custom-color-options" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">

                                            <div class="col-xs-12">

                                            <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Bot Floating Icon Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_floatingiconbg_color" type="text"
                                                                                    name="wp_chatbot_floatingiconbg_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_floatingiconbg_color') != '' ? get_option('wp_chatbot_floatingiconbg_color') : '#fff'); ?>"/>
                                                </div>
                                            </div>

                                                <h3 class="qc-opt-title">
                                                <?php _e('Custom Color Options', 'woochatbot'); ?>
                                                </h3>
                                                <div class="cxsc-settings-blocks">
                                                <input value="1" id="enable_wp_chatbot_custom_color" type="checkbox"
                                                                                name="enable_wp_chatbot_custom_color" <?php echo(get_option('enable_wp_chatbot_custom_color') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_wp_chatbot_custom_color">
                                                    <?php _e('Enable Custom Colors ', 'woochatbot'); ?>
                                                </label>
                                                </div>
                                                <br>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_text_color" type="text"
                                                                                    name="wp_chatbot_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_text_color') != '' ? get_option('wp_chatbot_text_color') : '#37424c'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Link Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_link_color" type="text"
                                                                                    name="wp_chatbot_link_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_link_color') != '' ? get_option('wp_chatbot_link_color') : '#e2cc1f'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Link Hover Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_link_hover_color" type="text"
                                                                                    name="wp_chatbot_link_hover_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_link_hover_color') != '' ? get_option('wp_chatbot_link_hover_color') : '#734006'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Bot Message  Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_bot_msg_bg_color" type="text"
                                                                                    name="wp_chatbot_bot_msg_bg_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_bot_msg_bg_color') != '' ? get_option('wp_chatbot_bot_msg_bg_color') : '#1f8ceb'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Bot Message Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_bot_msg_text_color" type="text"
                                                                                    name="wp_chatbot_bot_msg_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_bot_msg_text_color') != '' ? get_option('wp_chatbot_bot_msg_text_color') : '#ffffff'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('User Message  Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_user_msg_bg_color" type="text"
                                                                                    name="wp_chatbot_user_msg_bg_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_user_msg_bg_color') != '' ? get_option('wp_chatbot_user_msg_bg_color') : '#ffffff'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('User Message Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_user_msg_text_color" type="text"
                                                                                    name="wp_chatbot_user_msg_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_user_msg_text_color') != '' ? get_option('wp_chatbot_user_msg_text_color') : '#000000'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Buttons Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_buttons_bg_color" type="text"
                                                                                    name="wp_chatbot_buttons_bg_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_buttons_bg_color') != '' ? get_option('wp_chatbot_buttons_bg_color') : '#1f8ceb'); ?>"/>
                                                </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Buttons Hover Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_buttons_bg_color" type="text"
                                                                                    name="wp_chatbot_buttons_bg_color_hover"
                                                                                    value="<?php echo(get_option('wp_chatbot_buttons_bg_color_hover') != '' ? get_option('wp_chatbot_buttons_bg_color_hover') : '#1f8ceb'); ?>"/>
                                                </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Buttons Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_buttons_text_color" type="text"
                                                                                    name="wp_chatbot_buttons_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_buttons_text_color') != '' ? get_option('wp_chatbot_buttons_text_color') : '#ffffff'); ?>"/>
                                                </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <h4 class="qc-opt-title">
                                                        <?php _e('Buttons Text Color Hover.', 'woochatbot'); ?>
                                                        </h4>
                                                        <input id="wp_chatbot_buttons_text_color" type="text"
                                                                                        name="wp_chatbot_buttons_text_color_hover"
                                                                                        value="<?php echo(get_option('wp_chatbot_buttons_text_color_hover') != '' ? get_option('wp_chatbot_buttons_text_color_hover') : '#ffffff'); ?>"/>
                                                    </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <h4 class="qc-opt-title">
                                                        <?php _e('Theme Primary Color', 'woochatbot'); ?>
                                                        </h4>
                                                        <input id="wp_chatbot_theme_primary_color" type="text"
                                                                                        name="wp_chatbot_theme_primary_color"
                                                                                        value="<?php echo(get_option('wp_chatbot_theme_primary_color') != '' ? get_option('wp_chatbot_theme_primary_color') : '#ffffff'); ?>"/>
                                                    </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <h4 class="qc-opt-title">
                                                        <?php _e('Theme Secondary Color', 'woochatbot'); ?>
                                                        </h4>
                                                        <input id="wp_chatbot_theme_secondary_color" type="text"
                                                                                        name="wp_chatbot_theme_secondary_color"
                                                                                        value="<?php echo(get_option('wp_chatbot_theme_secondary_color') != '' ? get_option('wp_chatbot_theme_secondary_color') : '#ffffff'); ?>"/>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="wp-chatbot-bottom-icons-setting" class="tab-pane fade">
                                    <div class="top-section">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h3 class="qc-opt-title">
                                            <?php _e('Bottom Icon Settings', 'woochatbot'); ?>
                                            </h3>
                                            
                                            <div class="row" >
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable All Icons', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_allicon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_allicon" <?php echo(get_option('enable_wp_chatbot_disable_allicon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_allicon">
                                                        <?php _e('Enable to hide all icons from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>
                                            <div class="row" >
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable Help Icon', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_helpicon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_helpicon" <?php echo(get_option('enable_wp_chatbot_disable_helpicon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_helpicon">
                                                        <?php _e('Enable to hide help icon from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                                <div class="row" >
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable Support Icon', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_supporticon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_supporticon" <?php echo(get_option('enable_wp_chatbot_disable_supporticon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_supporticon">
                                                        <?php _e('Enable to hide support icon from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="row">
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable Chat Icon', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_chaticon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_chaticon" <?php echo(get_option('enable_wp_chatbot_disable_chaticon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_chaticon">
                                                        <?php _e('Enable to hide chat icon from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>

                                                

                                        </div>
                                    </div>
                                    </div>

                                </div>

                            </div>



                        </section>

                        <section id="section-flip-12">
                            <div class="wp-chatbot-language-center-summmery">
                                <p><?php echo esc_html__('Embed the Bot on any website copying the code below', 'wpchatbot'); ?> </p>
                            </div>
                            <div class="top-section">
                                <div class="row">

									<div class="col-xs-12 wpbot_embed_code_section" >
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Embed Code', 'wpchatbot'); ?> </h4>
                                        
												
                                                <p>Copy the below code & add to any page before closing the body tag. <b>Please note that some features like retargeting will not work on embedded pages and it will always use the "Template One" template.</b> SIte search will be performed on the website the WPBot is installed on. Not the site the embed code is on.</p>
												
												<?php 
												$css_url = QCLD_wpCHATBOT_PLUGIN_URL . 'css/common-style.css';
                                                $page = get_page_by_title('wpwBot Mobile App');
                                                
												$wp_chatbot_custom_icon_path = '';
												if (get_option('wp_chatbot_icon') == "custom.png") {
													$wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
												} else if (get_option('wp_chatbot_icon') != "custom.png") {
													$wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_icon');
												} else {
													$wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
												}
												
												?>
												
												<textarea class="wpbot_embed_textarea"><?php echo htmlentities('<script type="text/javascript">var wpIframeUrl = "'.esc_html(home_url().'/'.$page->post_name).'"</script><script type="text/javascript" src="'.esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'js/qcld-wp-chatbot-api.js').'"></script>');  ?></textarea>
											
                                                
                                    </div>

                                    <div class="col-xs-12">
                                        <hr>
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Widget', 'wpchatbot'); ?></h4>
                                        <hr>
                                        
                                        <div class="col-xs-8">

                                            <div class="cxsc-settings-blocks">
                                                <p><b>Use Shortcode: [chatbot-widget]</b></p>
                                                    <p>If you want to add the Bot as like widget then please add the above shortcode anywhere in the page. It will display like widget. <br><b>Please Note -</b> The WPBot bot icon would not load on that page you have added the above shortcode.</p>
                                                <p>Available Parameter: width, intent</p>
                                                <p><b>width</b>: This parameter allow you to specify the widget width. Default value: 400px. You can also use percentage instead of pixel<br>
                                                Ex: [chatbot-widget width="400px"]
                                                </p>
                                                <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents.
                                                <br>
                                                Available Values:
                                                <br>
                                                
                                                Predefined Intents: <b>Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback</b><br>
                                                
                                                <?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                    ?>
                                                    Woocommerce Intents: <b>Product Search, Catalog, Featured Products, Products on Sale, Order Status</b><br>
                                                    <?php
                                                    }
                                                ?>


                                                Custom Intents: Any custom intent you create using the Conversational Forms or DialogFlow. Add the custom intent name exactly as you created. For conversational forms, use the exact form name. For Dialogflow use the exact intent name.
                                                <br>
                                                Your available custom intents are:  <b><?php echo qc_dynamic_intent(); ?></b>
                                                
                                                <br>Ex: [chatbot-widget intent="Request Callback"]
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-xs-4">
                                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/widget.jpg'); ?>" alt="">
                                        
                                        </div>

                                    </div>                                    
                                   
                                    <div class="col-xs-12">
                                        <hr>
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Shortcode for Click to Chat Button', 'wpchatbot'); ?>  </h4>
                                        <hr>
                                        <div class="cxsc-settings-blocks">
                                            <p><b>Use Shortcode: [wpbot-click-chat text="Click to Chat"]</b></p>
                                            <p><b>Available Parameters: text, bot_visibility, intent, display_as, bgcolor, textcolor</b></p>
                                            <p><b>text</b>: This is for the button text. Value for this option would be a text that will be automatically linked to open the ChatBot.<br>Ex: [wpbot-click-chat text="Click to Chat"]</p>
                                            <p><b>bot_visibility</b>: This is show or hide bot floating icon. Available values: show, hide. Default value is "show".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide"]</p>



                                            <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents.
                                            <br>
                                            Available Values:
                                            <br>
                                            
                                            Predefined Intents: <b>Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback</b><br>
                                            <?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                    ?>
                                                    Woocommerce Intents: <b>Product Search, Catalog, Featured Products, Products on Sale, Order Status</b><br>
                                                    <?php
                                                    }
                                                ?>
                                            Custom Intents: Any custom intent you create using the Conversational Forms or DialogFlow. Add the custom intent name exactly as you created. For conversational forms, use the exact form name. For Dialogflow use the exact intent name.
                                            <br>
                                            Your available custom intents are:  <b><?php echo qc_dynamic_intent(); ?></b>
                                            
                                            <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription"]
                                            </p>

                                            <p><b>display_as</b>: This parameter can control the appearence. Available values: button, link. Default value is "link".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" display_as="button"]</p>
                                            <p><b>bgcolor</b>: You can set the background color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9"]</p>
                                            <p><b>textcolor</b>: You can set the text color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9" textcolor="#fff"]</p>
                                        </div>
                                    </div>


                                    <div class="col-xs-12">
                                        <hr>
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Show Bot on a Page', 'wpchatbot'); ?></h4>
                                        <hr>
                                        <div class="cxsc-settings-blocks">
                                            <p class="qc-opt-title-font"><?php echo esc_html__('Paste the shortcode', 'wpchatbot'); ?>
                                                <b>[wpbot-page]</b> <?php echo esc_html__('on any page to display Bot on that page.', 'wpchatbot'); ?> </p>
                                            <p><b>Available Parameter: intent</b></p>

                                            <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents.
                                            <br>
                                            Available Values:
                                            <br>
                                            
                                            Predefined Intents: <b>Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback</b><br>
                                            <?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                    ?>
                                                    Woocommerce Intents: <b>Product Search, Catalog, Featured Products, Products on Sale, Order Status</b><br>
                                                    <?php
                                                    }
                                                ?>
                                            Custom Intents: Any custom intent you create using the Conversational Forms or DialogFlow. Add the custom intent name exactly as you created. For conversational forms, use the exact form name. For Dialogflow use the exact intent name.
                                            <br>
                                            Your available custom intents are:  <b><?php echo qc_dynamic_intent(); ?></b>
                                            
                                            <br>Ex: [wpbot-page intent="Send Us Email"]
                                            </p>

                                            
                                        </div>
                                    </div>


                                </div>
                            </div>
                            
                        </section>

                        <section id="section-flip-6">
                        <?php 
                        wp_enqueue_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . '/css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                        ?>
                            <div class="top-section">
                                <div class="custom_class_startmenu">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            
                                        <div class="row">
                                    <div class="col-xs-12">
										<h2>Predefined Intents</h2>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Site Search', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_site_search" type="checkbox"
														   name="disable_wp_chatbot_site_search" <?php echo(get_option('disable_wp_chatbot_site_search') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_site_search"><?php echo esc_html__('Disable Site Search feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>
										<div class="form-group">
                                                
                                                <?php 
                                                    qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_site_search', 'Site Search', '');
                                                ?>
                                            </div>
											<hr>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Call Me', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_call_gen" type="checkbox"
														   name="disable_wp_chatbot_call_gen" <?php echo(get_option('disable_wp_chatbot_call_gen') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_call_gen"><?php echo esc_html__('Disable Call Me feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
											
										</div>

                                        <div class="form-group">
                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_chatbot_support_phone', 'Leave your number. We will call you back!', '');
                                            ?>
                                        </div>
											<hr>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Send Email', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_feedback" type="checkbox"
														   name="disable_wp_chatbot_feedback" <?php echo(get_option('disable_wp_chatbot_feedback') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_feedback"><?php echo esc_html__('Disable Send Email feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>

                                        <div class="form-group">
                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_send_us_email', 'Send Us Email', '');
                                            ?>
                                        </div>
											<hr>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Leave a Feedback', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_leave_feedback" type="checkbox"
														   name="disable_wp_leave_feedback" <?php echo(get_option('disable_wp_leave_feedback') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_leave_feedback"><?php echo esc_html__('Disable Leave a Feedback feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>

                                        <div class="form-group">

                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_leave_feedback', 'Leave a Feedback', '');
                                            ?>
                                        </div>
										<hr>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('FAQ', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_faq" type="checkbox"
														   name="disable_wp_chatbot_faq" <?php echo(get_option('disable_wp_chatbot_faq') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_faq"><?php echo esc_html__('Disable FAQ feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>

                                        <div class="form-group">
                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_chatbot_wildcard_support', 'FAQ', '');
                                            ?>
                                        </div>
										<hr>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Email Subscription', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_email_subscription" type="checkbox"
														   name="disable_email_subscription" <?php echo(get_option('disable_email_subscription') == 1 ? 'checked' : ''); ?>>
													<label for="disable_email_subscription"><?php echo esc_html__('Disable Email Subscription feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>

                                        <div class="form-group">
                                            
                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_email_subscription', 'Email Subscription', '');
                                            ?>
                                        </div>
										<hr>
										<?php if(class_exists('Qcld_str_pro')): ?>
										
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('STR Categories', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_str_categories" type="checkbox"
														   name="disable_str_categories" <?php echo(get_option('disable_str_categories') == 1 ? 'checked' : ''); ?>>
													<label for="disable_str_categories"><?php echo esc_html__('Disable STR Category feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>
										
										<div class="form-group">
                                            
                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_str_category', 'STR Categories', '');
                                            ?>
                                        </div>
										<hr>
										<?php endif; ?>

                                        <?php if( is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) ): ?>
										
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Voice Message', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_voice_message" type="checkbox"
														   name="disable_voice_message" <?php echo(get_option('disable_voice_message') == 1 ? 'checked' : ''); ?>>
													<label for="disable_voice_message"><?php echo esc_html__('Disable voice message feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>
										
										<div class="form-group">
                                            
                                            
                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_wp_voice_message', 'Voice Message', '');
                                            ?>
                                        </div>
										<hr>
										<?php endif; ?>
										
										<?php if(class_exists('Qcld_kbx_support')): ?>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Open a Ticket', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_open_ticket" type="checkbox"
														   name="disable_open_ticket" <?php echo(get_option('disable_open_ticket') == 1 ? 'checked' : ''); ?>>
													<label for="disable_open_ticket"><?php echo esc_html__('Disable Open a Ticket feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>
										
                                        <div class="form-group">
                                            
                                            <?php 
                                                qcld_wpbot()->helper->render_language_field(esc_html__('Button Label', 'wpchatbot'), 'qlcd_open_ticket_label', 'Open a Ticket', '');
                                            ?>
                                        </div>
										<hr>
										<?php endif; ?>
									</div>
									
								</div>

                                    <div class="col-xs-12" style="padding-left: 0px;">
                                        <div class="wpb_custom_intent">
                                            <h2>Add Custom Menu Button with Link</h2>
                                            <div class="form-group">
                                                <?php
                                                $agent_join_options = maybe_unserialize(get_option('qlcd_wp_custon_menu'));
                                                $agent_join_option = 'qlcd_wp_custon_menu';
                                                $agent_join_text = esc_html__('', 'wpchatbot');
                                                qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option_menu($agent_join_options, $agent_join_option, $agent_join_text);
                                                ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                        <?php 
                                        if( function_exists( 'qcld_wpbotml' ) ){
                                            do_action( 'ml_render_start_menu' );
                                        } else {
                                        ?>
                                        <div class="qcld_wpbot_startmenu_area">
                                            <?php 
                                                $menu_order = maybe_unserialize(get_option('qc_wpbot_menu_order'));
                                                if( $menu_order && isset( $menu_order[get_wpbot_locale()] )){
                                                    $menu_order = $menu_order[get_wpbot_locale()];
                                                }
                                                $menu_order = maybe_unserialize($menu_order);
                                                
                                                if( strpos($menu_order, 'span') === false ){
                                                    $menu_orde = '';
                                                }

                                            ?>
                                            <h2>Menu Sorting & Customization Area</h2>
                                            <p style="color:red">*After making changes in the settings, please clear browser cache and cookies before reloading the page or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
                                            <p>In this section you can control the UI of the menu.<br>
To adjust the Active Menu ordering just drag it up or down. To add a menu item in Active Menu simply drag a menu item from Available Menu and drop it to Active Menu . To remove a menu item from Active Menu simple drag the menu item and drop it to Available Menu.</p>

                                            <p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Menu Area" and add it back from "Menu list".</p>
                                            <div class="qc_menu_setup_area">

                                                <div class="qc_menu_area">
                                                    <h3>Active menu</h3>
                                                    
                                                    <div class="qc_menu_area_container qc_menu_area_sort" id="qc_menu_area">

                                                        <?php echo stripslashes($menu_order); ?>

                                                    </div>
                                                </div>

                                                <div class="qc_menu_list_area" >
                                                    <h3>Available Menu items</h3>
                                                    
                                                    <div class="qc_menu_list_container">
                                                        <p>Predefined Intents</p>
                                                    
                                                        <?php qcld_wpbot()->helper->render_start_menu(get_wpbot_locale()); ?>

                                                    </div>

                                                </div>
                                            
                                            </div>
                                            
                                            <input class="qc_wpbot_menu_order" type="hidden" name="qc_wpbot_menu_order[<?php echo get_wpbot_locale(); ?>]" value='<?php echo stripslashes($menu_order); ?>' />
                                        </div>
                                        <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section id="section-flip-8">
                            <div class="wp-chatbot-language-center-summmery">
                                <p><?php echo esc_html__('On Site Retargeting  ', 'wpchatbot'); ?> </p>
                            </div>
                            <div class="top-section">
                                <div class="row">
                                    <div class="col-xs-12">

                                        Please go to <a href="<?php echo esc_url( admin_url( 'admin.php?page=retarget-settings')); ?>" >Chatbot Pro > Retargeting</a> page to setup Retargeting.

                                    </div>
                                </div>
                            </div>
                            <!-- top-section-->
                        </section>

                        <section id="section-flip-10">
                            <div class="top-section">
                                <div class="wp-chatbot-language-center-summmery">
                                    <p><?php echo esc_html__('WPBot will be opened based on the following settings', 'wpchatbot'); ?> </p>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable Bot Activity Hour', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks wpbot_bot_activity">
                                            <input value="1" id="enable_wp_chatbot_opening_hour" type="checkbox"
                                                   name="enable_wp_chatbot_opening_hour" <?php echo(get_option('enable_wp_chatbot_opening_hour') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_opening_hour"><?php echo esc_html__('If enabled Bot will show only during the time schedule you set below. The timezone you set from WordPress general settings will be used.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                               

                                <?php 
                                $custom_css = ".wp-chatbot-hours-container{
                                    padding:0px 0 15px 0;
                                    display: flex;
                                    justify-content: space-between;
                                }
                                .wp-chatbot-hours{
                                    
                                    display: inline-block;
                                }
                                .wp-chatbot-hours input{
                                    display: inline-block;
                                    width: 40%;
                                    padding-right: 10px;
                                    text-align: center;
                                }
                                .wp-chatbot-hours-remove{
                                    display: inline-block;
                                }";
                                wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', $custom_css );
                                ?>


                                <div class="row" id="wp-chatbot-hours-wrapper">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('WPBot Bot Activity Hours', 'wpchatbot'); ?> </h4>
                                        <?php

                                         if(get_option('wpwbot_hours')){
                                             $wpwbot_times=maybe_unserialize(get_option('wpwbot_hours'));
                                         }else{
                                             $wpwbot_times=array();
                                         }
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-3">Monday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                 <?php
                                                 qcld_wpbot()->helper->wp_chatbot_opening_hours('monday',$wpwbot_times);
                                                 ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="monday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Tuesday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                    <?php
                                                    qcld_wpbot()->helper->wp_chatbot_opening_hours('tuesday',$wpwbot_times);
                                                    ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="tuesday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Wednesday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                qcld_wpbot()->helper->wp_chatbot_opening_hours('wednesday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="wednesday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Thursday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                qcld_wpbot()->helper->wp_chatbot_opening_hours('thursday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="thursday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Friday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                qcld_wpbot()->helper->wp_chatbot_opening_hours('friday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="friday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Saturday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                qcld_wpbot()->helper->wp_chatbot_opening_hours('saturday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="saturday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Sunday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                qcld_wpbot()->helper->wp_chatbot_opening_hours('sunday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="sunday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- top-section-->
                        </section>

                        

                        <section id="section-flip-7">
                            <div class="wp-chatbot-language-center-summmery">
                                <p> <?php echo esc_html__('WPBot integration like Facebook Messenger, WhatApps etc.', 'wpchatbot'); ?></p>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#wp-chatbot-scl-general"><?php echo esc_html__('General', 'wpchatbot'); ?></a></li>
                                <li ><a data-toggle="tab" href="#wp-chatbot-scl-fb"><?php echo esc_html__('Messenger', 'wpchatbot'); ?></a></li>
                                <li ><a data-toggle="tab" href="#wp-chatbot-scl-skype"><?php echo esc_html__('Skype', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-whats"><?php echo esc_html__('WhatsApp', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-viber"><?php echo esc_html__('Viber', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-link"><?php echo esc_html__('Web Link', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-phone"><?php echo esc_html__('Phone', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-livechat"><?php echo esc_html__('Live Chat', 'wpchatbot'); ?></a></li>
                                <?php  if( is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) ): ?>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-voice"><?php echo esc_html__('Voice Message', 'wpchatbot'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                            <div class="tab-content">
                            <div id="wp-chatbot-scl-general" class="tab-pane fade in active">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Auto Hide Floating Buttons', 'wpchatbot'); ?> </h4>
                                                        <div class="cxsc-settings-blocks">
                                                            <input value="1" id="qc_auto_hide_floating_button" type="checkbox"
                                                                name="qc_auto_hide_floating_button" <?php echo(get_option('qc_auto_hide_floating_button') == 1 ? 'checked' : ''); ?>>
                                                            <label for="qc_auto_hide_floating_button"><?php echo esc_html__('Enable to auto hide floating buttons', 'wpchatbot'); ?> </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Reset & Close Button at Top', 'wpchatbot'); ?> </h4>
                                                        <div class="cxsc-settings-blocks">
                                                            <input value="1" id="enable_reset_close_button" type="checkbox"
                                                                name="enable_reset_close_button" <?php echo(get_option('enable_reset_close_button') == 1 ? 'checked' : ''); ?>>
                                                            <label for="enable_reset_close_button"><?php echo esc_html__('Enable reset & close button at top', 'wpchatbot'); ?> </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Reset Button Toolip Text', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_reset_lan"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_reset_lan') != '' ? get_option('qlcd_wp_chatbot_reset_lan') : 'Reset'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Close Button Toolip Text', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_close_lan"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_close_lan') != '' ? get_option('qlcd_wp_chatbot_close_lan') : 'Close'); ?>">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wp-chatbot-scl-fb" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-interaction-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Enable Messenger (if enabled it will show as option during chat and support)', 'wpchatbot'); ?>  </h4>
                                                 <p><?php echo esc_html__('Create', 'wpchatbot'); ?>  <a href="https://www.facebook.com/business/help/104002523024878" target="_blank"><?php echo esc_html__('Facebook Page Id', 'wpchatbot'); ?> </a> <?php echo esc_html__('and', 'wpchatbot'); ?> <a href="https://developers.facebook.com/docs/apps/register" target="_blank"><?php echo esc_html__('Facebook App ID', 'wpchatbot'); ?></a>.</p>
                                                 <p>You need to add your domain name in the App Domains field in the Basic section of your Facebook Developers-> App settings area.</p>
                                                 <p>You need to add your domain name in the Whitelisted Domains field under your Page Settings -> Messenger Platform area.</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_messenger" type="checkbox"
                                                           name="enable_wp_chatbot_messenger" <?php echo(get_option('enable_wp_chatbot_messenger') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_messenger"><?php echo esc_html__('Enable Messenger', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <?php
                                                    $messenger_options = maybe_unserialize(get_option('qlcd_wp_chatbot_messenger_label'));
                                                    $messenger_option = 'qlcd_wp_chatbot_messenger_label';
                                                    $messenger_text = esc_html__('Chat with Us on Facebook Messenger', 'wpchatbot');
                                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($messenger_options, $messenger_option, $messenger_text);
                                                    ?>
                                                </div>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Messenger Icon beside Bot Icon', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_messenger_floating_icon" type="checkbox"
                                                           name="enable_wp_chatbot_messenger_floating_icon" <?php echo(get_option('enable_wp_chatbot_messenger_floating_icon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_messenger_floating_icon"><?php echo esc_html__('Enable to display Messenger Icon beside Bot Icon', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Facebook App ID', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_app_id"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_app_id') != '' ? get_option('qlcd_wp_chatbot_fb_app_id') : ''); ?>" placeholder="<?php echo esc_html__('Facebook App ID', 'wpchatbot'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Facebook Page ID', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_page_id"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_page_id') != '' ? get_option('qlcd_wp_chatbot_fb_page_id') : ''); ?>" placeholder="<?php echo esc_html__('Facebook Page ID', 'wpchatbot'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Messenger Color', 'wpchatbot'); ?></h4>
                                                    <input id="qlcd_wp_chatbot_fb_color" type="hidden" name="qlcd_wp_chatbot_fb_color" value="<?php echo(get_option('qlcd_wp_chatbot_fb_color') != '' ? get_option('qlcd_wp_chatbot_fb_color') : '#0084ff'); ?>"/>
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Logged In Welcome Message', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_in_msg"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_in_msg') != '' ? get_option('qlcd_wp_chatbot_fb_in_msg') :'Welcome to Our Store!'); ?>" placeholder="<?php echo esc_html__('Facebook logged in welcome message', 'wpchatbot'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Logged Out Welcome Message', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_out_msg"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_out_msg') != '' ? get_option('qlcd_wp_chatbot_fb_out_msg') : 'You are not logged in'); ?>" placeholder="<?php echo esc_html__('Facebook logged out welcome message', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wp-chatbot-scl-skype" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                               <h4 class="qc-opt-title"><?php echo esc_html__('Show Skype Floating Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_skype_floating_icon" type="checkbox"
                                                           name="enable_wp_chatbot_skype_floating_icon" <?php echo(get_option('enable_wp_chatbot_skype_floating_icon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_skype_floating_icon"><?php echo esc_html__('Enable to display Skype Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Skype ID', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="enable_wp_chatbot_skype_id"
                                                           value="<?php echo(get_option('enable_wp_chatbot_skype_id') != '' ? get_option('enable_wp_chatbot_skype_id') : ''); ?>" placeholder="<?php echo esc_html__('Skype', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wp-chatbot-scl-whats" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Enable WhatsApp (if enabled it will show as option during chat and support)', 'wpchatbot'); ?>  </h4>
                                                <p><?php echo esc_html__('Find', 'wpchatbot'); ?> <a target="_blank" href="https://faq.whatsapp.com/en/android/27585377/?category=5245246"><?php echo esc_html__('WhatsApp phone number', 'wpchatbot'); ?></a> <?php echo esc_html__('for settings', 'wpchatbot'); ?>.</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_whats" type="checkbox"
                                                           name="enable_wp_chatbot_whats" <?php echo(get_option('enable_wp_chatbot_whats') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_whats"><?php echo esc_html__('Enable WhatsApp', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <?php
                                                    $whatsapp_options = maybe_unserialize(get_option('qlcd_wp_chatbot_whats_label'));
                                                    $whatsapp_option = 'qlcd_wp_chatbot_whats_label';
                                                    $whatsapp_text = esc_html__('Chat with Us on WhatsApp', 'wpchatbot');
                                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($whatsapp_options, $whatsapp_option, $whatsapp_text);
                                                    ?>
                                                </div>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show WhatsApp Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_whats" type="checkbox"
                                                           name="enable_wp_chatbot_floating_whats" <?php echo(get_option('enable_wp_chatbot_floating_whats') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_whats"><?php echo esc_html__('Enable to display WhatsApp Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('WhatsApp Phone Number', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_whats_num"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_whats_num') != '' ? get_option('qlcd_wp_chatbot_whats_num') : ''); ?>" placeholder="<?php echo esc_html__('WhatsApp Phone Number', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                <div id="wp-chatbot-scl-viber" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Viber Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <p> <?php echo esc_html__('Create', 'wpchatbot'); ?><a href="<?php echo esc_url('https://support.viber.com/customer/en/portal/articles/2733413-get-started-with-a-public-account'); ?>" target="_blank"> <?php echo esc_html__('Viber public Account ', 'wpchatbot'); ?> </a> <?php echo esc_html__('for settings', 'wpchatbot'); ?>.</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_viber" type="checkbox"
                                                           name="enable_wp_chatbot_floating_viber" <?php echo(get_option('enable_wp_chatbot_floating_viber') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_viber"><?php echo esc_html__('Enable to display Viber Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Viber Account', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_viber_acc"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_viber_acc') != '' ? get_option('qlcd_wp_chatbot_viber_acc') : ''); ?>" placeholder="<?php echo esc_html__('Viber Account', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                
                                <div id="wp-chatbot-scl-link" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Website Floating Link on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_link" type="checkbox"
                                                           name="enable_wp_chatbot_floating_link" <?php echo(get_option('enable_wp_chatbot_floating_link') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_link"><?php echo esc_html__('Enable to display Website Floating Link on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Website Url', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_weblink"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_weblink') != '' ? get_option('qlcd_wp_chatbot_weblink') : ''); ?>" placeholder="<?php echo esc_html__('Website Url', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                <div id="wp-chatbot-scl-phone" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Phone Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_phone" type="checkbox"
                                                           name="enable_wp_chatbot_floating_phone" <?php echo(get_option('enable_wp_chatbot_floating_phone') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_phone"><?php echo esc_html__('Enable to display Phone Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Phone Number', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_phone"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_phone') != '' ? get_option('qlcd_wp_chatbot_phone') : ''); ?>" placeholder="<?php echo esc_html__('Phone Number', 'wpchatbot'); ?>">
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
								
								<div id="wp-chatbot-scl-livechat" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Live Chat Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_livechat" type="checkbox"
                                                           name="enable_wp_chatbot_floating_livechat" <?php echo(get_option('enable_wp_chatbot_floating_livechat') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_livechat"><?php echo esc_html__('Enable to display Livechat Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <?php if(qcld_wpbot_is_active_livechat()!==true): ?>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Direct Chat Link', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_livechatlink"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_livechatlink') != '' ? get_option('qlcd_wp_chatbot_livechatlink') : ''); ?>" placeholder="<?php echo esc_html__('Direct Chat Link', 'wpchatbot'); ?>">
                                                </div>
												<img class="wpbot_direct_chat_link" src="<?php echo QCLD_wpCHATBOT_IMG_URL.'/live-chat.jpg' ?>" alt="" />
                                                <br>
												
												<div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Enable Display in Start Menu', 'wpchatbot'); ?></h4>
                                                    <input value="1" id="enable_wp_custom_intent_livechat_button" type="checkbox"
                                                           name="enable_wp_custom_intent_livechat_button" <?php echo(get_option('enable_wp_custom_intent_livechat_button') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_custom_intent_livechat_button"><?php echo esc_html__('Enable custom intent button for livechat.', 'wpchatbot'); ?> </label>
                                                </div>
												<br>
												<br>
												<div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Livechat Button Label', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_livechat_button_label"
                                                           value="<?php echo(get_option('qlcd_wp_livechat_button_label') != '' ? get_option('qlcd_wp_livechat_button_label') : ''); ?>" placeholder="<?php echo esc_html__('Ex: Live Chat', 'wpchatbot'); ?>">
                                                </div>
												<br>
                                                <?php endif; ?>
												<div class="row">
													<div class="col-xs-12">
														<h4 class="qc-opt-title"><?php echo esc_html__(' Upload custom Icon ', 'wpchatbot'); ?></h4>
														<div class="cxsc-settings-blocks">
															<input type="hidden" name="wp_custom_icon_livechat"
																   id="wp_custom_icon_livechat"
																   value="<?php echo (get_option('wp_custom_icon_livechat') != '' ? get_option('wp_custom_icon_livechat') : ''); ?>" />
															<div id="wp_custom_icon_livechat_src">
																<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
																<img src="<?php echo get_option('wp_custom_icon_livechat'); ?>" alt="" width="50" height="50" />
																<?php endif; ?>
															</div>
															<button type="button" class="wp_custom_icon_livechat button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
															<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
															<button type="button" class="wp_custom_icon_livechat_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
															<?php endif; ?>
														</div>
														
													</div>
												</div>
												
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                <?php  if( is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) ): ?>
                                <div id="wp-chatbot-scl-voice" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Enable to show Voice Message button on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_voice_message" type="checkbox"
                                                           name="enable_wp_chatbot_voice_message" <?php echo(get_option('enable_wp_chatbot_voice_message') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_voice_message"><?php echo esc_html__('Enable to display Voice Message Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
								
                            </div>
                            <!--                            tab-content-->
                        </section>

<section id="section-flip-11">
                            <div class="top-section">
                                <div class="wp-chatbot-language-center-summmery">
                                    <p><?php echo esc_html__('DialogFlow as Artificial Intelligences Engine for wpwBot', 'wpchatbot'); ?> </p>
                                </div>

                                <?php qcld_wpbot_field_valudation_df(); ?>                   

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable DialogFlow as AI Engine to Detect Intent', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_dailogflow" type="checkbox"
                                                   name="enable_wp_chatbot_dailogflow" <?php echo(get_option('enable_wp_chatbot_dailogflow') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_dailogflow"><?php echo esc_html__('Enable DialogFlow AI Engine to process Natural Language commands from users.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>


                                    <div class="col-xs-12">
                                        <br>
                                        <p><?php echo esc_html__('Log in to DialogFlow Console from', 'wpchatbot'); ?>
                                            <a class="wpbot_df_instruction" href="<?php echo esc_url('https://dialogflow.com/'); ?>" target="_blank"><?php echo esc_html__('Here', 'wpchatbot'); ?></a> <?php echo esc_html__('with your gmail account.', 'wpchatbot'); ?> 

                                       <a class="wpbot_df_instruction" href="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'download/wpwBot.zip'); ?>" download ><?php echo esc_html__('Download', 'wpchatbot'); ?></a> <?php echo esc_html__('the agent training data and import from DialogFlow->Settings->Export and Import tab. You can add your own intents in that agent but do not modify our following intents which are', 'wpchatbot'); ?> <b>email, email subscription, faq, get email, get name, help, phone, reset, site search and start.</b> </p>
                                    </div>

                                    <div class="col-xs-12" id="wp-chatbot-dialflow-section">
                                        <h4 class="qc-opt-title" style="display:none"><?php echo esc_html__('DialogFlow API Version', 'wpchatbot'); ?></h4>
                                        <div class="form-group" style="display:none">

                                            <label class="radio-inline">
                                                <input id="wp-chatbot-df-api" type="radio"
                                                        name="wp_chatbot_df_api"
                                                        value="v2" <?php echo(get_option('wp_chatbot_df_api') == 'v2' ? 'checked' : 'checked'); ?>>
                                                <?php echo esc_html__('Dialogflow API V2', 'wpchatbot'); ?>
                                            </label>

                                        </div>

                                        <?php if(!file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')): ?>
                                        <div class="form-group">
                                            
                                            <br>
                                            <h4 class="qc-opt-title" style="color:red"><?php echo esc_html__('For Interacting with Dialogflow V2 the Google Client Package is Required!', 'wpchatbot'); ?></h4>
                                            <p>Please click the download button below to download the Google Client package. The package will be downloaded inside your Wordpress's <b>/wp-content</b> folder. This package is around <b>10 MB</b> in zip file format and it will be about <b>49 MB</b> after unzipping. Please make sure that your server has enough space to store that package.</p>
                                            <div class="qcld-wpbot-gcdownload-area">
                                                <button class="btn btn-primary" id="qc_wpbot_gc_download" <?php echo (!is_writable(QCLD_wpCHATBOT_GC_ROOT)?'disabled':''); ?>>Download and Install the Google Client</button>
                                                <?php 
                                                    if(!is_writable(QCLD_wpCHATBOT_GC_ROOT)){
                                                        echo '<span style="color:red;font-size: 12px;"><b>wp-content</b> folder is not writable.</span>';
                                                    }
                                                ?>
                                                <br><br>
                                                <p>Alternatively, If the download operation fails for some reason like folder permission or server timeout issue then you can manually upload the <u title="Google Client">GC</u> package by following some simple steps.</p>
                                                <p>1. Download GC package from: <a href="https://github.com/qcloud/gc/archive/master.zip" target="_blank">https://github.com/qcloud/gc/archive/master.zip</a></p>
                                                <p>2. Unzip the <b>wpbotgc.zip</b> inside to your computer.</p>
                                                <p>3. Create a folder with name <b>wpbot-dfv2-client</b> under <b>wp-content</b> into your server.</p>
                                                <p>4. Upload the upziped files and folders into <b>wpbot-dfv2-client</b> via FTP.</p>
                                                
                                                
                                                <div class="qcld_wpbot_download_statuses">
                                                    
                                                </div>
                                            </div>
                                            <br>
                                            
                                        </div>
                                        <?php else: ?>
                                        <div class="form-group">
                                            <h4 class="qc-opt-title" style="color:green"><?php echo esc_html__('Google Client Package is Installed on Your Website.', 'wpchatbot'); ?></h4>
                                        </div>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title" >Please follow along with this <a href="https://dev.quantumcloud.com/wpbot-pro/dialogflow-integration/" target="_blank">tutorial</a>. It will help you to create a project id, private key and integrate WPBot with Dialogflow: <a href="https://dev.quantumcloud.com/wpbot-pro/dialogflow-integration/" target="_blank">Click Here</a></h4>
                                        </div>
                                        
                                        <?php 
                                            qcld_wpbot()->helper->render_dialogflow();
                                        ?>


                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Webhook URL', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font" value="<?php echo home_url(); ?>/wp-json/wpbot/v1/dialogflow_webhook" />
                                            <p>You can use this webhook url for Dialogflow agent fulfillment. You can write your own fulfillment code in "qcld-df-webhook.php" file that can be found in plugin root directory.</p>
                                        </div>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Enable Authentication for Webhook URL', 'wpchatbot'); ?> </h4>
                                            <div class="cxsc-settings-blocks">
                                                <input value="1" id="enable_authentication_webhook" type="checkbox"
                                                    name="enable_authentication_webhook" <?php echo(get_option('enable_authentication_webhook') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_authentication_webhook"><?php echo esc_html__('Enable Authentication for Dialogflow fulfillment Webhook URL', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <br>
										<div class="qcld_webhook_auth_container">
                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Auth Username', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font" value="<?php echo(get_option('qcld_auth_username') != '' ? get_option('qcld_auth_username') : ''); ?>" name="qcld_auth_username" placeholder="<?php echo esc_html__('Enter Username', 'wpchatbot'); ?>" />
                                                
                                            </div>
                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Auth Password', 'wpchatbot'); ?></h4>
                                                <input type="password" class="form-control qc-opt-dcs-font" value="<?php echo(get_option('qcld_auth_password') != '' ? get_option('qcld_auth_password') : ''); ?>" name="qcld_auth_password" placeholder="<?php echo esc_html__('Enter Password', 'wpchatbot'); ?>" />
                                                
                                            </div>
                                        </div>
                                        
                                        
										<br>
										<div class="form-group">
										<div class="wpb_custom_intent">
											<h2>Custom Intent Options</h2>
											<p>Need to enable Artificial Intelligence for Custom Intent work. The intent name & label must be added in training phrases. The intent name must match EXACTLY as in what you added in DialogFlow.</p>
											<div class="form-group">
												<?php
												$agent_join_options = maybe_unserialize(get_option('qlcd_wp_custon_intent'));
												$agent_join_option = 'qlcd_wp_custon_intent';
												$agent_join_text = esc_html__('', 'wpchatbot');
												qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option_custom($agent_join_options, $agent_join_option, $agent_join_text);
												?>
											</div>
											
										</div>
										</div>
										<?php do_action('woowbot_product_search_by_tags_settings'); ?>
										
										
										
										
                                    </div>
									
                                </div>
                            </div>
							
                        </section>

                        <section id="section-flip-20">
                            <div class="top-section">
                                <div class="wp-chatbot-language-center-summmery">
                                    <p><?php echo esc_html__('Conversational Form Builder', 'wpchatbot'); ?> </p>
                                </div>

            

                                <div class="row">
                                    <div class="col-xs-12">
                                    <div class="qc-column-12"><!-- qc-column-4 -->
                                        <!-- Feature Box 1 -->
                                        <div class="support-block support-block-custom">
                                            <div class="support-block-img">
                                                <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/conversational-forns.png'); ?>" alt="">
                                            </div>
                                            <div class="support-block-info">
                                                <h4 style="font-weight: normal !important;">Conversational Form Addon</h4>
                                                <p>Use the Conversational form builder AddOn to create conversations and forms for a native WordPress ChatBot experience without any 3rd party integrations. Conversational forms can also be emailed to you.</p>
                                                <p><a href="https://wordpress.org/plugins/conversational-forms/" target="_blank">Download Free</a>|<a href="<?php echo esc_url('https://www.quantumcloud.com/products/conversations-and-form-builder/ '); ?>" target="_blank">Download Pro</a></p>

                                            </div>
                                        </div>
                                    </div><!--/qc-column-4 -->
                                    </div>
									
                                </div>
                            </div>
							
                        </section>



                        <section id="section-flip-3">
                            <div class="row">
                                <div class="col-xs-12">
                                    
                                </div>
                            </div>
                            <div class="top-section">
                                <?php qcld_wpbot()->helper->render_faqs(); ?>
                            </div>
                        </section>
                        <section id="section-flip-4">
                            <div class="top-section">

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="cxsc-settings-blocks">
                                            <?php $notification_interval = get_option('qlcd_wp_chatbot_notification_interval') != "" ? get_option('qlcd_wp_chatbot_notification_interval') : 5 ?>
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Interval between notifications (in Seconds).', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control"
                                                    name="qlcd_wp_chatbot_notification_interval"
                                                    value="<?php echo esc_html($notification_interval); ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php qcld_wpbot()->helper->render_notifications(); ?>

                                <hr>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Intent Navigation for Notification area', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="show_intent_navigation_notification" type="checkbox"
                                                   name="show_intent_navigation_notification" <?php echo(get_option('show_intent_navigation_notification') == 1 ? 'checked' : ''); ?>>
                                            <label for="show_intent_navigation_notification"><?php echo esc_html__('Enable Intent Navigation for Notification area', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                                <?php $navintents = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wpbot_notification_navigations'))); 
                                if( !is_array( $navintents ) ){
                                    $navintents = array();
                                }
                                ?>
                                <div class="row" id="wpbot_notification_navigation_main_container" <?php echo (get_option('show_intent_navigation_notification') == 1?'style="display:block"':'style="display:none"'); ?>>
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Please Select Intents for Notification Area Navigation', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            
                                            <div class="wpcq_intents_navigation_section">
                                            <?php $allIntents = qc_get_all_intents(); 
                                            
                                            
                                            ?>
                                            <?php foreach($allIntents as $key=>$value): ?>
                                                <div class="wpbot_navigation_group">
                                                    <h2><?php echo $key; ?> Intent</h2>
                                                    <ul>
                                                        <?php foreach($value as $val): ?>
                                                        <li>
                                                        <input id="wp_chatbot_notification_navigation_<?php echo $val; ?>" type="checkbox" name="wpbot_notification_navigations[]" value="<?php echo $val; ?>" <?php echo (in_array($val, $navintents)?'checked="checked"':''); ?>>
                                                        <label for="wp_chatbot_notification_navigation_<?php echo $val; ?>"><?php echo $val; ?></label>
                                                        </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                
                            </div>
                            
                        </section>

                        <section id="section-flip-13">
                            <div class="top-section">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-dcs"><?php echo esc_html__('You can paste or write your custom css here.', 'wpchatbot'); ?></h4>
                                        <textarea name="wp_chatbot_custom_css"
                                                  class="form-control wp-chatbot-custom-css"
                                                  cols="10"
                                                  rows="16"><?php echo get_option('wp_chatbot_custom_css'); ?></textarea>
                                    </div>
                                </div>
                                <!--                                row-->
                            </div>
                        </section>
                        <?php if(!qcld_wpbot_is_active_white_label()): ?>

                        <section id="section-flip-14">
                            <div class="top-section">
                                <div class="row">
                                    <div class="col-xs-12">

        <?php wp_enqueue_style( 'qcpd-google-font-lato', 'https://fonts.googleapis.com/css?family=Lato' ); ?>
		<?php wp_enqueue_style( 'qcpd-style-addon-page', QCLD_wpCHATBOT_PLUGIN_URL.'qc-support-promo-page/css/style.css' ); ?>
        <?php wp_enqueue_style( 'qcpd-style-responsive-addon-page', QCLD_wpCHATBOT_PLUGIN_URL.'qc-support-promo-page/css/responsive.css' ); ?>
        
<div class="qc_support_container"><!--qc_support_container-->

<div class="qc_tabcontent clearfix-div">
<div class="qc-row">
	
    <h2 class="plugin-title wpbot_page_title" >Extend <?php echo wpbot_text(); ?> and give it more Super Powers</h2>
    
    

	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				 <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/conversational-forns.png'); ?>" alt="">
			</div>
			<div class="support-block-info">
				<h4 style="font-weight: normal !important;">Conversational Form Addon</h4>
				<p>Use the Conversational form builder AddOn to create conversations and forms for a native WordPress ChatBot experience without any 3rd party integrations. Conversational forms can also be emailed to you.</p>
                <p><a href="https://wordpress.org/plugins/conversational-forms/" target="_blank">Download Free</a>|<a href="<?php echo esc_url('https://www.quantumcloud.com/products/conversations-and-form-builder/ '); ?>" target="_blank">Download Pro</a></p>

			</div>
		</div>
	</div><!--/qc-column-4 -->

    

    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/custom-post-type-addon-logo.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Extended Search</a></h4>
				<p>Extend <?php echo wpbot_text(); ?>’s search power to include almost any Custom Post Type including WooCommerce</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->
	
    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/woo-addon-256.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Woocommerce Addon</a></h4>
				<p>Utilize the <?php echo wpbot_text(); ?> on your Woocommerce website and make a Woocommerce Chatbot with zero configuration</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->

	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/messenger-chatbot.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Messenger ChatBot Addon</a></h4>
				<p>Utilize the <?php echo wpbot_text(); ?> on your website as a hub to respond to customer questions on FB Page & Messenger</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->
	
	
	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/chatbot-sesssion-save.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">ChatBot Session Save Addon</a></h4>
				<p>This AddOn saves the user chat sessions and helps you fine tune the bot for better support and performance.</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->
	
	
	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/WPBot-LiveChat.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">LiveChat Addon</a></h4>
				<p>Live Human Chat integrated with <?php echo wpbot_text(); ?><p/>
			</div>
		</div>
	</div><!--/qc-column-4 -->

    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/white-label.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">White Label <?php echo wpbot_text(); ?></a></h4>
				<p>Replace the QuantumCloud Logo and branding with yours. Suitable for developers and agencies interested in providing ChatBot services for their clients.<p/>
			</div>
		</div>
	</div><!--/qc-column-4 -->

    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/mailing-list-integrationt (1).png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Mailing List Integration AddOn</a></h4>
				<p>Mailing List Integration is an addon that lets you connect our ChatBot with Mailchimp and Zapier accounts. You can add new subscribers to your Mailchimp Lists and unsubscribe them.<p/>
			</div>
		</div>
	</div><!--/qc-column-4 -->
    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/chatbot-addons.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">More Addons</a></h4>
				<p>Check out all the available ChatBot AddOns<p/>
			</div>
		</div>
    </div><!--/qc-column-4 -->
    
    <div class="qc-column-12"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block ">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/themes/chatbot-theme/'); ?>" target="_blank"> <img class="wp_addon_fullwidth" src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/ChatBot-Master-theme.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info" style="min-height:150px">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">ChatBot Master Theme</a></h4>
                <p>Get a ChatBot Powered Theme!</p>
			</div>
		</div>
	</div><!--/qc-column-4 -->

</div>
<!--qc row-->
</div>

</div><!--qc_support_container-->



                                    </div>
                                </div>
                                <!--                                row-->
                            </div>
                        </section>
                                            <?php endif; ?>
                    


                    </div><!-- /content -->
                </div><!-- /wp-chatbot-tabs -->
                <footer class="wp-chatbot-admin-footer">
                    <div class="row">
                        <div class="text-left col-sm-3 col-sm-offset-3">
                            <input type="button" class="btn btn-warning submit-button"
                                   id="qcld-wp-chatbot-reset-option"
                                   value="<?php echo esc_html__('Reset all options to Default', 'wpchatbot'); ?>"/>
                        </div>
                        <div class="text-right col-sm-6">
                            <input type="submit" class="btn btn-primary submit-button" name="submit"
                                   id="submit" value="<?php echo esc_html__('Save Settings', 'wpchatbot'); ?>"/>
                        </div>
                    </div>
                    <!--                    row-->
                </footer>
            </section>
        </div>
        <?php wp_nonce_field('wp_chatbot'); ?>
    </form>

<div class="wpbot-fabs" >

  <div id="wpbot-load-qcbot" title="Launch the chatbot for testing" class="qc_wpbot_floating_main qc_right_position" style="display: block;" >
    <div class="qc_bot_floating_content"> <img alt="Launch the chatbot for testing" src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-0.png'); ?>" alt="WPBot"><p>Test Your Changes</p> </div>
    </div>

</div>

<div id="wpbot-qcbot-myModal" class="wpbot-giphy-modal" style="z-index: 99999;padding-top: 0;">

    <!-- Modal content -->
    <div class="wpbot-giphy-modal-content" style="height: 95%;
    overflow: auto;
    box-shadow: 2px 5px 15px 5px #0707075e;
    border-radius: 5px;
    max-width: 1600px;">
    <span class="wpbot-giphy-close">&times;</span>
    To test in the front end, after making any changes, please type reset and hit enter in the ChatBot to start testing from the beginning or open a new Incognito window (Ctrl+Shit+N in Chrome).
    <iframe id="qcwpbot_ifram_qcbot" src="about:blank" data-src="<?php echo home_url().'/'.$page->post_name; ?>" height="100%" width="100%" style="border:none;height: calc(100% - 46px);"></iframe>
    </div>

</div>

<script type="text/javascript">

jQuery(document).ready(function($){
// toggleFab();

//Fab click
$('#wpbot-prime').click(function() {
  toggleFab();
});

//Toggle chat and links
function toggleFab() {
  $('.wpbot-prime').toggleClass('wpbot-is-active');
  $('#wpbot-prime').toggleClass('wpbot-is-float');
  $('.wpbot-fab').toggleClass('wpbot-is-visible');
  
}

// Ripple effect
var target, ink, d, x, y;
$(".wpbot-fab").click(function(e) {
  target = $(this);
  //create .ink element if it doesn't exist
  if (target.find(".wpbot-ink").length == 0)
    target.prepend("<span class='wpbot-ink'></span>");

  ink = target.find(".wpbot-ink");
  //incase of quick double clicks stop the previous animation
  ink.removeClass("wpbot-animate");

  //set size of .ink
  if (!ink.height() && !ink.width()) {
    //use parent's width or height whichever is larger for the diameter to make a circle which can cover the entire element.
    d = Math.max(target.outerWidth(), target.outerHeight());
    ink.css({
      height: d,
      width: d
    });
  }

  //get click coordinates
  //logic = click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center;
  x = e.pageX - target.offset().left - ink.width() / 2;
  y = e.pageY - target.offset().top - ink.height() / 2;

  //set the position and add class .animate
  ink.css({
    top: y + 'px',
    left: x + 'px'
  }).addClass("wpbot-animate");
});

})

// Get the modal
var modal = document.getElementById("wpbot-qcbot-myModal");

// Get the button that opens the modal
var btn = document.getElementById("wpbot-load-qcbot");

var giphyifram = document.getElementById('qcwpbot_ifram_qcbot');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("wpbot-giphy-close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
  giphyifram.setAttribute('src', giphyifram.getAttribute('data-src'));
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  giphyifram.setAttribute('src', 'about:blank');
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    giphyifram.setAttribute('src', 'about:blank');
  }
}

</script>