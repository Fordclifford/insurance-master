<?php
session_start();
//require_once './HTML.php';
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

      $insurance = Array();
     
 
      
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

    $last_id = $db->insert('`payments_to_monarch`', $insurance);
    
      
            // Retrieving each selected option 
            foreach ($_POST['clients'] as $subject) { 
                $payment=Array();
              $payment['insurance_id']=$subject;
              $payment['payment_id']= $last_id;
              $payment['batch']=$data_to_store['batch'];
               $db->insert('`client_payment`', $payment);
        }
    
        print_r($payment);
     //exit();
   
    $db->disconnect();
   //  $last_id2 = $db->insert('`client motorbike details`', $motorbike);

    if ($last_id ) {
        $_SESSION['success'] = "Payment added successfully!";
        header('location: payments.php');
        exit();
    } else {
        echo 'insert failed: ' . $db->getLastError();
        exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php';
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Add Payment Details</h2>
        </div>

    </div>
    <form class="form" action="" method="post"  id="customer_form" enctype="multipart/form-data">
<?php include_once('./forms/payment_form.php'); ?>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#customer_form").validate({
            rules: {
                number_plate: {
                    required: true,
                    minlength: 3
                },
                policy_number: {
                    required: true,
                    minlength: 3
                }
            }
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>