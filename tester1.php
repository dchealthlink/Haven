<html>
<title>CodeAve.com(Display/No Display Content)</title>
<body bgcolor="#FFFFFF">

<script language="JavaScript">
<!-- 
function Show_Stuff(Click_Menu)
// Function that will swap the display/no display for 
// all content within span tags
{
if (Click_Menu.style.display == "none")
{
Click_Menu.style.display = "";
}
else
{
Click_Menu.style.display = "none";
}
}
-->
</script>

<DIV><a href="javascript:Show_Stuff(display1)">Link #1 (Hyperlink)</a></DIV>

<!-- The code within the span tags will not be displayed until
 the user click the link above and will "disappear" when clicked a second time 
 The link above is set to display anything with a span tag with an id = display1-->

<span ID="display1" style="display: none">
<table bgcolor="#FFFFCC">
<tr><td width=200 wrap>
This is the table that will appear when link #1 is clicked. 
You can add in a <a target="_blank" href="http://www.yahoo.com">hyperlink</a>
or any other html
</td>
</tr>
</table>
</span>



<div onClick="Show_Stuff(display2)">Link #2 (OnClick Text Example)</div>

<!-- The code within the span tags will not be displayed until
 the user click the link above and will "disappear" when clicked a second time -->


<span id="display2" STYLE="display: none">
Text that will appear when link #2 is clicked
<br>
this too can be any html
</span>






</body> 
</html>

