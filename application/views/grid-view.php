<section class="grid__view mt-4">
    <div class="container">
        <h4>Quiz</h4>
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
                    <a href="<?php echo base_url('packagespricing'); ?>" class="btn btn-success">Table View</a>
                </p>

            </div>
        </div>
        <div class="row  mt-md-3">
            <div class="col-md-4  ">
                <div class="latest">
                    <div class="box left-menu">
                        <h3 class="text-left"><i class="fa fa-file-text" aria-hidden="true"></i> Package Pricing </h3>
                        <ul class="panel-group ms-collapse-nav" id="components-nav" role="tablist"
                            aria-multiselectable="true">


                            <li><a class="withripple active" href="#">Package pricing list will show here from admin
                                    panel ke package management</a></li>

                            <?php if ($package) {
                                $cnt = 0;
                                foreach ($package as $key => $packagepack) {
                                    $cnt++; ?>
                                    <li><a class="withripple active" href="#"><i class="fa fa-check"
                                                                                 aria-hidden="true"></i> <?php echo $cnt . ')&nbsp;';
                                            echo $packagepack->package_name; ?></a></li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row ">

                    <?php if ($package) {
                        $cnt = 0;
                        foreach ($package as $key => $packagepack) {
                            $cnt++;
                            ?>
                            <div class="col-md-6 text-center">
                                <div class="panel panel-success panel-pricing">
                                    <div class="panel-heading">
                                        <div class="grid_logo p-3 alert-warning"><img
                                                src="<?php echo base_url() . 'assets/images/' . $packagepack->image; ?>"
                                                alt="" style="height:200px; width:400px;"></div>
                                        <h4 class="alert alert-warning"><?php echo $packagepack->package_name; ?></h4>
                                    </div>
                                    <li class="list-group-item">Package
                                        Type:<?php echo $packagepack->package_type; ?></li>

                                    <li class="list-group-item">Package
                                        Price:<?php if ($packagepack->package_type == 'Free') {
                                            echo '<i class="fa fa-inr" aria-hidden="true"></i>' . '00.00';
                                        } else {
                                            echo '<i class="fa fa-inr" aria-hidden="true"></i>' . $packagepack->package_price;
                                        } ?></li>
                                    <!--   <li class="list-group-item"><?php echo $packagepack->package_duration . 'days'; ?></li> -->
                                    <div class="panel-body text-center">
                                        <p><strong> <i class="fa fa-clock-o"></i> Duration
                                                :<?php echo $packagepack->package_duration . 'days'; ?></strong></p>
                                    </div>
                                    <ul class="list-group text-center">
                                        <li class="list-group-item">Total PCBT
                                            Test: <?php echo $packagepack->tot_cbt_test; ?></li>
                                        <li class="list-group-item">Number of
                                            MCQS: <?php echo $packagepack->mcq_in_cbt; ?></li>
                                        <li class="list-group-item">Frequency(Per Test in
                                            Days): <?php echo $packagepack->frequency_oc_cbt; ?></li>
                                        <!-- <li class="list-group-item"><?php echo $packagepack->numberofquestion; ?></li> -->


                                    </ul>
                                    <div class="panel-footer" style="margin:20px;">
                                        <a href="<?php echo base_url('subscribenowmypackage/' . $packagepack->package_id); ?>"
                                           class="btn btn-success">SUBSCRIBE NOW</a>

                                    </div>
                                </div>
                            </div>


                        <?php }
                    } ?>


                </div>
                <div class="my-3 text-right mb-2">
                    <a href="#0" class="btn btn-primary mx-2"> <span> Back</span></a>
                    <a href="#0" class="btn btn-primary"> <span>Next</span> </a>
                </div>
            </div>
        </div>


    </div>
</section>