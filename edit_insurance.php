<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$customer_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
 $db = getUipDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get customer id form query string parameter.
    $customer_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);
    
//    $time = strtotime($data_to_update['commence_date']);
    
//$final = date("Y-m-d", strtotime("+".$data_to_store['period']."month", $time));
//$dt = new DateTime($final);
//$dt->modify('-1 day');
//$dt->format('Y-m-d H:i:s');
    //$data_to_store['due_date'] = date_format($dt,"Y/m/d H:i:s");
  //  print_r($data_to_update);exit();
    $data_to_update['updated_at'] = date('Y-m-d H:i:s');
    //$data_to_update['motorbike_details_id'] = $data_to_update['client_id'];
    $db = getUipDbInstance();
    $db->where('id',$customer_id);
    $stat = $db->update('`client_insurance_details`', $data_to_update);

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
    $db->where('id', $customer_id);
    //Get data to pre-populate the form.
    $customer = $db->getOne("`client_insurance_details`");
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