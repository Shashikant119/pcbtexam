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
                    <a href="<?php echo base_url('myquizlistgridview/'.$packid);?>" class="btn btn-success">Grid View</a>
                </p>

            </div>
        </div>

        <div class="row  mt-md-3">
            <!--    <div class="col-md-4  ">
                   <div class="latest">
                       <div class="box left-menu">
                           <h3 class="text-left"><i class="fa fa-file-text" aria-hidden="true"></i> Package Pricing </h3>
                           <ul class="panel-group ms-collapse-nav" id="components-nav" role="tablist" aria-multiselectable="true">
                                    <li><a class="withripple active" href="#">Package pricing list will show here from admin panel ke package management</a></li>

                             </ul>
                       </div>
                   </div>
               </div> -->
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody>
                        <tr class="thead-dark ">
                            <th>#</th>
                            <th>Quiz Name</th>
                            <th>No. of Questions</th>
                            <th>Marks per Question</th>
                            <th>Negative Marks per Question</th>

                            <th>Max Attempt</th>
                            <th>Quiz Duration</th>
                            <th>Minimum Pass percentage</th>
                            <th>Action </th>
                        </tr>
                        <?php
                        if($quiz) {
                            $cnt=0;foreach ($quiz as $key => $packagepack) { $cnt++;
                            ?>
                                <tr>
                                    <td><?php echo $cnt;?></td>
                                    <td><?php echo $packagepack->quiz_title;?></td>

                                    <td><?php echo $packagepack->number_of_questions;?></td>
                                    <td><?php echo $packagepack->marks_per_question;?></td>
                                    <td><?php echo $packagepack->negative_marks_per_question;?></td>
                                    <td><?php echo $packagepack->max_attempts_allowed;?></td>
                                    <td><?php echo $packagepack->duration.'min';?></td>
                                    <td><?php echo $packagepack->min_pass_percentage.'%';?></td>
                                    <td width="30%">
                                        <a href="<?php echo base_url('instructionstarttest/'.$packagepack->quiz_id);?>" class="btn btn-success">Start Test </a>
                                    </td>
                                </tr>

                        <?php
                        }
                        }
                        ?>
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


