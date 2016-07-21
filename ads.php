<?php
/*
Plugin Name: Inventiv Advertisement Manager
Plugin URI: http://inventiv.ph/
Version: 
Author: Inventiv Media Inc
Description:Inventiv Advertisement Manager
*/	

global $jal_db_version;
$jal_db_version = '1.0';

require_once(plugin_dir_path( __FILE__ ).'onboard.php');
function jal_install() {
	global $wpdb;
	global $jal_db_version;
	$onboard_table_ads = $wpdb->prefix . 'onboard_ads';
	$onboard_table_advertiser = $wpdb->prefix . 'onboard_advertiser';
	$onboard_table_pricing = $wpdb->prefix . 'onboard_pricing';
	$onboard_table_ad_log = $wpdb->prefix . 'onboard_ad_log';
	
	$charset_collate = $wpdb->get_charset_collate();

	$ads_sql = "CREATE TABLE $onboard_table_ads (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		advertiser_id mediumint(9) NOT NULL,
		pricing_id mediumint(9) NOT NULL,
		name tinytext NOT NULL,
		ad_file tinytext NOT NULL,
		views mediumint(9) NOT NULL,
		status int NOT NULL,
		created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		UNIQUE KEY id (id)
	) $charset_collate;";

	
	$advertiser_sql = "CREATE TABLE $onboard_table_advertiser (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		email tinytext NOT NULL,
		contact_number tinytext NOT NULL,
		address tinytext NOT NULL,
		status int NOT NULL,
		created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		UNIQUE KEY id (id)
	) $charset_collate;";

	$pricing_sql = "CREATE TABLE $onboard_table_pricing (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		views tinytext NOT NULL,
		price tinytext NOT NULL,
		status int NOT NULL,
		created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		UNIQUE KEY id (id)
	) $charset_collate;";

	$log_sql = "CREATE TABLE $onboard_table_ad_log (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		ad_id int NOT NULL,
		post_id int NOT NULL,
		user_agent tinytext NOT NULL,
		log_date DATE NOT NULL,
		log_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		UNIQUE KEY id (id)
	) $charset_collate;";


	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta($log_sql);
	dbDelta($ads_sql );
	dbDelta($advertiser_sql);
	dbDelta($pricing_sql);
	
	add_option( 'jal_db_version', $jal_db_version );
}

register_activation_hook( __FILE__, 'jal_install' );

function get_serve_onboard_ad($postID) {
	global $wpdb;
	$onboard_table_ads = $wpdb->prefix . 'onboard_ads';
	$q = "SELECT * FROM $onboard_table_ads  WHERE status=1 ORDER BY RAND() LIMIT 2";
	$ads = $wpdb->get_results($q);
	foreach ($ads as $ad) {
		if($postID) {
			add_onboard_ad_logs($ad->id, $postID);
		}
	}
	return $ads;
}


function add_onboard_ad_logs($ad_id, $post_id) {
	date_default_timezone_set('Asia/Manila');
	global $wpdb;
	require_once( ABSPATH . '/wp-load.php' );
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$today = date('Y-m-d');
	$onboard_table_ad_log = $wpdb->prefix . 'onboard_ad_log';
	$onboard_table_ads = $wpdb->prefix . 'onboard_ads';
	 $wpdb->insert( $onboard_table_ad_log, array(
	    'ad_id' => $ad_id,
	    'post_id' => $post_id,
	    'user_agent' => $user_agent,
	    'log_date' => $today,
	  ) );
	 $update_sql = "UPDATE  $onboard_table_ads SET  views =  views+1 WHERE  id =".$ad_id;
	 $wpdb->query($update_sql);
}





// JS
//function onboard_script() {
	wp_enqueue_script('jquery');
	//wp_register_script('prefix_bootstrap', plugins_url('/js/bootstrap.js',__FILE__ ));
	wp_enqueue_script('prefix_bootstrap');
	wp_register_script('prefix_charts', plugins_url('/js/Chart.bundle.js',__FILE__ ));
	wp_enqueue_script('prefix_charts');


	// CSS
	wp_register_style('prefix_bootstrap', plugins_url('/css/bootstrap.css',__FILE__ ));
	wp_enqueue_style('prefix_bootstrap');

//}

add_action('admin_menu', 'ad_plugin_setup_menu');
add_action( 'admin_action_wpse10500', 'wpse10500_admin_action' );
function wpse10500_admin_action()
{
   	global $wpdb;
	require_once( ABSPATH . '/wp-load.php' );
	if(isset($_POST['add-advertiser'])) {
		//$_POST
		$onboard = new Onboard_Model();
		$onboard->init($wpdb);
		$onboard->new_advertiser($_POST);
		
	}

	if(isset($_POST['add-pricing'])) {
		//$_POST
		$onboard = new Onboard_Model();
		$onboard->init($wpdb);
		$onboard->new_pricing($_POST);
	}
	//new-ad

	if(isset($_POST['new-ad'])) {
		//$_POST
		$onboard = new Onboard_Model();
		$onboard->init($wpdb);
		$onboard->new_ad($_POST);
	}

	wp_redirect( $_SERVER['HTTP_REFERER'] );
	exit();
  
}
function ad_plugin_setup_menu(){
        add_menu_page( 'Ads Management', 'Ads', 'manage_options', 'ads-inventiv', 'stat_views_onboard' );
        // sub menus---------------
        add_submenu_page('ads-inventiv', 'View Ads', 'View Ads', 'manage_options', 'view-ads-inventiv', 'view_ads_onboard' );
         add_submenu_page('ads-inventiv', 'Create Ads', 'Create Ads', 'manage_options', 'create-ads-inventiv', 'create_new_ads_onboard' );
        /*add_submenu_page('ads-inventiv', 'Statistics', 'Statistics', 'manage_options', 'stats-ads-inventiv', 'stat_views_onboard' );*/
        add_submenu_page('ads-inventiv', 'Advertiser ', 'Advertisers', 'manage_options', 'add-advertiser-inventiv', 'add_new_advertiser_onboard' );
    	add_submenu_page('ads-inventiv', 'Price ', 'Pricing', 'manage_options', 'add-pricing-inventiv', 'add_new_pricing_onboard' );
}
 
function main_init_onboard(){
        echo "<h1>Main Dashboard</h1>";
}



function  create_new_ads_onboard(){
	global $wpdb;
	require_once( ABSPATH . '/wp-load.php' );
	$onboard = new Onboard_Model();
	$onboard->init($wpdb);
	$advertisers = $onboard->get_advertisers();
	$pricing = $onboard->get_pricing();
	require_once(plugin_dir_path( __FILE__ ).'admin/createads.php');
}
function  view_ads_onboard(){
	global $wpdb;
	require_once( ABSPATH . '/wp-load.php' );
	$onboard = new Onboard_Model();
	$onboard->init($wpdb);
	$ads = $onboard->get_ads();
	require_once(plugin_dir_path( __FILE__ ).'admin/viewads.php');
}
function  stat_views_onboard(){
	global $wpdb;
	require_once( ABSPATH . '/wp-load.php' );
	$onboard = new Onboard_Model();
	$onboard->init($wpdb);
	$advertisers = $onboard->get_advertisers(); 
	$today_log = $onboard->get_today_log();
	$total_log = $onboard->get_log();
	$get_last_days = $onboard->get_last_days(7);

	require_once(plugin_dir_path( __FILE__ ).'admin/stats.php');
}




function  add_new_advertiser_onboard(){
	global $wpdb;
	require_once( ABSPATH . '/wp-load.php' );
	$onboard = new Onboard_Model();
	$onboard->init($wpdb);
	$advertisers = $onboard->get_advertisers();
	require_once(plugin_dir_path( __FILE__ ).'admin/advertiser.php');
}


function  add_new_pricing_onboard(){
	global $wpdb;
	require_once( ABSPATH . '/wp-load.php' );
	$onboard = new Onboard_Model();
	$onboard->init($wpdb);
	$pricing = $onboard->get_pricing();
	require_once(plugin_dir_path( __FILE__ ).'admin/pricing.php');
	
}





?>