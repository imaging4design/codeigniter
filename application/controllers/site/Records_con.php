<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Records_con extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		// AUTOLOADED FILES
		// Helpers: 	global
		// Models: 		global_model
		// Config: 		anz_settings
		// Libraries:	auth
		$this->load->model('site/records_model');
		
	}

	
	/*************************************************************************************/
	// FUNCTION index()
	// Displays home page content including Athlete and Ranking search panels
	/*************************************************************************************/
	public function index()
	{
		// Get records data from database
		if($query = $this->records_model->get_outdoor_records())
		{
			//$result['token'] = $this->auth->token();
			$result['get_records'] = $query;
			echo json_encode($result);
		}
			
		// $data['main_content'] = 'site/records';
		// $this->load->view('site/includes/template', $data);
	
	} // ENDS index()
	

	
	
	/*************************************************************************************/
	// FUNCTION get_records()
	// Displays NZ Records based upon user selection
	/*************************************************************************************/
	public function get_records()
	{
		$this->form_validation->set_rules('recordType', 'Record Type', 'trim|required');
		$this->form_validation->set_rules('in_out', 'Indoors / Outdoors', 'trim|required');
		$this->form_validation->set_rules('ageGroup', 'Age Group', 'trim|required');
		
		if($this->form_validation->run() == TRUE ) 
		{
			if($query = $this->records_model->get_outdoor_records())
			{
				$data['get_records'] = $query;
			}
		}
		else
		{
			 $this->error_message = validation_errors('<div class="message_error">', '</div>') . '<br />';
		}
		
		//$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/records';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS get_records()



	/*************************************************************************************/
	// FUNCTION forms()
	// Displays (records) page to show Record Application Forms
	/*************************************************************************************/
	public function forms()
	{
		//$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/recordForms';
		$this->load->view('site/includes/template', $data);
	
	} // ENDS forms()
	
	
	
	
} //ENDS Records class