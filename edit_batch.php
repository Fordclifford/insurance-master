<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//User ID for which we are performing operation
$batch_id = filter_input(INPUT_GET, 'batch_id');
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'edit') ? $edit = true : $edit = false;
//Serve POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	

	// Sanitize input post if we want
	$data_to_update = filter_input_array(INPUT_POST);
	//Check whether the user name already exists ;
	$batch_id = filter_input(INPUT_GET, 'batch_id', FILTER_VALIDATE_INT);

         $start=$data_to_update['start']-1;
      $end=$data_to_update['end'];
      
      $db = getUipDbInstance();
	$db->where('batch_id', $batch_id);
	$del = $db->delete('insurance_cert_numbers');
    
      
      $db = getUipDbInstance();
	$db->where('id', $batch_id);
	$stat = $db->update('insurance_batches', $data_to_update);
    if($start>$end){
    $_SESSION['failure'] = "Invalid certificates range ";
header('location: batches.php');
	exit;
    }
      while ($start < $end ){
           
          $start++;
         
          $data=Array();
          $data['batch_id']=$batch_id;
           $data['cert_no']=$start;
          $db = getUipDbInstance();
    $last = $db->insert('insurance_cert_numbers', $data);
  
               
      }
           
	
	if ($stat && $last && $del) {
		$_SESSION['success'] = "Batch has been updated successfully";
	} else {
		$_SESSION['failure'] = "Failed to update Batch : " . $db->getLastError();
	}

	header('location: batches.php');
	exit;

}

//Select where clause
$db = getUipDbInstance();
$db->where('id', $batch_id);

$batch = $db->getOne("insurance_batches");
$db->disconnect();

// Set values to $row

// import header
require_once 'includes/header.php';
?>
<div id="page-wrapper">

    <div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Update Batch</h2>
        </div>

    </div>
    <?php include_once 'includes/flash_messages.php';?>
    <form class="well form-horizontal" action="" method="post"  id="contact_form" enctype="multipart/form-data">
        <?php include_once './forms/batch_form.php';?>
    </form>
</div>




<?php include_once 'includes/footer.php';?>