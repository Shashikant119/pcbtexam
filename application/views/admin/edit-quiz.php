<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-server"></i> Quiz Management</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Quiz Management</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url();?>edit-quiz" name="quiz-form" method="POST" enctype="multipart/form-data">
                <div class="tile">
                    <input type="hidden" name="quiz_id" value="<?php echo @$quiz->quiz_id; ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="quiz_name">Quiz Name: <span style="color: red">*</span></label>
                                <input class="form-control" id="quiz_name" type="text" name="quiz_name"
                                       placeholder="Quiz Name" required="" maxlength="255"
                                       value="<?php echo $quiz->quiz_title; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="duration">Duration (In Minutes) : <span style="color: red">*</span></label>
                                <input class="form-control" id="duration" type="number" placeholder="Duration"
                                       name="duration" required="" value="<?php echo $quiz->duration; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="start_time">Start Time (Question can be attempted after this time) : <span style="color: red">*</span></label>
                                <input class="form-control" id="start_time" type="text"
                                       placeholder="Start Time" name="start_time" required=""
                                       value="<?php echo $quiz->start_time; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="end_time">End Time (Question can be attempted before this time) : <span style="color: red">*</span></label>
                                <input class="form-control" id="end_time" type="text" placeholder="End Time"
                                       name="end_time" required="" value="<?php echo $quiz->end_time; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="max_attempts">Allow Maximum Attempts : <span
                                        style="color: red">*</span></label>
                                <input class="form-control" id="max_attempts" type="number"
                                       placeholder="Maximum Attempts" name="max_attempts" required=""
                                       value="<?php echo $quiz->max_attempts_allowed; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="min_pass_percentage">Minimum Percentage Required to Pass : <span
                                        style="color: red">*</span></label>
                                <input class="form-control" id="min_pass_percentage" type="number"
                                       placeholder="Minimum Percentage Required to Pass" name="min_pass_percentage"
                                       required="" value="<?php echo $quiz->min_pass_percentage; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="marks_per_question">Correct Score : <span
                                        style="color: red">*</span></label>
                                <input class="form-control" id="marks_per_question" type="number"
                                       placeholder="Correct Score" name="marks_per_question" required=""
                                       value="<?php echo $quiz->marks_per_question; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="negative_marks_per_question">Incorrect Score : <span style="color: red">*</span></label>
                                <select class="form-control" id="negative_marks_per_question"
                                        placeholder="Incorrect Score" name="negative_marks_per_question" required="">
                                    <option value="0" <?php if ($quiz->negative_marks_per_question == 0) { echo "selected"; } ?>>0</option>
                                    <option value="1/4" <?php if ($quiz->negative_marks_per_question == '1/4') { echo "selected"; } ?>>1/4</option>
                                    <option value="1/3" <?php if ($quiz->negative_marks_per_question == '1/3') { echo "selected"; } ?>>1/3</option>
                                    <option value="1/2" <?php if ($quiz->negative_marks_per_question == '1/2') { echo "selected"; } ?>>1/2</option>
                                    <option value="1" <?php if ($quiz->negative_marks_per_question == '1') { echo "selected"; } ?>>1</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Question Explanation: <span style="color: red">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="question_explanation" value="1" <?php if ($quiz->question_explanation == 1) { echo "checked"; } ?>>Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="question_explanation" value="0" <?php if ($quiz->question_explanation == 0) { echo "checked"; } ?>>No
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Common Merit Link: <span style="color: red">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="common_merit_link" value="1" <?php if ($quiz->common_merit_link == 1) { echo "checked"; } ?>>Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="common_merit_link" value="0" <?php if ($quiz->common_merit_link == 0) { echo "checked"; } ?>>No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">PDF Paper Link: <span style="color: red">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="pdf_paper_link" value="1" <?php if ($quiz->pdf_paper_link == 1) { echo "checked"; } ?>>Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="pdf_paper_link" value="0" <?php if ($quiz->pdf_paper_link == 0) { echo "checked"; } ?>>No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">CBT Practice Link: <span style="color: red">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cbt_practice_link" value="1" <?php if ($quiz->cbt_practice_link == 1) { echo "checked"; } ?>>Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cbt_practice_link" value="0" <?php if ($quiz->cbt_practice_link == 0) { echo "checked"; } ?>>No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label"> Answer Response Sheet <span style="color: red">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
             <input class="form-check-input" type="radio" name="show_answersheet" value="1" <?php echo ($quiz->show_answersheet)?'checked':'';?>>Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
  <input class="form-check-input" type="radio" name="show_answersheet" <?php echo (!$quiz->show_answersheet)?'checked':'';?> value="0">No
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label for="package_image" class="col-form-label">Quiz Image :<span style="color: red;">*</span></label>
                            <input type="file" class="form-control" id="quiz_image" name="package_image">

                        </div>
                    </div>
                     <div class="col-lg-6">
                            <div class="form-group">
                                <label for="quiz-packages">Choose Packages : <span style="color: red">*</span></label>
                                <div class="checkbox">
                                    <?php $prev_pack = array();
                                    $prev_pack = @$quiz->quiz_packages;
                                    $prev_pack = @explode(',', $prev_pack);
                                    foreach ($packages as $package) {
                                        echo '<label><input type="checkbox" name="quiz_packages[]" value="' . $package->package_id . '"';
                                        if (in_array($package->package_id, $prev_pack)) {
                                            echo 'checked=""';
                                        }
                                        echo '> ' . $package->package_name . '</label><br/>';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-danger" href="<?php echo base_url() ?>quiz-management/">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</main>
<?php $this->load->view('admin/footer'); ?>
<script type="text/javascript">
    /*$(document).ready(function () {
        $('#start_time').datepicker({
            format: "yyyy-mm-dd H:i:s",
            autoclose: true,
            todayHighlight: true
        });

        $('#end_time').datepicker({
            format: "yyyy-mm-dd H:i:s",
            autoclose: true,
            todayHighlight: true
        });
    });*/
</script>
</body>
</html>