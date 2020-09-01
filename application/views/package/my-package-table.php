<section class="grid__view mt-4">
    <div class="container">
        <h4>My Packages</h4>
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
                    <a href="<?php echo base_url('my-packages');?>?view=grid" class="btn btn-success">Grid View</a>
                </p>
            </div>
        </div>
        <div class="row mt-md-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody>
                        <tr class="thead-dark" style="white-space: nowrap;">
                            <th>#</th>
                            <th>Package Image</th>
                            <th>Package Name</th>
                            <th>Package Started</th>
                            <th>Package End Date</th>
                            <th>Days Left</th>
                            <th>Total PCBT Test</th>
                            <th>Frequency</th>
                            <th>Action </th>
                        </tr>
                        <?php if($packages) {
                            $count = 0;
                            foreach ($packages as $package) {
                                if (!$package->image) {
                                    $package->image = "dummy-image.jpg";
                                }
                            date_default_timezone_set('Asia/Kolkata');
                            $currentTime = date( 'Y-m-d ', time () );
                             $startDate = date("Y-m-d", strtotime( $package->package_start));
                            $newDate = date("Y-m-d", strtotime( $package->package_end));
                            $datetime1 = strtotime($currentTime);
                            $datetime2 = strtotime($newDate);
                            $secs = $datetime2 - $datetime1;
                            $days = $secs / 86400;
                            if($days >= 0)
                            {
                               $datetime3=strtotime($startDate);
                               $remaining=($datetime2 - $datetime3)/86400;
                               $count++;
                        ?>
                                <tr>
                                    <td><?php echo $count;?></td>
                                    <td><img src="<?php echo base_url('assets/images/packages/').$package->image; ?>" height="55" width="70"></td>
                                    <td><?php echo $package->package_name;?></td>
                                    <td><?php echo $package->package_start;?></td>
                                    <td><?php echo $package->package_end;?></td>
                                    <td><?php echo  $remaining;?></td>
                                    <td><?php echo $package->total_cbt_test;?></td>
                                    <td><?php echo $package->frequency_of_cbt;?>
                       
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('my-quiz/'.$package->package_id);?>" class="btn btn-success">Open Package</a>
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