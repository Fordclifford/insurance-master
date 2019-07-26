<?php

session_start();
ob_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//include_once 'includes/header.php';

?>

    <?php require './lib/TCPDF/tcpdf.php';
    $client_id = filter_input(INPUT_GET, 'id');
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'print') ? $print = true : $print = false;
 
     $db = getUipDbInstance();
     $db->join("`client_bike_details` e", "e.id = d.bike_id", "INNER");
            $db->join("m_client c", "c.id = e.client_id", "INNER");
             
            $db->where("d.id", $client_id);
             //$db->where("d.print_status", 1);
             $select = array('c.id','d.id as d_id', 'c.display_name','d.policy_number','d.cover_type','c.firstname','c.lastname','d.commence_date','d.due_date','c.mobile_no','e.number_plate','c.account_no','e.Engine','e.Model','e.Others');

            //$customers = $db->get("client_motorbike_details d");
            $customers = $db->arraybuilder()->paginate("client_insurance_details d", 1, $select);
            //print_r($customers);
    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);


// set default header data
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(17, 16, -17);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helveticaB', 8, 0);
//$pdf->SetFont('helveticaB', 'B',4,'', 'false');


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();
foreach ($customers as $row) :
$pdf->SetAuthor('City Corporation LTD');
$pdf->SetTitle('Insurance Certificate');
$pdf->SetSubject($row['display_name']);
$pdf->SetKeywords('TCPDF, PDF');

 $id = $row['d_id'];

 $name = strtoupper($row['display_name']);
$policy_number= strtoupper($row['policy_number']."-".$row['cover_type']);
$print_date = new DateTime($row['commence_date']);

$print_date= $print_date->format("d/m/Y");
$print_time = new DateTime($row['commence_date']);
$print_time=$print_time->format("g:i A");

  $number_plate = strtoupper($row['number_plate']);
   $row['due_date'];
$duedate = new DateTime($row['due_date']);
$duedate= $duedate->format("d/m/Y");

 
// create some HTML content
    $subtable1='<tr><div style="" class="cls_008"><span class="name1 cls_008"></span></div></tr>
<tr class="name1"><div style="position:absolute;left:38.50px;top:65.80px" class="cls_008"><span class="cls_008"></span></div></tr>
<tr>
<div style="padding:-50" class="cls_008"><span class="cls_008"></span></div>
<div style="position:absolute;left:139.50px;top:78.55px" class="name1 cls_008"><span class="cls_008"></span></div>
</tr>
<tr><div style="position:absolute;left:71.50px;top:91.30px" class="cls_008"><span class="cls_008"></span></div></tr>
<tr><div style="position:absolute;left:71.50px;top:104.05px" class="cls_008"><span class="cls_008"></span></div></tr>
<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_008"><span class="cls_008"></span></div></tr>
<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_008"><span class="cls_008"></span></div></tr>
' ;

$subtable = '<tr><div style="" class="cls_008"><span class="name1 cls_008">'.$name.'</span></div></tr>
<tr class="cls_008"><div style="position:absolute;left:38.50px;top:65.80px" class="cls_008"><span class="cls_008">'.$policy_number.'</span></div></tr>
<tr>
<div style="position:absolute;padding-left:71.50px;top:78.55px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$print_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$print_time.'</span></div>
</tr>

<tr><div style="position:absolute;left:71.50px;top:91.30px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$duedate.'</span></div></tr>

<tr><div style="position:absolute;left:71.50px;top:104.05px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$number_plate.'</span></div></tr>
<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_008"><span class="cls_008"></span></div></tr>
    <tr><div style="position:absolute;left:71.50px;top:104.05px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;***1 PAX***</span></div></tr>
    
<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_008"><span class="cls_008">THE MONARCH INS. CO. LTD.</span></div></tr>
<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_008"><span class="cls_008"></span></div></tr>
<tr><div style="position:absolute;left:20.49px;top:180.57px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."INS".str_pad($id, 8, '0', STR_PAD_LEFT).'</span></div></tr>
';
$subtable2 =
'<tr><div style="" class="cls_008"><span class="name1 cls_008"></span></div></tr>
<tr class="cls_008"><div class="cls_008"><span class="cls_006">'.$policy_number.'</span></div></tr>
<tr>
<div style="position:absolute;padding-left:71.50px;top:78.55px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$print_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$print_time.'</span></div>
</tr>

<tr><div style="position:absolute;left:71.50px;top:91.30px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$duedate.'</span></div></tr>

<tr><div style="position:absolute;left:71.50px;top:104.05px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$number_plate.'</span></div></tr>
<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_006"><span class="cls_008"></span></div></tr>
    <tr><div style="position:absolute;left:71.50px;top:104.05px" class="cls_008"><span class="cls_008">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;***1 PAX***</span></div></tr>

<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_008"><span class="cls_008">THE MONARCH INS. CO. LTD.</span></div></tr>
<tr><div style="position:absolute;left:463.04px;top:129.55px" class="cls_008"><span class="cls_008"></span></div></tr>
';
$html = '
<style type="text/css">
span.cls_008{font-family:Helvetica;font-size:9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_008{font-family:Helvetica;font-size:9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}


        div.name2{
        position:absolute;
        left:248.50px;top:53.05px;
        
        }

   </style>
<table border="0"  >
   
   <tr  style="margin:0">
        <td style="width:26%">'.$subtable.'</td>
            <td style="width:8%">'.$subtable1.'</td>
       <td style="width:25%">'.$subtable.'</td>
             <td style="width:8%">'.$subtable1.'</td>
           <td style="width:26%" >'.$subtable2.'</td>
               
    </tr>
    
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
    
    

endforeach; 
// Print some HTML Cells

$pdf->lastPage();


// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output($name." ".$print_date.'.pdf', 'D');
$date=date("Y-m-d H:i:s");
$db = getUipDbInstance();
$data = Array (
    'print_status' => '1',
    'print_date' => $date
);
$db->where ('id', $id);
$db->update ('client_insurance_details', $data);
$db->disconnect();


//============================================================+
// END OF FILE
//==============================================
    
    
    
    
    
    
    
    
    ?>