<section class="grid__view mt-4">
    <div class="container">
        <h4>My Quiz</h4>
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
                    <a href="<?php echo base_url('my-quiz/'.$package_id);?>?view=table" class="btn btn-success">Table View</a>
                </p>
            </div>
        </div>
        <div class="row mt-md-3">
            <div class="col-md-12">
                <div class="text-center">
                    <?php $msg=$this->session->flashdata('msg'); if ($msg) { echo $msg; } ?>
                </div>
                <div class="row ">
                    <?php
                    if($quiz_list) {
                        $count = 0;
                        foreach ($quiz_list as $quiz) {
                            $count++;
                            ?>
                            <div class="col-md-4 text-center">
                                <div class="card" style="margin-bottom:10px;">
                                    <!--<div class="card-header">-->

                                    <!--</div>-->
                                    <ul class="list-group text-center list-group-flush">
                                         <li class="list-group-item" style="background:#e5ffc4"> 
            <img src="<?php echo base_url();?>assets/images/quiz/<?=$quiz->image;?>"  style='width:100%;height:190px;'/><hr>
            <h4 style="
    padding: 6px;color: #996609;margin:5px;" ><?php echo $quiz->quiz_title;?></h4>
        </li>
                                       
                                        
                                       
                                        <li class="list-group-item">No. of Questions: <?php echo $quiz->number_of_questions; ?></li>
                                        <li class="list-group-item">Negative Marks : 
        <?php echo $quiz->negative_marks_per_question;
           
         ?></li>
                                        <li class="list-group-item">Max Attempt: <?php echo $quiz->max_attempts_allowed; ?></li>
                                        <li class="list-group-item">Quiz Duration: <?php echo $quiz->duration . 'min'; ?></li>
                                       
                                    </ul>
                                    <div style="margin:20px;">
                                        <a href="<?php echo base_url('online-test/instructions/'.$package_id."/".$quiz->quiz_id);?>" class="btn btn-success">Start Test </a>
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