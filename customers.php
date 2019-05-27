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
    $filter_col = "d.created_at";
}
if (!$order_by) {
    $order_by = "Desc";
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getUipDbInstance();
 //$db->join("m_client c", "c.id = d.client_id", "LEFT");
 $db->join("`client_bike_details` d", "c.id = d.client_id", "inner");
// $db->join("`m_loan` l", "c.id = l.client_id", "LEFT");
  // $db->join("`m_product_loan` p", "p.id = l.product_id", "LEFT");
            $db->where("c.status_enum", 300);
              $db->where("c.office_id", 50);
           //SELECT c.display_name,c.mobile_no,c.account_no ,d.Model,d.number_plate,d.`Engine`,d.COLOUR,d.marketing_agent FROM m_client c INNER JOIN `client motorbike details` d ON c.id=d.client_id
            //$db->where("d.print_status", "0");
   $select = array('d.id','c.display_name','c.mobile_no','c.account_no',"d.`number_plate`","d.Engine","d.Model","d.Others","d.client_id");

//Start building query according to input parameters.
// If search string
if ($search_string) 
{
   $db->where('c.display_name', '%' . $search_string . '%', 'like');
    $db->orwhere('c.mobile_no', '%' . $search_string . '%', 'like');
    $db->where('c.account_no', '%' . $search_string . '%', 'like');
    $db->orwhere('d.number_plate', '%' . $search_string . '%', 'like');
    $db->where('d.Engine', '%' . $search_string . '%', 'like');
    $db->orwhere('d.Model', '%' . $search_string . '%', 'like');
    $db->where('d.cheses_number', '%' . $search_string . '%', 'like');
    $db->orwhere('d.COLOUR', '%' . $search_string . '%', 'like');
    $db->orwhere('d.kra_pin', '%' . $search_string . '%', 'like');
$db->orwhere('d.marketing_agent', '%' . $search_string . '%', 'like');

}

//If order by option selected
if ($order_by)
{
    $db->orderBy($filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$customers = $db->arraybuilder()->paginate("m_client c", $page, $select);
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
            <h1 class="page-header">Client Motorbike Details</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
	            <a href="add_customer.php?operation=create">
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
                ?>Desc</option>
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
                <th>Account No</th>
                <th>Number Plate</th>
                               <th>Engine</th>
                <th>Model</th>
                <th>Others</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $row) : ?>
                <tr>
	                <td><?php echo $row['id'] ?></td>
                        
	                <td><?php echo htmlspecialchars($row['display_name']); ?></td>
	                <td><?php echo htmlspecialchars($row['mobile_no']) ?></td>
	                <td><?php echo htmlspecialchars($row['account_no']) ?> </td>
                        <td><?php echo htmlspecialchars($row['number_plate']); ?></td>
                      
	                <td><?php echo htmlspecialchars($row['Engine']) ?></td>
	                <td><?php echo htmlspecialchars($row['Model']) ?> </td>
                        <td><?php echo htmlspecialchars($row['Others']) ?></td>
	                <<td>
                            		<a href="edit_customer.php?client_id=<?php echo $row['id'] ?>&operation=edit" class="btn btn-primary" style="margin-right: 8px;"><span class="glyphicon glyphicon-edit"></span>

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
						        	
						          <p>Are you sure you want to delete this client?</p>
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
                echo '<li' . $li_class . '><a href="customers.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
    <!--    Pagination links end-->

</div>
<!--Main container end-->


<?php include_once './includes/footer.php'; ?>

