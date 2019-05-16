<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    $motorbike = Array();

         $motorbike['number_plate'] = $data_to_store['number_plate'];
           $motorbike['client_id'] = $data_to_store['client_id'];
          $motorbike['Model'] =$data_to_store['Model'];
           $motorbike['Engine'] = $data_to_store['Engine'];
            $motorbike['kra_pin'] = $data_to_store['kra_pin'];
             $motorbike['cheses_number'] =$data_to_store['cheses_number'];
              $motorbike['COLOUR'] = $data_to_store['COLOUR'];
               $motorbike['Others'] = $data_to_store['Others'];
                $motorbike['marketing_agent'] = $data_to_store['marketing_agent'];
                  $motorbike['created_at'] = date('Y-m-d H:i:s');


    $db = getUipDbInstance();

    $last_id = $db->insert('`client motorbike details`', $motorbike);
    // $last_id2 = $db->insert('`client motorbike details`', $motorbike);

    if ($last_id ) {
        $_SESSION['success'] = "Client added successfully!";
        header('location: customers.php');
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
            <h2 class="page-header">Add Client Motorbike Details</h2>
        </div>

    </div>
    <form class="form" action="" method="post"  id="customer_form" enctype="multipart/form-data">
<?php include_once('./forms/customer_form.php'); ?>
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