<?php
 require_once '../config/config.php';
if ($_POST) {
     
    $batch = $_POST['client_id'];
    if ($batch != '') {
          $sql = "select d.id,c.display_name,d.cover_type from client_insurance_details d inner join `client_bike_details` e on d.bike_id = e.id inner join m_client c on c.id = e.client_id where d.cancelled='0' and c.status_enum='300' and d.id not in (select insurance_id from client_payment p inner join payments_to_monarch q on q.id=p.payment_id where q.cancelled='0' and p.batch='$batch') group by d.id";

     
        $result = mysqli_query(getDbConnection(), $sql);
       echo "<select  id='t1available'>";
    
        foreach ($result as $opt) {
        echo '<option value="' . $opt['id'] . '"' . $sel . '>' . $opt['display_name'] ."-". $opt['cover_type'] .'</option>';}
       echo "</select>";
    }
    else
    {
        echo  '';
    }
}