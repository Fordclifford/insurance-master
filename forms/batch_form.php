<fieldset>
    <!-- Form Name -->
    <legend>Add Batch</legend>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label">Start</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-arrow-left"></i></span>
                <input  type="number" name="start"  placeholder="Start" class="form-control" value="<?php echo ($edit) ? $batch['start'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" >End</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-arrow-right"></i></span>
                <input type="number" name="end" placeholder="End " class="form-control" required="" value="<?php echo ($edit) ? $batch['end'] : ''; ?>"  autocomplete="off">
            </div>
        </div>
    </div>
    
      <div class="form-group">
        <label class="col-md-4 control-label">Date</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input  type="date" name="date_issued"   placeholder="Date Issued" class="form-control" value="<?php echo ($edit) ? $batch['date_issued'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- radio checks -->
  
    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>