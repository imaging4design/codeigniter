<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profiles_Model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();

		// WHAT IS $this->athleteID?

		// It is the posted 'athleteID' field from the 'auto-populate' input box in the 'Search Section'
		// This returns the athlete 'firstname', 'lastName' and 'id' (as the posted result)
		// Do a PHP string function to get the last 6 characters/digits
		// This will be the athlete(ID)

		// OR it might be the '$this->uri->segment(4)' if clicking the athletes 'name link' in the lists
		// OR it might be teh user clicking on the 'Quick Profile' icon on the main lists

		// Get and configure $athleteID
		if( $this->input->get('athleteID') && $this->input->get('auto_complete')) 
		{
			$this->athleteID = substr($this->input->get('athleteID'), -6);
		}
		elseif($this->uri->segment(4))
		{
			$this->athleteID = $this->uri->segment(4);
		}
		else
		{
			$this->athleteID = $this->input->get('athleteID');
		}

		
		
		/*************************************************************************/
		// Work out how to order athlete profile results (by date or performance)
		// Create exceptions for 'individual' events as well as 'multi' events
		/*************************************************************************/
		
		if($this->input->get('order_by') == 0)
		{
			// If in_array $this->config->item('multi_events') = Multi Event
			if(in_array($this->input->get('eventID'), $this->config->item('multi_events')))
				{
					$this->order_by = "resMulti.points DESC";
				}
				else
				{
					$this->order_by = "results.time ASC, results.distHeight DESC, results.date ASC";
				}
		}
		else
		{
			// If in_array $this->config->item('multi_events') = Multi Event
			if(in_array($this->input->get('eventID'), $this->config->item('multi_events')))
				{
					$this->order_by = "resMulti.date DESC";
				}
				else
				{
					$this->order_by = "results.date DESC";
				}
		}
		
		
		
		/*************************************************************************/
		// Work out YEAR posted.
		// 0 = ALL years
		// Create exceptions for 'individual' events as well as 'multi' events
		/*************************************************************************/
		
		if($this->input->get('year') == 0)
		{
			// If in_array $this->config->item('multi_events') = Multi Event
			if(in_array($this->input->get('eventID'), $this->config->item('multi_events')))
				{
					$this->year = "YEAR(resMulti.date) >=  2008"; // Use this if a multi event
				}
				else
				{
					$this->year = "YEAR(results.date) >=  2008"; // Use this if an individual event
				}
		}
		else
		{
			// If in_array $this->config->item('multi_events') = Multi Event
			if(in_array($this->input->get('eventID'), $this->config->item('multi_events')))
				{
					$this->year = "YEAR(resMulti.date) = ". $this->input->get('year'); // Use this if a multi event
				}
				else
				{
					$this->year = "YEAR(results.date) = ". $this->input->get('year'); // Use this if an individual event
				}
		}
			
		
	} // ENDS __construct()




	/*************************************************************************************/
	// FUNCTION show_athletes()
	// Display 'data grid' of ALL athletes who's lastname starts with 'A', 'B', 'C' etc ..
	/*************************************************************************************/
	// public function show_athletes()
	// {
	// 	$this->db->select('*');
	// 	$this->db->like('nameLast', $this->input->post('alpha'), 'after');
	// 	$this->db->join('results', 'results.athleteID = athletes.athleteID');
	// 	$this->db->join('centre', 'centre.centreID = athletes.centreID');
	// 	$this->db->group_by('athletes.athleteID');
	// 	$this->db->order_by('nameLast', 'ASC');
	// 	$this->db->order_by('nameFirst', 'ASC');
	// 	$query = $this->db->get('athletes');
		
	// 	if($query->num_rows() >0) 
	// 	{
	// 		return $query->result();
	// 	}
		
		
	// } //ENDS show_athletes()


	
	/*************************************************************************************/
	// FUNCTION born_this_day()
	// Shows Athletes born this day on home page
	/*************************************************************************************/
	public function born_this_day()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(athletes.DOB, '%d %b %Y') AS birthDate", FALSE);
		$this->db->where('MONTH(athletes.DOB)', date('m'));
		$this->db->where('DAY(athletes.DOB)', date('d'));
		$this->db->join('club', 'club.clubID = athletes.clubID');
		$this->db->join('centre', 'centre.centreID = athletes.centreID');
		$this->db->order_by('athletes.nameLast', 'ASC');
		$query = $this->db->get('athletes');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	} // ENDS born_this_day()

	
	
	/*************************************************************************************/
	// FUNCTION get_athlete_events()
	// Retrieve ALL events athlete has results against
	// Needed for the Profile Panel event dropdowm menu
	/*************************************************************************************/
	public function get_athlete_events()
	{
		$query = $this->db->query("
		
		SELECT * 
		FROM ((SELECT results.eventID FROM results WHERE results.athleteID = ".$this->athleteID.")
		UNION
		(SELECT resMulti.eventID FROM resMulti WHERE resMulti.athleteID = ".$this->athleteID.")) AS list_of_events
		INNER JOIN events ON list_of_events.eventID = events.eventID
		ORDER BY events.eventID ASC
		
		");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	} // ENDS get_athlete_events()
	
	
	/*************************************************************************************/
	// FUNCTION athlete()
	// Gets information about the athlete
	// i.e., Name, club, centre etc
	/*************************************************************************************/
	public function athlete()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(athletes.DOB, '%d %b %Y') AS birthDate", FALSE);
		$this->db->where('athletes.athleteID', $this->input->get('athleteID'));
		$this->db->join('club', 'club.clubID = athletes.clubID');
		$this->db->join('centre', 'centre.centreID = athletes.centreID');
		$query = $this->db->get('athletes');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	} // ENDS athlete()
	
	
	
	
	
	/***************************************************************************************************************************/
	
	// 1ST SET - MAIN QUERIES START HERE ....
	
	/***************************************************************************************************************************/
	
	
	/*************************************************************************************/
	// FUNCTION personal_bests()
	// Displays the Personal Best Performances of an athletes individual events 
	/*************************************************************************************/
	public function progessions($eventID)
	{
		$query = $this->db->query("
															
			SELECT *, MIN(r.time) AS MIN_time, MAX(r.distHeight) AS MAX_distHeight, DATE_FORMAT(r.date, '%Y') AS year, DATE_FORMAT(r.date, '%d %b %Y') AS date
			FROM
						
			(SELECT *
				FROM results
				WHERE athleteID = ".$this->athleteID."
				AND eventID = ".$eventID."
				AND record != 'ht'
				GROUP BY eventID, implement, resultID
				ORDER BY time ASC, distHeight DESC
			) AS rr
						
			JOIN results AS r
				ON r.time = rr.time
				AND r.distHeight = rr.distHeight
				AND r.resultID = rr.resultID
			
			INNER JOIN events AS e ON e.eventID = r.eventID
					
			GROUP BY YEAR(r.date), r.athleteID, r.eventID, r.implement
			ORDER BY YEAR(r.date), e.eventID ASC, r.implement DESC
					
		");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} // ENDS progessions($eventID)


	/*************************************************************************************/
	// FUNCTION progessions_multis()
	// Displays the Personal Best Performances of an athletes individual events 
	/*************************************************************************************/
	public function progessions_multis($eventID)
	{
		$query = $this->db->query("
															
			SELECT *, MAX(m.points) AS MAX_points, DATE_FORMAT(m.date, '%Y') AS year, DATE_FORMAT(m.date, '%d %b %Y') AS date
			FROM
						
			(SELECT *
				FROM resMulti
				WHERE athleteID = ".$this->athleteID."
				AND eventID = ".$eventID."
				GROUP BY eventID, resultID
				ORDER BY points DESC
			) AS mm
						
			JOIN resMulti AS m
				ON m.points = mm.points
				AND m.resultID = mm.resultID
			
			INNER JOIN events AS e ON e.eventID = m.eventID
					
			GROUP BY YEAR(m.date), m.athleteID, m.eventID
			ORDER BY YEAR(m.date), e.eventID ASC
					
		");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} // ENDS progessions_multis($eventID)


	/*************************************************************************************/
	// FUNCTION personal_bests()
	// Displays the Personal Best Performances of an athletes individual events 
	/*************************************************************************************/
	public function personal_bests()
	{
		$query = $this->db->query("
															
			SELECT *, MIN(r.time) AS MIN_time, MAX(r.distHeight) AS MAX_distHeight, DATE_FORMAT(r.date, '%d %b %Y') AS date
			FROM
						
			(SELECT *
				FROM results
				WHERE athleteID = ".$this->athleteID."
				AND wind <= 2.0
				AND wind != 'nwr'
				GROUP BY eventID, implement, resultID
				ORDER BY time ASC, distHeight DESC
			) AS rr
						
			JOIN results AS r
				ON r.time = rr.time
				AND r.distHeight = rr.distHeight
				AND r.resultID = rr.resultID
			
			INNER JOIN events AS e ON e.eventID = r.eventID
					
			GROUP BY r.athleteID, r.eventID, r.implement
			ORDER BY e.eventID ASC, r.implement DESC
					
		");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} // ENDS personal_bests()
	
	
	/*************************************************************************************/
	// FUNCTION personal_bests_multis()
	// Displays the Personal Best Performances of an athletes multi-events 
	/*************************************************************************************/
	public function personal_bests_multis()
	{
		$query = $this->db->query("
															
			SELECT *, DATE_FORMAT(r.date, '%d %b %Y') AS date
			FROM    (
			
			SELECT *, MAX(points) AS MAX_points
				FROM resMulti AS r
				WHERE r.athleteID = ".$this->athleteID."
				GROUP BY r.eventID
			) AS rr
			
			JOIN resMulti AS r
				ON r.points = rr.MAX_points 
				AND r.athleteID = rr.athleteID
			
			JOIN events e ON e.eventID = r.eventID
			
			ORDER BY e.eventID ASC

		");
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} // ENDS personal_bests_multis()
	
	
	
	/***************************************************************************************************************************/
	
	// 2ND SET - MAIN QUERIES START HERE ....
	
	/***************************************************************************************************************************/
	
	
	/*************************************************************************************/
	// FUNCTION athlete_data()
	// Display an athletes 'individual' event results
	/*************************************************************************************/
	public function athlete_data()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB", FALSE);
		$this->db->select("DATE_FORMAT(results.date, '%d %b %Y') AS date", FALSE);
		$this->db->where('athletes.athleteID', $this->input->get('athleteID'));
		$this->db->where('results.eventID', $this->input->get('eventID'));
		$this->db->where($this->year);
		$this->db->join('results', 'results.athleteID = athletes.athleteID');
		$this->db->join('events', 'events.eventID = results.eventID');
		$this->db->group_by('resultID');
		$this->db->order_by('implement', 'DESC');
		$this->db->order_by($this->order_by);
		
		$query = $this->db->get('athletes');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_data()
	
	
	/*************************************************************************************/
	// FUNCTION athlete_multi_data()
	// Display an athletes 'multi' event results
	/*************************************************************************************/
	public function athlete_multi_data()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB", FALSE);
		$this->db->select("DATE_FORMAT(resMulti.date, '%d %b %Y') AS date", FALSE);
		$this->db->where('athletes.athleteID', $this->uri->segment(4));
		$this->db->where('resMulti.eventID', $this->input->get('eventID'));
		$this->db->where($this->year);
		$this->db->join('resMulti', 'resMulti.athleteID = athletes.athleteID');
		$this->db->join('events', 'events.eventID = resMulti.eventID');
		$this->db->group_by('resultID');
		$this->db->order_by('ageGroup', 'DESC');
		$this->db->order_by($this->order_by);
		
		$query = $this->db->get('athletes');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS athlete_multi_data()


	/*************************************************************************************/
	// FUNCTION legal_vs_windy_profile($athleteID, $eventID, $year)
	// USED IN THE INDIVIDUAL ATHLETE PROFILES !
	// This determinds an athletes best 'LEGAL (non-windy)' performance by $athleteID, $eventID and $year
	// WHY? .. So we can check if an athletes best 'ILLEGAL (wind-aided)' is superior.
	// If true - we display that performance in the 'Wind-Aided' section of the rankings as a notable performance
	// If false - don't bother displaying it as their legal performance is better anyway.
	/*************************************************************************************/
	public function legal_vs_windy_profile($athleteID, $eventID, $year)
	{
		$query = $this->db->query("
															
			SELECT *, MIN(r.time) AS legal_time, MAX(r.distHeight) AS legal_distHeight, DATE_FORMAT(r.date, '%d %b %Y') AS date
			FROM
						
			(SELECT *
				FROM results
				WHERE athleteID = ".$athleteID."
				AND eventID = ".$eventID."
				AND YEAR(results.date) = ".$year." 
				AND wind <= 2.0
				AND wind NOT IN ('nwr')
				AND record != 'ht'
				GROUP BY eventID, implement, resultID
				ORDER BY time ASC, distHeight DESC
			) AS rr
						
			JOIN results AS r
				ON r.time = rr.time
				AND r.distHeight = rr.distHeight
				AND r.resultID = rr.resultID
			
			INNER JOIN events AS e ON e.eventID = r.eventID
					
			GROUP BY r.athleteID, r.eventID, r.implement
			ORDER BY e.eventID ASC, r.implement DESC
					
		");
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}

	}



	/*************************************************************************************/
	// FUNCTION get_representations()
	// Gets ALL the honours / representations of an athlete
	/*************************************************************************************/
	function get_representations($data)
	{
		$this->db->select('representations.id, representations.year, representations.competition, events.eventName, representations.performance, representations.position');
		$this->db->where('representations.athleteID', $data);
		$this->db->join('athletes', 'athletes.athleteID = representations.athleteID');
		$this->db->join('events', 'events.eventID = representations.eventID');
		$this->db->order_by('representations.year', 'ASC');
		$this->db->order_by('representations.id', 'ASC');
		$this->db->order_by('representations.competition', 'ASC');
		$query = $this->db->get('representations');

		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	}



	/*************************************************************************************/
	// FUNCTION get_nzchamps()
	// Gets ALL the NZ Championships Medals of an athlete
	/*************************************************************************************/
	function get_nzchamps($data)
	{
		$this->db->select('nzchamps.id, nzchamps.year, nzchamps.ageGroup, events.eventName, nzchamps.performance, nzchamps.position');
		$this->db->where('nzchamps.athleteID', $data);
		$this->db->join('athletes', 'athletes.athleteID = nzchamps.athleteID');
		$this->db->join('events', 'events.eventID = nzchamps.eventID');
		$this->db->order_by('nzchamps.year', 'ASC');
		$this->db->order_by('nzchamps.ageGroup', 'ASC');
		$query = $this->db->get('nzchamps');

		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	}
	
		
	
		
} // ENDS class Profiles_Model