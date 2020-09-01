<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

  <div class="app-title">
    <div>
      <h1><i class="fa fa-key fa-lg"></i> Change Password</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Change Password</a></li>
    </ul>
  </div>

<div class="row">
  <div class="col-md-12">
    <form action="" name="cp-form" method="POST">
    <div class="tile">

      <div class="row">
        <div class="col-lg-4">
          <div class="form-group">
            <label for="password">Password : <span style="color: red">*</span></label>
            <input class="form-control" id="password" type="password" placeholder="Password" name="password" required="" minlength="5" maxlength="10">
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label for="password1">Confirm Password : <span style="color: red">*</span></label>
            <input class="form-control" id="password1" type="password" placeholder="Confirm Password" name="password1" required="" minlength="5" maxlength="10">
          </div>
        </div>
      </div>
      <div class="tile-footer">
        <button class="btn btn-primary" type="submit" onclick="return validateCPForm();">Submit</button>
      </div>
    </div>
    </form>
  </div>
</div>

</main>
<?php $this->load->view('admin/footer'); ?>
<script type="text/javascript">
    function validateCPForm() {
        var p1 = $("#password").val();
        var p2 = $("#password1").val();
        if(p1 == p2) {
            return true;
        } else {
            alert("Password and Confirm Password does not matched.");
            return false;
        }
    }
    
    <?php 
        if($this->session->flashdata('msg')) {
          echo 'showNotification("'. $this->session->flashdata('msg') .'");';
        }
     ?>
</script>
</body>
</html>