<?php
 require_once '../config/config.php';
if ($_POST) {
     
    $batch = $_POST['batch_id'];
    if ($batch != '') {
         $sql1 = "SELECT cert_no FROM insurance_cert_numbers WHERE batch_id='$batch' and cert_no not in (select cert_no from client_insurance_details where cert_no is not null)";
        $result = mysqli_query(getDbConnection(), $sql1);
       echo "<select name='cert_no' id='cert_no'>";
       echo "<option value=''>Select Cert</option>"; 
        foreach ($result as $opt) {
          echo "<option value='" . $opt['cert_no'] . "'>" . $opt['cert_no']. "</option>";}
       echo "</select>";
    }
    else
    {
        echo  '';
    }
}