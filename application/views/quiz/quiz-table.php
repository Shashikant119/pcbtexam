<section class="grid__view mt-4">
    <div class="container">
        <h4>My Quiz</h4>
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
                    <a href="<?php echo base_url('my-quiz/'.$package_id);?>?view=grid" class="btn btn-success">Grid View</a>
                </p>

            </div>
        </div>
        <div class="row  mt-md-3">

            <div class="col-md-12">
                <div class="text-center">
                    <?php $msg=$this->session->flashdata('msg'); if ($msg) { echo $msg; } ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody>
                        <tr class="thead-dark" style="white-space: pre">
                            <th>#</th>
                             <th>Quiz Image</th>
                            <th>Quiz Name</th>
                            <th>No. of Questions</th>
                            
                            <th>Negative Marks</th>
                            <th>Max Attempt</th>
                            <th>Quiz Duration</th>
                         
                            <th>Action </th>
                        </tr>
                        <?php
                        if($quiz_list) {
                            $cnt=0;foreach ($quiz_list as $quiz) { $cnt++;
                                ?>
                                <tr style="white-space: nowrap">
                                    <td><?php echo $cnt;?></td>
                                     <td>
    <img src="<?php echo base_url();?>assets/images/quiz/<?php echo $quiz->image;?>"  style='width:100px;height:50px'/>         
                            </td>

                                    <td><?php echo $quiz->quiz_title;?></td>

                                    <td><?php echo $quiz->number_of_questions;?></td>
                                      <td><?php echo $quiz->negative_marks_per_question;?></td>
                                    <td><?php echo $quiz->max_attempts_allowed;?></td>
                                    <td><?php echo $quiz->duration.' min';?></td>
                                       <td width="30%">
                                        <a href="<?php echo base_url('online-test/instructions/'.$package_id."/".$quiz->quiz_id);?>" class="btn btn-success">Start Test </a>
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