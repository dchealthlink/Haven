<?php
print_r($_POST);

$sidf = explode("|",$_POST['sidfunc']);

$presql = "SELECT ws.service_id, ws.service_url, wsf.function_name FROM testweb_service ws, testweb_service_function wsf WHERE ws.service_id = wsf.service_id AND ws.service_id = ".$sidf[0]." AND wsf.function_name ='".$sidf[1]."'";

echo $presql;

echo "<br>";

$sql = "SELECT ind_id, person_id, person_surname, person_given_name, address_type, address_line_1, address_line_2, location_city_name, location_state_code, postal_code, phone_type, full_phone_number, is_preferred, ssn, gender, birthdate, created_at FROM testload_data WHERE ind_id = '".$_POST['iid']."'";
echo $sql;

echo "<br>";

/* */
?>
