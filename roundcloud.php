<?php
/*
Plugin Name: RoundCloud
Plugin URI: http://yourcloudaround.com/en/
Description:  RoundCloud plugin
Version: 1.0.3
Author:RoundCloud
Author URI: http://yourcloudaround.com/en/
License: GPL2
*/

define('RC_DIR', plugin_dir_path(__FILE__));
define('RC_URL', plugin_dir_url(__FILE__));
register_activation_hook(__FILE__, 'rc_activation');
register_deactivation_hook(__FILE__, 'rc_deactivation');
include dirname(__FILE__) . '/PapApi.class.php';

function rc_activation() {
	add_option('rc_clicktracking','false','','yes');
	add_option('rc_autoregister','false','','yes');
	add_option('rc_autoregister_parent_affiliate','from_cookie','','yes');
	add_option('rc_woocommerce','false','','yes');
	add_option('rc_form_seven','false','','yes');
	add_option('rc_contact_seven_form_name','','','yes');
	add_option('rc_contact_seven_company','','','yes');
	add_option('rc_contact_seven_company_id','','','yes');
	add_option('rc_contact_seven_commissions','','','yes');
	add_option('rc_show_banner','false','','yes');
	


}

function rc_deactivation() {
	delete_option('rc_clicktracking');
	delete_option('rc_show_banner');
	delete_option('rc_autoregister');
	delete_option('rc_autoregister_parent_affiliate');
	delete_option('rc_woocommerce');
	delete_option('rc_form_seven');
	delete_option('rc_contact_seven_form_name');
	delete_option('rc_contact_seven_company');
	delete_option('rc_contact_seven_company_id');
	delete_option('rc_contact_seven_commissions');
}

function rc_full_logout(){
	rc_deactivation();
	rc_activation();
	delete_option('rc_PanAccountId');
	delete_option('rc_PanEmail');
	delete_option('rc_PanAccount');
	delete_option('rc_PanPassword');
}


function rc_userlist_init(){
	$icon =plugins_url('roundcloud/assets/img/icon.png');
	
	add_object_page('ROUNDCLOUD ADVERTISING', 'ROUNDCLOUD ADVERTISING', -1, basename(__FILE__), '', $icon);
	
	add_submenu_page(basename(__FILE__), 'General settings', 'General settings', 10, 'rc_settings', 'rc_load_settings');
	
	if(get_option('rc_PanAccountId')!==false){
		
		add_submenu_page(basename(__FILE__), 'Integration', 'Integration', 10, 'rc_integration', 'rc_load_integration');
		
		add_submenu_page(basename(__FILE__), 'Manage Adv', 'Manage Adv', 10, 'rc_manage_adv', 'rc_load_manage_adv');
		
	}

}

function rc_load_manage_adv(){
	
	include(RC_DIR.'/views/PaPWindow.php');
	
}


function rc_load_integration(){
	
	include(RC_DIR.'/views/integration.php');
	
}

function rc_load_settings(){
	
	include(RC_DIR.'/views/settings.php');
	
}

function add_my_script() {

	if($_GET['page']=='rc_settings' || $_GET['page']=='rc_integration' || $_GET['page']=='rc_manage_adv' ){
		
		wp_enqueue_script('roundcloud', plugins_url('/assets/js/roundcloud.js', __FILE__),'');

		wp_register_style( 'prefix-style', plugins_url('/assets/css/RoundCloud.css', __FILE__) );
			
		wp_enqueue_style( 'prefix-style' );
			
	}
		
}

function rc_init(){

	 
}

function rc_set_option(){

	echo add_option($_GET['option_name'],$_GET['option_value'],'','yes');

}

function rc_deleteOption(){
	
	delete_option($_GET['option_name']);
	
}

function rc_update_option(){

		delete_option($_GET['option_name']);
		
		echo update_option($_GET['option_name'],$_GET['option_value']);

}

function rc_get_option(){
	
	echo get_option($_GET['option_name']);

}

function rc_get_affiliate_id(){
	
	echo get_option('rc_PanAccountId');
	
}

function rc_get_affiliate_id_front_end(){
	
	echo get_option('rc_PanAccountId');
	
}


function rc_get_Pan_session(){
	
	$session = new Gpf_Api_Session("http://affiliate.yourcloudaround.com/scripts/server.php");
	
	$session->login(get_option('rc_PanEmail'), get_option('rc_PanPassword'));
	
    return $session;
	
}

function rc_onNewUserRegistration($user_id){

	$session = rc_get_Pan_session();

	$affiliate = initAffiliate(new WP_User($user_id), $session);
	
	$affiliate = setParentToAffiliate($affiliate, $session);
	
	$affiliate = setStatusToAffiliate($affiliate);
	
	try {
		
        $affiliate->add();
		
    } catch (Exception $e) {
		_log('RoundCloud error create new affiliate. message: '.$e->getMessage);
    }
	
}

function initAffiliate(WP_User $user, Gpf_Api_Session $session) {
	
	$affiliate = new Pap_Api_Affiliate($session);
	
	$affiliate->setUsername($user->user_email);
	
	$affiliate = resolveFirstAndLastName($user, $affiliate);
	
	$affiliate->setNotificationEmail($user->user_email);
	
	$affiliate->setData(1, __('User level: ') . $user->user_level);
	
	return $affiliate;
	
}

function setParentToAffiliate(Pap_Api_Affiliate $affiliate, Gpf_Api_Session $session) {
	
	if (get_option('rc_autoregister_parent_affiliate')!==false &&

		get_option('rc_autoregister_parent_affiliate')!==null &&

		get_option('rc_autoregister_parent_affiliate')!='' &&

		get_option('rc_autoregister_parent_affiliate')!='from_cookie') {
	
		$affiliate->setParentUserId(get_option('rc_autoregister_parent_affiliate'));
	}
	if (get_option('rc_autoregister_parent_affiliate')=='from_cookie') {
		
		$affiliate =  resolveParentAffiliateFromCookie($session, $affiliate);
	
	}
	
	return $affiliate;

}

function setStatusToAffiliate(Pap_Api_Affiliate $affiliate) {
	
	$affiliate->setStatus('A');

	return $affiliate;

}
		
function resolveParentAffiliateFromCookie(Gpf_Api_Session $session, Pap_Api_Affiliate $affiliate) {
	
	$clickTracker = new Pap_Api_ClickTracker($session);
	
    $clickTracker->track();
	
    $clickTracker->saveCookies();
          
    if ($clickTracker->getAffiliate() != null) {
		
        $affiliate->setParentUserId($clickTracker->getAffiliate()->getValue('userid'));
		
    }else{
           _log('RoundCloud warning login. message: not parent affiliate');
    }
	
	return $affiliate;
	
}

 function resolveFirstAndLastName(WP_User $user, Pap_Api_Affiliate $affiliate) {
	 
    if ($user->first_name=='' && $user->last_name=='') {
				
		$affiliate->setFirstname($user->nickname);
				
        $affiliate->setLastname(' ');
				
        } else {
				
            $affiliate->setFirstname(($user->first_name=='')?' ':$user->first_name);
				
            $affiliate->setLastname(($user->last_name=='')?' ':$user->last_name);
				
        }
			
	return $affiliate;
			
}

function rc_register_new_user( $login,$email,$error ) {

}


function debug_to_console( $data ) {

    if ( is_array( $data ) )
		
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
		
    else
		
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
	
}


function rc_check_quantity($order_id) {
	if(get_option('rc_woocommerce')=='true'){
		
	$order = new WC_Order( $order_id );
	
	$aff_id = get_option('rc_PanAccountId');
	
	$total = $order->get_total();
	
	$items = $order->get_items();
	
	foreach ( $items as $item ) {
		
		$product_id = $item['product_id'];
		
	}

	$url = 'http://affiliate.yourcloudaround.com/scripts/savereg.php';
	
	$response = wp_remote_post( $url, array(
	
	'method' => 'POST',
	
	'body'=>array('QueryType'=>'createSale','account_id'=>$aff_id,'order_id'=>$order_id,'total'=>$total,'product_id'=>$product_id)));

		
	}

	
}

function rc_addContactForm7ContactCommission($form){
	
	if(get_option('rc_form_seven')=='true'){
	
		$form_name = $form->title;
	
		$submission = WPCF7_Submission::get_instance();
  
		if ( $submission ) {
			
			$posted_data = $submission->get_posted_data();
			
		}
		
		$rc_contact_seven_form_name = get_option('rc_contact_seven_form_name');
		
		if ($form_name ==$rc_contact_seven_form_name || $rc_contact_seven_form_name=="All") {
     
			$commissions =  get_option('rc_contact_seven_commissions');
			
			$company =  get_option('rc_contact_seven_company_id');
			
			$aff_id = get_option('rc_PanAccountId');
			
			$url = 'http://affiliate.yourcloudaround.com/scripts/savereg.php';
			
			$response = wp_remote_post( $url, array(
			'method' => 'POST',
			'body'=>array('QueryType'=>'createFromContactForm','account_id'=>$aff_id,'campaign_id'=>$company,'total'=>$commissions)));
			 
		}
		
	}
	
}

function rc_get_Contact_Form_Forms(){
	
		global $wpdb;
		
		$querystr = "SELECT ID, post_title FROM wp_posts WHERE `post_type` = 'wpcf7_contact_form'";
		
		$forms = $wpdb->get_results($querystr);
		
		$data[0]='All';
		
			foreach($forms as $form) {
				
				$data[] = $form->post_title;	
				
			}
		
		echo json_encode($data);
		die();
	
}

function rc_get_RoundCloud_campaigns(){
	
		$session = new Gpf_Api_Session("http://affiliate.yourcloudaround.com/scripts/server.php");
	
		$login = get_option('rc_PanEmail');
		$pass = get_option('rc_PanPassword');
	
		if(!$session->login($login,$pass)) {
	
			$output = Array('status' => 'error', 'text' =>'Cannot login. Message: '.$session->getMessage(), 'QueryType' => 'Registration');
			echo json_encode($output);
			exit;
			
		}else{
		
			$request = new Gpf_Rpc_GridRequest("Pap_Merchants_Campaign_CampaignsGrid", "getRows", $session);
			
			$request->setLimit(0, 9999);
			
			$request->addParam('columns', new Gpf_Rpc_Array(array(array('id'), array('id'))));
        
			$filters = new Gpf_Rpc_Array();
			$filters->add(new Gpf_Data_Filter('rstatus', 'NE', 'D'));
			$filters->add(new Gpf_Data_Filter('rstatus', 'NE', 'S'));
			$filters->add(new Gpf_Data_Filter('rstatus', 'NE', 'W'));        
                
			$request->addParam('filters', $filters);
			
			try {
				
				$request->sendNow();
				
			} catch(Exception $e) {
				
				return null;
				
			}
			$grid = $request->getGrid();
			
			$campaignList = $grid->getRecordset();
			
			$parray = array();
			
			foreach($campaignList as $campaign) {
			
				$partarray=array("company_id" => $campaign->get('id'),"company_name" => $campaign->get('name'));
				
				array_push($parray,$partarray);
			}
			
			$result = array("status"=>"Y","data"=>$parray);
			
			echo json_encode($result);
			
		}

}

function rc_get_RoundCloud_Top_Affiliates(){
	
		$session = new Gpf_Api_Session("http://affiliate.yourcloudaround.com/scripts/server.php");
		
		$login = get_option('rc_PanEmail');
		$pass = get_option('rc_PanPassword');
	
		if(!$session->login($login,$pass)) {
	
			$output = Array('status' => 'error', 'text' =>'Cannot login. Message: '.$session->getMessage(), 'QueryType' => 'Registration');
			echo json_encode($output);
			exit;
			
		}else{
		
			$request = new Gpf_Rpc_GridRequest("Pap_Merchants_User_TopAffiliatesGrid", "getRows", $session);

			$request->addParam('columns', new Gpf_Rpc_Array(array(array('id'), array('id'))));
        
			try {
			
				$request->sendNow();
			
			} catch(Exception $e) {
			
					_log('RoundCloud error Pap_Merchants_User_TopAffiliatesGrid message: '.$e->getMessage);
			
			}
			$grid = $request->getGrid();
		
			$affiliateList = $grid->getRecordset();
		
			$parray = array();
		
			foreach($affiliateList as $affiliate) {
			
				$partarray=array("affiliate_id" => $affiliate->get('userid'),"affiliate_name" => $affiliate->get('username'));
			
				array_push($parray,$partarray);
			
			}
		
			$result = array("status"=>"Y","data"=>$parray);
		
			echo json_encode($result);
		
		}
}

function rc_load_scripts_to_head(){
	if(get_option('rc_clicktracking')=='true'){
			
			$AccountName=get_option("rc_PanAccountId");
		
			?><script type="text/javascript">
					  document.write(unescape("%3Cscript id=\'pap_x2s6df8d\' src=\'" + (("https:" == document.location.protocol) ? "https://" : "http://") + 
					  "affiliate.yourcloudaround.com/scripts/trackjs.js\' type=\'text/javascript\'%3E%3C/script%3E")); 
                      </script>
                    <script type="text/javascript"> 
					  PostAffTracker.setAccountId('<?php echo $AccountName ?>');
                      try {
                      PostAffTracker.track();
                      } catch (err) {
					
					  }
                      
                      </script><?php
	
	}else{
		
	}
}

if(!function_exists('_log')){
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}

add_action('wpcf7_mail_sent','rc_addContactForm7ContactCommission');
add_action('woocommerce_thankyou', 'rc_check_quantity',10);
add_action('user_register', 'rc_onNewUserRegistration');
add_action('register_post', 'rc_register_new_user',10,3);
add_action('wp_head','rc_load_scripts_to_head');
add_action('wp_ajax_nopriv_get_affiliate_id', 'rc_get_affiliate_id_front_end' );
add_action('wp_ajax_get_RoundCloud_Top_Affiliates', 'rc_get_RoundCloud_Top_Affiliates' );
add_action('wp_ajax_get_RoundCloud_campaigns', 'rc_get_RoundCloud_campaigns' );
add_action('wp_ajax_get_Contact_Form_Forms', 'rc_get_Contact_Form_Forms' );
add_action('wp_ajax_get_affiliate_id', 'rc_get_affiliate_id' );
add_action('wp_ajax_update_option', 'rc_update_option' );
add_action('wp_ajax_set_option', 'rc_set_option' );
add_action('wp_ajax_get_option', 'rc_get_option' );
add_action('wp_ajax_rc_logout', 'rc_full_logout' );
add_action('plugins_loaded', 'rc_init');
add_action('init', 'add_my_script');
add_action('admin_menu','rc_userlist_init');

?>