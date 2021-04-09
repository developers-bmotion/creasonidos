<?php 

class Qcld_WPBot_Menu
{
    
    public function __construct() {
        add_action('admin_menu', array($this, 'chatbot_menu'));
    }
    
    public function chatbot_menu()
    {
		global $custom_hook;
        add_menu_page( wpbot_menu_text(), wpbot_menu_text(), 'manage_options','wpbot-panel', array($this, 'qcld_wb_chatbot_admin_page'),'dashicons-format-status', 6 );
		
        add_submenu_page( 'wpbot-panel', 'Settings', 'Settings', 'manage_options','wpbot', array($this, 'qcld_wb_chatbot_admin_page_settings') );

        add_submenu_page( 'wpbot-panel', 'Retargeting', 'Retargeting', 'manage_options','retarget-settings', array($this, 'qcld_wp_chatbot_retargeting_settings') );

        add_submenu_page( 'wpbot-panel', 'Language Center', 'Language Center', 'manage_options','language-center', array($this, 'language_center_render') );

        add_submenu_page( 'wpbot-panel', 'User Data', 'User Data', 'manage_options','email-subscription', array($this, 'qcld_wb_chatbot_admin_page1') );

        add_submenu_page( 'wpbot-panel', 'Stop Words', 'Stop Words', 'manage_options','stop-word', array($this, 'qcld_wb_chatbot_admin_stop_word') );

        $custom_hook = add_submenu_page( 'wpbot-panel', 'Simple Text Responses', 'Simple Text Responses', 'manage_options','simple-text-response', array($this, 'qcld_wb_chatbot_admin_str') );

        add_action( "load-$custom_hook", [ $this, 'screen_option' ] );

        if(!qcld_wpbot_is_active_white_label()){
            add_submenu_page( 'wpbot-panel', 'Support', 'Support', 'manage_options','wpbot_support_page', 'qcpromo_support_page_callback_func' );
        }

        $page_title = __('Extended Interface', 'botstartmenu');
        $menu_title = __('Extended Interface', 'botstartmenu');
        $capability = 'manage_options';
        $menu_slug = 'chatbot-menu';
        $function = array( 'Qcld_startmenu_menu', 'menu' );
        
        add_submenu_page( 'wpbot-panel', $page_title, $menu_title, $capability,$menu_slug, $function );

        add_submenu_page( 'wpbot-panel', 'Help & License', 'Help & License', 'manage_options','wpbot_license_page', 'wpbot_License_page_callback_func' );
        
    }

    /**
     * Render the admin page
     */
    public function qcld_wb_chatbot_admin_page()
    {
        global $woocommerce;
        $action = 'admin.php?page=wpbot-panel';
        require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/templates/admin_ui2.php");
    }

    /**
     * Render settings page
     *
     * @return void
     */
    public function qcld_wb_chatbot_admin_page_settings()
    {
        global $woocommerce;
        $action = 'admin.php?page=wpbot';
        $data = get_option('wbca_options');
        require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/templates/admin_ui.php" );
    }

    /**
     * Render retargeting settings
     *
     * @return void
     */
    public function qcld_wp_chatbot_retargeting_settings(){
        require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/admin/templates/retarget_settings.php' );
    }
    
    /**
     * Render Language settings
     *
     * @return void
     */
    public function language_center_render(){
        require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/admin/templates/language_settings.php' );
    }

    /**
     * Render user data
     *
     * @return void
     */
    public function qcld_wb_chatbot_admin_page1(){
		require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/templates/email_subscription.php");
    }

    /**
     * Render Stopwords
     *
     * @return void
     */
    public function qcld_wb_chatbot_admin_stop_word(){
        require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/templates/stop-word.php" );
    }

    /**
     * Render Simple Text Responses admin page
     *
     * @return void
     */
    public function qcld_wb_chatbot_admin_str(){
        ob_start();
        require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/templates/simple_text_response.php" );
        $content = ob_get_clean();
        echo $content;
    }

    function screen_option(){
		global $custom_hook;
		$screen = get_current_screen();
	
        $option = 'per_page';
		$args   = [
			'label'   => 'Response',
			'default' => 25,
			'option'  => 'str_responses_per_page'
		];
		add_screen_option( $option, $args );
		qcld_wpbot()->set_response_list();
    }
}

new Qcld_WPBot_Menu();
