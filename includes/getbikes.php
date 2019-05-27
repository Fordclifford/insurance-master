<?php
 require_once '../config/config.php';
if ($_POST) {
     
    $client = $_POST['client_id'];
    if ($client != '') {
        echo $sql1 = "SELECT * FROM client_bike_details WHERE client_id=" .$client;
        $result = mysqli_query(getDbConnection(), $sql1);
       echo "<select name='bike_id' id='bike_id'>";
       echo "<option value=''>Select Bike</option>"; 
        foreach ($result as $opt) {
          echo "<option value='" . $opt['id'] . "'>" . $opt['Model']."-".$opt['number_plate'] . "</option>";}
       echo "</select>";
    }
    else
    {
        echo  '';
    }
}