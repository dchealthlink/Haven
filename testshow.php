<?php
?>
  <HEad>
    <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script> 
       $(document).ready(function() {
         $.setDisplay = function (id){
           if($("#" + id ).css('display') == 'none'){
             $("#" + id ).css('display', 'block');
           }
           else
           if($("#" + id ).css('display') == 'block'){
             $("#" + id ).css('display', 'none');
           }
         }

         $('*[id^="divheader"]').click(function (){
            $.setDisplay($(this).data("id"));
         });
       });
     </script>
  </HEad>        

<div id='divheader-div1' data-id='div1'>
  This is the header Click to show/unshow
</div>
<div id='div1' style='display: block'>
  <div>
    <label for="startrow">Retail Price:</label>
    <input type="text" name="price" id="price" value=""><small></small>
  </div>
</div>

<div id='divheader-div2' data-id='div2'>
 This is the header Click to show/unshow
</div>
<div id='div2' style='display: none'>
 <div>
   <label for="startrow">Division:</label>
   <input type="text" name="division" id="division" value=""><small> </small>
 </div>
</div>
