
<fieldset>
      	       <div class="form-group">
        <label for="installment">Batch *</label>
        <?php $opt_arr = array("1", "2", "3","4"); 
                            ?>         
        <select  name="batch" id="batch" class="form-control selectpicker" onchange="get_bike()" required="required" >
                <option value=" " >Please select Installment</option>
                <?php
                foreach ($opt_arr as $opt) {
                    if ($edit && $opt == $customer['batch']) {
                        $sel = "selected";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
                }
                ?>
            
        </select>
            </div>
    <div class="row">
        <div class="col-lg-4">

            <select id="t1available" size=10  onchange="countLeft()" multiple>
    
    <?php
            require_once './config/config.php';
           $sql = "select d.id,c.display_name,d.cover_type,d.policy_number from client_insurance_details d inner join `client_bike_details` e on d.bike_id = e.id inner join m_client c on c.id = e.client_id where d.cancelled='0' and c.status_enum='300' group by d.id";
                 $result = mysqli_query(getDbConnection(), $sql);
if ($edit){
    $client = $customer['id'];
         $sql = "select d.id,c.display_name,d.cover_type,d.policy_number from client_insurance_details d inner join `client_bike_details` e on d.bike_id = e.id inner join m_client c on c.id = e.client_id where d.cancelled='0' and c.status_enum='300' and d.id not in(select insurance_id from client_payment where payment_id='$client')  group by d.id";
                
            $result1 = mysqli_query(getDbConnection(), $sql);
                  foreach ($result1 as $opt) {
                
                  echo '<option value="' . $opt['id'] . '"' . $sel . '>' . $opt['display_name'] ."-". $opt['cover_type'] .'</option>';
          }
            }else{
            foreach ($result as $opt) {
                if ($edit && $opt['id'] == $clients[0]['id']) {
                   // $sel = "selected";
                } else {
                    $sel = "";
                }
               echo '<option value="' . $opt['id'] . '"' . $sel . '>' . $opt['display_name'] ."-". $opt['cover_type'] .'</option>';
            }}
            ?>
</select>
            <br>   
                <span id="box4Counter" class="count">0 Selected</span> <br>   
                <span id="box5Counter" class="count">Total Amount: 0</span>   
            <!-- /.panel -->
        </div>
        
        <div class="col-lg-4">


<br />

   <div class="dualBtn">
                                        <button id="t1add" type="button"  class="btn" ><span class="icon12 minia-icon-arrow-right-3"></span></button>
                                        <button id="t1addAll" type="button" class="btn" ><span class="icon12 iconic-icon-last"></span></button>
                                        <button id="t1removeAll" type="button" class="btn marginT5"><span class="icon12 minia-icon-arrow-left-3"></span></button>
                                        <button id="t1remove" type="button"class="btn marginT5" ><span class="icon12 iconic-icon-first"></span></button>
                                    </div>
<br />
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <select id="t1published" onchange="count()" name="clients[]" size=10 multiple width="200">
             <?php
            if ($edit){
    $client = $customer['id'];
              $sql = "select d.id,c.display_name,d.cover_type,d.policy_number from client_insurance_details d inner join `client_bike_details` e on d.bike_id = e.id inner join m_client c on c.id = e.client_id inner join client_payment cp on cp.insurance_id=d.id where d.cancelled='0' and c.status_enum='300' and cp.payment_id='$client' group by d.id";
                
            $result1 = mysqli_query(getDbConnection(), $sql);
                  foreach ($result1 as $opt) {
                
              echo '<option value="' . $opt['id'] . '"' . 'selected' . '>' . $opt['display_name'] ."-". $opt['cover_type'] .'</option>';
            }
            }
            ?>
            </select><br>
                <span id="box2Counter" class="count">0 Selected</span> <br>   
                <span id="box3Counter" class="count">Total Amount: 0</span>      


            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
  

    
       <div class="form-group">
        <label for="commence_date">Transaction Date *</label>
        <input type="text" name="date" data-date-format="dd-mm-yyyy" value="<?php echo $edit ? $customer['date'] : ''; ?>" placeholder="Date" class="form-control" required="required" id="date">
    </div> 
    
 <div class="form-group">
        <label for="commence_date">Month *</label>
        <input type="text" name="month" data-date-format="m" value="<?php echo $edit ? $customer['month'] : ''; ?>" placeholder="Month" class="form-control" required="required" id="month">
    </div>
    
    <div class="form-group">
        <label for="commence_date">Year *</label>
        <input type="text" name="year" data-date-format="yyyy" value="<?php echo $edit ? $customer['year'] : ''; ?>" placeholder="Year" class="form-control" required="required" id="year">
    </div>
    <div class="form-group">
        <label for="policy_number">Amount *</label>
        <input type="number" name="amount" value="<?php echo $edit ? $customer['amount'] : ''; ?>" placeholder="Amount" class="form-control" required="required" id="amount">
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
        $("#date").datepicker(
                );

    });
    $(function () {
        $("#duedate").datepicker();
    });
      $(function () {
        $("#month").datepicker({
  dateFormat: "mm"
})});
       $(function () {
        $("#year").datepicker({
  dateFormat: "yy"
})});
    
function get_bike() { // Call to ajax function
    var client = $('#batch').val();
    var dataString = "client_id="+client;
    $.ajax({
        type: "POST",
        url: "./includes/getbikesbatch.php", // Name of the php files
        data: dataString,
        success: function(html)
        {
            $("#t1available").html(html);
            
        }
    });
}
</script>

<script type="text/javascript">
    function count(){
         // var values=$('#t1published').val();
   var selectedValues = [];    
    $("#t1published :selected").each(function(){
        selectedValues.push($(this).val()); 
       // alert(selectedValues);
    });
    return selectedValues;
    }
    
   function countLeft(){
         // var values=$('#t1published').val();
   var selectedValues = [];    
    $("#t1available :selected").each(function(){
        selectedValues.push($(this).val()); 
       // alert(selectedValues);
    });
    return selectedValues;
    getAmount2(selectedValues);
    }
function getAmount(clients) { // Call to ajax function
    
    var dataString = "insurance="+clients;
    
    $.ajax({
        type: "POST",
        url: "./includes/get_amount.php", // Name of the php files
        data: dataString,
        success: function(html)
        {
        $("#box3Counter").html("Total Amount "+html);
            
        }
    });
}
function getAmount2(clients) { // Call to ajax function
    
    var dataString = "insurance="+clients;
    
    $.ajax({
        type: "POST",
        url: "./includes/get_amount.php", // Name of the php files
        data: dataString,
        success: function(html)
        {
        $("#box5Counter").html("Total Amount "+html);
            
        }
    });
}
function moveSelectedItems(source, destination){
  var selected = $(source+' option:selected').remove();
   var sorted = $.makeArray($(destination+' option').add(selected)).sort(function(a,b){
    return $(a).text() > $(b).text() ? 1:-1;
  });
  $(destination).empty().append(sorted);
var insurance=count();
$("#box2Counter").html(insurance.length+ " Selected");
getAmount(insurance);
var insuranceleft=countLeft();
$("#box4Counter").html(insuranceleft.length+ " Selected");
getAmount2(insuranceleft);
}
</script>

<script type="text/javascript">
$(document).ready(function(){
var insurance=count();
$("#box2Counter").html(insurance.length+ " Selected");
getAmount(insurance);
  $('#t1add').click(function(){
    moveSelectedItems('#t1available', '#t1published');
  });
  $('#t1addAll').click(function(){
    $('#t1available option').attr('selected', 'true');
    moveSelectedItems('#t1available', '#t1published');
  });
  $('#t1remove').click(function(){
    moveSelectedItems('#t1published', '#t1available');
  });
  $('#t1removeAll').click(function(){
    $('#t1published option').attr('selected', 'true');
    moveSelectedItems('#t1published', '#t1available');
  });

});
</script>