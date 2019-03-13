<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Multis_Model extends CI_Model
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
		
		$this->ageGroup = $this->input->get('ageGroup');
		$this->eventID 	= $this->input->get('eventID');
		
		
		/*****************************************************/
		// COMBINE ALL AGE GROUPS IN OPEN LISTS
		/*****************************************************/
		// Example: Mens Decathlon
		// MS, M20 and M19 should all appear in the (MS) Mens Open list
		// as ALL implements and hurdle heights are the same in each ageGroup
		
		
		// Check the value of $this->input->post('eventID')
		// If it appears in the array $this->config->item('open_events_men')
		// && $this->ageGroup == 'MS' then ALL ageGroups in this event will appear in the Mens Open list 
		
		if(in_array($this->eventID, $this->config->item('multi_events')) && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS'";
		}
		
		// Womens version of above
		if(in_array($this->eventID, $this->config->item('multi_events')) && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		
		/*************************************************************************/
		// Work out YEAR posted.
		// 0 = ALL years
		/*************************************************************************/
		if($this->input->get('year') == 1900)
		{
			$this->year = "YEAR(resMulti.date) >=  1900";
		}
		else
		{
			$this->year = "YEAR(resMulti.date) = ". $this->input->get('year');
		}

		
		/*****************************************************/
		// EXPLAIN :: $this->group_by
		/*****************************************************/
		// This determinds if rankings are listed by
		// Athletes or Performances
		if($this->input->get('list_type') == 0)
		{
			$this->group_by = 'resMulti.athleteID';
		}
		else
		{
			$this->group_by = 'resMulti.resultID';
		}


		/*****************************************************/
		// EXPLAIN :: $this->limit_by
		/*****************************************************/
		// This determinds the list depth
		// If ALL TIME selected only show top 20, else show users selection
		
		if($this->input->get('year') == 1900)
		{
			$this->limit_by = '10000';
		}
		else
		{
			$this->limit_by = $this->input->get('list_depth');
		}
		
		
		/*****************************************************/
		// IMPORTANT NOTE!
		/*****************************************************/
		// If we are going to use the WHERE IN () clause
		// we must include each ageGroup in parentheses ''
		// Example: W19 = 'W19'
		
		$ages = array('MS','M20','M19','M17','WS','W20','W19','W17');
		
		if(in_array($this->ageGroup, $ages))
		{
			$this->ageGroup = "'$this->ageGroup'";
		}



		/*****************************************************/
		// EXPLAIN :: ALL TIME LISTS - 'Performance Limits'
		/*****************************************************/
		// All Time Lists will only display performances 'greater' than the original 20th mark initially supplied
		// Example: In the men's 100m the original 20th mark was 10.53. Therefore, only show future performances greater than this (10.53) on this list

		
		// Work out what 'config->item' list to pass
		$config_gender_list = ( $this->input->get( 'ageGroup' ) == 'MS' ) ? 'all_time_men' : 'all_time_women';


		if( $this->input->get( 'year' ) == 1900 )
		{
			foreach( $this->config->item( $config_gender_list ) as $key => $value)
			{
				if( $this->eventID == $key && in_array( $this->eventID, $this->config->item( 'multi_events' ) ) )
				{
					$this->alltime_limit = 'AND resMulti.points >= '.$value;
				}
			}
		}
		else
		{
			$this->alltime_limit = 'AND resMulti.points >= 0';
		}

		// Do NOT display results for Men Heptathlon and Women Decathlon etc!
		foreach( $this->config->item( $config_gender_list ) as $key => $value ):

			if( $this->eventID == $key && $value == 'xxxxxxx') 
			{
				$this->alltime_limit = 'AND resMulti.points < 0';
			}

		endforeach;
		
		
		
	} //ENDS __construct()
	
	
	
	
	
	/*************************************************************************************/

	// START MYSQL ACTIVE QUERIES

	/*************************************************************************************/
	
	/*************************************************************************************/
	// FUNCTION multis()
	// Retrieves ALL results for multi events based on the above exceptions
	/*************************************************************************************/
	public function multis()
	{
		$query = $this->db->query("
															
		SELECT *, DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(resMulti.date, '%d %b %Y') AS date
			FROM (SELECT * FROM resMulti AS resMulti
			WHERE resMulti.eventID = " . $this->eventID . " 
			".$this->alltime_limit."
			AND " . $this->year . " 
			AND resMulti.ageGroup IN (" . $this->ageGroup . ")
			ORDER BY resMulti.points DESC, resMulti.date ASC, resMulti.resultID ASC) AS resMulti
		LEFT JOIN athletes AS athletes ON (athletes.athleteID = resMulti.athleteID)
		GROUP BY " . $this->group_by . "  
		ORDER BY resMulti.points DESC, resMulti.date ASC, resMulti.resultID asc 
		LIMIT " . $this->limit_by . "");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS multis()
	
		
	
		
} // ENDS class Multis_Model