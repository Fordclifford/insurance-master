<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

//Get current page.
$page = filter_input(INPUT_GET, 'page');

//Per page limit for pagination.
$pagelimit = 10;

if (!$page) {
    $page = 1;
}

// If filter types are not selected we show latest created data first
if (!$filter_col) {
    $filter_col = "d.id";
}
if (!$order_by) {
    $order_by = "Desc";
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getUipDbInstance();

 $db->join("`client_bike_details` e", "d.bike_id = e.id", "LEFT");
  $db->join("m_client c", "c.id = e.client_id", "LEFT");
            $db->where("c.status_enum", 300);
              $db->where("c.office_id", 50);
            $db->where("d.cancelled", '0');
          //  $db->where("d.print_status", "0");
   $select = array('d.id', 'c.display_name','left(d.policy_number,20) AS policy_number','d.cover_type','d.cert_no','d.commence_date','d.period', 'd.due_date','c.mobile_no','c.account_no',"e.`number_plate`","e.Engine","e.Model","e.Others","e.client_id");

//Start building query according to input parameters.
// If search string
if ($search_string) 
{
    $db->where('c.firstname', '%' . $search_string . '%', 'like');
    $db->orwhere('c.mobile_no', '%' . $search_string . '%', 'like');
        $db->where('d.policy_number', '%' . $search_string . '%', 'like');
    $db->orwhere('d.cert_no', '%' . $search_string . '%', 'like');
        $db->where('c.account_no', '%' . $search_string . '%', 'like');
    $db->orwhere('e.number_plate', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by)
{
    $db->orderBy($filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$customers = $db->arraybuilder()->paginate("client_insurance_details d", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($customers as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}
include_once 'includes/header.php';
?>

<!--Main container start-->
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Insurance Clients</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
                <a href="add_insurance.php?operation=create">
	            	<button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add new </button>
	            </a>
            </div>
        </div>
    </div>
        <?php include('./includes/flash_messages.php') ?>
    <!--    Begin filter section-->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col" class="form-control">

                <?php
                foreach ($filter_options as $option) {
                    ($filter_col === $option) ? $selected = "selected" : $selected = "";
                    echo ' <option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                ?>

            </select>

            <select name="order_by" class="form-control" id="input_order">

                <option value="Asc" <?php
                if ($order_by == 'Asc') {
                    echo "selected";
                }
                ?> >Asc</option>
                <option value="Desc" <?php
                if ($order_by == 'Desc') {
                    echo "selected";
                }
                ?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">

        </form>
    </div>
<!--   Filter section end-->

    <hr>


    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th class="header">#</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Commencement Date</th>
                <th>Expiry Date</th>
                <th>Policy Number</th>
                 <th>Certificate Number</th>
                <th>Number Plate</th>
               <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        
            <?php foreach ($customers as $row) : ?>
             
                <tr>
                 
	                <td><?php echo $row['id'] ?></td>
                        
	                <td><?php echo htmlspecialchars($row['display_name']); ?></td>
	                <td><?php echo htmlspecialchars($row['mobile_no']) ?></td>
	                <td><?php echo htmlspecialchars($row['commence_date']) ?> </td>
                        <td><?php echo htmlspecialchars($row['due_date']) ?> </td>                     
                       <td><?php echo htmlspecialchars($row['policy_number']."-".$row['cover_type']) ?> </td>
                        <td><?php echo htmlspecialchars($row['cert_no']) ?> </td>
                        <td><?php echo htmlspecialchars($row['number_plate']); ?></td>
	               
	                <td>
                            	<a href="print_cert.php?id=<?php echo $row['id'] ?>&operation=print" class="btn btn-primary" style="margin-right: 8px;"><span class="glyphicon glyphicon-print"></span>
					<a href="edit_insurance.php?id=<?php echo $row['id'] ?>&operation=edit" class="btn btn-primary" style="margin-right: 8px;"><span class="glyphicon glyphicon-edit"></span>

			<a href=""  class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id'] ?>" style="margin-right: 8px;"><span class="fa fa-close"></span></td>
				</td>
		
</tr>
                                

						<!-- Delete Confirmation Modal-->
					 <div class="modal fade" id="confirm-delete-<?php echo $row['id'] ?>" role="dialog">
					    <div class="modal-dialog">
					      <form action="delete_customer.php" method="POST">
					      <!-- Modal content-->
						      <div class="modal-content">
						        <div class="modal-header">
						          <button type="button" class="close" data-dismiss="modal">&times;</button>
						          <h4 class="modal-title">Confirm</h4>
						        </div>
						        <div class="modal-body">
						      
						        		<input type="hidden" name="del_id" id = "del_id" value="<?php echo $row['id'] ?>">
						        	
						          <p>Are you sure you want to cancel this policy?</p>
						        </div>
						        <div class="modal-footer">
						        	<button type="submit" class="btn btn-default pull-left">Yes</button>
						         	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						        </div>
						      </div>
					      </form>
					      
					    </div>
  					</div>
            <?php endforeach; ?>      
        </tbody>
    </table>


   
<!--    Pagination links-->
    <div class="text-center">

        <?php
        $db->disconnect();
        if (!empty($_GET)) {
            //we must unset $_GET[page] if previously built by http_build_query function
            unset($_GET['page']);
            //to keep the query sting parameters intact while navigating to next/prev page,
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        //Show pagination links
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = "";
                echo '<li' . $li_class . '><a href="insurance.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
    <!--    Pagination links end-->

</div>
<!--Main container end-->


<?php include_once './includes/footer.php'; ?>

