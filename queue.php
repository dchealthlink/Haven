<?
# queue.php

# Define the queue class
class queue
{
   # Initialize class variables
   var $queueData = array();
   var $currentItem = 0;
   var $lastItem = 0;
   
   # This function adds an item to the end of the queue
   function enqueue($object)
   {
       # Increment the last item counter
       $this->lastItem = count($this->queueData);
       
       # Add the item to the end of the queue
       $this->queueData[$this->lastItem] = $object;
   }
   
   # This function removes an item from the front of the queue
   function dequeue()
   {
       # If the queue is not empty...
       if(! $this->is_empty())
       {
           # Get the object at the front of the queue
           $object = $this->queueData[$this->currentItem];
           
           # Remove the object at the front of the queue
           unset($this->queueData[$this->currentItem]);
           
           # Increment the current item counter
           $this->currentItem++;
           
           # Return the object
           return $object;
       }
       # If the queue is empty...
       else
       {
           # Return a null value
           return null;
       }
   }
   
   # This function specifies whether or not the queue is empty
   function is_empty()
   {
       # If the queue is empty...
       if($this->currentItem > $this->lastItem)
           
           # Return a value of true
           return true;
           
       # If the queue is not empty...
       else
       
           # Return a value of false
           return false;
   }
}

?>

