<!DOCTYPE html>

<html lang="en">

<?php $this->load->view('admin/header'); ?>

<body class="app sidebar-mini rtl">

<?php $this->load->view('admin/sidebar'); ?>

<main class="app-content">



    <div class="app-title">

        <div>

            <h1><i class="fa fa-question-circle"></i> Add Question</h1>

            <p></p>

        </div>

        <ul class="app-breadcrumb breadcrumb">

            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

            <li class="breadcrumb-item"><a href="#">Add Question</a></li>

        </ul>

    </div>



    <div class="row">

        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">

                    <div class="row">

                        <div class="col-lg-6">

                            <label>

                                <strong>

                                    Add Question: <?php echo QuestionBank::QUESTION_TYPE[$question_type];?> <?php if (QuestionBank::SHORT_ANSWER != $question_type && $question_type != QuestionBank::LONG_ANSWER) { echo "(".$number_of_option.")"; }?>

                                </strong>

                            </label>

                        </div>

                        <div class="col-lg-6">

                            <!--<a class="btn btn-success pull-right mr-2" data-toggle="modal" data-target="#uploadQuestionModal" href="javascript:void(0)">Upload Question</a>-->

                        </div>

                    </div>

                    <div class="modal-header">



                    </div>

                    <!-- Add New Question Form -->

                    <form action="<?php echo base_url(); ?>store-question" method="POST" name="question-form">

                        <div class="modal-body">



                            <input type="hidden" name="question_type" value="<?php echo $question_type; ?>">

                            <input type="hidden" name="number_of_option" value="<?php echo $number_of_option; ?>">



                            <div class="form-group">

                                <div class="col-md-6">

                                    <label for="category" class="col-form-label">Select Category<span style="color: red;">*</span></label>

                                    <select class="form-control" name="category" id="category" required>

                                        <?php foreach ($categories as $category) { ?>

                                            <option value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>

                                        <?php } ?>

                                    </select>

                                </div>

                            </div>



                            <div class="form-group">

                                <div class="col-md-6">

                                    <label for="level" class="col-form-label">Select Level<span style="color: red;">*</span></label>

                                    <select class="form-control" name="level" id="level" required>

                                        <?php foreach ($levels as $level) { ?>

                                            <option value="<?php echo $level->id; ?>"><?php echo $level->level_name; ?></option>

                                        <?php } ?>

                                    </select>

                                </div>

                            </div>



                            <div class="form-group">

                                <div class="col-md-6">

                                    <label for="question_text" class="col-form-label">Question :<span style="color: red;">*</span></label>

                                    <textarea class="form-control" id="question_text" name="question_text" required="" maxlength="255"></textarea>

                                </div>

                            </div>



                            <?php if($question_type !== QuestionBank::LONG_ANSWER && $question_type !== QuestionBank::SHORT_ANSWER) {

                                 for($i = 1; $i <= $number_of_option; $i++) { ?>

                                    <div class="form-group">

                                        <div class="col-md-6">

                                            <label for="option_<?php echo $i;?>" class="col-form-label">Option <?php echo $i; ?> :<span style="color: red;">*</span></label>

                                            <input type="text" class="form-control" id="option_<?php echo $i;?>" name="option_<?php echo $i;?>" maxlength="200" required="">

                                        </div>

                                    </div>

                                <?php }

                            } ?>



                            <?php if ($question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER || $question_type == QuestionBank::MULTIPLE_CHOICE_SINGLE_ANSWER) { ?>

                                <div class="form-group">

                                    <div class="col-md-6">

                                        <label for="correct_option" class="col-form-label">Correct Answer :<span style="color: red;">*</span></label>

                                        <select class="form-control" id="correct_option" name="correct_option[]" required <?php if ($question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) { echo "multiple"; }?>>

                                            <?php for ($i = 1; $i <= $number_of_option; $i++) { ?>

                                                <option value="option_<?php echo $i; ?>">Option <?php echo $i; ?></option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                </div>

                            <?php } ?>



                            <?php if ($question_type == QuestionBank::LONG_ANSWER || $question_type == QuestionBank::SHORT_ANSWER) { ?>

                                <div class="form-group">

                                    <div class="col-md-6">

                                        <label for="correct_option" class="col-form-label">Correct Answer :<span style="color: red;">*</span></label>

                                        <input class="form-control" id="correct_option" name="correct_option[]" required>

                                    </div>

                                </div>

                            <?php } ?>



                            <div class="form-group">

                                <div class="col-md-6">

                                    <label for="answer_explanation" class="col-form-label">Answer Explanation:</label>

                                    <textarea class="form-control" id="answer_explanation" name="answer_explanation" maxlength="2000"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <div class="col-md-6">

                                <button type="submit" class="btn btn-primary pull-right">Submit</button>

                                <a href="<?php echo base_url();?>pre-add-question" class="btn btn-danger pull-right mr-2">Back</a>

                            </div>

                            <div class="col-md-6"></div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>



</main>

<!-- add question modals -->



<!--edit question modals -->

<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Update Question</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>



            <div id="loader-area-section">

                <center>

                    <div class="m-loader mr-4">

                        <br/>

                        <svg class="m-circular" viewBox="25 25 50 50">

                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>

                        </svg>

                    </div>

                    Loading...

                </center>

            </div>

            <div id="updateq-form-section" style="display: none;">

                <form action="<?php echo base_url(); ?>update-question/" method="POST" name="edit-question-form">

                    <div class="modal-body">

                        <div class="form-group">

                            <label for="equestion-text" class="col-form-label">Question :<span style="color: red;">*</span></label>

                            <textarea class="form-control" id="equestion-text" name="equestion_text" required="" maxlength="255"></textarea>

                        </div>

                        <div class="form-group">

                            <label for="eoption-1" class="col-form-label">Option 1 :<span style="color: red;">*</span></label>

                            <input type="text" class="form-control" id="eoption-1" name="eoption_1" maxlength="200" required="">

                        </div>

                        <div class="form-group">

                            <label for="eoption-2" class="col-form-label">Option 2 :<span style="color: red;">*</span></label>

                            <input type="text" class="form-control" id="eoption-2" name="eoption_2" maxlength="200" required="">

                        </div>

                        <div class="form-group">

                            <label for="eoption-3" class="col-form-label">Option 3 :<span style="color: red;">*</span></label>

                            <input type="text" class="form-control" id="eoption-3" name="eoption_3" maxlength="200" required="">

                        </div>

                        <div class="form-group">

                            <label for="eoption-4" class="col-form-label">Option 4 :<span style="color: red;">*</span></label>

                            <input type="text" class="form-control" id="eoption-4" name="eoption_4" maxlength="200" required="">

                        </div>

                        <div class="form-group">

                            <label for="eanswer-option" class="col-form-label">Correct Option :<span style="color: red;">*</span></label>

                            <select class="form-control" id="eanswer-option" name="eanswer_option" required>

                                <option value="">Select Answer Option</option>

                                <option value="option_1">Option 1</option>

                                <option value="option_2">Option 2</option>

                                <option value="option_3">Option 3</option>

                                <option value="option_4">Option 4</option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="equestion-explanation" class="col-form-label">Answer Explanation :<span style="color: red;">*</span></label>

                            <textarea class="form-control" id="equestion-explanation" name="equestion_explanation" required="" maxlength="2000"></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                    </div>

                    <input type="hidden" id="quiz-id-for-question" name="quiz_id_for_question" value="<?php echo $req_quiz_id; ?>">

                    <input type="hidden" id="req-edit-id" name="req_edit_id" value="">

                </form>

            </div>

        </div>

    </div>

</div>
<!-- Upload question modal -->
<div class="modal" tabindex="-1" role="dialog" id="uploadQuestion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>upload-question" name="upload-question" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="category" class="col-form-label">Select Category<span
                                        style="color: red;">*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category->id; ?>"> <?php echo $category->category_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="level" class="col-form-label">Select Level<span
                                        style="color: red;">*</span></label>
                            <select class="form-control" name="level" id="level" required>
                                <?php foreach ($levels as $level) { ?>
                                    <option value="<?php echo $level->id; ?>"> <?php echo $level->level_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="question_file" class="col-form-label">Select File<span
                                        style="color: red;">*</span></label>
                            <input type="file" name="question_file" class="form-control" id="question_file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload Question</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Upload question modal -->
<!-- modal code end -->

<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/select2.min.js"></script>

<script type="text/javascript">

    <?php

        if ($question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) {

            echo "$('#correct_option').select2();";

        }

        if($this->session->flashdata('msg')) {

            echo 'showNotification("'. $this->session->flashdata('msg') .'");';

        }

    ?>

</script>

</body>

</html>