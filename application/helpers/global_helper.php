<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Helper function to retrieve views data for each page
 * 
 */


function show_my_404(){   
    //Using 'location' not work well on some windows systems
    redirect('nz_error404');  
}


/********************************************************************/
// FUNCTION recordAge()
// Shows the age of a NZ Record/Athlete in Years / Months / days
/********************************************************************/
function recordAge($dateOne, $dateTwo) {

	$date1 = new DateTime($dateOne);
	$date2 = new DateTime($dateTwo);
	$interval = $date1->diff($date2);

	return $interval->y . " year(s), " . $interval->m." month(s), ".$interval->d." day(s) ";
}


/********************************************************************/
// FUNCTION recordAgeY()
// Shows the age of a NZ Record/Athlete (Year ONLY)!
/********************************************************************/
function recordAgeY($dateOne, $dateTwo) {

	$date1 = new DateTime($dateOne);
	$date2 = new DateTime($dateTwo);
	$interval = $date1->diff($date2);

	return $interval->y . " years old ";
}


/********************************************************************/
// FUNCTION recordAgeYears()
// Shows the age of a NZ Record/Athlete in Years only
/********************************************************************/
function recordAgeYears($dateOne, $dateTwo) {

	$date1 = new DateTime($dateOne);
	$date2 = new DateTime($dateTwo);
	$interval = $date1->diff($date2);

	return $interval->y;
	//return "difference " . $interval->days . " days ";
}


/********************************************************************/
// FUNCTION recordAgeHistory()
// Shows the age of a NZ Record in Years / Months / days
/********************************************************************/
function recordAgeHistory($dateOne, $dateTwo) {

	$date1 = new DateTime($dateOne);
	$date2 = new DateTime($dateTwo);
	$interval = $date1->diff($date2);

	return $interval->y . " year(s) ago ";
	//return "difference " . $interval->years . " days ";
}


/********************************************************************/
// FUNCTION born_this_day()
// Shows Athletes born this day on home page
/********************************************************************/
function born_this_day()
{
	$CI = &get_instance();
	$CI->load->model('site/profiles_model');
	$var = $CI->profiles_model->born_this_day();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}


/********************************************************************/
// FUNCTION records_this_day()
// Shows Records Set this day in history on home page
/********************************************************************/
function records_this_day()
{
	$CI = &get_instance();
	$CI->load->model('site/records_model');
	$var = $CI->records_model->records_this_day();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}


/********************************************************************/
// FUNCTION show_advert()
// Displays the advert on the page
/********************************************************************/
function show_advert()
{
	$CI = &get_instance();
	$CI->load->model('admin/advert_model');
	$var = $CI->advert_model->show_advert();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}


/********************************************************************/
// FUNCTION show_news()
// Shows the latest news
/********************************************************************/
function show_news()
{
	$CI = &get_instance();
	$CI->load->model('site/news_model');
	$var = $CI->news_model->show_news();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}


/********************************************************************/
// FUNCTION show_flash_news()
// Shows the latest 'Flash' news item for homepage
/********************************************************************/
function show_flash_news()
{
	$CI = &get_instance();
	$CI->load->model('site/news_model');
	$var = $CI->news_model->show_flash_news();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}


/********************************************************************/
// FUNCTION fresh_results()
// Used to hightlight the latest rankings added - (less than a week old!)
/********************************************************************/
function fresh_results($data)
{
	$dateClass = NULL;

	if( strtotime($data) > strtotime('2 week ago') )
	{
		return 'fresh_results'; // this is a class name
	}

}


/********************************************************************/
// FUNCTION fresh_records()
// As above - but for the records section - (less than 1 month old)
/********************************************************************/
function fresh_records($data)
{
	$dateClass = NULL;

	if( strtotime($data) > strtotime('2 week ago') )
	{
		return 'fresh_results'; // this is a class name
	}

}


/********************************************************************/
// FUNCTION ratified_record()
// Displays a NEW ratified record on the home page - as item of interest!
/********************************************************************/
function ratified_record()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->ratified_record();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}


/********************************************************************/
// FUNCTION rankings_added_month()
// Retrieves the total number of results for the current month!
/********************************************************************/
function rankings_added_month()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->rankings_added_month();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}


/********************************************************************/
// FUNCTION rankings_seven_days()
// Retrieves the total number of results for the past 7 days!
/********************************************************************/
function rankings_seven_days()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->rankings_seven_days();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}

 
/********************************************************************/
// FUNCTION totalResults()
// Retrieves the total number of results on the site to date!
/********************************************************************/
function totalResults()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->totalResults();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION totalAthletes()
// Retrieves the total number of ranked athletes in the database!
/********************************************************************/
function totalAthletes()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->totalAthletes();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION mostRecent()
// Retrieves the most recent additions to the rankings database!
/********************************************************************/
function mostRecent()
{
	$CI = &get_instance();
	//$CI->load->model('toplist_model');
	$var = $CI->Toplist_model->mostRecent();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION most_recent_multis()
// Retrieves the most recent additions (Multi Events) to the rankings database!
/********************************************************************/
function most_recent_multis()
{
	$CI = &get_instance();
	//$CI->load->model('toplist_model');
	$var = $CI->Toplist_model->most_recent_multis();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION topPerformers()
// Retrieves list of top performances in each event for homepage
// Only one performance per event, per ageGroup
/********************************************************************/
function topPerformers()
{
	$CI = &get_instance();
	//$CI->load->model('toplist_model');
	$var = $CI->Toplist_model->topPerformers();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION topPerformers_Multis()
// Retrieves list of top performances in multi events for homepage
// Only one performance per multi, per ageGroup
/********************************************************************/
function topPerformers_Multis()
{
	$CI = &get_instance();
	//$CI->load->model('toplist_model');
	$var = $CI->Toplist_model->topPerformers_Multis();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION topPerformers_Relays()
// Retrieves list of top performances in relays events for homepage
// Only one performance per relay, per ageGroup
/********************************************************************/
function topPerformers_Relays()
{
	$CI = &get_instance();
	//$CI->load->model('toplist_model');
	$var = $CI->Toplist_model->topPerformers_Relays();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION getEvents()
// Retrieves ALL events
/********************************************************************/
function getEvents($value)
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->getEvents($value);

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION convertEventID()
// Converts the eventID into the human readable 'event name'
/********************************************************************/
function convertEventID()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->convertEventID();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION getIndoorEvents()
// Retrieves ALL indoor events
/********************************************************************/
function getIndoorEvents()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->getIndoorEvents();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION getCentres()
// Retrieves ALL Centres
/********************************************************************/
function getCentres()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->getCentres();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}
	
	
	
/********************************************************************/
// FUNCTION getClubs()
// Retrieves ALL Clubs
/********************************************************************/
function getClubs()
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->global_model->getClubs();

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}

}



/********************************************************************/
// FUNCTION get_representations()
// Retrieves Athlete NZ Representation Data
/********************************************************************/
function get_representations($data)
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->profiles_model->get_representations($data);

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}
	

}



/********************************************************************/
// FUNCTION get_nzchamps()
// Retrieves Athlete NZ Championships Medal Data
/********************************************************************/
function get_nzchamps($data)
{
	$CI = &get_instance();
	//$CI->load->model('global_model');
	$var = $CI->profiles_model->get_nzchamps($data);

	//return the data $query
	if($query = $var) 
	{
		return $query;
	}
	

}
	
	
	
/********************************************************************/
// FUNCTION dropDownCentres()
// Creates drop down menu for ALL 'centres'
/********************************************************************/
function dropDownCentres($value='', $selected='', $label='')
{
	$CI = &get_instance();
	$CI->load->model('global_model');
	$var = $CI->global_model->getCentres();

	$data = array();
	//gets the list of categorys to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="centreID" id="centreID" class="form-control">';

	if($value)
	{
		echo '<option value="'.$value.'"'.set_select('centreID', $selected).'>'.$label.'</option>';
	}
	else
	{
		echo '<option value="" selected="selected">Select Centre</option>';
	}

	foreach($data as $row):
		echo '<option value="'.$row->centreID.'"'.set_select('centreID', $row->centreID).'>'.$row->centreName.'</option>';
	endforeach;	

	echo '</select>';


}
	
	
	
/********************************************************************/
// FUNCTION dropDownClubs()
// Creates drop down menu for ALL 'centres'
/********************************************************************/
function dropDownClubs($value='', $selected='', $label='')
{
	$CI = &get_instance();
	$CI->load->model('global_model');
	$var = $CI->global_model->getClubs();

	$data = array();
	//gets the list of categorys to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="clubID" id="clubID" class="form-control">';

	if($value)
	{
		echo '<option value="'.$value.'"'.set_select('clubID', $selected).'>'.$label.'</option>';
	}
	else
	{
		echo '<option value="" selected="selected">Select Club</option>';
	}

	foreach($data as $row):
		echo '<option value="'.$row->clubID.'"'.set_select('clubID', $row->clubID).'>'.$row->clubName.'</option>';
	endforeach;	

	echo '</select>';


}



/********************************************************************/
// FUNCTION buildAgeGroupDropdown()
// Creates drop down menu for ALL ageGroups 
// (Used for Main Search Results)
/********************************************************************/
function buildAgeGroupDropdown($selected='')
{
	$options = array(
		'' 		=> 'Select Age Group',
		'MS'	=> 'Open Men',
		'M19' 	=> 'U20/Junior Men',
		'M17' 	=> 'U18/Youth Men',
		'WS'  	=> 'Open Women',
		'W19' 	=> 'U20/Junior Women',
		'W17' 	=> 'U18/Youth Women'
	);

	echo form_dropdown('ageGroup', $options,  $selected, 'id="ageGroup" class="form-control"');

}
	
		
	
/********************************************************************/
// FUNCTION buildAgeGroupDropdown()
// Creates drop down menu for ALL ageGroups 
// (Used for Main Search Results)
/********************************************************************/
function buildAgeGroupRadio()
{
	$options = array(
		'MS'	=> 'Open Men',
		'M19' 	=> 'U20/Junior Men',
		'M17' 	=> 'U18/Youth Men',
		'WS'  	=> 'Open Women',
		'W19' 	=> 'U20/Junior Women',
		'W17' 	=> 'U18/Youth Women'
	);

	$check = 'MS';

	echo '<div class="btn-group" data-toggle="buttons">';

	foreach($options as $key => $value)
	{
		//if( $key == $check ) { $checked = 'checked'; } else { $checked = ''; }
		if( $key == 'MS' ) { $check = TRUE; } else { $check = NULL; }
		
		// echo '<div class="radio">';
		// 	echo '<label>';
		// 		echo '<input type="radio" name="ageGroup" value="'. $key .'" '. set_radio('ageGroup', "$key", $check) . '>	'. $value .'';
		// 	echo '</label>';
		// echo '</div>';

		echo '<label class="btn btn-primary">';
			echo '<input type="radio" name="ageGroup" value="'. $key .'" '. set_radio('ageGroup', "$key", $check) . '>	'. $value .'';
		echo '</label>';
	}

	echo '</div>';

}



/********************************************************************/
// FUNCTION buildAgeGroupDropdownAT()
// Creates drop down menu for ALL ageGroups - Use for All Time
// (Used for Main Search Results)
/********************************************************************/
function buildAgeGroupRadioAT()
{
	$options = array(
		'MS'		=> 'Men All Time',
		'WS'  	=> 'Women All Time',
	);

	$check = 'MS';

	foreach($options as $key => $value)
	{
		//if( $key == $check ) { $checked = 'checked'; } else { $checked = ''; }
		if( $key == 'MS' ) { $check = TRUE; } else { $check = NULL; }
		
		echo '<div class="radio">';
			echo '<label class="radio">';
				echo '<input type="radio" name="ageGroup" value="'. $key .'" '. set_radio('ageGroup', "$key", $check) . '>	'. $value .'';
			echo '</label>';
		echo '</div>';
	}

}


	
/********************************************************************/
// FUNCTION buildAgeGroup_records()
// Creates drop down menu for ALL ageGroups 
// (Used in records section ONLY)
/********************************************************************/
function buildAgeGroup_records($selected='')
{
	$options = array(
		'' 		=> 'Select Age Group',
		'MS'	=> 'Men',
		'M19' 	=> 'Men Under 20',
		'M18' 	=> 'Men Under 19',
		'M17' 	=> 'Men Under 18',
		'M16' 	=> 'Men Under 17',
		'WS'  	=> 'Women',
		'W19' 	=> 'Women Under 20',
		'W18' 	=> 'Women Under 19',
		'W17' 	=> 'Women Under 18',
		'W16' 	=> 'Women Under 17'
	);

	echo form_dropdown('ageGroup', $options,  $selected, 'id="ageGroup" class="form-control selectpicker show-tick" data-width="100%"');

}
	
	
	
/********************************************************************/
// FUNCTION buildAgeGroup_topLists()
// Creates drop down menu for ALL ageGroups
// Displays as Senior Men, Senior Women - instead of Men Open, Women Open

// (Used in 'Top LIsts' section in home page)
// (Used in 'ADMIN' section for adding results)
/********************************************************************/
function buildAgeGroup_topLists($selected='')
{
	$options = array(
		'' 		=> 'Select Age Group',
		'MS'	=> 'Senior Men',
		'M19' 	=> 'U20/Junior Men',
		'M17' 	=> 'U18/Youth Men',
		'WS'  	=> 'Senior Women',
		'W19' 	=> 'U20/Junior Women',
		'W17' 	=> 'U18/Youth Women'
	);

	echo form_dropdown('ageGroup', $options,  $selected, 'class="selectpicker show-tick" data-width="100%" ', 'id="ageGroupTopPerf"');

}



/********************************************************************/
// FUNCTION ageGroupLabels($data)
// Converts and returns the 'ageGroup' human readable labels
/********************************************************************/
function ageGroupLabels($data)
{
	switch ( $data ) {

		case 'MS':
			$ageGroup = 'Senior Men';
		break;

		case 'M19':
			$ageGroup = 'U20/Junior Men';
		break;

		case 'M17':
			$ageGroup = 'U18/Youth Men';
		break;

		case 'WS':
			$ageGroup = 'Senior Women';
		break;

		case 'W19':
			$ageGroup = 'U20/Junior Women';
		break;

		case 'W17':
			$ageGroup = 'U18/Youth Women';
		break;

		default:
			$ageGroup = 'Men Open';
		break;
	}

	return $ageGroup;

}



/********************************************************************/
// FUNCTION ageGroupRecordConvert($data)
// Converts and returns the 'ageGroup' for records on the results page
// i.e., M19 = 'U20', M17 = U18 etc 
/********************************************************************/
function ageGroupRecordConvert($data)
{
	switch ( $data ) {

		case 'MS':
			$ageGroup = 'Mens';
		break;

		case 'M19':
			$ageGroup = 'U20';
		break;

		case 'M18':
			$ageGroup = 'U19';
		break;

		case 'M17':
			$ageGroup = 'U18';
		break;

		case 'M16':
			$ageGroup = 'U17';
		break;

		case 'WS':
			$ageGroup = 'Womens';
		break;

		case 'W19':
			$ageGroup = 'U20';
		break;

		case 'W18':
			$ageGroup = 'U19';
		break;

		case 'W17':
			$ageGroup = 'U18';
		break;

		case 'W16':
			$ageGroup = 'U17';
		break;
		
	}

	return $ageGroup;

}


/********************************************************************/
// FUNCTION ageGroupRecordHistoryConvert($data)
// Converts and returns the 'ageGroup' for today in history records on the home page
// i.e., M19 = 'U20', M17 = U18 etc 
/********************************************************************/
function ageGroupRecordHistoryConvert($data)
{
	switch ( $data ) {

		case 'MS':
			$ageGroup = 'Mens';
		break;

		case 'M19':
			$ageGroup = 'Mens U20';
		break;

		case 'M18':
			$ageGroup = 'Mens U19';
		break;

		case 'M17':
			$ageGroup = 'Mens U18';
		break;

		case 'M16':
			$ageGroup = 'Mens U17';
		break;

		case 'WS':
			$ageGroup = 'Womens';
		break;

		case 'W19':
			$ageGroup = 'Womens U20';
		break;

		case 'W18':
			$ageGroup = 'Womens U19';
		break;

		case 'W17':
			$ageGroup = 'Womens U18';
		break;

		case 'W16':
			$ageGroup = 'Womens U17';
		break;
		
	}

	return $ageGroup;

}



/********************************************************************/
// FUNCTION ageGroupLabelsAT($data)
// Converts and returns the 'ageGroup' human readable labels (All Time Lists) only!
/********************************************************************/
function ageGroupLabelsAT($data)
{
	switch ( $data ) {

		case 'MS':
			$ageGroup = 'Men';
		break;

		case 'WS':
			$ageGroup = 'Women';
		break;

		default:
			$ageGroup = 'Men';
		break;
	}

	return $ageGroup;

}
	
	
	
/********************************************************************/
// FUNCTION buildAgeGroupSmall()
// Creates drop down menu for ALL events
/********************************************************************/
function buildAgeGroupSmall($selected='')
{
	$options = array(
		'' 		=> 'Select Age Group',
		'MS'	=> 'Men Open',
		'WS'  	=> 'Women Open'
	);

	echo form_dropdown('ageGroup', $options,  $selected, 'id="ageGroup"');

}
	
	
	
/********************************************************************/
// FUNCTION recordType()
// Creates drop down menu for ALL 'record types' (i.e. Allcomers, National ...)
/********************************************************************/
function recordType($selected='')
{
	$options = array(
		'' 		=> 'Select Record Type',
		'AC'	=> 'NZ Allcomers',
		'NN' 	=> 'NZ National',
		'RR' 	=> 'NZ Resident'
	);

	echo form_dropdown('recordType', $options,  $selected, 'id="recordType" class="form-control selectpicker show-tick" data-width="100%"');

}
	
	
	
/********************************************************************/
// FUNCTION in_out()
// Creates drop down menu for 'Indoor' or 'Outdoor' options
/********************************************************************/
function in_out($selected='')
{
	$options = array(
		'out'	=> 'Outdoors',
		'in' 	=> 'Indoors'
	);

	echo form_dropdown('in_out', $options,  $selected, 'id="in_out" class="form-control selectpicker show-tick" data-width="100%"');

}
	
	
 	
/********************************************************************/
// FUNCTION buildEventsDropdown()
// Creates drop down menu for ALL events
// Function accepts three arguements
// 1) $value - the type od dropdown event - evaluated via $this->config->item($value))
//
// NOTE: This differs from below: shows ranking events only!!!
/********************************************************************/
function buildEventsDropdown($value)
{
	$CI = &get_instance();
	$CI->load->model('global_model');
	$var = $CI->global_model->getEvents($value);

	$data = array();
	//gets the list of categorys to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="eventID" id="eventID" class="form-control selectpicker show-tick" data-width="100%">';

	// if($value)
	// {
	// 	echo '<option value="'.$value.'"'.set_select('eventID', $selected).'>'.$label.'</option>';
	// }
	// else
	// {
	// 	echo '<option value="" selected="selected">Select Event</option>';
	// }

	foreach($data as $row):
		echo '<option value="'.$row->eventID.'"'.set_select('eventID', $row->eventID).'>'.$row->eventName.'</option>';
	endforeach;	

	echo '</select>';


}



/********************************************************************/
// FUNCTION buildRecordEventsDropdown()
// Creates drop down menu for ALL events
// Function accepts three arguements
// 1) $value - if specified, this will be the posted 'value'
// 2) $selected - if specified, this will be the 'option' selected
// 3) $label - if specified, this will be the 'option name' selected
//
// NOTE: This differs from above: shows record events only!!!
/********************************************************************/
function buildRecordEventsDropdown($value='', $selected='', $label='')
{
	$CI = &get_instance();
	$CI->load->model('global_model');
	$var = $CI->global_model->getRecordEvents();

	$data = array();
	//gets the list of categorys to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="eventID" class="col-sm-3 form-control" id="eventID">';

	if($value)
	{
		echo '<option value="'.$value.'"'.set_select('eventID', $selected).'>'.$label.'</option>';
	}
	else
	{
		echo '<option value="" selected="selected">Select Event</option>';
	}

	foreach($data as $row):
		echo '<option value="'.$row->eventID.'"'.set_select('eventID', $row->eventID).'>'.$row->eventName.'</option>';
	endforeach;	

	echo '</select>';


}
	
	
	
/********************************************************************/
// FUNCTION buildIndoorEventsDropdown()
// Creates drop down menu for ALL (Indoor) events
// Function accepts three arguements
// 1) $value - if specified, this will be the posted 'value'
// 2) $selected - if specified, this will be the 'option' selected
// 3) $label - if specified, this will be the 'option name' selected
/********************************************************************/
function buildIndoorEventsDropdown($value='', $selected='', $label='')
{
	$CI = &get_instance();
	$CI->load->model('global_model');
	$var = $CI->global_model->getIndoorEvents();

	$data = array();
	//gets the list of categorys to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="indoorEventID" id="indoorEventID" class="form-control">';

	if($value)
	{
		echo '<option value="'.$value.'"'.set_select('indoorEventID', $selected).'>'.$label.'</option>';
	}
	else
	{
		echo '<option value="" selected="selected">Select Indoor Event</option>';
	}

	foreach($data as $row):
		echo '<option value="'.$row->eventID.'"'.set_select('indoorEventID', $row->eventID).'>'.$row->eventName.'</option>';
	endforeach;	

	echo '</select>';

}
	
	
	
/********************************************************************/
// FUNCTION get_venues()
// Retrives full list of default venues
/********************************************************************/
function get_venues($value='')
{
	$venues = array(
		'Auckland',
		'Burnside (Chch)',
		'Christchurch',
		'Dunedin',
		'Hamilton',
		'Hastings',
		'Inglewood',
		'Invercargill',
		'Manukau',
		'Masterton',
		'Nelson',
		'North Shore',
		'Pakuranga',
		'Palmerston North',
		'Tauranga',
		'Timaru',
		'Waitakere',
		'Wanganui',
		'Whangarei',
		'Wellington'
	);

	echo '<label for="venue">Venue:</label>';
	echo '<select name="venue" id="venue" class="form-control">';

	if($value)
	{
		echo '<option value="'.$value.'"'.set_select('eventID', $value).'>'.$value.'</option>';
	}
	else
	{
		echo '<option value="" selected="selected">Select Venue</option>';
	}

	foreach($venues as $venue):
		echo '<option value="'.$venue.'">'.$venue.'</option>';
	endforeach;	

	echo '</select>';

}
	
	
	
/********************************************************************/
// FUNCTION buildDayDropdown()
// Creates drop down menu for the days of the month
/********************************************************************/
function buildDayDropdown($name='', $value='', $id='')
{
	$days='';

	while ( $days <= '31' )
	{
		$day[]=$days;$days++;
	}

	return form_dropdown($name, $day, $value, $id);
}


    
/********************************************************************/
// FUNCTION buildMonthDropdown()
// Creates drop down menu for the months of the year
/********************************************************************/
function buildMonthDropdown($name='', $value='', $id='')
{
	$month=array(
		'01'=>'January',
		'02'=>'February',
		'03'=>'March',
		'04'=>'April',
		'05'=>'May',
		'06'=>'June',
		'07'=>'July',
		'08'=>'August',
		'09'=>'September',
		'10'=>'October',
		'11'=>'November',
		'12'=>'December'
	);
	
	return form_dropdown($name, $month, $value, $id);

}


		
/********************************************************************/
// FUNCTION buildYearDropdown()
// Creates drop down menu for the year(s) - Starting current year
// Going forward 5 years (FOR ADMIN SECTION)
/********************************************************************/
function buildYearDropdown($name='', $value='', $id='')
{
	$years=date('Y') -15;

	while ( $years <= '5' + date('Y')) //Current year + add 10 years
	{
		$year[$years] = $years;
		$years++;
	}

	return form_dropdown($name, $year, $value, $id);

}


		
/********************************************************************/
// FUNCTION buildYearDropdownPast()
// Creates drop down menu for the year(s) - Starting current year
// Going back 5 years (FOR ADMIN SECTION)
/********************************************************************/
function buildYearDropdownPast($name='', $value='', $id='')
{
	//$years=date('Y');
	$years=2000;

	while ( $years <= '0' + date('Y')) //Current year + add 10 years
	{
		$year[$years] = $years;
		$years++;
	}

	return form_dropdown($name, $year, set_value($name, date('Y')), $id);

}


		
/********************************************************************/
// FUNCTION buildYearDOB()
// Creates drop down menu for the year(s) - DOB in add athlete
// Going back 50 years (FOR ADMIN SECTION)
/********************************************************************/
function buildYearDOB($name='', $value='', $id='')
{
	for ($i = 1965; $i <= date('Y'); $i++)
	{
		$years[$i] = $i; 
		//echo "<pre>"; print_r($years); echo "</pre>";//remove this
	}

	$selected_year = ( isset( $selected_year ) ) ? $selected_year : 0;

	return form_dropdown('year', $years, set_value('year', $selected_year), 'id="year", class="form-control"');

}



/********************************************************************/
// FUNCTION get_centre_flag( $centre )
// Create function that will accept the $centreID and work out which flag CSS to display
/********************************************************************/
function get_centre_flag( $centre ) {

	switch ( $centre ) {
		case 'NTH':
			$flag = '<span class="flag NTH"></span>';
		break;

		case 'AKL':
			$flag = '<span class="flag AKL"></span>';
		break;

		case 'WBP':
			$flag = '<span class="flag WBP"></span>';
		break;

		case 'HBG':
			$flag = '<span class="flag HBG"></span>';
		break;

		case 'TAR':
			$flag = '<span class="flag TAR"></span>';
		break;

		case 'MWA':
			$flag = '<span class="flag MWA"></span>';
		break;

		case 'WEL':
			$flag = '<span class="flag WEL"></span>';
		break;

		case 'TAS':
			$flag = '<span class="flag TAS"></span>';
		break;

		case 'CAN':
			$flag = '<span class="flag CAN"></span>';
		break;

		case 'OTG':
			$flag = '<span class="flag OTG"></span>';
		break;

		case 'STH':
			$flag = '<span class="flag STH"></span>';
		break;
		
		default:
			$flag = '<span class="flag ANZ"></span>';
		break;
	}

	return $flag;

}