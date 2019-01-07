<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Results_Model extends CI_Model
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
		// Example: Mens 100m
		// MS, M20, M19 and M17 should all appear in the (MS) Mens Open list
		// There are no implements or hurdle heights affecting these events
		
		
		// Check the value of $this->input->post('eventID')
		// If it appears in the array $this->config->item('open_events_men')
		// && $this->ageGroup == 'MS' then ALL ageGroups in this event will appear in the Mens Open list 
		
		if(in_array($this->eventID, $this->config->item('open_events_men')) && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19', 'M17', 'M16'";
		}
		
		// Womens version of above
		if(in_array($this->eventID, $this->config->item('open_events_women')) && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19', 'W17', 'W16'";
		}
		
		
		// Check the value of $this->input->post('eventID')
		// If it appears in the array $this->config->item('track_events_wind')
		// create the appropriate wind parameters for the query (AND where_in)
		if(in_array($this->eventID, $this->config->item('track_events_wind')))
		{
			$this->wind = "'nwr', ''";
		}
		else
		{
			$this->wind = "'nwr'";
		}
		
		/*****************************************************/
		// COMBINE LIMITED AGE GROUPS IN OPEN LISTS
		/*****************************************************/
		// In certain cases we only need to combine SOME of the younger 
		// ageGroups into the (MS/WS) open lists where they use the 
		// same implement weights/heights as the seniors
		
		// Example: Mens Javelin Throw
		// M20 and M19 use 800gm javelin, so these rankings
		// need to be included in the Mens Senior (MS) lists.
		/*****************************************************/
		
		/*****************************************************/
		// MENS HURDLES / STEEPLECHASE
		/*****************************************************/
		// 400m Hurdles (Combine MS / M20 / M19)
		if($this->eventID == 25 && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19'";
		}
		
		// 3000m Steeplechase (Combine MS / M20 / M19)
		if($this->eventID == 21 && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19'";
		}
		
		/*****************************************************/
		// MENS THROWS
		/*****************************************************/
		// Mens Javelin (Combine MS / M20 / M19)
		if($this->eventID == 33 && $this->ageGroup == 'MS')
		{
			$this->ageGroup = "'MS', 'M20', 'M19'";
		}
		
		/*****************************************************/
		// WOMENS HURDLES / STEEPLECHASE
		/*****************************************************/
		// 100m Hurdles (Combine WS / W20 / W19)
		if($this->eventID == 22 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		if($this->eventID == 25 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		// 3000m Steeplechase (Combine WS / W20 / W19)
		if($this->eventID == 21 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		/*****************************************************/
		// WOMENS THROWS
		/*****************************************************/
		// Shot Put (Combine WS / W20 / W19)
		if($this->eventID == 30 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		// Hammer (Combine WS / W20 / W19)
		if($this->eventID == 32 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		// Javelin (Combine WS / W20 / W19)
		if($this->eventID == 33 && $this->ageGroup == 'WS')
		{
			$this->ageGroup = "'WS', 'W20', 'W19'";
		}
		
		
		/*************************************************************************/
		// Work out YEAR posted.
		// 0 = ALL years
		/*************************************************************************/
		if($this->input->get('year') == 1900)
		{
			$this->year = "YEAR(results.date) >  1900";
		}
		else
		{
			$this->year = "YEAR(results.date) = ". $this->input->get('year');
		}
		
		
		/*****************************************************/
		// EXPLAIN :: $this->track_or_field
		// EXPLAIN :: $this->order_by
		/*****************************************************/
		// $this->track_or_field will tell the query to either
		// search by time (track events) or distHeight (field events)
		// $this->order_by will order the results correctly
		
		if(in_array($this->eventID, $this->config->item('track_events')))
		{
			$this->track_or_field = "MIN(time) AS time";
			$this->order_by = "time ASC";
		}
		else
		{
			$this->track_or_field = "MAX(distHeight) AS distHeight";
			$this->order_by = "distHeight DESC";
		}
		
		
		/*****************************************************/
		// EXPLAIN :: $this->group_by
		/*****************************************************/
		// This determinds if rankings are listed by
		// Athletes or Performances
		
		if($this->input->get('list_type') == 0)
		{
			$this->group_by = 'results.athleteID';
		}
		else
		{
			$this->group_by = 'results.resultID';
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
		// Example: W20 = 'W20' and  W19 = 'W19' etc ...
		
		$ages = array('MS','M20','M19','M17','M16','WS','W20','W19','W17','W16');
		
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
				if( $this->eventID == $key && in_array( $this->eventID, $this->config->item( 'track_events' ) ) )
				{
					$this->alltime_limit = "AND results.time <= '$value' "; // Note 'quatation' marks around '$value' - important in comparing string values <= & >=
				}

				if( $this->eventID == $key && in_array( $this->eventID, $this->config->item( 'field_events' ) ) )
				{
					$this->alltime_limit = 'AND results.distHeight >= '.$value;
				}
			}
		}
		else
		{
			$this->alltime_limit = 'AND results.time >= 0';
		}

		// Do NOT display results for events NOT included in the All Time events! (Only applies to Track events)!
		// foreach( $this->config->item( $config_gender_list ) as $key => $value ):

		// 	if( $this->eventID == $key && $value == 'xxxxxxx') 
		// 	{
		// 		$this->alltime_limit = 'AND results.time < $value';
		// 	}

		// endforeach;


		
		
		
		
	} //ENDS __construct()
	
	
	
	
	
	/*************************************************************************************/

	// START MYSQL ACTIVE QUERIES

	/*************************************************************************************/
	
	/*************************************************************************************/
	// FUNCTION results()
	// Retrieves ALL results for individual events based on the above exceptions
	// Irrelevant of wind, but DO NOT include hand timing
	/*************************************************************************************/
	public function results()
	{
		$query = $this->db->query("
															
		SELECT *, " . $this->track_or_field . ", DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM (SELECT * FROM results AS results
			WHERE results.eventID = " . $this->eventID . "
			".$this->alltime_limit."
			AND " . $this->year . " 
			AND results.ageGroup IN (" .$this->ageGroup . ")
			AND results.record NOT IN ('ht')
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID ASC) AS results
		INNER JOIN athletes AS athletes USING (athleteID)  
		GROUP BY " . $this->group_by . "  
		ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc 
		LIMIT " . $this->limit_by . "");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS results()
	
	
	
	/*************************************************************************************/
	// FUNCTION results_legal_wind()
	// Retrieves ALL results for individual events based on the above exceptions
	// Legal wind readings (< 2.1 m/s)
	/*************************************************************************************/
	public function results_legal_wind()
	{
		$query = $this->db->query("
															
		SELECT *, " . $this->track_or_field . ", DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM (SELECT * FROM results AS results
			WHERE results.eventID = " . $this->eventID . "
			".$this->alltime_limit."
			AND " . $this->year . " 
			AND results.ageGroup IN (" . $this->ageGroup . ")
			AND results.wind <= 2.0
			AND results.wind NOT IN ('nwr')
			AND results.record NOT IN ('ht')
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID ASC) AS results
		INNER JOIN athletes AS athletes USING (athleteID)  
		GROUP BY " . $this->group_by . "  
		ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc 
		LIMIT " . $this->limit_by . "");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS results_legal_wind()
	
	
	
	/*************************************************************************************/
	// FUNCTION results_illegal_wind()
	// Retrieves ALL results for individual events based on the above exceptions
	// Illegal wind readings (> 2.0 m/s)
	/*************************************************************************************/
	public function results_illegal_wind()
	{
		$query = $this->db->query("
															
		SELECT *, " . $this->track_or_field . ", DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM (SELECT * FROM results AS results
			WHERE results.eventID = " . $this->eventID . " 
			AND " . $this->year . " 
			AND results.ageGroup IN (" . $this->ageGroup . ")
			AND results.wind > 2.0
			AND results.record NOT IN ('ht')
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID ASC) AS results
		INNER JOIN athletes AS athletes USING (athleteID)  
		GROUP BY " . $this->group_by . "  
		ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc 
		LIMIT 10");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS results_illegal_wind()
	
	
	
	/*************************************************************************************/
	// FUNCTION results_hand_timed()
	// Retrieves ALL results for individual events based on the above exceptions
	// Hand-Timed (ht) performances only
	// Wind Legal (ignore 'nwr' and '') for wind affected events
	// Wind (include 'nwr' and '') for non-wind affected events
	/*************************************************************************************/
	public function results_hand_timed()
	{
		$query = $this->db->query("
															
		SELECT *, " . $this->track_or_field . ", DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB, DATE_FORMAT(results.date, '%d %b %Y') AS date
			FROM (SELECT * FROM results AS results
			WHERE results.eventID = " . $this->eventID . " 
			AND " . $this->year . " 
			AND results.ageGroup IN (" . $this->ageGroup . ")
			AND results.wind NOT IN (" . $this->wind . ")
			AND results.record = 'ht'
			ORDER BY " . $this->order_by . ", results.date ASC, results.resultID ASC) AS results
		INNER JOIN athletes AS athletes USING (athleteID)  
		GROUP BY " . $this->group_by . "  
		ORDER BY " . $this->order_by . ", results.date ASC, results.resultID asc 
		LIMIT 10");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS results_hand_timed()




	/*************************************************************************************/
	// FUNCTION legal_vs_windy($athleteID)
	// USED IN THE OPEN RANKING LISTS !
	// This determinds an athletes best 'LEGAL (non-windy)' performance by $athleteID, $eventID and $this->input->post('year')
	// WHY? .. So we can check if an athletes best 'ILLEGAL (wind-aided)' is superior.
	// If true - we display that performance in the 'Wind-Aided' section of the rankings as a notable performance
	// If false - don't bother displaying it as their legal performance is better anyway.
	/*************************************************************************************/
	public function legal_vs_windy($athleteID)
	{
		$this->db->select('date');
		$this->db->select_min('time', 'legal_time');
		$this->db->select_max('distHeight', 'legal_distHeight');
		$this->db->where('athletes.athleteID', $athleteID);
		$this->db->where('events.eventID', $this->eventID);

		$this->db->where('YEAR(results.date)', $this->input->get('year'));
		$this->db->where('results.wind <=', '2.0');

		$this->db->join('athletes', 'athletes.athleteID = results.athleteID');
		$this->db->join('events', 'events.eventID = results.eventID');
		$this->db->order_by('time', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('results');
		
		if($query->num_rows() > 0) 
		{
			return $query->row();
		}

	}


		
} // ENDS class Results_Model