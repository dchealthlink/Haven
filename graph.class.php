<?php

// Graph Generator for PHP
// http://szewo.com/php/graph

class phpGraph {
 var $_values;
 var $_ShowLabels;       
 var $_ShowCounts;       
 var $_ShowCountsMode;   
   
 var $_BarWidth;
 var $_GraphWidth;
 var $_BarImg;
 var $_BarBorderWidth;
 var $_BarBorderColor;
 var $_ShowCountsMode;
 var $_RowSortMode;
 var $_TDClassHead;
 var $_TDClassLabel;
 var $_TDClassCount;
 var $_GraphTitle;         

 function phpGraph() {
  $this->_values = array();
  $this->_ShowLabels = true;
  $this->_BarWidth = 16;
  $this->_GraphWidth = 360;
  $this->_BarImg = "http://www.szewo.com/php/graph/graph.gif";
  $this->_BarBorderWidth = 0;  
  $this->_BarBorderColor = "red";  
  $this->_ShowCountsMode = 2;
  $this->_RowSortMode = 1;  
  $this->_TDClassHead = "grphh";
  $this->_TDClassLabel = "grph";
  $this->_TDClassCount = "grphc";
  $this->_GraphTitle="Graph title>";    
 }

 function SetBarBorderWidth($width) {
  $this->_BarBorderWidth = $width;
 }
 function SetBorderColor($color) {
  $this->_BarBorderColor = $color;
 } 
 
//  mode = 1 labels asc, 2 label desc
 function SetSortMode($mode) {
  switch ($mode) {
   case 1:
    asort($this->_values);
    break;  
   case 2:
    arsort($this->_values);   
    break;
   default:
    break;
   }

 }

 function AddValue($labelName, $theValue) {
  array_push($this->_values, array("label" => $labelName, "value" => $theValue));

 }
 function SetBarWidth($width) {
  $this->_BarWidth = $width;
 }
 function SetBarImg($img) {
  $this->_BarImg = $img;
 }
 function SetShowLabels($lables) {
  $this->_ShowLabels = $labels;
 }
 function SetGraphWidth($width) {
  $this->_GraphWidth = $width;
 }
 function SetGraphTitle($title) {
  $this->_GraphTitle = $title;
 }
 //mode = percentage or counts
 function SetShowCountsMode($mode) {
  $this->_ShowCountsMode = $mode;
 }
 //mode = none(0) label(1) or count(2)
 function SetRowSortMode($sortmode) {
  $this->_RowSortMode = $sortmode;
 } 
 
 function SetTDClassHead($class) {
  $this->_TDClassHead = $class;
 } 
 function SetTDClassLabel($class) {
  $this->_TDClassLabel = $class;
 } 
 function SetTDClassCount($class) {
  $this->_TDClassCount = $class;
 }  
 function GetMaxVal() {
  $maxval = 0;
  foreach($this->_values as $value) if($maxval<$value["value"]) $maxval = $value["value"];
  return $maxval;
 }
 function BarGraphVert() {
  $maxval = $this->GetMaxVal();
  foreach($this->_values as $value) $sumval += $value["value"]; 
  $this->SetSortMode($this->_RowSortMode);
  echo "<table>";
  if (strlen($this->_GraphTitle)>0)  echo "<tr><td colspan=".count($this->_values)." class=\"".$this->_TDClassHead."\">".$this->_GraphTitle."</TD></TR>"; 
   echo "<tr>";
   foreach($this->_values as $value) {
    echo "<td valign=bottom align=center>";
    $height = $this->_BarWidth;
    $width=ceil($value["value"]*$this->_GraphWidth/$maxval);
    echo "<img SRC=\"".$this->_BarImg."\" height=$width width=$height ";
    echo "  style=\"border: ".$this->_BarBorderWidth."px solid ".$this->_BarBorderColor."\"";
    echo ">";
    echo "</TD>";
   }
   echo "</TR>";
   if ($this->_ShowCountsMode>0) {
   	echo "<tr>";
    foreach($this->_values as $value) {
     switch ($this->_ShowCountsMode) {
     case 1:
      $count = round(100*$value["value"]/$sumval)."%";
      break;  
     case 2:
      $count = $value["value"];
      break;  /* Exit the switch and the while. */
     default:
      break;
     }
     echo "<td align=center class=".$this->_TDClassCount.">$count</TD>";
   	}
	echo "</tr>";
   }   

   if ($this->_ShowLabels) { 
    echo "<tr>"; 
    foreach($this->_values as $value) {
     echo "<td align=center class=".$this->_TDClassLabel;
	 echo ">".$value["label"]."</TD>";
	}
	echo "</tr>"; 
   }	 

  echo "</TABLE>";   
 }



 function BarGraphHoriz() {
  $maxval = $this->GetMaxVal();
  foreach($this->_values as $value) $sumval += $value["value"]; 
  $this->SetSortMode($this->_RowSortMode);
  echo "<table border=0>";
  if (strlen($this->_GraphTitle)>0)  {
    echo "<tr><td ";
   if ($this->_ShowCountsMode>0) echo " colspan=2";
    echo " class=\"".$this->_TDClassHead."\">".$this->_GraphTitle."</TD></TR>";
  } 
  foreach($this->_values as $value) {
   if ($this->_ShowLabels) { 
    echo "<tr>"; 
    echo "<td class=".$this->_TDClassLabel;
    if ($this->_ShowCountsMode>0) echo " colspan=2";
	echo ">".$value["label"]."</TD></TR>";
   }	 
   echo "<tr>";
   if ($this->_ShowCountsMode>0) {
    switch ($this->_ShowCountsMode) {
    case 1:
     $count = round(100*$value["value"]/$sumval)."%";
     break;  
    case 2:
     $count = $value["value"];
     break;  /* Exit the switch and the while. */
    default:
     break;
    }
   echo "<td class=".$this->_TDClassCount.">$count</TD>";
   }
   echo "<td>";
   $height = $this->_BarWidth;
    $width=ceil($value["value"]*$this->_GraphWidth/$maxval);
   echo "<img SRC=\"".$this->_BarImg."\" height=$height width=$width ";
   echo "  style=\"border: ".$this->_BarBorderWidth."px solid ".$this->_BarBorderColor."\"";
   echo ">";
   echo "</TD></TR>";
  }
  echo "</TABLE>";   
 }
}

?>




