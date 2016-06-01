<?
/* ==================== form where_clause ================== */
if($SEARCHQUERY or $DELETE) {

	$where_clause=" WHERE";

        if (!$sql1) {
                $sql1 = retrieve_columns($tablename);
        };

	$result = execSql($db,$sql1,$debug);
	$numrows = pg_numrows($result);
	$rownum = 0;

	while ($row = pg_fetch_array($result,$rownum)) {
		$matrix[$rownum][1] = $row[pg_fieldname($result,1)];
		$matrix[$rownum][3] = $row[pg_fieldname($result,6)];

        	if ($$matrix[$rownum][1]) {
                	$where_clause.=  " (".$matrix[$rownum][1]." = '".$$matrix[$rownum][1]."') AND ";
        	}

		$rownum = $rownum + 1;
	};

	$where_clause=substr($where_clause,0,-5);
};

/* ==================== end form where_clause ================== */
/* ==================== SUBMIT ================================= */

if ($SUBMIT) {

        $sql ="INSERT INTO ".$tablename." (";

        if (!$sql1) {
                $sql1 = retrieve_columns($header_table); 
		$numkeys = retrieve_keys($db, $header_table);
        };

        $result = execSql($db,$sql1,$debug);
        $numrows = pg_numrows($result);
	$rownum=0;
        while ($row = pg_fetch_array($result,$rownum)) {

                $matrix[$rownum + 0][1] = $row[pg_fieldname($result,1)];
                $matrix[$rownum + 0][3] = $row[pg_fieldname($result,6)];

/* == this is new to check for defaults ==== */
		if (strlen($$matrix[$rownum][1]) > 0) {

                	$oldsql.=  "".$matrix[$rownum + 0][1].",";
                	$sql.=  "".$matrix[$rownum + 0][1].",";

		}

                if (in_array($rownum + 1,$arr)) {
                        $newwhere_clause.= $row[pg_fieldname($result,1)]."='".$$matrix[$rownum + 0][1]."' and ";
                        /* $newwhere_clause.= $row[pg_fieldname($result,1)]."='".$first[$rownum + 0]."' and "; */

                        if ($view_type[$rownum + 0] == 'int4') {
                                $query_value.= $row[pg_fieldname($result,1)]."=".$$matrix[$rownum + 0][1]." ";
                        } else {
                                $query_value.= $row[pg_fieldname($result,1)]."='".$$matrix[$rownum + 0][1]."' ";
                        }

                        if($debug) {
                                DisplayErrMsg(sprintf("primary_keys: %s query_value: %s",count($arr), $query_value)) ;
                        }


                }


                $rownum = $rownum + 1;

	};

/* new line just to end it */

	$sql = substr($sql,0,-1);
	$sql.= ") VALUES (";

	if ($newwhere_clause) {
                $where_clause = " WHERE ".substr($newwhere_clause,0,-4);
        } else {
                $where_clause = "";
        }

	if ($debug) {
                DisplayErrMsg(sprintf("whereclause: %s newwhere: %s", $where_clause, $newwhere_clause)) ;
	}

        $sql2 = "SELECT COUNT(*) as unique_cnt FROM ".$header_table." ".$where_clause;

        $result = execSql($db, $sql2,$debug);

        $row = pg_fetch_array($result, 0);
        $unique_cnt = $row["unique_cnt"];

        if ($unique_cnt == 1) {

                /* DisplayErrMsg(sprintf("Data already exists for:")) ; */
                for ($q=0; $q < $numkeys; ++$q) {
                        /* DisplayErrMsg(sprintf("%s : %s ", $matrix[$q][1],$$matrix[$q][1])) ; */
                }

                /* echo "<p>The ".$header_table." data has not been created</p>"; */
                /* $message_data = "<font color=red>The ".$header_table." data has not been creapted</font>"; */
		$message_data="<br><font color=red>The ".$tablename." data has not been created</font><br>Data already exists for : ".(ereg_replace('WHERE','',$where_clause));

        } else {

                $numrows = count ($matrix); 

                for ($i=0;$i < $numrows ;++$i) {

/* == this is new to check for defaults ==== */
			if (strlen($$matrix[$i + 0][1]) > 0) {
                
				if ($matrix[$i][1] == "password") {
                        		$oldsql.= "'".crypt($first[$i],$first[0])."',";
                        		$sql.= "'".crypt($$matrix[$i][1],$$matrix[0][1])."',";
                        /* 		$sql.= "'".crypt($$matrix[$i][1],$email)."',"; */
                 		} else {
                     /*   $sql.= "'".$first[$i]."'"; */
                        		$oldsql.= "'".$first[$i]."',";
			
                        		$sql.= "'".$$matrix[$i][1]."',";
                		}

			}

		};

                $sql = substr($sql,0,-1);
                $sql.= ")";

	        $sql = str_replace ("''","null",$sql);


        	$result = execSql($db, $sql, $debug); 

        	if (pg_ErrorMessage($db)) {
                        DisplayErrMsg(sprintf("Executing: %s", $sql)) ;
                        DisplayErrMsg(sprintf("%s", pg_ErrorMessage($db))) ;
        	} else {
                        if ($header_table == 'user') {
                                $new_query = "action='password' user_id='".$first[1]."'";
                                $ret_code = notify_server($new_query, $db, $userid, 0);

                        }

			if ($site_redirect) {
				header ("Location: ".$site_redirect);                        
                        	$message_data="<font color=red>The ".$header_table." data has been added but it wont redirect</font>";
			} else {

				if (substr($result,0,5) == 'error') {
                        		$message_data = "<font color=red>Error adding data to ".$header_table."<br>".$result."</font>";
					
				} else {
                        		$message_data = "<font color=green>The ".$header_table." data has been added</font>";
				}	
			}

			$returnfields = get_table_field_access($db, $header_table,'insert');

        		$sql = "SELECT ".$returnfields." from ".$header_table." ".$where_clause;
        		$result = execSql($db, $sql, $debug);

        		$row = pg_fetch_array($result, 0);

        		$fieldnum = pg_numfields($result);

        		for($i=0;$i<$fieldnum; $i++) {
                        	$matrix[$i][4]=$row[pg_fieldname($result,$i)];
                	}
        	};

	};

};


/* ================= start update ================== */
if($UPDATE)
{
        $sql ="UPDATE ".$tablename." SET ";
        $where_clause=" ";

        if (!$sql1) {

                $sql1 = retrieve_columns($tablename);

        };      

        $result = execSql($db,$sql1, $debug);

        $numrows = pg_numrows($result);
	$rownum = 0;

        while ($row = pg_fetch_array($result,$rownum)) {

	        $matrix[$rownum][1] = $row[pg_fieldname($result,1)];
        	$matrix[$rownum][3] = $row[pg_fieldname($result,6)];

	        switch ($rownum) {
        	case 0 :
        
			if (strlen($$matrix[$rownum][1]) > 0) { 
        			$testit = $lookup[0];
        			$testit1 = $$matrix[$rownum][1];

        			$sql.=  "".$matrix[$rownum][1]."='".$testit1."', ";
        			$where_clause.=  " WHERE ".$matrix[$rownum][1]."='".$$matrix[$rownum][1]."' ";

        			if ($view_type[$rownum + 0] == 'int4') {
        				$query_value.= $matrix[$rownum][1]."=".$$matrix[$rownum + 0][1]." ";
        			} else {
        				$query_value.= $matrix[$rownnum][1]."='".$$matrix[$rownum + 0][1]."' ";
        			}
         		} else {
				$where_clause.= " WHERE 1 = 0 ";
			} 

        	break;
                case $rownum < $numkeys :
                            
                	if (strlen($$matrix[$rownum][1]) > 0) {
                		$sql.=  "".$matrix[$rownum][1]."='".$$matrix[$rownum][1]."', ";
                		$where_clause.=  " AND ".$matrix[$rownum][1]."='".$$matrix[$rownum][1]."'";
                           

                		if ($view_type[$rownum + 0] == 'int4') {
                			$query_value.= $matrix[$rownum][1]."=".$$matrix[$rownum + 0][1]." ";
                		} else {
                			$query_value.= $matrix[$rownnum][1]."='".$$matrix[$rownum + 0][1]."' ";
                		}
			} else {
				$where_clause.= " AND 1 = 0 ";
			}
                break;

                default :
                	if (strlen($$matrix[$rownum][1]) > 0) {  

                		if ($matrix[$rownum][1] == "password") {

                		} else {
                			$sql.=  "".$matrix[$rownum][1]."='".$$matrix[$rownum][1]."', ";
                		}

                	};  
                };

                if ($tablename == 'app_user' and $matrix[$rownum][1] == 'password') {
                        $new_pw = $first[$rownum];
                }


                $rownum = $rownum + 1;
    
            };
	
	$sql = substr($sql,0,-2);
        $sql.=$where_clause;

        $sql2 = "SELECT * FROM ".$tablename." ";
        $sql2.=$where_clause;


        $result = execSql($db, $sql2, $debug);
        $unique_cnt = pg_numrows($result);

        $row = pg_fetch_array($result, 0);

        if ($unique_cnt == 0) {
                        /* DisplayErrMsg(sprintf("Data does not exist for:")) ; */
                 for ($q=0; $q < $numkeys; ++$q) {
                      /*   DisplayErrMsg(sprintf("%s : %s ", $matrix[$q][1],$first[$q])) ; */
                }
                        $message_data = "<font color=red>The ".$tablename." data has not been updated. Data not found.</font>"; 
                } else {

                        $sql = str_replace ("''","null",$sql);

                        if ($debug) {
                                DisplayErrMsg(sprintf("executing: %s ", $sql));
                        }

                        $result = execSql($db, $sql, $debug); 

                        if (pg_ErrorMessage($db)) {
                                DisplayErrMsg(sprintf("executing: %s ", $sql));
                                DisplayErrMsg(sprintf("%s", pg_ErrorMessage($db))) ;
                        }  else {

				if ($site_redirect) {
                        		header ("Location: ".$site_redirect);
                        		echo "<p>The ".$header_table." data has been updated but it wont redirect</p>";

				} else {
					
					if (substr($result,0,5) == 'error') {
                        			$message_data = "<font color=red>The ".$tablename." data has not been updated.<br>".$result."</font>"; 
					} else {
                        			$message_data = "<font color=green>The ".$tablename." data has been updated</font>"; 
					}
				}
                }

        	$sql = "SELECT * from ".$tablename." ".$where_clause;
        	$result = execSql($db, $sql,$debug);

        	$row = pg_fetch_array($result, 0);

        	$fieldnum = pg_numfields($result);

        	for($i=0;$i<$fieldnum; $i++) {
                        $matrix[$i][4]=$row[pg_fieldname($result,$i)];
                }
                pg_freeresult($result);

	}

};

/* ================= end update ==================== */

/* ==================== DELETE ====================== */
if($DELETE) {

	$sql = "SELECT * FROM ".$tablename." ".$where_clause;

	$result = execSql($db, $sql, $debug);

        $unique_cnt = pg_numrows($result);

	if ($unique_cnt == 0) {
                /* DisplayErrMsg(sprintf("Data does not exist for:")) ; */

                 for ($q=0; $q < $numkeys; ++$q) {
                        /* DisplayErrMsg(sprintf("%s : %s ", $view_fieldname[$q],$first[$q])) ; */
                        showEcho(" : ", $view_fieldname[$q]." : ".$first[$q]) ;
                }

		$message_data="<br><font color=red>The ".$tablename." data has not been deleted</font><br>Data does not exist for : ".(ereg_replace('WHERE','',$where_clause));


	} else {

		if (strpos($where_clause,'=')) {

			$sql = "DELETE FROM ".$tablename." ".$where_clause.";";

			$result = execSql($db, $sql, $debug);  

        		if($result != 'error') {
				if ($unique_cnt == 1) {
					$add_an_s = '';
				} else {
					$add_an_s = 's';
				}
                		$message_data="<br> ".$unique_cnt."<font color=green> record".$add_an_s." from ".$tablename." : deleted</font>";
        		}

		} else {
                	$message_data="<br><font color=red> 0 records from ".$tablename." : deleted -- not found</font>";

		}

		pg_freeresult($result);

	};

};

/* ==================== End of DELETE ====================== */
/* ==================== QUERY ====================== */

if($SEARCHQUERY) {

	$sql ="SELECT * FROM ".$tablename;
	$sql.=$where_clause;

	$result = execSql($db, $sql, $debug);
	if (pg_NumRows($result) == 1) {

        	$row = pg_fetch_array($result, 0);

        	$fieldnum = pg_numfields($result);

        	for($i=0;$i<$fieldnum; $i++) {
                        $matrix[$i][4]=$row[pg_fieldname($result,$i)];
                        $$matrix[$i][1]=$row[pg_fieldname($result,$i)];
                }

	} else {

		if (pg_NumRows($result) == 0) {

			$retrows_error = 1;
			$message_data="<br><font color=red>No data for table ".$tablename." matches the search criteria</font><br>Data does not exist for : ".(ereg_replace('WHERE','',$where_clause));
		} else {

			// session_register("where_clause");
			$where_clause = $where_clause;
			// session_register("tablename");
			$tablename = $tablename;
			Header ("Location: view_table.php");
			exit;

		}

		pg_freeresult($result);

	}

}

/* ==================== End of QUERY ====================== */
/* ==================== NEWQUERY ====================== */

if($NEWQUERY) {

	$sql ="SELECT * FROM ".$tablename;
	$sql.=" WHERE 1 = 0";

	$result = execSql($db, $sql,$debug);

        $fieldnum = pg_numfields($result);

        for($i=0;$i<$fieldnum; $i++) {
               $resultmatrix[$i]=pg_fieldname($result,$i);
               $$resultmatrix[$i]=NULL;
        }

	pg_freeresult($result);

}

/* ==================== End of NEWQUERY ====================== */

?>
