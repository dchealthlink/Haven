<?php
session_start();
include("inc/dbconnect.php");

$falseid = (date("y") * 10000000) + ((date("z") + 1) * 10000) ;
$falseid = date("ymdhis") ;

$show_menu="ON";

 include("inc/index_header_inc.php"); 
?>
<HTML>
<head>
<script language="javascript">
function submitform(form){
  var myindex=form.hh.selectedIndex;
  prim=form.hh.options[myindex].value;
  location="mcheck_aptc.php?no="+prim;
  mainform.applName.focus();
  }
function showpeople(lnno,strt) {
	var e = parseInt(document.getElementById("hh").value);
	var outer = e - (lnno + 1);
	var allopts = (e * (e - 1)) / 2;
	var fullname0=document.getElementById('aptcnamen['+lnno+']'); 
	var ctr = strt;
	var k = 0;
	var lasthit  = 'dummy';

	for (i = 0; i < outer; i++) {
        	document.getElementById("theperson["+ctr+"]").value = fullname0.value.toUpperCase();
        	document.getElementById("personcode["+ctr+"]").value = lnno;
		ctr = ctr + 1;
	}
	for (j = 0; j < allopts; j++) {
		if (document.getElementById("relperson["+j+"]").value == "" && k < lnno) {
			if (lasthit != document.getElementById("theperson["+j+"]").value) {
        			document.getElementById("relperson["+j+"]").value = fullname0.value.toUpperCase();
        			document.getElementById("relcode["+j+"]").value = lnno;
				lasthit = document.getElementById("theperson["+j+"]").value ;
				k = k + 1;
			}
		} 
	}
}
function calculateAge(dateString,arrno) { // birthday is a date
        if (dateString.value.length == 8) {
                var dateString1 = dateString.value.substring(0,4)+'-'+dateString.value.substring(4,6)+'-'+dateString.value.substring(6,8);
        } else {
                var dateString1 = dateString.value;
        }
  var birthday = +new Date(dateString1);
  var applAge = document.getElementById("applAge["+arrno+"]");
  var age =  ~~((Date.now() - birthday) / (31557600000));
        if (age >= 0) {
        applAge.value = age;
        }
}
function BisDate(val, req) {
// Check for a properly formatted ANSI short date or a date shortcut.
   if ((val.value.length == 0) && (req == "R")) {
      alert("This field is required.");
      val.focus();
      val.select();
      return false;
   }
   if (val.value.length != 0) {
      var shortform = /^[TtDd]{1}/;
      var midform = /^[0-9]{4}[0-9]{2}[0-9]{2}$/;
      var longform = /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/;
//      var longform = /^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/;
      if (!longform.test(val.value)) {
         if (shortform.test(val.value)) {
            return true;
         }
         if (midform.test(val.value)) {
            return true;
         }
         if (val.value == "now") {
                HoldDate=new Date();
                val.value = (HoldDate.getFullYear() * 10000) + ((HoldDate.getMonth()+1) * 100) + HoldDate.getDate();
                return true;
         }
         alert ("This field must contain date format. (YYYY-MM-DD)");
         val.focus();
         val.select();
         return false;
      }
   }
   return true;
}
function showExpectedChildren(row_no) {
  	if (document.getElementById("isExp["+row_no+"]").value == "Y") {
              document.getElementById("expKids["+row_no+"]").style.display = '';
              document.getElementById("expKidsLabel").style.display = '';
              document.getElementById("expKidNo["+row_no+"]").value = 1;
        } else {
              document.getElementById("expKidNo["+row_no+"]").value = 0;
              document.getElementById("expKids["+row_no+"]").style.display = 'none';
//              document.getElementById("expKidsLabel").style.display = 'none';
        }
}




</script>

</head>
<tr><td>
  <blockquote>
   <h1>APTC check:</h1>

   <form name="mainform" method="post" action="mcheck_add.php">

<?
        echo "<tr><td><table>";
        echo "<tr><td>";
	echo "Household Size:&nbsp;&nbsp;&nbsp;";
  	echo '<select id="hh" name="hh" onChange=submitform(this.form)>';
  		echo '<option value="1" selected>1</option>';

		for ($i=2;$i <= 10;$i++) {
			if ($_GET['no'] == $i) {
	 			echo "<option selected value=".$i." >".$i."</option>";
			} else {
	 			echo "<option value=".$i." >".$i."</option>";
			}
		}

  	echo '</select>';
	echo '</td>';
        echo '<td>Request Year:</td><td>';
        echo '<select name="requestYear">';
               echo '<option value="'.(date("Y")).'" selected>'.(date("Y")).'</option>';
                for ($i=1;$i < 3; $i++) {
                        echo "<option value=".((date("Y")) - $i)." >".((date("Y")) - $i)."</option>";
                }
        echo '</select>';

  	echo '</td></tr>';
	echo '</table';
  	echo '</td></tr>';
//        echo "<tr><td colspan=6>Name:&nbsp;&nbsp;&nbsp;<input class=pink type=text id=aptcName name=aptcName maxlength=70 size=40>";
        echo "<tr><td colspan=6>Name:&nbsp;&nbsp;&nbsp;<input type=text id=applName name=applName maxlength=70 size=40>";
	echo '<input type=hidden name=applId value='.$falseid.'></td></tr>';
	echo '<input type=hidden name=user value=100000></td></tr>';

	echo "<tr><td colspan=10>&nbsp;</td></tr>";
?>
	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=95%> 

	<tr><td colspan=10><table border=1 width=95%>
	<td>Name</td>
	<td>D.O.B.</td>
	<td>Age</td>
<!--	<td>Hrs Worked</td> -->
	<td>No. Deps</td>
	<td>Annual Income</td>
<!--	<td>Parent</td>
	<td>Dependant</td>  -->
	<td>Tax Relation</td>
	<td>Incarcerated</td>
	<td>Five Year<br>Bar Met</td>
	<td>Have Other<br>Coverage</td>
	<td>Pregnant</td>
	<td id=expKidsLabel style="display:none">Expected<br>Kids</td>
	</tr>

<?
if ($_GET['no'] > 0) {
	$app_no = $_GET['no'];
} else {
	$app_no = 1;
}
	$startline = 0;
	for($j=0; $j< $app_no; $j++) {

        echo '<tr>';
	echo '<td><input class=pink type=text id="aptcnamen['.$j.']" name=aptc_array['.$j.'][0] maxlength=40 size=25 onchange="showpeople('.$j.','.$startline.');"></td>';
	$startline = $startline + (($_GET['no'] - $j) - 1);
	echo "<td><input class=pink type=text id=applDOB[".$j."] name=aptc_array[".$j."][1] maxlength=10 size=8  onblur='BisDate(this,'N');' onchange='calculateAge(this,".$j.")';></td>";
/*
        echo '<td>';
  	echo '<select name=aptc_array['.$j.'][1]>';
		for ($i=1;$i < 100;$i++) {
	 		echo "<option value=".$i." >".$i."</option>";
		}
  	echo '</select>';
	echo '</td>';
*/  
	echo '<td><input class=nb type=text id="applAge['.$j.']" name=aptc_array['.$j.'][2] maxlength=5 size=5 readonly></td>';
/*
        echo '<td>';
  	echo '<select name=aptc_array['.$j.'][3]>';
		for ($i=0;$i <= 80;$i++) {
	 		echo "<option value=".$i." >".$i."</option>";
		}
  	echo '</select>';
	echo '</td>';
*/
	echo '<td>';
  	echo '<select name="aptc_array['.$j.'][4]">';
  		echo '<option value="0" selected>0</option>';

		for ($i=1;$i < 10;$i++) {
	 		echo "<option value=".$i." >".$i."</option>";
		}

  	echo '</select>';
        echo '</td>';
        echo '<td><input class=pink type=text name=aptc_array['.$j.'][5] maxlength=10 size=9></td>';
/*
	echo '<td>';
  	echo '<select name="aptc_array['.$j.'][5]" >';
  		echo '<option value="N" selected>No</option>';
	  	echo '<option value="Y" >Yes</option>';
  	echo '</select>';
	echo '</td>';
	echo '<td>';
  	echo '<select name="aptc_array['.$j.'][6]" >';
  		echo '<option value="N" selected>No</option>';
  		echo '<option value="Y" >Yes</option>';
  	echo '</select>';
	echo '</td>';
*/
	echo '<td>';
  	echo '<select name="aptc_array['.$j.'][8]" >';
  		echo '<option value="Filers" selected>Filer</option>';
  		echo '<option value="Dependents" >Dependent</option>';
  	echo '</select>';
	echo '</td>';
	echo '<td>';
  	echo '<select name="aptc_array['.$j.'][9]" >';
  		echo '<option value="N" selected>No</option>';
  		echo '<option value="Y" >Yes</option>';
  	echo '</select>';
	echo '</td>';
	echo '<td>';
  	echo '<select name="aptc_array['.$j.'][10]" >';
  		echo '<option value="Y" selected>Yes</option>';
  		echo '<option value="N" >No</option>';
  	echo '</select>';
	echo '</td>';
	echo '<td>';
  	echo '<select name="aptc_array['.$j.'][11]" >';
  		echo '<option value="N" selected>No</option>';
  		echo '<option value="Y" >Yes</option>';
  	echo '</select>';
	echo '</td>';
	echo '<td>';
  	echo '<select id=isExp['.$j.'] name="aptc_array['.$j.'][6]" onchange="showExpectedChildren('.$j.');">';
  		echo '<option value="N" selected>No</option>';
  		echo '<option value="Y" >Yes</option>';
  	echo '</select>';
	echo '</td>';
	echo '<td id=expKids['.$j.'] style="display:none">';
  	echo '<select name="aptc_array['.$j.'][7]" id=expKidNo['.$j.']>';
  		echo '<option value="0" selected>0</option>';

		for ($i=1;$i < 10;$i++) {
	 		echo "<option value=".$i." >".$i."</option>";
		}

  	echo '</select>';
        echo '</td>';
	echo '</tr>';

	}
?>
	</table></td></tr>
	<tr><td colspan=6>&nbsp;</td></tr>

<?

echo "<tr><td colspan=6>&nbsp;</td></tr>";
echo "<tr><td colspan=6><table>";

if ($_GET['no']) {
	$rel_rows = ($_GET['no'] * ($_GET['no'] - 1))/2;
	for($j=0;$j<$rel_rows;$j++) {
	 	echo "<tr>";
			echo "<td align=right width=40><input type=text class=nb id=relperson[".$j."] name=relarray[".$j."][0] readonly size=45></td>";
			echo "<td align=center>is the</td>";
  $sql = "SELECT relationship FROM relationship ORDER BY sort_order ";

$result = execSql($db, $sql, $debug);

  		echo '<td width=60><select name="relarray['.$j.'][1]" >';
  		echo '<option value="" selected></option>';
        $rownum=0;
while ($row = pg_fetch_array($result,$rownum))
{
        list($temp_rel) = pg_fetch_row($result,$rownum);
                echo "<option value=".$temp_rel.">".$temp_rel;
        $rownum = $rownum + 1;
}

  		echo '</select>';
		echo "</td>";
		echo "<td align=center width=25>of</td>";
			echo "<td align=left><input type=text class=nb id=theperson[".$j."] name=relarray[".$j."][2] size=45 readonly><input type=hidden id=relcode[".$j."] name=relarray[".$j."][3]><input type=hidden id=personcode[".$j."] name=relarray[".$j."][4]>";
		echo "</td>";
		echo "</tr>";
	}
}

// echo "<tr><td colspan=6><B>Additional Information:</B></td></tr>";

echo "</table></td></tr>";
echo "<br><br>";
//    echo "<tr><td align=center colspan=2><b>---------------</a></b></td><td align=left colspan=2>------------------------------</td></tr>";





?>
	<tr><td colspan=6>&nbsp;</td></tr>

    	<tr>
	<td align=right>Response Format:</td><td>
  	<select name="responseFormat" >
  		<option value="json" selected>JSON</option>
  		<option value="xml" >XML</option>
  	</select>
        </td></tr>

    <tr>
    <td colspan=2><input class="gray" type="Submit" name="formsubmit" value="Submit"></td></tr>
    </table>
    </p>
    </form>
</blockquote>
<?

// include "inc/cb_footer.htm";
 include "inc/footer_inc.php";
?>
</body>
</HTML>
