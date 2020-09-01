<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-user"></i> Add User</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">User Management</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('add-user'); ?>" name="user-form" method="POST">
                <div class="tile">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="user_type">User Type : <span style="color: red">*</span></label>
                                <select class="form-control" name="user_type" id="user_type" required onchange="toggleUsername(this.value)">
                                    <option value="2">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="fg-username" style="display: none">
                                <label for="username">Username : <span style="color: red">*</span></label>
                                <input class="form-control" type="text" id="username" name="username" placeholder="Enter username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Name : <span style="color: red">*</span></label>
                                <input class="form-control" id="name" type="text" name="name" placeholder="Name" required="" maxlength="255" value="">
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
                                <label for="mobile">Mobile : <span style="color: red">*</span></label>
                                <input class="form-control" id="mobile" type="text" name="mobile" placeholder="Mobile" required="" maxlength="10" pattern="\d{10}" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email_id">Email : <span style="color: red">*</span></label>
                                <input class="form-control" id="email_id" type="email" name="email_id" placeholder="abc@xyz.com" required="" maxlength="150" onfocus="clearError();" value="">
                            </div>
                            <span id="error-email" style="color: red;"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="dob">Date Of Birth : <span style="color: red">*</span></label>
                                <input class="form-control" id="dob" type="text" name="dob" placeholder="Date Of Birth" required="" maxlength="20" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="address">Address : </label>
                                <input class="form-control" id="address" type="text" name="address" placeholder="Address" value="">
                            </div>
                        </div>
                    </div>

                    <?php
                    date_default_timezone_set('Asia/Kolkata');
                    $currentTime = date( 'd-m-Y', time () );
                    $currentTime = date("Y-m-d", strtotime($currentTime));

                    ?>
                    <div class="row" id="packages_list">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="quiz-packages">Choose Packages : <span style="color: red">*</span></label>
                                <div class="checkbox">
                                    <table>
                                        <col width="30">
                                        <col width="250">
                                        <col width="130">
                                        <col width="130">
                                        <tr>
                                            <?php

                                                $ci = 0;
                                                foreach($packages as $package) {
                                                    echo '<td><input type="checkbox" id="check-'.$package->package_id.'" name="quiz_packages[]" value="'.$package->package_id.'"></td>';
                                                    echo '<td><label style="margin-bottom: 0px" for="check-'.$package->package_id.'">'.$package->package_name.'</label></td>';
                                                    $currentTimepackage = date('Y-m-d', strtotime($currentTime. ' + '.$package->package_duration.' days'));
                                            ?>

                                            <td>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <?php if ($ci == 0) { ?>
                                                            <label for="branch-location">Start Date : <span style="color: red">*</span></label>
                                                        <?php } ?>
                                                        <input class="form-control"  type="date" name="startdate[]" value="<?php echo $currentTime; ?>" >
                                                    </div>
                                                </div>
                                            </td><td>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <?php if($ci==0){ ?>  <label for="branch-location">End Date : <span style="color: red">*</span></label><?php } ?>
                                                        <input class="form-control"  type="date" name="enddate[]" value="<?php echo $currentTimepackage; ?>">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                        $ci++; }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-danger" href="<?php echo base_url() ?>user-management/">Cancel</a>
                    </div>
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

    function toggleUsername(user_type) {
        if (user_type == 1) {
            $("#fg-username").show();
            $("#packages_list").hide();
        } else {
            $("#fg-username").hide();
            $("#packages_list").show();
        }
    }

    <?php
    if ($this->session->flashdata('msg')) {
        echo 'showNotification("' . $this->session->flashdata('msg') . '");';
    }
    ?>
</script>
</body>
</html>