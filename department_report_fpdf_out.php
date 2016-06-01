<?php
include("inc/dbconnect.php");

define('FPDF_FONTPATH','/var/www/html/timeatt/font/');
require('inc/fpdf.php');

class PDF extends FPDF
{






//Load data
function LoadData($db,$file)
{
    //Read file lines
    $lines=file($file);
    $data=array();
//    foreach($lines as $line)
//       $data[]=explode(';',chop($line));


// $outersql = "SELECT e.department_id||';'||e.last_name||';'||e.first_name||';'||e.employee_id FROM employee e WHERE e.department_id = '01330' ORDER BY e.department_id,  e.employee_id";
$outersql = "SELECT e.department_id, e.last_name, e.first_name, e.employee_id FROM employee e WHERE e.department_id = '01330' ORDER BY e.department_id,  e.employee_id";


        $outerresult = execSql($db, $outersql, $debug);

        $outerrows = pg_numrows($outerresult);
	$ctr = 0;
        for ($outrows = 0; $outrows < $outerrows; $outrows++) {

               list ($list_department_id, $list_last_name, $list_first_name, $list_employee_id) = pg_fetch_row($outerresult,$outrows);

		// $data[]= array($list_department_id, $list_last_name, $list_first_name, $list_employee_id);
// $data[]=explode(';',$dummy);



//                $innersql = "SELECT pay_day, hours_reg, '100', hours_ot, ot_pay_type_cd, hours_other, other_pay_type_cd FROM employee_pay_log WHERE employee_id = '".$list_employee_id."' ORDER BY employee_id, pay_day ";
                $innersql = "SELECT pay_day, hours_reg, '100', hours_ot, ot_pay_type_cd, hours_other, other_pay_type_cd FROM employee_pay_log WHERE employee_id = '".$list_employee_id."' AND pay_period_num = '".$pay_period_num."' ORDER BY employee_id, pay_day";

                $low_val = 0;
                $high_val = $period_ending - $period_beginning;
                $innerresult = execSql($db, $innersql, $debug);

                $innerrows = pg_numrows($innerresult);
 
                $grand_total = 0;
                for ($inrows = 0; $inrows < $innerrows; $inrows++) {

                        list ($list_pay_day, $list_hours_reg, $list_pay_type_cd, $list_hours_ot, $list_ot_pay_type_cd, $list_hours_other, $list_other_pay_type_cd) = pg_fetch_row($innerresult,$inrows);

                        if ($list_hours_reg) {
                                $data[$ctr][0] = $list_department_id;
                                $data[$ctr][1] = $list_last_name;
                                $data[$ctr][2] = $list_first_name;
                                $data[$ctr][3] = $list_employee_id;
                                $data[$ctr][4] = $list_pay_type_cd;
                                $checkval = ($list_pay_day - $period_beginning) + 4;
                                $data[$ctr][$checkval] = $list_hours_reg;

				$ctr = $ctr + 1;
                        }
                        if ($list_hours_ot AND $list_ot_pay_type_cd != 'split') {
                                $data[$ctr][0] = $list_department_id;
                                $data[$ctr][1] = $list_last_name;
                                $data[$ctr][2] = $list_first_name;
                                $data[$ctr][3] = $list_employee_id;
                                $data[$ctr][4] = $list_ot_pay_type_cd;
                                $checkval = ($list_pay_day - $period_beginning) + 4;
                                $data[$ctr][$checkval] = $list_hours_ot;
				$ctr = $ctr + 1;
                        }
                        if ($list_hours_other AND $list_other_pay_type_cd != 'split') {
                                $data[$ctr][0] = $list_department_id;
                                $data[$ctr][1] = $list_last_name;
                                $data[$ctr][2] = $list_first_name;
                                $data[$ctr][3] = $list_employee_id;
                                $data[$ctr][4] = $list_other_pay_type_cd;
                                $checkval = ($list_pay_day - $period_beginning) + 4;
                                $data[$ctr][$checkval] = $list_hours_other;
				$ctr = $ctr + 1;
                        }
			$ctr = $ctr + 1;

                $detailsql = "SELECT pay_type_cd, pay_day, sum(base_hours) FROM employee_pay_log_detail WHERE employee_id = '".$list_employee_id."' GROUP BY pay_type_cd, pay_day ORDER BY pay_type_cd, pay_day";
                $detresult = execSql($db, $detailsql, $debug);

                $pay_day_count = 1;
                $prev_pay_code = "";
                $detailrows = pg_numrows($detresult);
$rowtot = 0;
                for ($detrows = 0; $detrows < $detailrows; $detrows++) {

                        list ($det_pay_type_cd, $det_pay_day, $det_hours) = pg_fetch_row($detresult,$detrows);

                        if ($prev_pay_code != $det_pay_type_cd) {

                                $pay_day_count = $pay_day_count + 1;
                                $rowtot = 0;
                        }

			
                                $data[$ctr][0] = $list_department_id;
                                $data[$ctr][1] = $list_last_name;
                                $data[$ctr][2] = $list_first_name;
                                $data[$ctr][3] = $list_employee_id;
                                $data[$ctr][4] = $det_pay_type_cd;
                        	$checkval = ($det_pay_day - $period_beginning) + 4;
                                $data[$ctr][$checkval] = $det_hours;
				$ctr = $ctr + 1;

                }



               }

	}


    return $data;
}



function DropHeader($header)
{
    	$w=array(11,30,10,12,20);
	$i = 0;
	$j = 0;
    //Header

        	$this->Cell($w[0],3.5,$header[0],1,0,'C');
        	$this->Cell($w[1],3.5,$header[1],1,0,'C');
        	$this->Cell($w[1],3.5,$header[2],1,0,'C');
        	$this->Cell($w[3],3.5,$header[3],1,0,'C');
        	$this->Cell($w[0],3.5,$header[4],1,0,'C');
        	$this->Cell($w[2],3.5,$header[5],1,0,'C');
        	$this->Cell($w[2],3.5,$header[6],1,0,'C');
        	$this->Cell($w[2],3.5,$header[7],1,0,'C');
        	$this->Cell($w[2],3.5,$header[8],1,0,'C');
        	$this->Cell($w[2],3.5,$header[9],1,0,'C');
        	$this->Cell($w[2],3.5,$header[10],1,0,'C');
        	$this->Cell($w[2],3.5,$header[11],1,0,'C');
        	$this->Cell($w[2],3.5,$header[12],1,0,'C');
        	$this->Cell($w[2],3.5,$header[13],1,0,'C');
        	$this->Cell($w[2],3.5,$header[14],1,0,'C');
        	$this->Cell($w[2],3.5,$header[15],1,0,'C');
        	$this->Cell($w[2],3.5,$header[16],1,0,'C');
        	$this->Cell($w[2],3.5,$header[17],1,0,'C');
        	$this->Cell($w[2],3.5,$header[18],1,0,'C');
        	$this->Cell($w[4],3.5,$header[19],1,0,'C');
    		$this->Ln();
}


//Simple table
function BasicTable($header,$data)
{
    	$w=array(10,25,9,12);
	$i = 0;
    //Data
    foreach($data as $col)
    {
        	$this->Cell($w[0],3.5,$col[0],'LR');
        	$this->Cell($w[1],3.5,$col[1],'LR');
        	$this->Cell($w[1],3.5,$col[2],'LR');
        	$this->Cell($w[3],3.5,$col[3],'LR');
        	$this->Cell($w[0],3.5,$col[4],'LR');
        	$this->Cell($w[2],3.5,$col[5],'LR');
        	$this->Cell($w[2],3.5,$col[6],'LR');
        	$this->Cell($w[2],3.5,$col[7],'LR');
        	$this->Cell($w[2],3.5,$col[8],'LR');
        	$this->Cell($w[2],3.5,$col[9],'LR');
        	$this->Cell($w[2],3.5,$col[10],'LR');
        	$this->Cell($w[2],3.5,$col[11],'LR');
        	$this->Cell($w[2],3.5,$col[12],'LR');
        	$this->Cell($w[2],3.5,$col[13],'LR');
        	$this->Cell($w[2],3.5,$col[14],'LR');
        	$this->Cell($w[2],3.5,$col[15],'LR');
        	$this->Cell($w[2],3.5,$col[16],'LR');
        	$this->Cell($w[2],3.5,$col[17],'LR');
        	$this->Cell($w[2],3.5,$col[18],'LR');
        	$this->Cell($w[0],3.5,$col[19],'LR');
        $this->Ln();
	$i = $i + 1;
	if ($i > 50)
	{
		$i = 0;
		$pdf->AddPage();
	}
    }
}


// function AcceptPageBreak()
// {
    //Method accepting or not automatic page break
        //Go back to first column
//        $this->SetCol(0);
        //Page break
//        return true;
//}


//Better table
function ImprovedTable($header,$data)
{
    //Column widths
    $w=array(40,35,40,45);
    //Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Closure line
    $this->Cell(array_sum($w),0,'','T');
}

//Colored table
function FancyTable($header,$data)
{
    //Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(40,35,40,45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF();
//Column titles
//Data loading
// $data=$pdf->LoadData($db,'department.txt');
$pdf->FPDF('L','mm','letter');
$pdf->AddPage();

    //Logo
    $pdf->Image('images/fullmoon1.jpg',10,8,33);
    //Arial bold 15
    $pdf->SetFont('Arial','B',15);
    //Move to the right
    $pdf->Cell(80);
    //Title
    $pdf->Cell(60,10,'Timesheet Report',1,0,'C');
    //Line break
    $pdf->Ln(20);
$pdf->SetFont('Arial','',7);


// $pdf->BasicTable($header,$data);


        if (!$pay_period_num) {
                $ppsql = "SELECT pay_period_num FROM pay_period WHERE pay_period_start_date < now() ORDER BY pay_period_num DESC limit 1";
                $ppresult = execSql($db, $ppsql, $debug);
                list($pay_period_num) = pg_fetch_row($ppresult,0);
        }


        $ppsql = "SELECT pay_period_num, extract(doy from pay_period_start_date), extract(doy from pay_period_end_date), pay_period_start_date, pay_period_start_date + 1, pay_period_start_date + 2, pay_period_start_date + 3, pay_period_start_date + 4, pay_period_start_date + 5, pay_period_start_date + 6, pay_period_start_date + 7, pay_period_start_date + 8, pay_period_start_date + 9, pay_period_start_date + 10, pay_period_start_date + 11, pay_period_start_date + 12, pay_period_end_date  from pay_period WHERE pay_period_num = ".$pay_period_num;

        $ppresult = execSql($db, $ppsql, $debug);

        list($pay_period_num, $period_beginning, $period_ending, $period_beg_date, $period_day1, $period_day2, $period_day3, $period_day4, $period_day5, $period_day6, $period_day7, $period_day8, $period_day9, $period_day10, $period_day11, $period_day12, $period_end_date) = pg_fetch_row($ppresult,0);

	$d0 = substr($period_beg_date,5,5);
	$d1 = substr($period_day1,5,5);
	$d2 = substr($period_day2,5,5);
	$d3 = substr($period_day3,5,5);
	$d4 = substr($period_day4,5,5);
	$d5 = substr($period_day5,5,5);
	$d6 = substr($period_day6,5,5);
	$d7 = substr($period_day7,5,5);
	$d8 = substr($period_day8,5,5);
	$d9 = substr($period_day9,5,5);
	$d10 = substr($period_day10,5,5);
	$d11 = substr($period_day11,5,5);
	$d12 = substr($period_day12,5,5);
	$d13 = substr($period_end_date,5,5);

$header1=array('','','','','','Sun','Mon','Tue','Wed','Thu','Fri','Sat','Sun','Mon','Tue','Wed','Thu','Fri','Sat','');
$pdf->DropHeader($header1);

$header=array('Dept#','Last Name','First Name','Emp Id','Line #',"$d0","$d1","$d2","$d3","$d4","$d5","$d6","$d7","$d8","$d9","$d10","$d11","$d12","$d13",'Total');
$pdf->DropHeader($header);

if (!$department_id) {

        $pgsql = "SELECT e.department_id, d.department_name from employee e, department d WHERE e.department_id = d.department_id AND  e.employee_id = '".$key_value."'";

        $pgresult = execSql($db, $pgsql, $debug);

                list($department_id, $department_name) = pg_fetch_row($pgresult,0);
        } else {
                $pgsql = "SELECT department_name from department  WHERE department_id like '%".$department_id."%'";

                $pgresult = execSql($db, $pgsql, $debug);

                list($department_name) = pg_fetch_row($pgresult,0);

        }











$outersql = "SELECT e.department_id, e.last_name, e.first_name, e.employee_id FROM employee e WHERE e.department_id like '%".$department_id."%' ORDER BY e.department_id,  e.employee_id ";


        $outerresult = execSql($db, $outersql, $debug);

        $outerrows = pg_numrows($outerresult);
        $ctr = 0;
        for ($outrows = 0; $outrows < $outerrows; $outrows++) {

               list ($list_department_id, $list_last_name, $list_first_name, $list_employee_id) = pg_fetch_row($outerresult,$outrows);

                // $data[]= array($list_department_id, $list_last_name, $list_first_name, $list_employee_id);
// $data[]=explode(';',$dummy);



                 $innersql = "SELECT pay_day, hours_reg, '100' FROM employee_pay_log WHERE employee_id = '".$list_employee_id."' AND pay_period_num = '".$pay_period_num."' ORDER BY employee_id, pay_day";

                $low_val = 0;
                $high_val = $period_ending - $period_beginning;
                $innerresult = execSql($db, $innersql, $debug);

                $innerrows = pg_numrows($innerresult);

                $grand_total = 0;
                for ($inrows = 0; $inrows < $innerrows; $inrows++) {
			$ctr_set = $ctr;

                        list ($list_pay_day, $list_hours_reg, $list_pay_type_cd) = pg_fetch_row($innerresult,$inrows);

                        if ($list_hours_reg) {
                                $data[$ctr_set][0] = $list_department_id;
                                $data[$ctr_set][1] = $list_last_name;
                                $data[$ctr_set][2] = $list_first_name;
                                $data[$ctr_set][3] = $list_employee_id;
                                $data[$ctr_set][4] = $list_pay_type_cd;
                                $checkval = ($list_pay_day - $period_beginning) + 4;
                                $data[$ctr_set][$checkval] = $list_hours_reg;
                        }

	                $detailsql = "SELECT other_pay_type_cd as pay_type_cd, pay_day, sum(hours_other) as hours FROM employee_pay_log WHERE employee_id = '".$list_employee_id."' AND pay_period_num = '".$pay_period_num."' AND hours_other is not null AND other_pay_type_cd != 'split' group by 1,2 UNION SELECT ot_pay_type_cd as pay_type_cd, pay_day, sum(hours_ot) as hours FROM employee_pay_log WHERE employee_id = '".$list_employee_id."' AND pay_period_num = '".$pay_period_num."' AND hours_ot is not null AND ot_pay_type_cd != 'split' group by 1,2 UNION SELECT pay_type_cd, pay_day, sum(base_hours) as hours FROM employee_pay_log_detail WHERE employee_id = '".$list_employee_id."' AND pay_period_num = '".$pay_period_num."' GROUP BY 1, 2 ORDER BY 1, 2";

                $detresult = execSql($db, $detailsql, $debug);

                $pay_day_count = 1;
                $prev_pay_code = "";
                $detailrows = pg_numrows($detresult);
$rowtot = 0;
                for ($detrows = 0; $detrows < $detailrows; $detrows++) {

                        list ($det_pay_type_cd, $det_pay_day, $det_hours) = pg_fetch_row($detresult,$detrows);

                        if ($prev_pay_code != $det_pay_type_cd) {
                                $pay_day_count = $pay_day_count + 1;
                                $rowtot = 0;
			}

                                $data[($ctr_set + $pay_day_count)][0] = $list_department_id;
                                $data[($ctr_set + $pay_day_count)][1] = $list_last_name;
                                $data[($ctr_set + $pay_day_count)][2] = $list_first_name;
                                $data[($ctr_set + $pay_day_count)][3] = $list_employee_id;
                                $data[($ctr_set + $pay_day_count)][4] = $det_pay_type_cd;
                                $checkval = ($det_pay_day - $period_beginning) + 4;
                                $data[($ctr_set + $pay_day_count)][$checkval] = $det_hours;
				$prev_pay_code = $det_pay_type_cd;

                }


               }

$ctr = $ctr + 6;
        }






    	$w=array(11,30,10,12,20);
	$i = 0;
	$oldcol = "";
    //Data
    foreach($data as $col)
    {

		if ($oldcol != $col[3] AND $oldcol != "") {
                $pdf->Cell($w[0],3.5,'','LR');
                $pdf->Cell($w[1],3.5,'Totals','LR');
                $pdf->Cell($w[1],3.5,'','LR');
                $pdf->Cell($w[3],3.5,'','LR');
                $pdf->Cell($w[0],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[4],3.5,(number_format($emptot,3)),'LR','','R');
        	$pdf->Ln();
		$emptot = 0;
                $pdf->Cell($w[0],3.5,'','LR');
                $pdf->Cell($w[1],3.5,'','LR');
                $pdf->Cell($w[1],3.5,'','LR');
                $pdf->Cell($w[3],3.5,'','LR');
                $pdf->Cell($w[0],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[4],3.5,'','LR');
        	$pdf->Ln();
        $i = $i + 2;
		}

               $pdf->Cell($w[0],3.5,$col[0],'LR');
                $pdf->Cell($w[1],3.5,$col[1],'LR');
                $pdf->Cell($w[1],3.5,$col[2],'LR');
                $pdf->Cell($w[3],3.5,$col[3],'LR');
                $pdf->Cell($w[0],3.5,$col[4],'LR');
                $pdf->Cell($w[2],3.5,$col[5],'LR');
                $pdf->Cell($w[2],3.5,$col[6],'LR');
                $pdf->Cell($w[2],3.5,$col[7],'LR');
                $pdf->Cell($w[2],3.5,$col[8],'LR');
                $pdf->Cell($w[2],3.5,$col[9],'LR');
                $pdf->Cell($w[2],3.5,$col[10],'LR');
                $pdf->Cell($w[2],3.5,$col[11],'LR');
                $pdf->Cell($w[2],3.5,$col[12],'LR');
                $pdf->Cell($w[2],3.5,$col[13],'LR');
                $pdf->Cell($w[2],3.5,$col[14],'LR');
                $pdf->Cell($w[2],3.5,$col[15],'LR');
                $pdf->Cell($w[2],3.5,$col[16],'LR');
                $pdf->Cell($w[2],3.5,$col[17],'LR');
                $pdf->Cell($w[2],3.5,$col[18],'LR');
		$col[19] = $col[18] + $col[17] + $col[16] + $col[15] + $col[14] + $col[13] + $col[12] + $col[11] + $col[10] + $col[9] + $col[8] + $col[7] + $col[6] + $col[5] ;
		$emptot = $emptot + $col[19];
                $pdf->Cell($w[4],3.5,(number_format($col[19],3)),'LR','','R');
		$oldcol = $col[3];
        $pdf->Ln();
        $i = $i + 1;
        if ($i > 42)
        {
		$pdf->Cell(254,0,'','T');
                $i = 0;
                $pdf->AddPage();
		$pdf->DropHeader($header1);
		$pdf->DropHeader($header);
        }
    }

                $pdf->Cell($w[0],3.5,'','LR');
                $pdf->Cell($w[1],3.5,'Totals','LR');
                $pdf->Cell($w[1],3.5,'','LR');
                $pdf->Cell($w[3],3.5,'','LR');
                $pdf->Cell($w[0],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[2],3.5,'','LR');
                $pdf->Cell($w[4],3.5,(number_format($emptot,3)),'LR','','R');
        	$pdf->Ln();
		$pdf->Cell(254,0,'','T');












// $pdf->AddPage();
// $pdf->ImprovedTable($header,$data);
// $pdf->AddPage();
// $pdf->FancyTable($header,$data);
$pdf->Output();

?>
