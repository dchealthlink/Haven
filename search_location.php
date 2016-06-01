<?php
session_start();
include("inc/dbconnect.php");
$show_menu="ON";
$tag_line="Citizen Payment";

include("inc/index_header_inc.php");
$sql = "";
?>

<HTML>
<head>
<script language = "Javascript">

function ValidateForm(){

	if ($OPENREGISTER) {
		document.mainform.amount.value=0;

	}
	
        if (chkForm1()==false){
                return false
        }
        return true
}
</script>
</head>


  <?php

$sql ="SELECT cash_drawer_id FROM cash_drawer ORDER BY 1"; 

$result = execSql($db, $sql, $debug);

 echo "Please Enter Data to Search For</td></tr>";
 echo "<tr><td>All Selections will be <em>Logically Anded</em> (e.g. First Name = 'Bill' AND Last Name = 'Smith')</td></tr>";
 echo "<FORM NAME=mainform METHOD=post ACTION=location_result.php onSubmit='return ValidateForm()'>"; 
 echo "<tr><td valign=top>";
 echo "<table>";
 echo "<tr><td>Location Id:</td><td><input class=pink type=text name=location_id maxlength=16 size=17></td>";
 echo "<tr><td>Address:</td><td><input class=pink type=text name=address1 maxlength=30 size=30></td>";
 echo "<tr><td>City:</td><td><input class=pink type=text name=city maxlength=30 size=30></td>";
 echo "<tr><td>Parent Location Id:</td><td><input class=pink type=text name=parent_location_id maxlength=16 size=17></td>";




 echo "</table></td></tr>";
 
?>

          <tr><td>
    <input class="gray" type="Submit" name="SEARCHLOCATION" value="Search Location">&nbsp;
    <input class="gray" type="reset" name="RESET" value="Reset">
        </td></tr>


<?
	echo "<input type=hidden name=tablename value=".$header_table.">";

?>

 </p>
  </form>

</blockquote>
<?

include "inc/footer_inc.php";
?>
</table> 
</body>
</HTML>
