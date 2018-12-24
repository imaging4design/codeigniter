<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Helper function to retrieve views data for each page
 * 
 */


	
		
	
/********************************************************************/
// FUNCTION buildAgeGroupDropdown()
// Creates drop down menu for ALL ageGroups 
// (Used for Main Search Results)
/********************************************************************/
function ageOptions()
{
	$options = array(
		'MS'	=> 'Open Men',
		'M19' 	=> 'U20/Junior Men',
		'M17' 	=> 'U18/Youth Men',
		'WS'  	=> 'Open Women',
		'W19' 	=> 'U20/Junior Women',
		'W17' 	=> 'U18/Youth Women'
	);

	echo json_encode($options);

}