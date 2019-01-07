<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relays_Model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();
		
		/*****************************************************/
		// IMPORTANT!!!
		// BEFORE WE START
		/*****************************************************/
		// The $this->config->item('XXXXXXXX')
		// are config items imported from application/config/anz_settings.php
		
		
		/*****************************************************/
		// SET UP TWO KEY POST VARIABLES
		/*****************************************************/
		// $this->ageGroup will represent the value of the posted 'ageGroup'
		// $this->eventID will represent the value of the posted 'eventID'
		
		$this->ageGroup = $this->input->post('ageGroup');
		$this->eventID 	= $this->input->post('eventID');
		
		
		/*****************************************************/
		// COMBINE ALL AGE GROUPS IN OPEN LISTS
		/*****************************************************/
		// Example: Mens 100m
		// MS, M20, M19 and M17 should all appear in the (MS) Mens Open list
		// There are no implements or hurdle heights affecting these events
		
		
		// Check the value of $this->input->post('eventID')
		// If it appears in the array $this->config->item('open_events_men')
		// && $this->ageGroup == 'MS' then ALL ageGroups in this event will appear in the Mens Open list 
		
		if(in_array($this->eventID, $this->config->item('open_events_men')) && $this->ageGroup == 'MS')
		{
			$this->ageGroup = array('MS', 'M20', 'M19', 'M17', 'M16');
		}
		
		// Womens version of above
		if(in_array($this->eventID, $this->config->item('open_events_women')) && $this->ageGroup == 'WS')
		{
			$this->ageGroup = array('WS', 'W20', 'W19', 'W17', 'W16');
		}
		
		
		/*************************************************************************/
		// Work out YEAR posted.
		// 0 = ALL years
		/*************************************************************************/
		if($this->input->post('year') == 0)
		{
			$this->year = "YEAR(resRelays.date) >=  2008";
		}
		else
		{
			$this->year = "YEAR(resRelays.date) = ". $this->input->post('year');
		}
		
		
		/*****************************************************/
		// EXPLAIN :: $this->group_by
		/*****************************************************/
		// This determinds if rankings are listed by
		// Athletes or Performances
		
		if($this->input->post('list_type') == 0)
		{
			$this->group_by = 'results.athleteID';
		}
		else
		{
			$this->group_by = 'results.resultID';
		}
		
		
		/*****************************************************/
		// IMPORTANT NOTE!
		/*****************************************************/
		// If we are going to use the WHERE IN () clause
		// we must include each ageGroup in parentheses ''
		// Example: W20 = 'W20' and  W19 = 'W19' etc ...
		//
//		$ages = array('MS','M20','M19','M17','M16','WS','W20','W19','W17','W16');
//		
//		if(in_array($this->ageGroup, $ages))
//		{
//			$this->ageGroup = "'$this->ageGroup'";
//		}
		
		
		
		
	} //ENDS __construct()
	
	
	
	
	
	/*************************************************************************************/

	// START MYSQL ACTIVE QUERIES

	/*************************************************************************************/
	
	/*************************************************************************************/
	// FUNCTION relays()
	// Retrieves ALL relays results based on the above exceptions
	/*************************************************************************************/
	public function relays()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(resRelays.date, '%d %b %Y') AS date", FALSE);
		$this->db->where('resRelays.eventID', $this->input->post('eventID'));
		$this->db->where_in('resRelays.ageGroup', $this->ageGroup);
		$this->db->where($this->year);
		$this->db->order_by('time', 'ASC');
		$this->db->limit($this->input->post('list_depth'));
		$query = $this->db->get('resRelays');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS relays()
	
	
	
		
} // ENDS class Relays_Model