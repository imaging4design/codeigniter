<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*****************************************************/
// ATHLETES WHO HAVE PASSED AWAY
/*****************************************************/
// We do not wish to display these athletes Age in Years / Days on their profile
$config['passed'] = array(
	'516570',
	'524915'
);

/*****************************************************/
// EVENTS INDEX (REFERENCE)
/*****************************************************/
// Displays the complete events list with with corresponding eventID's

/*
1 	100m
2 	200m
3 	400m
4 	800m
5 	1000m
6 	1500m
7 	Mile
8 	2000m
9 	3000m
10 	5000m
11 	10000m
12 	10km
13 	15km
14 	20km
15 	One Hour
16 	Half Marathon
17 	25km
18 	30km
19 	Marathon
20 	2000m Steeplechase
21 	3000m Steeplechase
22 	100m Hurdles
23 	110m Hurdles
24 	300m Hurdles
25 	400m Hurdles
26 	High Jump
27 	Pole Vault
28 	Long Jump
29 	Triple Jump
30 	Shot Put
31 	Discus Throw
32 	Hammer Throw
33 	Javelin Throw
34 	Octathlon
35 	Heptathlon
36 	Decathlon
37 	3000m Race Walk (Track)
38 	10km Race Walk (Road)
39 	20km Race Walk (Road)
40 	50km Race Walk (Road)
41 	4x100m Relay
42 	4x200m Relay
43 	4x400m Relay
44 	4x800m Relay
45 	4x1500m Relay
46 	Medley Relay
47 	5000m Race Walk
49	60m
50	20000m
51	25000m
52	30000m
53	60m Hurdles
54	Pentathlon
55	10000m Walk (Track)
56	20000m Walk (Track)
57	30000m Walk (Track)
58	50000m Walk (Track)
59	5km
60	6km
61	8km
62	100km
63	5km Walk (Road)
64	Ekiden Road Relay
65	Cross Country
66	Mountain Running
67	24hr
*/

/*****************************************************/
// AGE GROUPS CONVERTER ARRAY
/*****************************************************/
// Creates $key => $value pairs of ageGroup abbreviations
$config['ageGroups'] = array(
	'MS'  => 'Men Open',
	'M19' => 'Men Under 20',
	'M17' => 'Men Under 18',
	'WS'  => 'Women Open',
	'W19' => 'Women Under 20',
	'W17' => 'Women Under 18'
);


// Use this version for Home Page 'Top Lists'
// We need Senior Men and Senior Women - NOT Men Open / Women Open!
$config['ageGroups2'] = array(
	'MS'  => 'Men Senior',
	'M19' => 'Men Under 20',
	'M17' => 'Men Under 18',
	'WS'  => 'Women Senior',
	'W19' => 'Women Under 20',
	'W17' => 'Women Under 18'
);



/*****************************************************/
// ALL EVENTS ARRAY - TO RETRIEVE APPROPRIATE LABELS
/*****************************************************/
// Creates an array of $key => $values for ALL events

// $config['rankings_dropdown'] = Only display these 'Events' (eventsID's) in the front end Rankings Lists drop down menu
$config['rankings_dropdown'] = array('1', '2', '3', '4', '5', '6', '7', '9', 
	'10', '11', '12', '13', '16', '18', '19', '20', '21', '22', '23', '24', '25', 
	'26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', 
	'39', '40', '41', '42', '43', '47');

// $config['alltime_dropdown'] = Only display these 'Events' (eventsID's) in the front end All-Time drop down menu
$config['alltime_dropdown'] = array(
	'1', '2', '3', '4', '6', '7', '9', '10', '11', '19', '21', '22', '23', '25', 
	'26', '27', '28', '29', '30', '31', '32', '33', '35', '36', '38', '39', '40');

// $config['records_dropdown'] = Display these 'Events' (eventID's) in the Records section drop down menu
$config['records_dropdown'] = array(
	'1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', 
	'15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', 
	'28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', 
	'41', '42', '43', '44', '45', '46', '47', '50', '51', '52', '53', '54', '55', 
	'56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67');

// $config['relays_dropdown'] = Only display these 'Events' (eventsID's) in the front end Rankings Lists drop down menu
$config['relays_dropdown'] = array('41', '42', '43', '44', '45', '46');

// $config['seperate_performances'] = all events that need special attention because of implement weights / hurdle heights
$config['seperate_performances'] = array('20', '21', '22', '23', '24', '25', '30', '31', '32', '33', '36');

$config['2000m_Steeplechase'] = array(
	'MS' => '0914mm',
	'M20' => '0914mm',
	'M19' => '0914mm',
	'M18' => '0914mm',
	'M17' => '0914mm',
	'M16' => '0914mm',
	'WS' => '0762mm',
	'W20' => '0762mm',
	'W19' => '0762mm',
	'W18' => '0762mm',
	'W17' => '0762mm',
	'W16' => '0762mm'
);

$config['3000m_Steeplechase'] = array(
	'MS' => '0914mm',
	'M20' => '0914mm',
	'M19' => '0914mm',
	'M18' => '0914mm',
	'M17' => '0914mm',
	'M16' => '0914mm',
	'WS' => '0762mm',
	'W20' => '0762mm',
	'W19' => '0762mm',
	'W18' => '0762mm',
	'W17' => '0762mm',
	'W16' => '0762mm'
); 

$config['100m_Hurdles'] = array(
	'WS' => '0840mm', 
	'W20' => '0840mm', 
	'W19' => '0840mm',
	'W18' => '0840mm',
	'W17' => '0762mm', 
	'W16' => '0762mm'
);

$config['110m_Hurdles'] = array(
	'MS' => '1067mm', 
	'M20' => '0990mm', 
	'M19' => '0990mm', 
	'M18' => '0990mm', 
	'M17' => '0914mm',
	'M16' => '0914mm'
);

$config['300m_Hurdles'] = array(
	'MS' => '0914mm',
	'M20' => '0914mm',
	'M19' => '0914mm',
	'M18' => '0840mm',
	'M17' => '0840mm', 
	'M16' => '0840mm',
	'WS' => '0762mm',
	'W20' => '0762mm',
	'W19' => '0762mm',
	'W18' => '0762mm',
	'W17' => '0762mm',
	'W16' => '0762mm'
);

$config['400m_Hurdles'] = array(
	'MS' => '0914mm',
	'M20' => '0914mm',
	'M19' => '0914mm',
	'M18' => '0914mm',
	'M17' => '0840mm', 
	'M16' => '0840mm',
	'WS' => '0762mm',
	'W20' => '0762mm',
	'W19' => '0762mm',
	'W18' => '0762mm',
	'W17' => '0762mm',
	'W16' => '0762mm'
);

$config['Shot_Put'] = array(
	'MS' => '7.26kg', 
	'M20' => '6kg', 
	'M19' => '6kg',
	'M18' => '6kg', 
	'M17' => '5kg',
	'M16' => '5kg',
	'WS' => '4kg', 
	'W20' => '4kg', 
	'W19' => '4kg',
	'W18' => '4kg', 
	'W17' => '3kg', 
	'W16' => '4kg'
);

$config['Discus_Throw'] = array(
	'MS' => '2kg', 
	'M20' => '1.75kg', 
	'M19' => '1.75kg', 
	'M18' => '1.75kg', 
	'M17' => '1.5kg',
	'M16' => '1.5kg',
	'WS' => '1kg', 
	'W20' => '1kg', 
	'W19' => '1kg', 
	'W18' => '1kg', 
	'W17' => '1kg', 
	'W16' => '1kg'
);

$config['Hammer_Throw'] = array(
	'MS' => '7.26kg', 
	'M20' => '6kg', 
	'M19' => '6kg', 
	'M18' => '6kg', 
	'M17' => '5kg',
	'M16' => '5kg',
	'WS' => '4kg', 
	'W20' => '4kg', 
	'W19' => '4kg', 
	'W18' => '4kg', 
	'W17' => '3kg', 
	'W16' => '4kg'
);

$config['Javelin_Throw'] = array(
	'MS' => '800gm', 
	'M20' => '800gm', 
	'M19' => '800gm',
	'M18' => '800gm', 
	'M17' => '700gm',
	'M16' => '700gm',
	'WS' => '600gm', 
	'W20' => '600gm', 
	'W19' => '600gm',
	'W18' => '600gm', 
	'W17' => '500gm', 
	'W16' => '600gm'
);


/*****************************************************/
// ALL EVENTS - TRACK / FIELD / MULTIS
/*****************************************************/
// Breaks events list into three categories:
// $track_events 
// $field_events 
// $multi_events

$config['all_events'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '47');
$config['track_events'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '37', '38', '39', '40', '47');
$config['field_events'] = array('26', '27', '28', '29', '30', '31', '32', '33');
$config['multi_events'] = array('34', '35', '36');
$config['relay_events'] = array('41', '42', '43', '44', '45');


/*****************************************************/
// INCLUDE ALL IN OPEN LISTS
/*****************************************************/
// All ageGroups to appear in the open lists:
// These events are not affected by implements or hurdle heights
// BOTH track and field events 

$config['open_events_men'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '26', '27', '28', '29', '37', '38', '41', '42', '43', '44', '45', '47');
$config['open_events_women'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '26', '27', '28', '29', '31', '37', '38', '41', '42', '43', '44', '45', '47');


/*****************************************************/
// WIND AFFECTED EVENTS
/*****************************************************/
// Lists wind-affected events 
// $track_events_wind
// $field_events_wind

$config['track_events_wind'] = array('1', '2', '22', '23');
$config['field_events_wind'] = array('28', '29');


/*****************************************************/
// ALL TIME LISTS
/*****************************************************/
// This is important to the 'All Time' lists
// Only future performances that 'exceed' the following marks in each event will be added to the 'All Time' lists 

$config['all_time_men'] = array(
	'1' => '00010.54',
	'2' => '00021.19',
	'3' => '00047.02',
	'4' => '01:48.24',
	'5' => '0', 
	'6' => '03:39.94',
	'7' => '03:58.84',
	'8' => '0',
	'9' => '07:55.18',
	'10' => '13:37.81',
	'11' => '28:33.00',
	'12' => '0',
	'13' => '0',
	'14' => '0',
	'15' => '0',
	'16' => '0',
	'17' => '0',
	'18' => '0',
	'19' => '02:14:08',
	'20' => '0',
	'21' => '08:46.48',
	'22' => '0',
	'23' => '00014.80',
	'24' => '0',
	'25' => '00052.27', 
	'26' => '002.08',
	'27' => '004.60',
	'28' => '007.42',
	'29' => '015.16',
	'30' => '015.98',
	'31' => '052.23',
	'32' => '054.10',
	'33' => '065.40',
	'34' => '0',
	'35' => '0',
	'36' => '6938',
	'37' => '0',
	'38' => '0',
	'39' => '01:33:14',
	'40' => '04:51:09',
	'41' => '0',
	'42' => '0',
	'43' => '0',
	'44' => '0',
	'45' => '0',
	'47' => '0'
);

$config['all_time_women'] = array(
	'1' => '00011.83',
	'2' => '00024.02',
	'3' => '00054.60',
	'4' => '02:04.84',
	'5' => '0', 
	'6' => '04:16.70',
	'7' => '04:41.71',
	'8' => '0',
	'9' => '08:58.68',
	'10' => '15:46.16',
	'11' => '33:20.78',
	'12' => '0',
	'13' => '0',
	'14' => '0',
	'15' => '0',
	'16' => '0',
	'17' => '0',
	'18' => '0',
	'19' => '02:37:03',
	'20' => '07:06.77',
	'21' => '10:55.46',
	'22' => '00014.10',
	'23' => '0',
	'24' => '0',
	'25' => '00061.03', 
	'26' => '001.79',
	'27' => '003.30',
	'28' => '006.09',
	'29' => '011.89',
	'30' => '013.99',
	'31' => '047.52',
	'32' => '045.28',
	'33' => '041.06',
	'34' => '0',
	'35' => '4871',
	'36' => '0',
	'37' => '0',
	'38' => '00053:35',
	'39' => '01:58:38',
	'40' => '0',
	'41' => '0',
	'42' => '0',
	'43' => '0',
	'44' => '0',
	'45' => '0',
	'47' => '0'
);
