<?
//------------------------------------------------------------------
//created by mike wolf(init): wolf@geekpunk.org
//
//description:
//used to display a db diagram and table/sequence list
//for a postgres DB.  You can either specifiy the main 
//vars below or pass them along in the url
//
//V1V4 L4 0P3N 50URC3
//
//------------------------------------------------------------------


//-----------------------------------------------------------------
//chage these variables as needed
//-----------------------------------------------------------------
$db="citcomp";
$server="LOCALHOST";
$pass="mookie";
$user="root";
//-----------------------------------------------------------------
//change below at your own risk....
//-----------------------------------------------------------------




function tabledisplay($SQL,$DBSERVER,$DB,$USERNAME,$PASSWORD)
{

// make a connection and get a result

$connection = pg_connect("host=$DBSERVER dbname=$DB user=$USERNAME password=$PASSWORD") or die("couldnt make a connection to DB");

// lets get the details for looping
$sql_result=pg_exec($connection,$SQL) or die("query has errors in it");
$num = pg_numrows($sql_result);
$GLOBALS["rowcount"] = pg_numrows($sql_result);
$fieldnum = pg_numfields($sql_result);

//lets get those field names and populate the array
for($i=0;$i<$fieldnum; $i++)
{
	
	$fieldname[]=pg_fieldname($sql_result,$i);
	$fieldname2[pg_fieldname($sql_result,$i)][]="";
	while($x<$num)
	{
	$row=pg_fetch_array($sql_result,$x);
	$fieldname2[pg_fieldname($sql_result,$i)][$x].=$row[pg_fieldname($sql_result,$i)];
	$x++;
	}
	$x=0;
}

//set a gloabl var to the tables
for($i=0;$i<$num;$i++)
{
   $GLOBALS["tables"].= $fieldname2["Name"][$i] . "<br>";
}



//pull out the table details

for($X=1;$X<$num;$X++)
{ 
   $table = $fieldname2["Name"][$X];
   if(strrpos($table,"_seq")== false)
   {
	$GLOBALS["fieldrow"].="<table border=1>";
	$sqlstate = "select  *  from  $table";
	pg_freeresult($sql_result);
        
	$sql_result=pg_exec($connection,$sqlstate) or die("query has errors in it");
	
        $GLOBALS["fieldrow"].="<tr style=\"background-color:CCCCCC;\"><td colspan=3>$table</td></tr>";
	for($Y=0;$Y<pg_numfields($sql_result);$Y++)
	{
		$fieldname=pg_fieldname($sql_result,$Y);
		$fieldtype=pg_fieldtype($sql_result,$Y);
		$fieldsize=pg_fieldsize($sql_result,$Y);
		$GLOBALS["fieldrow"].="<tr><td>$fieldname</td><td>$fieldtype</td><td>$fieldsize</td></tr>";
		
	}
	$GLOBALS["fieldrow"].="</table>\n<br>";
	
     }
}

//free up some memory
pg_freeresult($sql_result);
pg_close($connection);

}

//big old sql statement that does a \d on the db

$sql="SELECT c.relname as \"Name\", 'table'::text as \"Type\", u.usename as \"Owner\"" ;
$sql.="FROM pg_class c, pg_user u" ;
$sql.=" WHERE c.relowner = u.usesysid AND c.relkind = 'r'" ;
$sql.="  AND c.relname !~ '^pg_'" ;
$sql.=" UNION SELECT c.relname as \"Name\", 'table'::text as \"Type\", NULL as \"Owner\" FROM pg_class c " ;
$sql.="WHERE c.relkind = 'r' AND not exists (select 1 from pg_user where usesysid = c.relowner) " ;
$sql.="AND c.relname !~ '^pg_' UNION SELECT c.relname as \"Name\", 'view'::text as \"Type\", u.usename as \"Owner\"" ;
$sql.="FROM pg_class c, pg_user u WHERE c.relowner = u.usesysid AND c.relkind = 'v'" ;
$sql.="  AND c.relname !~ '^pg_'" ;
$sql.=" UNION" ;
$sql.=" SELECT c.relname as \"Name\", 'view'::text as \"Type\", NULL as \"Owner\"" ;
$sql.="FROM pg_class c";
$sql.=" WHERE c.relkind = 'v'" ;
$sql.="  AND not exists (select 1 from pg_user where usesysid = c.relowner)" ;
$sql.="  AND c.relname !~ '^pg_'";
$sql.=" UNION ";

$sql.="SELECT c.relname as \"Name\", " ;
$sql.=" (CASE WHEN relkind = 'S' THEN 'sequence'::text ELSE 'index'::text END) as \"Type\",  u.usename as \"Owner\""; 
$sql.="FROM pg_class c, pg_user u ";
$sql.="WHERE c.relowner = u.usesysid AND relkind in ('S')" ;
$sql.="  AND c.relname !~ '^pg_'";
$sql.=" UNION ";
$sql.="SELECT c.relname as \"Name\"," ;
$sql.="  (CASE WHEN relkind = 'S' THEN 'sequence'::text ELSE 'index'::text END) as \"Type\", NULL as \"Owner\"" ;
$sql.="FROM pg_class c WHERE not exists (select 1 from pg_user where usesysid = c.relowner) AND relkind ";
$sql.=" in ('S')   AND c.relname !~ '^pg_'";


//call the function which will set some global variables use @ to suppress error
@tabledisplay($sql,$server,$db,$user,$pass);


?>

<!--- display them -->

TABLE/SEQUENCE NAMES
<hr>
<?
echo $GLOBALS["tables"];
?>
<hr>
TABLES
<hr>
<?
echo $GLOBALS["fieldrow"];
?>


