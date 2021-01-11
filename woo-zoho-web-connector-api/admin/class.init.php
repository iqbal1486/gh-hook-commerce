<?php
/**
 * INIT Class
 */
class GH_Init_Admin
{
	
	public function __construct(){
		
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab'), 50 );
		add_action( 'woocommerce_settings_tabs_gh-wc-zoho-settings', array( $this, 'settings_tab' ) );
		add_action( 'woocommerce_update_options_gh-wc-zoho-settings', array( $this, 'update_settings' ) );
		add_action( 'woocommerce_api_gh_wc_zoho_auth', array( $this, 'gh_wc_zohocrm_oauth_callback' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_script' ) );
	}
	
	public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['gh-wc-zoho-settings'] = __( 'GH Woo Zoho Settings', 'gh-wc-zoho' );
        return $settings_tabs;
    }
	
	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}
	
	public function get_settings() {
		$auth_redirect_url = home_url('wc-api/gh_wc_zoho_auth');
		$auth_request = '';
		$gh_wc_zoho_client_id = get_option('gh_wc_zoho_client_id');
		
		if($gh_wc_zoho_client_id != '')
		{
			$gh_wc_zoho_dc = get_option('gh_wc_zoho_dc');
			$gh_auth_url = 'https://accounts.zoho.'.$gh_wc_zoho_dc.'/oauth/v2/auth?scope=ZohoCRM.modules.ALL,ZohoCRM.settings.ALL&client_id='.$gh_wc_zoho_client_id.'&response_type=code&access_type=offline&redirect_uri='.$auth_redirect_url;

			$auth_request = ' ';
			if(get_option('wc_zohocrm_access_token') != '' && get_option('wc_zohocrm_refresh_token') != '')
				$auth_request .= '<span style="color: green;">You have authorized Zoho App.</span> <a href="" class="button-primary">'.__( 'Authorize New Zoho App', 'gh-wc-zoho' ).'</a>';
			else
				$auth_request .= '<a href="'.$gh_auth_url.'" class="button-primary">'.__( 'Authorize Zoho App', 'gh-wc-zoho' ).'</a>';
		}
		
		$settings = array(
			array(
				'name' => __( 'Zoho CRM API Settings', 'gh-wc-zoho' ),
				'type' => 'title',
				'desc' => 'For OAuth add this Redirect URI in Zoho App registration - <b>'.$auth_redirect_url.'</b>.'.$auth_request,
				'id'   => 'wc_zoho'
			),	
			array(
				'name'    => __( 'Data Center', 'gh-wc-zoho' ),
				'desc'    => __( 'You can find the Zoho Data Center from your browser URL.', 'gh-wc-zoho' ),
				'id'      => 'gh_wc_zoho_dc',
				'default' => 'com',
				'type'    => 'select',
				'options'     => array(
					'com'     => __('Other','gh-wc-zoho').' (COM)',
					'eu'      => __('Europe','gh-wc-zoho').' (EU)',
					'com.cn' => __('China','gh-wc-zoho').' (CN)'
				),
				'desc_tip' =>  true,
				'css'=>'height: 30px;'
			),
			array(
				'name'    => __( 'Client ID', 'gh-wc-zoho' ),
				'desc'    => __( 'Register your application from accounts.zoho.com/developerconsole and get Client ID.', 'gh-wc-zoho' ),
				'id'      => 'gh_wc_zoho_client_id',
				'default' => '',
				'type'    => 'text',
				'desc_tip' =>  true
			),
			array(
				'name'    => __( 'Client Secret', 'gh-wc-zoho' ),
				'desc'    => __( 'The consumer secret generated from the connected app.', 'gh-wc-zoho' ),
				'id'      => 'wc_zoho_client_secret',
				'default' => '',
				'type'    => 'text',
				'desc_tip' =>  true
			),
			array( 'type' => 'sectionend', 'id' => 'wc_zoho' ),
			array(
				'name' => __( 'WooCommerce to Zoho Synchronization Settings', 'gh-wc-zoho' ),
				'type' => 'title',
				'desc' => 'Enable/Disable synchronization for WooCommerce to Zoho. Zoho Products, Sales Orders and Invoices modules are only available for Professional and Enterprise accounts.',
				'id'   => 'wc_zoho_sync'
			),	
			array(
				'name'    => __( 'Customers to Zoho Accounts', 'gh-wc-zoho' ),
				'desc'    => __( 'Enable Customers to Zoho Accounts Synchronization.', 'gh-wc-zoho' ),
				'id'      => 'wc_zoho_accounts',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Customers to Zoho Leads', 'gh-wc-zoho' ),
				'desc'    => __( 'Enable Customers to Zoho Leads Synchronization.', 'gh-wc-zoho' ),
				'id'      => 'wc_zoho_leads',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Customers to Zoho Contacts', 'gh-wc-zoho' ),
				'desc'    => __( 'Enable Customers to Zoho Contacts Synchronization.', 'gh-wc-zoho' ),
				'id'      => 'wc_zoho_contacts',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Products to Zoho Products', 'gh-wc-zoho' ),
				'desc'    => __( 'Enable Products to Zoho Products Synchronization.', 'gh-wc-zoho' ),
				'id'      => 'wc_zoho_products',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Orders to Zoho Sales Orders', 'gh-wc-zoho' ),
				'desc'    => __( 'Enable Orders to Zoho Sales Orders Synchronization.', 'gh-wc-zoho' ),
				'id'      => 'wc_zoho_orders',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Completed Orders to Zoho Invoices', 'gh-wc-zoho' ),
				'desc'    => __( 'Enable Completed Orders to Zoho Invoices Synchronization.', 'gh-wc-zoho' ),
				'id'      => 'wc_zoho_invoices',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array( 'type' => 'sectionend', 'id' => 'wc_zoho_sync' ),
			array(
				'name' => __( 'Zoho to WooCommerce Synchronization Settings', 'gh-wc-zoho' ),
				'type' => 'title',
				'desc' => 'Enable/Disable synchronization for Zoho to WooCommerce using Zoho Webhook. To setup Automatic Sync from Zoho please setup Workflow and Webhook as per our documentation or visit <a href="https://www.zoho.com/crm/help/automation/webhooks.html" target="_blank">here</a>.',
				'id'   => 'wc_zoho_sync_2'
			),
			array(
				'name'    => __( 'Enable Zoho to WooCommerce Sync', 'gh-wc-zoho' ),
				'id'      => 'wc_zohocrm_webhook',
				'default' => 'no',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Enable Product Sync', 'gh-wc-zoho' ),
				'desc'    => 'Create and Update Products. Webhook URL is <b>'.home_url('wc-api/zoho-products').'</b>.',
				'id'      => 'wc_zohocrm_webhook_products',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Enable Customer Sync from Zoho Contacts module', 'gh-wc-zoho' ),
				'desc'    => 'Create and Update Customers from Zoho Contacts module. Webhook URL is <b>'.home_url('wc-api/zoho-contacts').'</b>.',
				'id'      => 'wc_zohocrm_webhook_contacts',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array(
				'name'    => __( 'Enable Customer Sync from Zoho Accounts module', 'gh-wc-zoho' ),
				'desc'    => 'Update Customers from Zoho Accounts module. Webhook URL is <b>'.home_url('wc-api/zoho-accounts').'</b>.',
				'id'      => 'wc_zohocrm_webhook_accounts',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
			array( 'type' => 'sectionend', 'id' => 'wc_zoho_sync_2' ),
			
		);
		return $settings;
	}
	
	public function admin_script() {
		wp_enqueue_script( 'wc_zohocrm_admin', plugin_dir_url(dirname(__FILE__)) . 'assets/zoho-admin.js', array(), '1.0', true );
	}
	
	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
	}	
	
	public function gh_wc_zohocrm_oauth_callback()
	{
		if(isset($_REQUEST['code']))
		{
			
			$data  = new Initialize($_REQUEST['code']);
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			die();

			// $oauth = 0;
			// $zoho = new WCZohoCRMAPI();
			// $response = $zoho->OAuth($_REQUEST['code']);
			
			// if( !is_wp_error( $response ) ){
			// 	$data = json_decode($response['body'], true);
			// 	if(isset($data['access_token']))
			// 	{
			// 		update_option('wc_zohocrm_access_token', $data['access_token']);
			// 		update_option('wc_zohocrm_access_token_expires_on', strtotime(current_time('mysql')) + 3600);
					
			// 		if(isset($data['refresh_token']))
			// 			update_option('wc_zohocrm_refresh_token', $data['refresh_token']);
					
			// 		$oauth = 1;
			// 	}
			// }
			
			// wp_redirect(admin_url('admin.php?page=wc-settings&tab=gh_wc_zoho_settings&oauth='.$oauth));
			// exit;
		}
	}
}

new GH_Init_Admin();