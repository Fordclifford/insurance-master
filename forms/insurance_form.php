
<fieldset>
    <div class="form-group">
        <label>Please Select Client </label>

        <select  name="motorbike_details_id" id="motorbike_details_id" class="form-control selectpicker" required="required" onchange="get_bike();">
            <option value=" " >Please select Client</option>
            <?php
            require_once './config/config.php';
            echo $sql = "select distinct(c.id),c.display_name from m_client c left join `client_bike_details` m on c.id=m.client_id where c.status_enum='300' and c.office_id='50' ";
            $result = mysqli_query(getDbConnection(), $sql);
if ($edit){
    $client = $customer['motorbike_details_id'];
             echo $sql = "select distinct(c.id),c.display_name from client_insurance_details d left join `client_bike_details` e on d.motorbike_details_id = e.id left join m_client c on c.id = e.client_id  where e.id='$client' ";
            $result1 = mysqli_query(getDbConnection(), $sql);
                      
            $clients=Array();
             foreach ($result1 as $row) {
                 array_push($clients, $row);
                 
             }
             print_r($clients);
}
            foreach ($result as $opt) {
                if ($edit && $opt['id'] == $clients[0]['id']) {
                    $sel = "selected";
                } else {
                    $sel = "";
                }
                echo '<option value="' . $opt['id'] . '"' . $sel . '>' . $opt['display_name'] . '</option>';
            }
            ?>
        </select>
    </div>  
    
      <div class="form-group">
        <label>Please Select Bike </label>

        <select id="bike_id" name="bike_id" class="form-control selectpicker" required="required" >     
                    <?php
                   
if ($edit){    
      require_once './config/config.php';
    $client = $customer['motorbike_details_id'];
              $sql = "select e.id,e.Model,e.number_plate from `client_bike_details` e where id='$client' ";
            $result = mysqli_query(getDbConnection(), $sql);
                      
            foreach ($result as $opt) {
               echo '<option value="' . $opt['id'] . '"' . $sel . '>' . $opt['Model']."-".$opt['number_plate'] . '</option>';
            }
}
            ?>
            </select>
    </div> 


    <div class="form-group">
        <label for="commence_date">Commencement Date *</label>
        <input type="text" name="commence_date" data-date-format="dd/mm/yyyy" value="<?php echo $edit ? $customer['commence_date'] : ''; ?>" placeholder="Commence Date" class="form-control" required="required" id="commence_date">
    </div> 
    <div class="form-group">
        <label>Period(Months) </label>

        <input type="text" name="period"  value="<?php echo $edit ? $customer['period'] : ''; ?>" placeholder="Period" class="form-control" required="required" id="period">
    </div> 

    <div class="form-group">
        <label for="due_date">Due Date *</label>
        <input type="text" name="due_date" data-date-format="dd/mm/yyyy" value="<?php echo $edit ? $customer['due_date'] : ''; ?>" placeholder="Due Date" class="form-control" required="required" id="duedate">
    </div> 
    <div class="form-group">
        <label for="policy_number">Policy Number *</label>
        <input type="text" name="policy_number" value="<?php echo $edit ? $customer['policy_number'] : ''; ?>" placeholder="Policy Number" class="form-control" required="required" id="policy_number">
    </div> 


    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function () {
        $("#commence_date").datepicker(
                );

    });
    $(function () {
        $("#duedate").datepicker();
    });
    
function get_bike() { // Call to ajax function
    var client = $('#motorbike_details_id').val();
    var dataString = "client_id="+client;
    $.ajax({
        type: "POST",
        url: "./includes/getbikes.php", // Name of the php files
        data: dataString,
        success: function(html)
        {
            $("#bike_id").html(html);
        }
    });
}
</script>