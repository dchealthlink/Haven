<?
include("inc/header_inc.php");
include("inc/libmail.php");

function CheckEmail($Email = "") {
  if (ereg("[[:alnum:]]+@[[:alnum:]]+\.[[:alnum:]]+", $Email)) {
    return true;
  } else {
    return false;
  }
}

if ($submit) {

if(CheckEmail($youremail)) {
        $m= new Mail; // create the mail
        $m->From( $youremail );
        $m->To( "support@ignitetrx.com" );
        $m->Subject( $yoursubject );

//      $message.="The cust_id is : ".$cust_id." \n";
        $message.="\n ".$yourmessage."\n";

        $m->Body( $message);    // set the body
        $m->Cc( "support@ignitetrx.com");
        $m->Priority( "3" ) ;
        $m->Send();     // send the mail
        echo "Your email entitled : <b>".$yoursubject."</b><br>Has been sent to support@laurel.md.us";

        $m= new Mail; // create the mail
        $m->From( "autoreply@ignitetrx.com" );
        $m->To( $youremail );
        $m->Subject( $yoursubject );

$message="**Please DO NOT REPLY to this message. E-mail support@ignitetrx.com if you have any questions.\n\n";

$message.="The following email has been sent to ignitetrx.com\n\n";

//      $message.="The cust_id is : ".$cust_id." \n";
        $message.="\n ".$yourmessage."\n";

        $m->Body( $message);    // set the body
        $m->Priority( "3" ) ;
        $m->Send();     // send the mail
} else {
        echo "The email entitled : <b>".$yoursubject."</b><br>Has <font color=red><b>NOT</b></font> been sent to ignitetrx.com<br>The email address: <b>".$youremail."</b> is invalid";

}
}

echo "<form method=post action=".$PHP_SELF.">";

?>
<font size=+1><b>Information Request</b></font><br><br>

<b>Please fill in the form below:</b>
<br><br>
        <b>Your name:</b>
<br>
<input type="text" name="yourname" value="<?php echo $yourname ?>" size="40"><br><br>
        <b>Subject:</b>
<br>
<input type="text" name="yoursubject" value="<?php echo $yoursubject ?>" size="60"><br><br>
        <b>Email:</b>
<br>
<input type="text" name="youremail" value="<?php echo $youremail ?>"size="60"><br><br>

        <b>Message:</b>
<br>
<textarea name="yourmessage" rows="10" cols="50"><?php echo $yourmessage ?></textarea><br><br>
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
&nbsp;&nbsp;
<INPUT TYPE="reset" NAME="reset" VALUE="Reset">

</form>
<?

 include("inc/footer_inc.php");
?>

