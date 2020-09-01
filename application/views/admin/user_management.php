<!DOCTYPE html>

<html lang="en">



<?php $this->load->view('admin/header'); ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>



<body class="app sidebar-mini rtl">



<?php $this->load->view('admin/sidebar'); ?>

<main class="app-content">



    <div class="app-title">

        <div>

            <h1><i class="fa fa-users"></i> User Management</h1>

            <p></p>

        </div>

        <ul class="app-breadcrumb breadcrumb">

            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

            <li class="breadcrumb-item"><a href="#">User Management</a></li>

        </ul>

    </div>



    <div class="row">

        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">

                    <a class="btn btn-success pull-right" href="<?php echo base_url() ?>add-user/">Add New User</a>
                    <a class="btn btn-success" style="color:#fff;float:right;margin-right:5px;" href="<?php echo base_url(); ?>umprint"><i class="fa fa-print"></i> Print </a>

                    <a class="btn btn-success" style="color:#fff;float:right;margin-right:5px;" href="<?php echo base_url(); ?>umpdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF </a>
                    
                    <br/>



                    <div class="bs-component">

                        <!--<ul class="nav nav-tabs">

            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#active"><strong>Active Users (<?php echo count($active_users); ?>)</strong></a></li>

            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#inactive"><strong>Deleted Users (<?php echo count($deactive_users); ?>)</strong></a></li>

          </ul>-->



                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade active show" id="active">

                                <br/>

                                <table class="table table-hover table-bordered" id="tbl-activeuser" role="grid" aria-describedby="tbl-activeuser_info">

                                    <thead>

                                    <tr>

                                        <th>Sr. No.</th>

                                        <th>UserId</th>

                                        <th>Name</th>

                                        <th>Email</th>

                                        <th>Mobile</th>

                                        <th>Date Of Birth</th>

                                        <th>Address</th>

                                        <th>Assigned_By</th>

                                        <th>Action</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    <?php

                                  // echo "<pre>";print_r($active_users);die;

                                        $sr_no = 1;

                                        foreach ($active_users as $user) {

                                           // if($user->user_id==1)

                                               // continue;

                                            ?>

                                           

                                                <tr>

                                                    <td><?php echo $sr_no; ?></td>

                                                    <td><?php echo $user->username; ?></td>

                                                    <td><?php echo $user->name; ?></td>

                                                    <td><?php echo $user->email; ?></td>

                                                    <td><?php echo $user->mobile; ?></td>

                                                    <td><?php echo date('d-m-Y', strtotime($user->dob)); ?></td>

                                                    <td><?php echo $user->address; ?></td>

                                                    <td><?php echo $user->assigned_by; ?></td>

                                                    <td>

                                                        <a href="<?php echo base_url() . 'edit-user/' . $user->user_id; ?>"

                                                           class="badge badge-primary">

                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

                                                            Edit

                                                        </a>

                                                        <a href="<?php echo base_url() . 'status-user/' . $user->user_id; ?>"

                                                           class="badge badge-danger"

                                                           onclick="return confirm('Do you want to delete this user ?');">

                                                            <i class="fa fa-user-times" aria-hidden="true"></i> Delete

                                                        </a>

                                                    </td>

                                                </tr>

                                                <?php

                                                $sr_no++;

                                              }

                                    

                                    ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

</main>

<!-- show username password -->



<div class="modal fade" id="showUserInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">User Credentials</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div>

                    <span>Username: </span><strong><span id="temp_username"></span></strong>

                </div>

                <div>

                    <span>Password: </span><strong><span id="temp_password"></span></strong>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>





<?php $this->load->view('admin/footer'); ?>



<script type="text/javascript">

    $('#tbl-activeuser').DataTable({"aaSorting": []});

   // $('#tbl-deactiveuser').DataTable({"aaSorting": []});

    <?php

    if ($this->session->flashdata('msg')) {

        echo 'showNotification("' . $this->session->flashdata('msg') . '");';

    }



    if ($this->session->flashdata('temp_username') && $this->session->flashdata('temp_password')) {



        echo '$("#temp_username").text("'.$this->session->flashdata('temp_username').'");';

        echo '$("#temp_password").text("'.$this->session->flashdata('temp_password').'");';

        echo '$("#showUserInfo").modal("show");';

    }

    ?>

</script>



</body>

</html>





