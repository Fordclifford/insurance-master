<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

      $insurance = Array();

    $insurance['created_at'] = date('d-m-Y H:i:s');
    $time = strtotime($data_to_store['commence_date']);

    $final = date("Y-m-d", strtotime("+" . $data_to_store['period'] . "month", $time));
    $dt = new DateTime($final);
    $dt->modify('-1 day');
    $dt->format('Y-m-d H:i:s');
    
      $dt1 = new DateTime($data_to_store['commence_date']);
      $dt1->format('Y-m-d H:i:s');
         $dt2 = new DateTime($data_to_store['due_date']);
      $dt2->format('Y-m-d H:i:s');
    $insurance['due_date'] = date_format($dt2, "d-m-Y H:i:s");
    $insurance['commence_date'] = date_format($dt1, "d-m-Y H:i:s");
     $insurance['created_at'] = date('Y-m-d H:i:s');
      $insurance['bike_id'] = $data_to_store['bike_id'];
       $insurance['period'] = $data_to_store['period'];
        $insurance['policy_number'] = $data_to_store['policy_number'];
         $insurance['cover_type'] = $data_to_store['cover_type'];
          $insurance['cert_no'] = $data_to_store['cert_no'];
      // print_r($insurance);exit();
        $db = getUipDbInstance();

    $last_id = $db->insert('`client_insurance_details`', $insurance);
    $db->disconnect();
   //  $last_id2 = $db->insert('`client motorbike details`', $motorbike);

    if ($last_id ) {
        $_SESSION['success'] = "Insurance added successfully!";
        header('location: insurance.php');
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
            <h2 class="page-header">Add Insurance Details</h2>
        </div>

    </div>
    <form class="form" action="" method="post"  id="customer_form" enctype="multipart/form-data">
<?php include_once('./forms/insurance_form.php'); ?>
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
                batch: {
                    required: true                    
                },
                cert_no: {
                    required: true
                   
                },
                 period: {
                    required: true,
                    minlength: 1
                },
                 cover_type: {
                    required: true
                    
                },
                  commencement_date: {
                    required: true,
                    minlength: 3
                },
                due_date: {
                    required: true,
                    minlength: 3
                },
                 motorbike_details_id: {
                    required: true
                    
                }
            }
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>