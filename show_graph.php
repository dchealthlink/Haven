<?
echo "<table border=1>";
echo "<td>";
include ("inc/graph.class.php");

   $myFirstGraph = new phpGraph;
   $myFirstGraph->SetBarImg("graphics/laurel_sm_seal.jpg");
   $myFirstGraph->SetGraphTitle("Are you from Japan?");
   $myFirstGraph->AddValue("Yes",4);
   $myFirstGraph->AddValue("No",5);
   $myFirstGraph->AddValue("I don't know",3);
   $myFirstGraph->SetShowCountsMode(1);
   $myFirstGraph->SetBarWidth(90);
   $myFirstGraph->SetBorderColor("#333333");
   $myFirstGraph->SetBarBorderWidth(1);
   $myFirstGraph->SetGraphWidth(320);
   $myFirstGraph->BarGraphHoriz();
?>
</td>
</table>
<br>
<br>
<br>
<?
   $mySecondGraph = new phpGraph;
   $mySecondGraph->SetGraphTitle("Teenagers' age ");      
   $mySecondGraph->AddValue("Year<br>1995",10);    
   $mySecondGraph->AddValue("Year<br>1996",11);
   $mySecondGraph->AddValue("Year<br>1997",12);
   $mySecondGraph->AddValue("Year<br>1998",13);    
   $mySecondGraph->AddValue("Year<br>1999",12);
   $mySecondGraph->AddValue("Year<br>2000",15);
   $mySecondGraph->AddValue("Year<br>2001",16);
   $mySecondGraph->AddValue("Year<br>2002",12);
   $mySecondGraph->SetShowCountsMode(3);
   $mySecondGraph->SetBarWidth(35);
   $mySecondGraph->SetBorderColor("#333333");
   $mySecondGraph->SetBarBorderWidth(1);      
   $mySecondGraph->SetGraphWidth(360);
   $mySecondGraph->BarGraphVert();
?>

<br><br>
  <img src="inc/piemaker.php?width=400&height=400&values=84,27,32,91,15,53&desc=January,February,March,April,May,June&title=Calls+Per+Month">


<br>
<?
   $mySecondGraph = new phpGraph;
   $mySecondGraph->SetGraphTitle("Calls per Month");
   $mySecondGraph->AddValue("Jan",84);
   $mySecondGraph->AddValue("Feb",26);
   $mySecondGraph->AddValue("Mar",32);
   $mySecondGraph->AddValue("Apr",91);
   $mySecondGraph->AddValue("May",16);
   $mySecondGraph->AddValue("Jun",53);
   $mySecondGraph->SetShowCountsMode(2);
   $mySecondGraph->SetBarWidth(35);
   $mySecondGraph->SetBorderColor("#333333");
   $mySecondGraph->SetBarBorderWidth(1);
   $mySecondGraph->SetGraphWidth(360);
   $mySecondGraph->BarGraphVert();
   $mySecondGraph->SetRowSortMode(1);
?>

