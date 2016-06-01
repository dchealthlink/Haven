<?PHP
/**
*	patDbc simple example
*	
*	you need to set up a mysql database and change values in this exmple
*	to make it work
*/

	$db_host	=	"localhost";
	$db_name	=	"citcomp";
	$db_user	=	"root";
	$db_pass	=	"mypass";

	//	include dbc classes
	include( "inc/patDBC.php" );
	
	//	create new dbc
	$dbc	=	new	patMysqlDbc( $db_host, $db_name, $db_user );
	// $dbc	=	new	patMysqlDbc( $db_host, $db_name, $db_user, $db_pass );
	
	//	open connection, can be left out (if query is sent, patDbc will
	//	automatically open the connection, if it's not already opened.
	$dbc->connect();

	//	Send a query
	$query	=	"SELECT * FROM app_lookup";
	$result	=	$dbc->query( $query );

	//	dump the result
	$result->dump();
	
	//	close the connection
	$dbc->close();
?>
