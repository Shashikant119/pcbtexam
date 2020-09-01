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
                    <a href="<?php echo base_url('myquizlist/'.$packid);?>" class="btn btn-success">Table View</a>
                </p>

            </div>
        </div>
        <div class="row  mt-md-3">
            <!-- <div class="col-md-4  ">
                    <div class="latest">
                        <div class="box left-menu">
                            <h3 class="text-left"><i class="fa fa-file-text" aria-hidden="true"></i> My Packages </h3>
                            <ul class="panel-group ms-collapse-nav" id="components-nav" role="tablist" aria-multiselectable="true">
                            

                              <?php   if($package){ $cnt=0;foreach ($package as $key => $packagepack) { $cnt++; ?>
                                 <li><a class="withripple active" href="#"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $cnt.')&nbsp;'; echo $packagepack->package_name;?></a></li>
                                 <?php }} ?>
                            </ul>
                        </div>
                    </div>
                </div> -->
            <div class="col-md-8">
                <div class="row ">

                    <?php
                    if($quiz) {
                        $cnt=0;foreach ($quiz as $key => $packagepack) { $cnt++;
                        ?>
                        <div class="col-md-6 text-center">
                            <div class="panel panel-success panel-pricing">
                                <div class="panel-heading">
                                    <!--  <div class="grid_logo p-3 alert-warning"><img src="<?php echo base_url().'assets/images/'.$packagepack->image;?>" alt="" style="height:200px; width:400px;"></div> -->
                                    <h4 class="alert alert-warning"><?php echo $packagepack->quiz_title;?></h4>
                                </div>
                                <li class="list-group-item">No. of Questions:<?php echo $packagepack->number_of_questions;?></li>

                                <li class="list-group-item">Marks per Question:<?php echo $packagepack->marks_per_question;?></li>
                                <!--   <li class="list-group-item"><?php echo $packagepack->package_duration.'days';?></li> -->
                                <div class="panel-body text-center">
                                    <p><strong> <i class="fa fa-clock-o"></i> Negative Marks per Question :<?php echo $packagepack->negative_marks_per_question;?></strong></p>
                                </div>
                                <ul class="list-group text-center">
                                    <li class="list-group-item">Max Attempt:<?php echo $packagepack->max_attempts_allowed; ?></li>
                                    <li class="list-group-item">Quiz Duration:<?php echo $packagepack->duration.'min'; ?></li>
                                    <li class="list-group-item">Minimum Pass percentage:<?php echo $packagepack->min_pass_percentage.'%'; ?></li>
                                    <?php echo $packagepack->numberofquestion; ?>
                                </ul>
                                <div class="panel-footer" style="margin:20px;">
                                    <a href="<?php echo base_url('instructionstarttest/'.$packagepack->quiz_id);?>" class="btn btn-success">Start Test </a>
                                </div>
                            </div>
                        </div>

                    <?php
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
    
    