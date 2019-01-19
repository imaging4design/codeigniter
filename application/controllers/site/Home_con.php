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
		$this->load->model('admin/global_model');
		$this->load->model('site/Toplist_model');

		date_default_timezone_set('Pacific/Auckland'); // Set defaut timezone .... otherwise 1 day out on localhost!
	}

	/*************************************************************************************/
	// FUNCTION get_auto_athletes()
	// Used to operate the 'auto complete' drop down athlete menu
	/*************************************************************************************/
	public function get_auto_athletes()
	{
		// If query returns TRUE
		if($query = $this->global_model->get_auto_athletes())
		{

			// Initiate $nameLast array()
			//$nameLast = [];
			
			// Loop through results and create an array
			//foreach($query as $row)
				
				// Pushes the passed variables onto the end of array ($nameLast)
				//array_push($nameLast, strtoupper($row->nameLast) . ', ' . $row->nameFirst . ' ' . $row->athleteID);

			//$result = $query;
			
			// Return data (json_encode)
			echo json_encode( $query );
		}
		
		
	} // ENDS get_auto_athletes()

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
