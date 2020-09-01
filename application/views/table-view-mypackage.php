<section class="grid__view mt-4">
    <div class="container">
        <h4>Quiz</h4>
        <div class="row mb-3 ">
            <div class="col-6 ">
                <form method="post" action="#0">
                    <div class="input-group ">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <span class="input-group-btn">
                          <button class="btn btn-warning" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <p style="float:right;">
                    <a href="<?php echo base_url('mypackages');?>" class="btn btn-success">Grid View</a>
                </p>

            </div>
        </div>

        <div class="row  mt-md-3">
            <div class="col-md-3  ">
                <div class="latest">
                    <div class="box left-menu">
                        <h3 class="text-left"><i class="fa fa-file-text" aria-hidden="true"></i> My Package</h3>
                        <ul class="panel-group ms-collapse-nav" id="components-nav" role="tablist" aria-multiselectable="true">

                            <?php   if($package){ $cnt=0;foreach ($package as $key => $packagepack) { $cnt++; ?>
                                <li><a class="withripple active" href="#"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $cnt.')&nbsp;'; echo $packagepack->package_name;?></a></li>
                            <?php }} ?></ul>
                    </div>
                </div>
            </div>



            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody>
                        <tr class="thead-dark ">
                            <th>#</th>
                            <th>Package Image</th>
                            <th>Quiz Name</th>

                            <th>Package Type</th>
                            <th>Package Price</th>
                            <th> Package will end at</th>
                            <th> Package Started</th>
                            <th>Days left to expire this package</th>
                            <th>Package Duration</th>

                            <th> Total PCBT Test</th>
                            <th> Number of MCQS</th>
                            <th> Frequency(Per Test in Days)</th>
                            <th>Action </th>
                        </tr>
                        <?php if($package){ $cnt=0;foreach ($package as $key => $packagepack) { $cnt++;
                            ?>
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            $currentTime = date( 'd-m-Y ', time () );
                            $newDate = date("d-m-Y", strtotime( $packagepack->end_enddate));
                            $datetime1 = strtotime($currentTime);
                            $datetime2 = strtotime($newDate);
                            $secs = $datetime2 - $datetime1;
                            $days = $secs / 86400;
                            if($days>=0)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $cnt;?></td>
                                    <td><img src="<?php echo base_url().'assets/images/'.$packagepack->image;?>" alt="" style=" width:400px;"></td>

                                    <td><?php echo $packagepack->package_name;?></td>

                                    <td><?php echo $packagepack->package_type;?></td>
                                    <td width="20%"><?php if($packagepack->package_type=='Free'){ echo '<i class="fa fa-inr" aria-hidden="true"></i>'.'00.00';} else{ echo '<i class="fa fa-inr" aria-hidden="true"></i>'.$packagepack->package_price;}?></td>


                                    <td><?php echo $packagepack->package_start;?></td>
                                    <td><?php echo $packagepack->end_enddate;?></td>
                                    <td><?php echo $days;?></td>
                                    <td><?php echo $packagepack->package_duration.'days';?></td>
                                    <td><?php echo $packagepack->tot_cbt_test;?></td>
                                    <td><?php echo $packagepack->mcq_in_cbt;?></td>
                                    <td><?php echo $packagepack->frequency_oc_cbt;?></td>
                                    <td>
                                        <a href="<?php echo base_url('myquizlist/'.$packagepack->package_id);?>" class="btn btn-success">Open Package</a>
                                    </td>
                                </tr>

                            <?php }} } ?>

                        </tbody>
                    </table>
                </div>
            </div>



        </div>




        <div class="my-3 text-center mb-4">
            <a href="#0" class="btn btn-primary mx-2"> <span> Back</span></a>
            <a href="#0" class="btn btn-primary"> <span>Next</span> </a>
        </div>
    </div>
</section>