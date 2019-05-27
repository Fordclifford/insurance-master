<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

      $insurance = Array();

    $insurance['created_at'] = date('Y-m-d H:i:s');
    $time = strtotime($data_to_store['commence_date']);

    $final = date("Y-m-d", strtotime("+" . $data_to_store['period'] . "month", $time));
    $dt = new DateTime($final);
    $dt->modify('-1 day');
    $dt->format('Y-m-d H:i:s');
    
      $dt1 = new DateTime($data_to_store['commence_date']);
      $dt1->format('Y-m-d H:i:s');    
    $insurance['commence_date'] = date_format($dt1, "d-m-Y H:i:s");
   
    
    $insurance['due_date'] = date_format($dt, "d-m-Y H:i:s");
     $insurance['created_at'] = date('Y-m-d H:i:s');
      $insurance['motorbike_details_id'] = $data_to_store['bike_id'];
       $insurance['period'] = $data_to_store['period'];
        $insurance['policy_number'] = $data_to_store['policy_number'];
        $insurance['renewal']="1";
     //   print_r($insurance);exit();
        $db = getUipDbInstance();

    $last_id = $db->insert('client_insurance_details', $insurance);
    $db->disconnect();
   //  $last_id2 = $db->insert('`client motorbike details`', $motorbike);

    if ($last_id  ) {
        $_SESSION['success'] = "Insurance renewed successfully!";
        header('location: renewals.php');
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
            <h2 class="page-header">Renew Insurance</h2>
        </div>

    </div>
    <form class="form" action="" method="post"  id="customer_form" enctype="multipart/form-data">
<?php include_once('./forms/renew_form.php'); ?>
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