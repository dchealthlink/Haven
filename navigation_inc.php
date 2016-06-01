<?
/* echo "<p>page = ".$PHP_SELF." - key_attribute = ".$key_attribute." - key_value = ".$key_value."</p>"; */
if (!session_is_registered("userid"))
{
	header ("Location: itlogin.php");
	exit;
} else {

	if ($user_type == 'admin' or $user_type == 'vendor') {

	if(!$key_attribute) {
		$menu_enabled=0;
		if ($cust_id) {
        		$sql_where_clause =" where cust_id = ".$cust_id ;
        		$menu_enabled = 1;
        		$key_attribute = "cust_id";
        		$key_value = $cust_id;
		}
		if ($sponsor_id) {
        		$sql_where_clause =" where sponsor_id = ".$sponsor_id ;
        		$menu_enabled = 1;
        		$key_attribute = "sponsor_id";

        		$key_value = $sponsor_id;
		}
} else {


        		$menu_enabled = 1;

        			$$key_attribute = $key_value;

}



	} else {

		if(!session_is_registered("key_attribute"))
		{
			header("Location: select_new.php");
			exit;
		} else {
			if (!$key_value) {
				header("Location: select_new.php");
				exit;

			} else {
        		$menu_enabled = 1;
        			$$key_attribute = $key_value;
			}
		}

	}
$left_menu = display_menu_array($db,(substr($PHP_SELF, (strrpos($PHP_SELF, "/") + 1), 35)),$HTTP_REFERER,$menu_enabled, $user_level);
}
?>
