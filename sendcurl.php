<?php




$jsonData = array(
    'State' => $_POST['stateCd'],
    'Application Year' => filter_input(INPUT_POST, 'appYear', FILTER_VALIDATE_INT) ,
//    'Application Year' => (int)$_POST['appYear'],
    'Name' => 'Frontend Application',
    'People' => array ([
	'Is Applicant' => ($_POST['isApplicant']? 'Y' : 'N'),
	'Lives In State' => ($_POST['isStateResident'] ? 'Y' : 'N'),
	'Required to File Taxes' => ($_POST['isTaxRequired'] ? 'Y' : 'N'),
	'US Citizen Indicator' => ($_POST['isUSCitizen'] ? 'Y' : 'N'),
	'Applicant Age' => (int)$_POST['applAge'],
	'Hours Worked Per Week' => (int)$_POST['hrsWorked'],
	'Person ID' => 4000000001,
	'Income' => array (
		'Wages, Salaries, Tips' => (int)$_POST['wages'] 
    		),
	'Relationships' => []
  ]),
    'Physical Households' => array ([
	'Household ID' => 'Household1',
	'People' => array ([
		'Person ID' => 4000000001 ] ) ])	,
    'Tax Returns' => array([
		'Filers' => [],
		'Dependents' => []] )
);

var_dump($jsonData);
echo '<br><br>xxx<br><br>';


$datastring = json_encode($jsonData);

//  $datastring = '{"State":"DC","Application Year": 2015,"Name":"Frontend Application","People":[{"Is Applicant":"Y","Lives In State":"Y","Required to File Taxes": "N","US Citizen Indicator":"Y","Applicant Age": 54,"Hours Worked Per Week": 40,"Person ID": 1,"Income":{"Wages, Salaries, Tips": 24000}, "Relationships": []    }   ] , "Physical Households": [    {      "Household ID": "Household1",      "People": [        {          "Person ID": 1        }      ]    }  ],  "Tax Returns": [    {      "Filers": [],      "Dependents": []    }  ]  }';

// $datastring = '{"State":"DC","Application Year": 2015,"Name":"Frontend Application","People":[{"Is Applicant":"Y","Lives In State":"Y","Required to File Taxes": "N","US Citizen Indicator":"Y","Applicant Age": 54,"Hours Worked Per Week": 40,"Person ID": 1,"Income":{"Wages, Salaries, Tips": 24000}, "Relationships": []    }   ] , "Physical Households": [    {      "Household ID": "Household1",      "People": [        {          "Person ID": 1        }      ]    }  ],  "Tax Returns": [    {      "Filers": [],      "Dependents": []    }  ]  }';

echo "<br>\n".$datastring."\n<br>";

 $ch = curl_init('http://54.166.30.111/determinations/eval');                                                                      
// $ch = curl_init('http://10.4.64.151:3000');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
// curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Accept: application/json',                                                                                
    'Content-Length: ' . strlen($datastring))                                                                       
);                                                                                                                   
                                                                                                                     
$result = curl_exec($ch);

echo "<br><br>RESULT:<BR>".$result;

$deresult = json_decode($result,true) ;

echo "<br><br>RESULT:<BR>";
var_dump($deresult);
echo "<br><br><BR>";


//listing the array
foreach($deresult as $prop => $value) {
	if ( is_array($value)) {
		echo "<br><br> Level0: ".$prop." ==> ";
		foreach($value as $prop1 => $value1) {
			if ( is_array($value1)) {
			echo "<br><br>Level1:".$prop1." ==> ";
				foreach($value1 as $prop2 => $value2) {
					if (is_array($value2) ) {
					echo "<br><br>Level2: ".$prop2." ==> ";
						foreach($value2 as $prop3 => $value3) {
							if (is_array($value3) ) {
							echo "<br><br>Level3: ".$prop3." ==>";
								foreach($value3 as $prop4 => $value4) {
									echo '<br>'.$prop4.' : '.$value4;
								}
							} else {
								echo '<br>'.$prop3.' : '.$value3;
							}
						}				
					} else {
						echo '<br>'.$prop2.' : '.$value2;
					}
				}
			} else {
				echo '<br>'.$prop1.' : '.$value1;
			}
		}
	} else {
		echo '<br/>'. $prop .' : '. $value;
	}
}


?> 

