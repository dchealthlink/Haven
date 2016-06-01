<?php
session_start();
include("inc/dbconnect.php");

$falseid = (date("y") * 10000000) + ((date("z") + 1) * 10000) ;
$falseid = (date("ymdhis").substr((string)microtime(), 2, 6)) ;

$show_menu="ON";

?>
<HTML>
<head>
</head>
<?

 include("inc/index_header_inc.php"); 

?>
<tr><td>
  <blockquote>
   <h1>APTC check:</h1>

   <form name="mainform" method="post" action="call_ws_short.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600> 

        <tr><td>Name:</td><td colspan=5><input class=pink type=text name=aptcName maxlength=70 size=40>
        <tr><td>Annual Income:</td><td><input class=pink type=text name=annualIncome maxlength=9 size=10>
	<input type=hidden name=applid value=<?php echo $falseid ?>>
	<input type=hidden name=apikey value=1000000></td>
	<input type=hidden name=personid value=1000000></td>
	<input type=hidden name=user value=1000000>
	<input type=hidden name=userpw value=1000000></td>
        <td>Annual Benchmark:</td><td><input class=pink type=text name=annualBenchmark maxlength=9 size=10>
	</td></tr>



	<tr>
	<td>Request Year:</td><td>
  	<select name="requestYear">
  		<option value="<?php echo date("Y") ?>" selected><?php echo date("Y") ?></option>
<?
		for ($i=1;$i < 3; $i++) {
	 		echo "<option value=".((date("Y")) - $i)." >".((date("Y")) - $i)."</option>";
		}
?>
  	</select>
        </td>
        <!-- <td>FPL Per Cent:</td><td><input class=pink type=text name=fplPerCent maxlength=9 size=10></td> -->
        </tr>




	<tr>
	<td>Household Size:</td><td>
  	<select name="householdSize">
  		<option value="1" selected>1</option>
<?
		for ($i=2;$i < 10;$i++) {
	 		echo "<option value=".$i." >".$i."</option>";
		}
?>
  	</select>
        </td>
	<td>Response Format:</td><td>
  	<select name="responseFormat" >
  		<option value="json" selected>JSON</option>
  		<option value="xml" >XML</option>
  	</select>
        </td></tr>

<?

echo "<tr><td colspan=6>&nbsp;</td></tr>";

echo "<br><br>";





?>

    <tr>
    <td colspan=2><input class="gray" type="Submit" name="submit" value="Submit"></td></tr>
    </table>
    </p>
    </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
