<?php
$db = pg_connect("host=localhost dbname=citcomp user=root");

//#Examples of the use of the class

//# Make sure to include the file defining the class
include("queue.php");

//# Create a new instance of the queue object
$q = new queue;

//# Get data from a table
$query = "SELECT * FROM app_lookup";
$result = pg_query($db,$query);

// $rownum = 0;
//# For each row in the resulting recordset...
// while($row = pg_fetch_object($result,$rownum))
while($row = pg_fetch_object($result))
{
   # Enqueue the row
   # $q->enqueue($row);
    echo $row->lookup_table." (";
    echo $row->lookup_field ."): ";
    echo $row->item_cd."<BR>";
//	$rownum++;

}

//# Convert the queue object to a byte stream for data transport
$queueData = ereg_replace("\"", "&quot;", serialize($q));

//# Convert the queue from a byte stream back to an object
$q = unserialize(stripslashes($queueData));

//# For each item in the queue...
while(! $q->is_empty())
{
   # Dequeue an item from the queue
   $row = $q->dequeue();
} 
?>
