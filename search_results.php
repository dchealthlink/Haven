<?php
session_start();
if ($SUBMIT) {

        $KEYFLD0 = stripslashes($vari);
}

include "inc/dbconnect.php";
include("inc/index_header_inc.php");

?>

<?

/* ============= new stuff ========== */
?>

</head>
<body>

<FORM NAME="mainform" METHOD="get" ACTION="<?php $PHP_SELF ?>">
<?

      echo "<tr><td><table width=90% border=1 align=center cellpadding=5 cellspacing=0 bordercolor=#CCCCCC background=images/bgsearch.jpg>";
?>
            <tr align="left" valign="center">
            <td height="33" colspan="2">
              <input name="vari" type="text" class="pink" value="<?php echo stripslashes($KEYFLD0) ?>" size="80" onKeyPress="return submitenter(this,event)"> 

       <input type="submit" name="SUBMIT" value="Search">
</tr>


</td></table>

<?



$KEYFLD0 = stripslashes ($KEYFLD0);
/* = new array handler = */ 
$KEYFLD0 = strtr($KEYFLD0,"\"","'");
	$KEYFLD0 =$KEYFLD0." ";

if (!((substr_count($KEYFLD0,"'") % 2) == 0) and (substr_count($KEYFLD0,"'") > 0)) { 
	/* if ((substr_count($KEYFLD0,"'") % 2) == 0) {
	if (substr_count($KEYFLD0,"'")  <= 1) { 
	echo "<p>modulus is".(substr_count($KEYFLD0,"'") % 2)."</p>";
	*/
	$KEYFLD0 = ereg_replace("'","",$KEYFLD0);
	$keyfld_array = explode(" ",$KEYFLD0);
} else {


	$str_len = strlen($KEYFLD0) ;
	$beginfld = 1;
	$arraycnt = 0;
	$arrayval = "";

	for ($i = 0; $i < $str_len; $i++) {

		$str_char = $KEYFLD0{$i} ;

		if ($in_quotes == 1) {
        		if ($str_char == "'") {
                		$in_quotes = 0;
				/*
				if ($arraycnt > 0) {
				$keyarray.=",";
				}
				$arraycnt = $arraycnt + 1;
				$keyarray.="'".$arrayval."',";
				*/

				$keyfld_array[]= $arrayval ;
				$arrayval = "";
				$beginfld = 0;
        		} else {
				$beginfld = 1;
                		$arrayval.=$str_char ;
        		}

		} else {

        		switch ($str_char) {

        			case "'":
                			$in_quotes= 1;
					$beginfld = 0;
					/*		$arraycnt = 1; */
                		break;
        			case " ":
					/*
						if ($arraycnt > 0) {
						$keyarray.=",";
						}
						$arraycnt = $arraycnt + 1;
						$keyarray.="'".$arrayval."',";
					*/
					$keyfld_array[]= $arrayval ;
					$arrayval = "";
					$beginfld = 0;
                		break;
        			default:
					$beginfld = 1;
                			$arrayval.=$str_char ;
                		break;
        		};
		}		

}

if ($beginfld == 1) {
	if ($arraycnt > 0) {
		$keyarray.=",";
	}
	$keyarray.="'".$arrayval."'";
	$beginfld = 0;
	$arraycnt = $arraycnt + 1;
	$arrayval = "";
}
}
/* set up the select array here */

$keyfld_array_count = count($keyfld_array);

for ($j=0; $j < $keyfld_array_count; $j++) {

	$keycheck = $keyfld_array[$j];

	if ($keyfld_array[$j]) { 

		if (in_array($keycheck,$minus_array)) {

		} else {
		$arraycnt = $arraycnt + 1;
		$keyarray.="'".strtolower($keyfld_array[$j])."',";
		}

	} 

}
		$KEYFLD0 = substr($KEYFLD0,0,-1); 
		$keyarray = substr($keyarray,0,-1); 
/* end the set up of the select array */

if ($debug) { 
echo "<p>KEYFLD0 = : ".$KEYFLD0."--</p>";
echo "<p>keyarray = : ".$keyarray."</p>";
print_r($keyfld_array);
} 

$newfld = ereg_replace("'","''",$keyarray);
if ($debug) {
echo "<p>newfld = : ".$newfld."</p>";
}
if (!$start) {
$start = 0;
}

echo "</table>";
echo "<br>";

echo "<table align=center width=96% cellpadding=5 cellspacing=5>";
echo "<hr class=sponsor>";

$host="localhost";
$port = 8080;
$query = "search.jsp?query=";
/*
if (!$start) {
$start = 0;
}
*/
$nohits = 10 ;

$fp = fsockopen ($host, $port, $errno, $errstr);

if (!$fp) {
   echo "$errstr ($errno)<br />\n";
} else {

$KEYFLD0 = ereg_replace(" ","+",$KEYFLD0);
$SRCHKEYFLD0 = $KEYFLD0;
if ($debug) {
 echo "<p>Get /search.jsp?query=".$SRCHKEYFLD0."&start=".$start."&hitsPerPage=".$nohits." HTTP/1.0</p>";
}

 $search_query = "Get /search.jsp?query=".$SRCHKEYFLD0."&start=".$start."&hitsPerPage=".$nohits." HTTP/1.0\r\n";
 fputs ($fp, $search_query) ;


 fputs ($fp, "Host: ".$host.":".$port."\r\n\r\n");
}

 $lineno = 0;

echo "<tr><td>";

   while (!feof($fp)) {
       $linedata = fgets($fp, 1024);

        if ($lineno == 1) {
        $linedata = ereg_replace("/img/powered","http://itcom.fullmoonsoft.com:8080/img/powered",$linedata);

	$pos = strpos($linedata,"/search.jsp");

if ($pos === false) {

                echo $linedata ;

} else {

		echo "</FORM>";

		echo "<FORM NAME=search METHOD=get ACTION=search_results.php>";
		echo "<input type=hidden name=category value=".$category.">";
		echo "<input type=hidden name=sub_cat value=".$sub_cat.">";
		echo "<input type=hidden name=KEYFLD0 value=".$KEYFLD0.">";
}

        }

        if (substr($linedata,0,4) == 'Hits') {
		$newlinedata = strip_tags($linedata);

		echo "<tr><td>".$linedata."</td>";

if ($num_rows > 0) {
echo "<td align=right><b>Campaigns:</b></td></tr>";
}

echo "</table>";
echo "<table class=return width=95% cellspacing=5 cellpadding=5>";
                $lineno = $lineno + 1;
$rownum = 0;
/* ============ trying this here ============== */



echo "</table>";
echo "<table width=96%>";
	echo "<tr><td>&nbsp</td><td align=right><b>Search Results:</b></td></tr>";
echo "</table>";
echo "<table align=center width=86%>";


/* ============ ending =============== */


       } 


   }
   fclose($fp);

echo "</td></tr></table>";

/* =========================== */

?>
            </p>
<?
		echo "</FORM>";
include "inc/footer_inc.php";
?>
</HTML>


