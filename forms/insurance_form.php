
<fieldset>
    <div class="form-group">
        <label>Please Select Client </label>

        <select  name="motorbike_details_id" id="motorbike_details_id" class="form-control selectpicker" required="required" onchange="get_bike();">
            <option value=" " >Please select Client</option>
            <?php
            require_once './config/config.php';
            echo $sql = "select distinct(c.id),c.display_name from m_client c left join `client_bike_details` m on c.id=m.client_id where c.status_enum='300' and c.office_id='50' ";
            $result = mysqli_query(getDbConnection(), $sql);
            if ($edit) {
                $client = $customer['bike_id'];
                echo $sql = "select distinct(c.id),c.display_name from client_insurance_details d left join `client_bike_details` e on d.bike_id = e.id left join m_client c on c.id = e.client_id  where e.id='$client' ";
                $result1 = mysqli_query(getDbConnection(), $sql);

                $clients = Array();
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
            if ($edit) {
                require_once './config/config.php';
                $client = $customer['bike_id'];
                $sql = "select e.id,e.Model,e.number_plate from `client_bike_details` e where id='$client' ";
                $result = mysqli_query(getDbConnection(), $sql);

                foreach ($result as $opt) {
                    echo '<option value="' . $opt['id'] . '"' . $sel . '>' . $opt['Model'] . "-" . $opt['number_plate'] . '</option>';
                }
            }
            ?>
        </select>
    </div> 


    <div class="form-group">
        <label for="commence_date">Commencement Date *</label>
        <input type="text" name="commence_date" data-date-format="dd-mm-yyyy" value="<?php echo $edit ? $customer['commence_date'] : ''; ?>" placeholder="Commence Date" class="form-control" required="required" id="commence_date">
    </div> 
    <div class="form-group">
        <label>Period(Months) </label>

        <input type="text" name="period"  value="<?php echo $edit ? $customer['period'] : ''; ?>" placeholder="Period" class="form-control" required="required" id="period">
    </div> 

    <div class="form-group">
        <label for="batch">Batch *</label>
        <select name="batch_id" id="batch_id" class="form-control selectpicker" onchange="getBatch()" required="required" >     
            <option value="">Select Batch</option>

            <?php
            require_once './config/config.php';
            $sql = "select id,start,end from insurance_batches ";
            $result4 = mysqli_query(getDbConnection(), $sql);

            foreach ($result4 as $opt) {
                if ($edit && $opt['id'] == $customer['batch_id']) {
                    $sel = "selected";
                } else {
                    $sel = "";
                }
                echo '<option value="' . $opt['id'] . '"' . $sel . '>' . $opt['start'] . "-" . $opt['end'] . '</option>';
            }
            ?>
        </select>
    </div>

<div class="form-group">
        <label>Please Select Cert Number </label>

        <select id="cert_no" name="cert_no" class="form-control selectpicker" required="required" >     
            <?php
            if ($edit) {
                require_once './config/config.php';
                $client = $customer['cert_no'];
                $batch= $customer['batch_id'];
               echo  $sql = "select * from insurance_cert_numbers where batch_id='$batch' and cert_no not in (select cert_no from client_insurance_details where cert_no is not null)";
                $result = mysqli_query(getDbConnection(), $sql);

                foreach ($result as $opt) {
                    if ($edit && $opt['cert_no'] == $customer['cert_no']) {
                    $sel = "selected";
                } else {
                    $sel = "";
                }
                    echo '<option value="' . $opt['cert_no'] . '"' . $sel . '>' . $opt['cert_no']. '</option>';
                }
            }
            ?>
        </select>
    </div> 

    <div class="form-group">
        <label for="due_date">Due Date *</label>
        <input type="text" name="due_date" data-date-format="dd-mm-yyyy" value="<?php echo $edit ? $customer['due_date'] : ''; ?>" placeholder="Due Date" class="form-control" required="required" id="duedate">
    </div> 
    <div class="form-group">
        <label for="policy_number">Policy Number *</label>

        <select id="policy_number" name="policy_number" class="form-control selectpicker" required="required" >     
            <option value="">Select Policy number</option>
            <?php
            print_r($customer);
            require_once './config/config.php';
            $sql = "select policy_number from policy_numbers ";
            $result4 = mysqli_query(getDbConnection(), $sql);

            foreach ($result4 as $opt) {
                if ($edit && $opt['policy_number'] == $customer['policy_number']) {
                    $sel = "selected";
                } else {
                    $sel = "";
                }
                echo '<option value="' . $opt['policy_number'] . '"' . $sel . '>' . $opt['policy_number'] . '</option>';
            }
            ?>
        </select>
    </div> 
    <div class="form-group">
        <label for="cover_type">Cover Type *</label>
        <select id="cover_type" name="cover_type" class="form-control selectpicker" required="required" >
            <option value="">Select Cover Type</option>
            <?php
            require_once './config/config.php';
            $sql2 = "select cover_type,short_name from cover_type ";
            $result5 = mysqli_query(getDbConnection(), $sql2);

            foreach ($result5 as $opt) {
                if ($edit && $opt['short_name'] == $customer['cover_type']) {
                    $sel = "selected";
                } else {
                    $sel = "";
                }
                echo '<option value="' . $opt['short_name'] . '"' . $sel . '>' . $opt['cover_type'] . "(" . $opt['short_name'] . ")" . '</option>';
            }
            ?>
        </select>
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
                var dataString = "client_id=" + client;
                $.ajax({
                    type: "POST",
                    url: "./includes/getbikes.php", // Name of the php files
                    data: dataString,
                    success: function (html)
                    {
                        $("#bike_id").html(html);
                    }
                });
            }

            function getBatch() { // Call to ajax function
                var batch = $('#batch_id').val();
               
                var dataString = "batch_id=" + batch;
                $.ajax({
                    type: "POST",
                    url: "./includes/getbatch.php", // Name of the php files
                    data: dataString,
                    success: function (html)
                    {
                        $("#cert_no").html(html);
                    }
                });
            }
</script>