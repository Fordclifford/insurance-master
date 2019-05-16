
<fieldset>
    <div class="form-group">
        <label>Please Select Client </label>

        <select  name="client_id" class="form-control selectpicker" required="required">
            <option value=" " >Please select Client</option>
            <?php
            require_once './config/config.php';
            echo $sql = "select c.id,c.display_name from m_client c where c.status_enum='300' and c.office_id='50' and c.id not in (SELECT client_id from `client motorbike details`) ";
            $result = mysqli_query(getDbConnection(), $sql);
            
            if($edit){
                 echo $sql = "select c.id,c.display_name from m_client c where c.status_enum='300' and c.office_id='50' ";
            $result = mysqli_query(getDbConnection(), $sql);

            }

            $db = getUipDbInstance();
            //  $db->join("client_insurance_details l", "c.id = l.motorbike_details_id", "LEFT");
            //$db->where("l.product_id", 44);
            // $db->where ("(l.product_id = ? or l.product_id = ?)", Array(44,45));
            $db->where("c.status_enum", 300);
            // $db->where("c.id", "NOrT EXISTS (SELECT motorbike_details_id from client_insurance_details)");
            //$db->where("l.loan_status_id", 300);
            $db->where("c.office_id", 50);
            // $db->orderBy("l.id", "desc");
            //$db->orWhere("l.product_id", 45);
            $select = array('c.id', 'c.display_name', 'c.mobile_no', 'c.account_no');
            $customers = $db->get("m_client c", null, $select);

            foreach ($result as $opt) {
                if ($edit && $opt['id'] == $customer['client_id']) {
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
        <label for="number_plate">Number Plate *</label>
        <input type="text" name="number_plate" value="<?php echo $edit ? $customer['number_plate'] : ''; ?>" placeholder="Number Plate" class="form-control" required="required" id="number_plate">
    </div> 

    <div class="form-group">
        <label for="Model">Model *</label>
        <input type="text" name="Model" value="<?php echo $edit ? $customer['Model'] : ''; ?>" placeholder="Model" class="form-control"  id="Model">
    </div> 

    <div class="form-group">
        <label for="Engine">Engine *</label>
        <input type="text" name="Engine" value="<?php echo $edit ? $customer['Engine'] : ''; ?>" placeholder="Engine" class="form-control" id="Model">
    </div> 

    <div class="form-group">
        <label for="kra_pin">KRA PIN</label>
        <input name="kra_pin" placeholder="KRA PIN" class="form-control" id="address" value="<?php echo ($edit) ? $customer['kra_pin'] : ''; ?>">
    </div> 

  <div class="form-group">
        <label for="cheses_number">Cheses Number</label>
        <input name="cheses_number" placeholder="Cheses Number" class="form-control" id="address" value="<?php echo ($edit) ? $customer['cheses_number'] : ''; ?>">
  
  
    <div class="form-group">
        <label for="COLOUR">Colour</label>
        <input name="COLOUR" placeholder="COLOUR" class="form-control" id="address" value="<?php echo ($edit) ? $customer['COLOUR'] : ''; ?>">
    </div> 
    
    <div class="form-group">
        <label for="cheses_number">Marketing Agent</label>
        <input name="marketing_agent" placeholder="Marketing Agent" class="form-control" id="address" value="<?php echo ($edit) ? $customer['marketing_agent'] : ''; ?>">
  </div>
  
  <div class="form-group">      
        <label for="Others">Others</label>
        <input name="Others" placeholder="Others" class="form-control" id="address" value="<?php echo ($edit) ? $customer['Others'] : ''; ?>"</textarea>
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


</script>