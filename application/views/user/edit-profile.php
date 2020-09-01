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
                    <h3 class="text-left"><i class="fa fa-link" aria-hidden="true"></i>Edit Profile
                    </h3>
                    <div class="card-body table-responsive no-p">
                        <table class="table table-no-border table-striped">
                            <tbody>
                            <form action="<?php echo base_url('index.php/edit-profile'); ?>" method="POST" enctype='multipart/form-data'>
                              <!--  <tr>
                                    <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i> Profile Pic.</th>
                                    <td id="dis_phone">
                                        <input type="file" class="form-control" 
                                               name="profile_pic">
                                        <?php if($user->profile_pic){?>
                                               <img style="width:50px;height:50px;margin:10px;"src=<?php echo base_url();?>uploads/<?=$user->profile_pic;?> />
                                        <?php }?>
                                    </td>
                                </tr>-->
                                <tr>
                                    <th><i class="zmdi zmdi-account mr-1 color-royal"></i> Name</th>
                                    <td id="dis_fname"><input type="text" class="form-control"
                                                              value="<?php echo $user->name; ?>" name="name"></td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-account mr-1 color-warning"></i>UserID</th>
                                    <td id="dis_lname"><?php echo $user->username; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-email mr-1 color-primary"></i> Email</th>
                                    <td>
         <input type="text" readonly class="form-control" value="<?php echo $user->email; ?>"
                                               name="email">
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Phone No.</th>
                                    <td id="dis_phone"><input type="text" class="form-control"
                                                              value="<?php echo $user->mobile; ?>" name="mobile">
                                    </td>

                                </tr>
                                 <tr>
                                    <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Date Of Birth.</th>
                                    <td id="dis_phone">
                                        <input type="text" class="form-control" id="datepicker" value="<?php echo $user->dob; ?>"
                                               name="dob">
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Address.</th>
                                    <td id="dis_phone">
                                        <input type="text" class="form-control" value="<?php echo $user->address; ?>"
                                               name="address">
                                    </td>
                                </tr>
                                
                                 
                                <tr>
                                    <th></th>
                                    <td id="dis_phone">
                                        <input type="submit" class="form-control col-md-3 btn btn-primary "
                                               style="padding-bottom:35px; margin-top:40px;" value="Update"
                                               name="update">
                                    </td>
                                </tr>
                            </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>