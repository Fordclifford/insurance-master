<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Only super admin is allowed to access this page

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$data_to_store = filter_input_array(INPUT_POST);
    $db = getUipDbInstance();
       //Encrypt password
      //reset db instance
    $start=$data_to_store['start']-1;
      $end=$data_to_store['end'];
       $db = getUipDbInstance();
    $last_id = $db->insert ('insurance_batches', $data_to_store);
      
      while ($start < $end ){
           
          $start++;
          $data=Array();
          $data['batch_id']=$last_id;
           $data['cert_no']=$start;
          $db = getUipDbInstance();
    $last = $db->insert('insurance_cert_numbers', $data);
  
               
      }
      
    if($last_id && $last)
    {

    	$_SESSION['success'] = "Batch added successfully!";
    	header('location: batches.php');
        $db->disconnect();
    	exit();
    }  
    
}

$edit = false;


require_once 'includes/header.php';
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Add Batch</h2>
		</div>
	</div>
	 <?php 
    include_once('includes/flash_messages.php');
    ?>
	<form class="well form-horizontal" action=" " method="post"  id="contact_form" enctype="multipart/form-data">
		<?php include_once './forms/batch_form.php'; ?>
	</form>
</div>




<?php include_once 'includes/footer.php'; ?>