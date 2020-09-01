<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

  <div class="app-title">
    <div>
      <h1><i class="fa fa-user"></i> User Management</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">User Management</a></li>
    </ul>
  </div>

<div class="row">
  <div class="col-md-12">
    <form action="<?php echo base_url('Admin_home/add_update_user'); ?>" name="user-form" method="POST">
    <div class="tile">

<div class="row">
  <div class="col-lg-6">
            <div class="form-group">
              <label for="user-name">Userid : <span style="color: red">*</span></label><br>
             <b><i><?php echo @$edit_data->username; ?></i></b>   
            </div>
  </div>

   <div class="col-lg-6">
            <div class="form-group">
              <label for="dob">Password : <span style="color: red">*</span></label>
              <input class="form-control"  type="text" name="password" placeholder="Enter password if you want change"  maxlength="20" >
            </div>
        </div>
     
      </div>



      <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
              <label for="user-name">Name : <span style="color: red">*</span></label>
              <input class="form-control" id="user-name" type="text" name="user_name" placeholder="Name" required="" maxlength="255" value="<?php echo @$edit_data->name; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
              <label for="dob">Date Of Birth : <span style="color: red">*</span></label>
              <input class="form-control" id="dob" type="text" name="dob" placeholder="Date Of Birth" required="" maxlength="20" value="<?php echo @$edit_data->dob; ?>">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
              <label for="emailid">Email : <span style="color: red">*</span></label>
              <input class="form-control" id="emailid" type="email" name="emailid" placeholder="abc@xyz.com" required="" maxlength="150" onfocus="clearError();" value="<?php echo @$edit_data->email; ?>">
            </div>
            <span id="error-email" style="color: red;"></span>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
              <label for="mobile">Mobile : <span style="color: red">*</span></label>
              <input class="form-control" id="mobile" type="text" name="mobile" placeholder="Mobile" required="" maxlength="10" pattern="\d{10}" value="<?php echo @$edit_data->mobile; ?>">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
              <label for="address">Address : </label>
              <input class="form-control" id="address" type="text" name="address" placeholder="Address" value="<?php echo @$edit_data->address; ?>">
            </div>
        </div>
        
      
       <!-- 
        <div class="col-lg-6">
            <div class="form-group">
              <label for="password">Password : <span style="color: red">*</span></label>
              <input class="form-control" id="password" type="password" name="password" placeholder="*****"  minlength="5" maxlength="15" <?php //if (empty(@$edit_data->user_id)) echo 'required=""'; ?>>
            </div>
            <?php /* 
                if (!empty(@$edit_data->user_id)) {
                  echo '<p><small><strong>Note : </strong>If you want to change password of user then enter new password, otherwise skip it.<small></p>';
                } */
            ?>
        </div>
        -->
      </div>
      <?php
            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date( 'd-m-Y', time () );
            $currentTime = date("Y-m-d", strtotime($currentTime));
          
        ?>
     
      <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
            <label for="quiz-packages">Choose Packages : <span style="color: red">*</span></label>
            <div class="checkbox">
               <table>
                <col width="80">
                 <col width="80">
                <col width="130">
                
                <col width="130">
               
        <tr>
            <?php $prev_pack = array(); $prev_pack = @$edit_data->quiz_packages; $prev_pack = @explode(',', $prev_pack);  $ci=0; foreach($packages as $package) { 
              $f=0; foreach($selectpack as $pac ) {
               if($package->package_id== $pac->package) $f++; }
               echo '<td><label><input type="checkbox" name="quiz_packages[]" value="'.$package->package_id.'"'; if($f) { echo 'checked=""'; } 
               echo '> </td><td>'.$package->package_name.'</label></td>'; 
  $currentTimepackage= date('Y-m-d', strtotime($currentTime. ' + '.$package->package_duration.' days'));

               ?>

  <td>
  <div class="col-lg-12">
            <div class="form-group">
             <?php if($ci==0){ ?> <label for="branch-location">Start Date : <span style="color: red">*</span></label> <?php } ?>
              <input class="form-control"  type="date" name="startdate[]" <?php if(!empty($selectpack[$ci]->package_start)){ ?> value="<?php echo @$selectpack[$ci]->package_start; ?>" <?php } else { ?> value="<?php echo $currentTime; ?>" <?php } ?> > 
            </div>
        </div>
      </td><td>
        <div class="col-lg-12">
            <div class="form-group">
            <?php if($ci==0){ ?>  <label for="branch-location">End Date : <span style="color: red">*</span></label><?php } ?>
              <input class="form-control"  type="date" name="enddate[]" <?php if(!empty($selectpack[$ci]->end_enddate)){ ?>  value="<?php echo @$selectpack[$ci]->end_enddate; ?>" <?php } else { ?> value="<?php echo $currentTimepackage; ?>" <?php } ?> >
            </div>
        </div>
      </td>
    </tr>

               <?php $ci++; } 


               ?>
            </div>
          </div>
        </div>
      </div>
   
    </table>
      
      <div class="tile-footer">
        <button class="btn btn-primary" type="submit">Submit</button>
        <a class="btn btn-danger" href="<?php echo base_url() ?>user-management/">Cancel</a>
      </div>
      <input type="hidden" name="req_id" value="<?php echo @$edit_data->user_id; ?>">
    </div>
    </form>
  </div>
</div>

</main>
<?php $this->load->view('admin/footer'); ?>
<script type="text/javascript">
    $("#emailid").focusout(function(){ 
        var emailId = $("#emailid").val();
        var editId = '<?php echo @$edit_data->user_id; ?>';
        if(emailId != '') {
            $.ajax({
                url: '<?php echo base_url() . 'Admin_home/existEmailCheck'; ?>',
                crossDomain: true,
        		async: false,
        		type: 'post',
                data: {"email": emailId, "skip": editId},
                success: function(data) {
                    if(data == 'yes') {
            			$("#error-email").html('Email already exist. Please enter another email.');
            			$("#emailid").val('');
                    }
                }
            });
        }
    });
    
    function clearError() {
        $("#error-email").html('');
    }
	$(function() {
		$( "#dob" ).datepicker( { changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy', yearRange: "1950:2050" } );
    $( "#startd" ).datepicker( { changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy', yearRange: "1950:2050" } );
    $( "#endd" ).datepicker( { changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy', yearRange: "1950:2050" } );
	});
</script>
</body>
</html>