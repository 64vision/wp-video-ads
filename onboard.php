<?php
class Onboard_Model {
	//var $onboard_advertiser = $wpdb->prefix . 'onboard_advertiser';
	var $_wpdb;
	var $advertiser_table;
	var $ads_table;
	var $pricing_table;
	var $log_table;
	function init($wpdb) {
		$this->_wpdb = $wpdb;
		$this->advertiser_table = $wpdb->prefix . 'onboard_advertiser';
		$this->ads_table = $wpdb->prefix . 'onboard_ads';
		$this->pricing_table = $wpdb->prefix . 'onboard_pricing';
		$this->log_table = $wpdb->prefix . 'onboard_ad_log';
	}
	function new_advertiser($params)
	{
		$wpdb =$this->_wpdb;
		 $wpdb->insert($this->advertiser_table, array(
			'name' => $params['comp_name'],
			'email' => $params['comp_email'],
			'contact_number' => $params['comp_number'],
			'status' => 1,
		  ) );
	}

	function new_pricing($params)
	{
		$wpdb =$this->_wpdb;
		$params['status'] = 1;
		 $wpdb->insert($this->pricing_table, array(
			'name' => $params['name'],
			'views' => $params['views'],
			'price' => $params['price'],
			'status' => 1,
		  ) );
	}

	function new_ad($params)
	{
		$wpdb =$this->_wpdb;
		$params['status'] = 1;
		 $wpdb->insert($this->ads_table, array(
			'advertiser_id' => $params['advertiser_id'],
			'pricing_id' => $params['pricing_id'],
			'name' => $params['name'],
			'ad_file' => $params['ad_file'],
			'status' => 1,
		  ) );
	}

	function get_advertisers() {
		$wpdb =$this->_wpdb;
		$q = "SELECT * FROM $this->advertiser_table";
		return $wpdb->get_results($q);
		
	}

	function get_ads() {
		$wpdb =$this->_wpdb;
		$q = "SELECT * FROM $this->ads_table";
		return $wpdb->get_results($q);
		
	}

	function get_pricing() {
		$wpdb =$this->_wpdb;
		$q = "SELECT * FROM $this->pricing_table";
		return $wpdb->get_results($q);
		
	}

	function get_today_log() {
		date_default_timezone_set('Asia/Manila');
		$wpdb =$this->_wpdb;
		$today = date('Y-m-d');
		$q = "SELECT * FROM $this->log_table WHERE log_time LIKE '%".$today."%'";
		return $wpdb->get_results($q);
	}

	function get_log() {
		$wpdb =$this->_wpdb;
		$q = "SELECT * FROM $this->log_table";
		return $wpdb->get_results($q);
	}

	function get_last_days($days) {
		$wpdb =$this->_wpdb;
		/*$now = new DateTime( "$days days ago", new DateTimeZone('Asia/Manila'));
		$interval = new DateInterval( 'P1D'); 
		$period = new DatePeriod( $now, $interval, $days);
		$period_array = array();
		$result_array = array();
		$cnt = 0;
		foreach( $period as $day) {
		   $period_array[$cnt] = $day;
			$cnt++;
		}
		$start = $period_array[$days-$days]->format('Y-m-d 00:00:00');
		$end = $period_array[$days]->format('Y-m-d H:i:s');
		*/
		$q = "SELECT MONTH(log_time) as m, DAY(log_time) as d, count(*) as views FROM $this->log_table GROUP BY  DAY(log_time)";
		$result =  $wpdb->get_results($q);
		return $result;
		
	}
}
?>