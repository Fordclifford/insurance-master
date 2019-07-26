<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$customer_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;


//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
 $db = getUipDbInstance();
  
    $data_to_update = filter_input_array(INPUT_POST);
    $data_to_update['updated_at'] = date('Y-m-d H:i:s');
     $dt1 = new DateTime($data_to_update['commence_date']);
      $dt1->format('Y-m-d H:i:s');
      
         $dt2 = new DateTime($data_to_update['due_date']);
      $dt2->format('Y-m-d H:i:s');
      
    $data_to_update['commence_date'] = date_format($dt1, "d-m-Y H:i:s");
 $data_to_update['due_date'] = date_format($dt2, "d-m-Y H:i:s");
   // print_r($data_to_update);echo $stat; exit();

    $db->where('id',$customer_id);
    $stat = $db->update('client_insurance_details', $data_to_update);
    $db->disconnect();

    if($stat)
    {
        $_SESSION['success'] = "Insurance Details updated successfully!";
        //Redirect to the listing page,
        header('location: insurance.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{ 

  $db = getUipDbInstance();
    $db->where('id', $customer_id);
    //Get data to pre-populate the form.
    $customer = $db->getOne("client_insurance_details");
}
?>


<?php
    include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Insurance Details</h2>
    </div>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>

    <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">
        
        <?php
            //Include the common form for add and edit  
            require_once('./forms/insurance_form.php'); 
        ?>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>