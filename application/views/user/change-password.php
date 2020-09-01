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
                    <h3 class="text-left"><i class="fa fa-link" aria-hidden="true"></i> Change Password</h3>
                    <div class="card-body table-responsive no-p">
                        <table class="table table-no-border table-striped">
                            <tbody>
                            <form action="<?php echo base_url('update-password'); ?>" method="POST">
                                <tr>
                                    <th><i class="zmdi zmdi-account mr-1 color-warning"></i>New Password</th>
                                    <td id="dis_lname">
                                        <input type="password" class="form-control" value="" name="password">
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-email mr-1 color-primary"></i> Confirm New Password</th>
                                    <td>
                                        <input type="password" class="form-control" value="" name="confirm_password">
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