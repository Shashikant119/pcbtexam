<link rel="stylesheet" href="<?=base_url();?>assets/css/simple-rating.css">


<section class="latest mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <div class="text-center">
                    <?php $msg=$this->session->flashdata('msg'); if ($msg) {  ?>
                        <div class="alert alert-success">
                            <?=$msg;?>
                        </div>

                        <?php }?>
                </div>
                <div class="box dashbaord">
                    <h3 class="text-left"><i class="fa fa-link" aria-hidden="true"></i> New Appreciation 
                    </h3>
                    <div class="card-body table-responsive no-p">
                        <table class="table table-no-border table-striped">
                            <tbody>
                            <form action="<?php echo base_url('index.php/appreciation'); ?>" method="POST" enctype="multipart/form-data">
                                 <tr>
                                    <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Status Pic.</th>
                                    <td id="dis_phone">
                                        <input type="file" class="form-control" 
                                               name="profile_pic" />
                                      
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-account mr-1 color-royal"></i> Your Words</th>
                                    <td id="dis_fname">
<textarea type="text" class="form-control" name="feedback" ></textarea></td>
                                </tr>
                                   <tr>
                                    <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>State.</th>
                                    <td id="dis_phone">
                                        <input type="text" class="form-control" 
                                               name="state">
                                    </td>
                                </tr>
                                 <tr>
                                    <th><i class="zmdi zmdi-smartphone-android mr-1 color-success"></i>Rating.</th>
                                    <td id="dis_phone">
                                        <input class="rating" name='rating'>
                                    </td>
                                </tr>
                             
                                <tr>
                                    <td colspan='2' align='center'>
                        <button class='btn btn-info' type="submit">Submit</button>
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