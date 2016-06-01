<?php

$datastring =  '{  "State": "DC",  "Application Year": 2015,  "Name": "Frontend Application",  "People": [    {      "Is Applicant": "Y",      "Applicant Attest Blind or Disabled": "N",      "Student Indicator": "N",      "Medicare Entitlement Indicator": "N",      "Incarceration Status": "N",      "Lives In State": "Y",      "Claimed as Dependent by Person Not on Application": "N",      "Applicant Attest Long Term Care": "N",      "Has Insurance": "N",      "State Health Benefits Through Public Employee": "N",      "Prior Insurance": "N",      "Applicant Pregnant Indicator": "N",      "Applicant Post Partum Period Indicator": "N",      "Former Foster Care": "N",      "Required to File Taxes": "N",      "US Citizen Indicator": "Y",      "Applicant Age": 54,      "Applicant Age >= 90": "N",      "Hours Worked Per Week": 40,      "Person ID": 1,      "Income": {        "Monthly Income": 0,        "Wages, Salaries, Tips": 60000,        "Taxable Interest": 0,        "Tax-Exempt Interest": 0,        "Taxable Refunds, Credits, or Offsets of State and Local Income Taxes": 0,        "Alimony": 0,        "Capital Gain or Loss": 0,        "Pensions and Annuities Taxable Amount": 0,        "Farm Income or Loss": 0,        "Unemployment Compensation": 0,        "Other Income": 0,        "MAGI Deductions": 0      },      "Relationships": []    }  ],  "Physical Households": [    {      "Household ID": "Household1",      "People": [        {          "Person ID": 1        }      ]    }  ],  "Tax Returns": [    {      "Filers": [],      "Dependents": []    }  ]}';
$datastring =  '{  "State": "DC",  "Application Year": 2015,  "Name": "Frontend Application",  "People": [    { "Person ID": 1,     "Is Applicant": "Y",      "Applicant Attest Blind or Disabled": "N",      "Student Indicator": "N",      "Medicare Entitlement Indicator": "N",      "Incarceration Status": "N",      "Lives In State": "Y",      "Claimed as Dependent by Person Not on Application": "N",      "Applicant Attest Long Term Care": "N",      "Has Insurance": "N",      "State Health Benefits Through Public Employee": "N",      "Prior Insurance": "N",      "Applicant Pregnant Indicator": "N",      "Applicant Post Partum Period Indicator": "N",      "Former Foster Care": "N",      "Required to File Taxes": "N",      "US Citizen Indicator": "Y",      "Applicant Age": 54,      "Applicant Age >= 90": "N",      "Hours Worked Per Week": 40,       "Income": {        "Monthly Income": 0,        "Wages, Salaries, Tips": 60000,        "Taxable Interest": 0,        "Tax-Exempt Interest": 0,        "Taxable Refunds, Credits, or Offsets of State and Local Income Taxes": 0,        "Alimony": 0,        "Capital Gain or Loss": 0,        "Pensions and Annuities Taxable Amount": 0,        "Farm Income or Loss": 0,        "Unemployment Compensation": 0,        "Other Income": 0,        "MAGI Deductions": 0      },      "Relationships": []    }  ],  "Physical Households": [    {      "Household ID": "Household1",      "People": [        {          "Person ID": 1        }      ]    }  ],  "Tax Returns": [    {      "Filers": [],      "Dependents": []    }  ]}';


$jsonData = array(
    'State' => 'DC',
    'Application Year' => 2015,
    'Name' => 'Frontend Application',
    'People' => array ([
	'Is Applicant' => 'Y',
	'Lives In State' => 'Y',
	'Required to File Taxes' => 'N',
	'US Citizen Indicator' => 'Y',
	'Applicant Age' => 54,
	'Hours Worked Per Week' => 40,
	'Person ID' => 1,
	'Income' => array (
		'Wages, Salaries, Tips' => 24000.00 
    		),
	'Relationships' => []
  ]),
    'Physical Households' => array ([
	'Household ID' => 'Household1',
	'People' => array ([
		'Person ID' => 1 ] ) ])	,
    'Tax Returns' => array([
		'Filers' => [],
		'Dependents' => []] )
);

var_dump($jsonData);
echo 'xxx';


$datastring = json_encode($jsonData);

//  $datastring = '{"State":"DC","Application Year": 2015,"Name":"Frontend Application","People":[{"Is Applicant":"Y","Lives In State":"Y","Required to File Taxes": "N","US Citizen Indicator":"Y","Applicant Age": 54,"Hours Worked Per Week": 40,"Person ID": 1,"Income":{"Wages, Salaries, Tips": 24000}, "Relationships": []    }   ] , "Physical Households": [    {      "Household ID": "Household1",      "People": [        {          "Person ID": 1        }      ]    }  ],  "Tax Returns": [    {      "Filers": [],      "Dependents": []    }  ]  }';

// $datastring = '{"State":"DC","Application Year": 2015,"Name":"Frontend Application","People":[{"Is Applicant":"Y","Lives In State":"Y","Required to File Taxes": "N","US Citizen Indicator":"Y","Applicant Age": 54,"Hours Worked Per Week": 40,"Person ID": 1,"Income":{"Wages, Salaries, Tips": 24000}, "Relationships": []    }   ] , "Physical Households": [    {      "Household ID": "Household1",      "People": [        {          "Person ID": 1        }      ]    }  ],  "Tax Returns": [    {      "Filers": [],      "Dependents": []    }  ]  }';

echo "\n".$datastring."\n";

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

echo $result;


//  passthru ('curl -d '.$datastring.' http://54.166.30.111/determinations/eval --header "Content-Type: application/json" -H "Accept: application/json"; echo' );


?>
