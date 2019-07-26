<?php
 require_once '../config/config.php';
if ($_POST) {
     // echo  'yes';
    $batch = $_POST['insurance'];

   
    if ($batch != '') {
         $sql = "SELECT if(d.cover_type='comp',1625,525 ) AS amount FROM client_insurance_details d INNER JOIN `client_bike_details` e on d.bike_id = e.id INNER JOIN m_client c on c.id = e.client_id WHERE c.status_enum = '300' AND d.cancelled = '0' and d.id in ($batch) GROUP BY d.id";

     
        $result = mysqli_query(getDbConnection(), $sql);
    
    $amt=0;
        foreach ($result as $opt) {
          
       $amt+= $opt['amount'];
    }
    echo $amt;
        }
    else
    {
        echo  '';
    }
}