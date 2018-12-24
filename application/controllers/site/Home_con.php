<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		//$this->load->model('site/Profiles_model');
		//$this->load->model('site/News_model');
		$this->load->model('site/Toplist_model');

		date_default_timezone_set('Pacific/Auckland'); // Set defaut timezone .... otherwise 1 day out on localhost!
	}

	/*************************************************************************************/
	// FUNCTION index()
	// Displays home page content including Athlete and Ranking search panels
	// /*************************************************************************************/
	// public function index() {
	// 	$this->load->view('template/header');
	// 	$this->load->view('home');
	// 	$this->load->view('template/footer');
	// }

	public function showTopPerformers(){
		$result['topPerformers'] = topPerformers(); // from global_helper
		echo json_encode($result);
	}

	public function showTopMultis(){
		$result['topPerformers_Multis'] = topPerformers_Multis(); // from global_helper
		echo json_encode($result);
	}

	public function showTopRelays(){
		$result['topPerformers_Relays'] = topPerformers_Relays(); // from global_helper
		echo json_encode($result);
	}


}
