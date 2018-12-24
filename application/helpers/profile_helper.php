<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Helper function to retrieve views data for each page
* 
*/

/********************************************************************/
// FUNCTION athlete()
// Gets information about the athlete
// i.e., Name, club, centre etc
/********************************************************************/
function athlete()
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->athlete();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION athlete_age()
// Converts the Date of Birth into the actual 'age'
/********************************************************************/
function age_from_dob($dob) {

	$dob = strtotime($dob);
	$y = date('Y', $dob);

	if (($m = (date('m') - date('m', $dob))) < 0) {
		$y++;
	} elseif ($m == 0 && date('d') - date('d', $dob) < 0) {
		$y++;
	}

	return date('Y') - $y;

}



function daysLeftForBirthday($devabirthdate)
{
	/* input birthday date format -> Y-m-d */
	list( $y, $m, $d ) = explode( '-', $devabirthdate );
	$nowdate = mktime( 0, 0, 0, date("m"), date("d"), date("Y") );
	$nextbirthday = mktime( 0, 0, 0, $m, $d, date("Y") );

	if ( $nextbirthday < $nowdate )
	$nextbirthday = $nextbirthday + ( 60 * 60 * 24 * 365 );

	// ORIGNIAL
	// $daycount=intval(($nextbirthday-$nowdate)/(60*60*24));
	// return $daycount;
	
	// NEW
	$daycountStart = intval( ( $nextbirthday - $nowdate ) / ( 60 * 60 * 24 ) );
	$daycount = 365 - $daycountStart;

	return $daycount;
} 



/********************************************************************/
// FUNCTION get_athlete_events()
// Returns ALL events the athlete has result in
/********************************************************************/
function get_athlete_events()
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->get_athlete_events();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION progessions()
// Returns the yearly progessions in each event for selected athlete
/********************************************************************/
function progessions($eventID)
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->progessions($eventID);

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION progessions()
// Returns the yearly progessions in each event for selected athlete
/********************************************************************/
function progessions_multis($eventID)
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->progessions_multis($eventID);

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION personal_bests()
// Returns ALL 'Personal Best' performances for each event
/********************************************************************/
function personal_bests()
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->personal_bests();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/*************************************************************************************/
// FUNCTION legal_vs_windy($athleteID)
// USED IN THE OPEN RANKING LISTS !
// This determinds an athletes best 'LEGAL (non-windy)' performance by $athleteID, $eventID and $this->input->post('year')
// WHY? .. So we can check if an athletes best 'ILLEGAL (wind-aided)' is superior.
// If true - we display that performance in the 'Wind-Aided' section of the rankings as a notable performance
// If false - don't bother displaying it as their legal performance is better anyway.
/*************************************************************************************/
function legal_vs_windy($athleteID)
{
	$CI = &get_instance();
	$CI->load->model('site/results_model');
	$var = $CI->results_model->legal_vs_windy($athleteID);

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/*************************************************************************************/
// FUNCTION legal_vs_windy_profile($athleteID, $eventID, $year)
// USED IN THE INDIVIDUAL ATHLETE PROFILES !
// This determinds an athletes best 'LEGAL (non-windy)' performance by $athleteID, $eventID and $year
// WHY? .. So we can check if an athletes best 'ILLEGAL (wind-aided)' is superior.
// If true - we display that performance in the 'Wind-Aided' section of the rankings as a notable performance
// If false - don't bother displaying it as their legal performance is better anyway.
/*************************************************************************************/
function legal_vs_windy_profile($athleteID, $eventID, $year)
{
	$CI = &get_instance();
	$CI->load->model('site/profiles_model');
	$var = $CI->profiles_model->legal_vs_windy_profile($athleteID, $eventID, $year);

	//return the data $query
	if($query = $var) 
	{
		return $query; 
	}

}



/********************************************************************/
// FUNCTION athlete_data()
// Display athletes (individual) results data
// i.e., Rank | Time | Wind | Competition | Venue | Date 
/********************************************************************/
function athlete_data()
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->athlete_data();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION athlete_multi_data()
// Display athletes (multi-event) results data
// i.e., Rank | Time | Wind | Competition | Venue | Date 
/********************************************************************/
function athlete_multi_data()
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->athlete_multi_data();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION pro_getEvents()
// Retrieves ALL events
/********************************************************************/
function pro_getEvents()
{
	$CI = &get_instance();
	$CI->load->model('global_model');
	$var = $CI->global_model->get_events();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION pro_ageGroups()
// Creates drop down menu for ALL events
/********************************************************************/
function pro_ageGroups($selected='')
{
	$options = array(
		'' => 'Select Age Group',
		'MS'	=> 'Men Open',
		'M19' => 'Men Under 20',
		'M17' => 'Men Under 18',
		'WS'  => 'Women Open',
		'W19' => 'Women Under 20',
		'W17' => 'Women Under 18'
	);

	echo form_dropdown('ageGroup', $options,  $selected, 'id="ageGroup"');

}



/********************************************************************/
// FUNCTION pro_listEvents()
// ONLY show events this athlete has results in
// Function accepts three arguements
// 1) $value - if specified, this will be the posted 'value'
// 2) $selected - if specified, this will be the 'option' selected
// 3) $label - if specified, this will be the 'option name' selected
/********************************************************************/
function pro_listEvents($value='', $selected='', $label='')
{
	$CI = &get_instance();
	$CI->load->model('profiles_model');
	$var = $CI->profiles_model->get_athlete_events();

	$data = array();
	//gets the list of categorys to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="eventID" class="selectpicker show-tick" data-width="100%"" id="eventID">';

	if($value)
	{
		echo '<option value="' . $value . '" '.set_select('eventID', $selected).' >' . $label . '</option>';
	}
	else
	{
		echo '<option value="" selected="selected">Select Event</option>';
	}

	foreach($data as $row):
		echo '<option value="' . $row->eventID . '" ' . set_select('eventID', $row->eventID) . ' >' . $row->eventName . '</option>';
	endforeach;	

	echo '</select>';

}



/********************************************************************/
// FUNCTION pro_year()
// Creates drop down menu for the year(s) - Starting current year
// Going forward 5 years
/********************************************************************/
function pro_year($name='', $value='', $id='')
{
	$years=date('Y');

	while ( $years <= '5' + date('Y')) //Current year + add 10 years
	{
		$year[$years] = $years;
		$years++;
	}

	return form_dropdown($name, $year, set_value($name), $id, 'class="form-control"');
}



/********************************************************************/
// FUNCTION ranking_years()
// Creates drop down menu for the year(s) - Starting current year
// Going back 5 years
/********************************************************************/
function ranking_years()
{
	$years = NULL;

	for ($i = 2013; $i <= date('Y'); $i++)
	{
		$years[$i] = $i; 
	}

	// Reverse the years so latest (i.e., current) year appears at top of select list
	// This is also required for 'selectpicker' bug fix!
	$years = array_reverse($years, true);
	
	$selected_year = ( isset( $selected_year ) ) ? $selected_year : date('Y');

	return form_dropdown('year', $years, set_value('year', $selected_year), 'data-width="100%" class="selectpicker show-tick"');

}



/********************************************************************/
// FUNCTION pro_year_past()
// Creates drop down menu for the year(s) - Starting current year
// Going back 5 years
/********************************************************************/
function profile_years()
{

	for ($i = 2008; $i <= date('Y'); $i++)
	{
		$years[$i] = $i; 
	}

	// Reverse the years so latest (i.e., current) year appears at top of select list
	// This is also required for 'selectpicker' bug fix!
	$years = array_reverse($years, true);

	// Then make 'ALL YEARS' sit at the top
	$years = array(0 => 'ALL YEARS') + $years;

	$selected_year = (isset($selected_year)) ? $selected_year : 0;

	return form_dropdown('year', $years, set_value('year', $selected_year), 'class="selectpicker show-tick" data-width="100%""');

}