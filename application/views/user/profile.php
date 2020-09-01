<section class="latest mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <div class="text-center">
                    <?php $msg=$this->session->flashdata('msg'); if ($msg) { echo $msg; } ?>
                </div>
                <div class="box dashbaord">
                    <h3 class="text-left"><i class="fa fa-link" aria-hidden="true"></i> My Profile
                    </h3>
                    <div class="card-body table-responsive no-p">
                        <table class="table table-no-border table-striped">
                            <tbody>
            <?php //if($user->profile_pic){?>

                       <!-- <tr>
                                <th><i class="zmdi zmdi-account mr-1 color-royal"></i> Profile Pic</th>
                                <td id="dis_fname">
     <img src="<?php echo base_url('uploads/').$user->profile_pic;?>" width='100px' height='50px' /></td>
                            </tr>-->
            <?php// }?>
                            <tr>
                                <th><i class="zmdi zmdi-account mr-1 color-royal"></i> Name</th>
                                <td id="dis_fname"><?php echo $user->name; ?></td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-account mr-1 color-warning"></i>UserID</th>
                                <td id="dis_lname"><?php echo $user->username; ?></td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-email mr-1 color-primary"></i> Email</th>
                                <td>
                                    <?php echo $user->email; ?>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Phone No.</th>
                                <td id="dis_phone"><?php echo $user->mobile; ?></td>
                            </tr>
                             <tr>
                                <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Dob.</th>
                                <td id="dis_phone">
            <?php echo ($user->dob=='0000-00-00')?'':$user->dob; ?></td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Address.</th>
                                <td id="dis_phone"><?php echo $user->address; ?></td>
                            </tr>

                            <tr>
                                <th></th>
                                <td>
                                    <a href="<?php echo base_url('edit-profile'); ?>" class="btn-success btn">Edit Profile</a>
                                    <a href="<?php echo base_url('update-password'); ?>" class="btn-success btn">Change Password</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>