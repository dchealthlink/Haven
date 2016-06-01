<?php
include("inc/dbconnect.php");


$PAYFLD0 = 'CHECK';
$PAYFLD4 = '1234567';
$PAYFLD5 = '1234568';
$PAYFLD6 = '123';
$FULL_NAME = 'Joe Evans';
$BANK_ACCT_TYPE = 'C';
$PAYFLD7 = 5.25;
$trail_bank = '34568';
$cash_drawer_id = 'AA';

                $paysql = "INSERT INTO xa_pay_log (xa_id, pay_seq, pay_method, payment_amount, status, bank_aba_code, bank_acct_num, bank_acct_type, check_num, pay_return_cd, encrypt_iv_value, trail_bank, cash_drawer_id, pay_name) VALUES ";
                /* $paysql.= "('".$temp_xa_id."',1,'".$PAYFLD0."',".$PAYFLD7.",'PD','".$PAYFLD4."','".$PAYFLD5."',null,'".$PAYFLD6."',null,null,'".$trail_bank."','".$cash_drawer_id."','".$FULL_NAME."')"; */

showEcho('Entering encrypt <br>',$paysql);
                $encrypted_data = encryptData('test',$PAYFLD5);
                $encrypted_bank = explode('SEPARATOR',$encrypted_data);
                $paysql.= "('".(date('ymdhis'))."',1,'".$PAYFLD0."',".$PAYFLD7.",'PD','".$PAYFLD4."','".$encrypted_bank[0]."','".$BANK_ACCT_TYPE."','".$PAYFLD6."',null,'".$encrypted_bank[1]."','".$trail_bank."','".$cash_drawer_id."')";


        $result = execSql($db, $paysql, $debug);
if ($result == 'error') {
        exit("Could not execute query ".$paysql);
} else {
	showEcho('Success',$encrypted_bank[0]);
	
}

?>
