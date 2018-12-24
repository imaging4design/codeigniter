<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Toplist_Model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

		// $this->ageGroup = ( $this->input->post('ageGroup') ) ? $this->input->post('ageGroup') : 'MS';
		
		if($this->input->get('ageGroup'))
		{
			$this->ageGroup = $this->input->get('ageGroup');
		}
		else
		{
			$this->ageGroup = 'MS';
		}

		// Work out the time period selected by user
		$numDays = $this->input->post( 'time_frame' ) -1;
		$this->start = date('Y-m-d', strtotime("now -$numDays days") );

		//$this->start = ( $this->input->post( 'time_frame' ) === 'week' ) ? date('Y-m-d', strtotime("now -5 days") ) : date('Y-m-d', strtotime("now -14 days") ); //Timeframe $_POSTed by user
		$this->end = date('Y-m-d'); // Todays date
		
	} //ENDS __construct()

	
	
	/*************************************************************************************/
	// FUNCTION topPerformers()
	// Displays the top performers for each year in each event on the homepage
	/*************************************************************************************/
	public function topPerformers()
	{
		
		$query = $this->db->query("
		
			SELECT events.eventID, events.eventName, results.ageGroup, results.competition, results.wind, in_out, results.record, results.venue, results.athleteID, MIN(results.time) AS time, MAX(results.distHeight) as distHeight, DATE_FORMAT(results.date, '%d %b %Y') as date, athletes.nameFirst, athletes.nameLast, athletes.coach, athletes.DOB, athletes.centreID, DATE_FORMAT(athletes.DOB, '%d %b %Y') as format_DOB
			FROM (
					SELECT * FROM results 
					WHERE results.ageGroup = '" . $this->ageGroup . "' AND YEAR(results.date) = '" . date('Y') . "' AND results.wind < 2.1 AND results.wind != 'nwr' AND results.record != 'ht'
					ORDER BY results.time ASC, results.distHeight DESC, results.date ASC
					) as results
			
			INNER JOIN athletes ON results.athleteID = athletes.athleteID 
			INNER JOIN events ON results.eventID = events.eventID 
			GROUP BY results.eventID 
			ORDER BY events.eventID ASC"

		);
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS topPerformers()
	
	
	
	/*************************************************************************************/
	// FUNCTION topPerformers_Multis()
	// Displays the top performances for Multi-Events for the homepage
	/*************************************************************************************/
	public function topPerformers_Multis()
	{
		
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(resMulti.date, '%d %b %Y') AS date", FALSE);
		$this->db->select("DATE_FORMAT(athletes.DOB, '%d %b %Y') AS format_DOB", FALSE);
		$this->db->where('ageGroup', $this->ageGroup);
		$this->db->where('YEAR(date)', date('Y'));
		$this->db->join('athletes', 'athletes.athleteID = resMulti.athleteID');
		$this->db->join('events', 'events.eventID = resMulti.eventID');
		$this->db->order_by('resMulti.points', 'DESC');
		$this->db->limit(1);
		
		$query = $this->db->get('resMulti');
		
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
		
	} //ENDS topPerformers_Multis()
	
	
	
	/*************************************************************************************/
	// FUNCTION topPerformers_Relays()
	// Displays the top performances for Relays for the homepage
	/*************************************************************************************/
	public function topPerformers_Relays()
	{
		
		$query = $this->db->query("
		
		SELECT *, DATE_FORMAT(results.date, '%d %b %Y') as date
	
			FROM (SELECT * FROM resRelays AS resRelays
			WHERE YEAR(resRelays.date) = '" . date('Y') . "'
			AND resRelays.ageGroup = '" . $this->ageGroup . "'
			ORDER BY resRelays.time ASC) AS results

		INNER JOIN events AS events USING (eventID)  
		GROUP BY events.eventID"

		);
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	} //ENDS topPerformers_Relays()



	/*************************************************************************************/
	// FUNCTION mostRecent()
	// Retrieves the most recent additions to the rankings database!
	/*************************************************************************************/
	public function mostRecent()
	{
		// SEE CONSTRUCTOR FUNCTION AT TOP
		// Work out the user $_POSTed 'timeframe' (i.e., 1 x day or 1 x week)
		// $start =  date('Y-m-d', strtotime("now -7 days") ); // User selected ($_POST) time period (1 week)
		// $start =  date('Y-m-d', strtotime("now -30 days") ); // User selected ($_POST) time period (1 month)

		// Work out the user selected Gender choice
		// Either Male (M) or Female (W)
		$gender = ( $this->input->post('gender') === 'men' ) ? 'M' : 'W';

		$this->db->select('*');
		$this->db->select("DATE_FORMAT(results.date, '%d %b %Y') AS date", FALSE);
		$this->db->select("DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB", FALSE);

		$this->db->where("date BETWEEN '$this->start' AND '$this->end'");
		$this->db->like('ageGroup', $gender, 'after'); 

		$this->db->join('athletes', 'athletes.athleteID = results.athleteID');
		$this->db->join('events', 'events.eventID = results.eventID');
		$this->db->order_by('events.eventID', 'ASC');
		$this->db->order_by('results.time', 'ASC');
		$this->db->order_by('results.distHeight', 'DESC');
		
		$query = $this->db->get('results');
		
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	} //ENDS mostRecent()



	/*************************************************************************************/
	// FUNCTION most_recent_multis()
	// Retrieves the most recent additions (Multi Events) to the rankings database!
	/*************************************************************************************/
	public function most_recent_multis()
	{
		// SEE CONSTRUCTOR FUNCTION AT TOP
		// Work out the user $_POSTed 'timeframe' (i.e., 1 x day or 1 x week)
		// $start =  date('Y-m-d', strtotime("now -7 days") ); // User selected ($_POST) time period (1 week)
		// $start =  date('Y-m-d', strtotime("now -30 days") ); // User selected ($_POST) time period (1 month)

		// Work out the user selected Gender choice
		// Either Male (M) or Female (W)
		$gender = ( $this->input->post('gender') === 'men' ) ? 'M' : 'W';

		$this->db->select('*');
		$this->db->select("DATE_FORMAT(resMulti.date, '%d %b %Y') AS date", FALSE);
		$this->db->select("DATE_FORMAT(athletes.DOB, '%d %b %Y') AS DOB", FALSE);

		$this->db->where("date BETWEEN '$this->start' AND '$this->end'");
		$this->db->like('ageGroup', $gender, 'after'); 

		$this->db->join('athletes', 'athletes.athleteID = resMulti.athleteID');
		$this->db->join('events', 'events.eventID = resMulti.eventID');
		$this->db->order_by('events.eventID', 'ASC');
		$this->db->order_by('resMulti.points', 'DESC');
		
		$query = $this->db->get('resMulti');
		
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	} //ENDS mostRecent()
	
	
	
		
} // ENDS class toplist_Model