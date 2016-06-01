<?php
print_r($_POST);
echo "<br><br>";

echo "PHP Version: ".phpversion().'<br>'; 
if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ 
    echo $_POST['email'].'<br>'; 
    var_dump(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)); 
}else{ 
    var_dump(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));    
} 

// check if fields passed are empty
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['message'])		
   || (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === false) )
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = $_POST['name'];
$email_address = $_POST['email'];
$type = $_POST['type'];
$other = $_POST['other'];
$date = $_POST['date'];
$venue = $_POST['venue'];
$budget = $_POST['budget'];
$message = $_POST['message'];
 $selectedServices  = (isset($_POST['services']))?implode(',',$_POST['services']):'None'; 
print_r($_POST['services']);
echo "<br><br>";

// create email body and send it	
$to = 'tafahey@comcast.net'; // PUT YOUR EMAIL ADDRESS HERE
$email_subject = "The Lighting & Sound Company Contact Form:  $name"; // EDIT THE EMAIL SUBJECT LINE HERE
$email_body = "You have received a new message from your website's contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nType: $type\n\nOther: $other\n\nDate: $date\n\nVenue: $venue\n\nBudget: $budget\n\nServices: $selectedServices\n\nMessage:\n$message";
$headers = "From: noreply@lightingandsoundco.com\n";
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$email_body,$headers);
return true;			
?>
