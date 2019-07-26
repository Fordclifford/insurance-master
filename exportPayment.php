<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

// select loggedin users detail
  
$error = false;
   
$id=$_GET['payment_id'];
     if(!$error){
         		$filename = "payments.xls";	 
            header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		       
        $setSql = "SELECT  c.display_name,c.mobile_no,d.commence_date, d.due_date, d.policy_number , if(d.cover_type='comp',1625,525 ) AS 'PREMIUM', e.number_plate , e.Model,e.Engine, e.colour,e.cheses_number, d.cover_type ,d.cert_no,  if(d.renewal='1','NO','YES') as 'New Client',e.others FROM client_insurance_details d INNER JOIN `client_bike_details` e on d.bike_id = e.id INNER JOIN m_client c on c.id = e.client_id INNER JOIN client_payment s on s.insurance_id = d.id WHERE c.status_enum = '300' AND d.cancelled = '0' AND s.payment_id = '$id' GROUP BY s.id ORDER BY s.id";
      
        $columnHeader = '';
            $columnHeader = "Sr NO" . "\t" . "INSURED NAME" . "\t" . "MOBILE NUMBER" . "\t"."EFF DATE" . "\t"."EXP DATE" . "\t"."POL NO." . "\t"."PREMIUM" . "\t"."REG NO." . "\t"."MODEL" . "\t"."Engine" . "\t"."COLOUR" . "\t"."CHASIS NO." . "\t"."COVER TYPE." . "\t"."CERT NO." . "\t"."NEW CLIENT" ."\t"."OTHER DETAILS." . "\t";
  $setRec = mysqli_query(getDbConnection(),$setSql);
  
        $setData = '';
        $number = 1;
        $space = ' ';
         
        while ($rec = mysqli_fetch_assoc($setRec)) {

            $rowData = '';
            $num = '"' . $number . '"' . "\t";
            $rowData .= $num;
            foreach ($rec as $value) {
                $value = '"' . $value . '"' . "\t";
                $rowData .= $value;
            }

            $setData .= trim($rowData) . "\n";
            $number++;
        }
          echo ucwords($columnHeader) . "\n" . $setData . "\n";
            exit();
    }
   


?>
