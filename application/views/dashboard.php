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
                            <tr>
                                <th><i class="zmdi zmdi-account mr-1 color-royal"></i> Name</th>
                                <td id="dis_fname"><?php echo @$user->name; ?> <a
                                            href="<?php echo base_url('editprofile'); ?>" class="pull-right">
                                        <button class="btn-success btn pull-right">Edit</button></td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-account mr-1 color-warning"></i>UserID</th>
                                <td id="dis_lname"><?php echo @$user->username; ?></td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-email mr-1 color-primary"></i> Email</th>
                                <td>
                                    <?php echo @$user->email; ?>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Phone No.</th>
                                <td id="dis_phone"><?php echo @$user->mobile; ?></td>
                            </tr>
                            <tr>
                                <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Address.</th>
                                <td id="dis_phone"><?php echo @$user->address; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>