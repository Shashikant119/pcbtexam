<section class="grid__view mt-4">
    <div class="container">
        <h4>My Packages</h4>
        <div class="row">
            <div class="col-6">
                <form method="post" action="#0">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <span class="input-group-btn">
                          <button class="btn btn-warning" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <p style="float:right;">
                    <a href="<?php echo base_url('my-packages'); ?>?view=table" class="btn btn-success">Table View</a>
                </p>
            </div>
        </div>
        <div class="row mt-md-3">
            <div class="col-md-12">
                <div class="row ">
                    <?php
                     // echo "<pre>";print_r($packages);die;
                        if ($packages) {
                            $cnt = 0;
                            foreach ($packages as $key => $package) {
                                $cnt++;

                                if (!$package->image) {
                                    $package->image = "dummy-image.jpg";
                                }

                                date_default_timezone_set('Asia/Kolkata');
                                $currentTime = date( 'Y-m-d ', time () );
                                 $newDate = date("Y-m-d", strtotime( $package->package_end));
                                $datetime1 = strtotime($currentTime);
                                $datetime2 = strtotime($newDate);
                                $secs = $datetime2 - $datetime1;
                                 $days = $secs / 86400;
                                if ($days >= 0) {
                    ?>

                                <div class="col-md-4 text-center">
                                    <div class="card panel-pricing mt-3">
                                        <!--<div class="card-header">-->
                                            <div class="grid_logo p-3 alert-warning"><img
                                                        src="<?php echo base_url() . 'assets/images/packages/' . $package->image; ?>"
                                                        alt="" style="height:200px; width:400px;"></div>
                                            <h4 class="alert alert-warning"><?php echo $package->package_name; ?></h4>
                                            <ul class="list-group text-center list-group-flush">
                                                <li class="list-group-item">Package Started : <?php echo $package->package_start; ?></li>
                                                <li class="list-group-item">Package will end at : <?php echo $package->package_end; ?></li>
                                                <li class="list-group-item"><b>Days left to expire this package :</b> <?php echo $days; ?></li>
                                                <li class="list-group-item">Total PCBT Test : <?php echo $package->total_cbt_test; ?></li>
<li class="list-group-item">Frequency : <?php echo $package->frequency_of_cbt; ?>CBT/day<?=($package->frequency_of_cbt>1)?'s':'';?></li>
                                            </ul>
                                            <div style="margin: 20px">
                                                <a href="<?php echo base_url('my-quiz/' . $package->package_id); ?>"
                                                   class="btn btn-success">Open Package </a>
                                            </div>
                                    </div>
                                </div>

                            <?php }
                        }
                    }
                    ?>


                </div>
                <div class="my-3 text-right mb-2">
                    <a href="#0" class="btn btn-primary mx-2"> <span> Back</span></a>
                    <a href="#0" class="btn btn-primary"> <span>Next</span> </a>
                </div>
            </div>
        </div>
    </div>
</section>