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
 
    //$customer_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_INT);
$data_to_store = filter_input_array(INPUT_POST);
    //Get input data

 $insurance=Array();
      $dt1 = new DateTime($data_to_store['date']);
      $dt1->format('d-m-Y');
    $insurance['date'] = date_format($dt1, "Y-m-d");
       $insurance['batch'] = $data_to_store['batch'];
       $insurance['amount'] = $data_to_store['amount'];
       // $insurance['policy'] = $data_to_store['policy'];
         $insurance['month'] = $data_to_store['month'];
          $insurance['year'] = $data_to_store['year'];
         $insurance['office_id'] =50;
       
        $db = getUipDbInstance();
 $db->where('payment_id', $customer_id);
    $stat = $db->delete('client_payment');
   
            $db = getUipDbInstance();
 $db->where('id', $customer_id);
    $last_id = $db->update('`payments_to_monarch`', $insurance);
     //  print_r($last_id);exit();
      
            // Retrieving each selected option 
            foreach ($_POST['clients'] as $subject) { 
                $payment=Array();
              $payment['insurance_id']=$subject;
              $payment['payment_id']= $customer_id;
              $payment['batch']=$data_to_store['batch'];
               $db->insert('`client_payment`', $payment);
        }
    
        print_r($payment);
     //exit();
       $db->disconnect();

    if($stat&&$last_id)
    {
        $_SESSION['success'] = "Payment Details updated successfully!";
        //Redirect to the listing page,
        header('location: payments.php');
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
    $customer = $db->getOne("payments_to_monarch");
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
            require_once('./forms/payment_form.php'); 
        ?>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>