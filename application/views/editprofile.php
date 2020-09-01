<section class="latest mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <div class="box dashbaord">
                    <h3 class="text-left"><i class="fa fa-link" aria-hidden="true"></i> Personal Information
                    </h3>
                    <div class="card-body table-responsive no-p">
                        <table class="table table-no-border table-striped">
                            <tbody>
                            <form action="<?php echo base_url('updateprofile'); ?>" method="post">
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
                                        <input type="text" class="form-control" value="<?php echo $user->email; ?>"
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