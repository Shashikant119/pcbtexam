<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-server"></i>Quiz Management</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Quiz Management</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="" name="quiz-form" method="POST">
                <div class="tile">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="quiz_name">Quiz Name : <span style="color: red">*</span></label>
                                <input class="form-control" id="quiz_name" type="text" name="quiz_name"
                                       placeholder="Quiz Name" required="" maxlength="255"
                                       value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="duration">Duration (In Minutes) : <span style="color: red">*</span></label>
                                <input class="form-control" id="duration" type="number" placeholder="Duration"
                                       name="duration" required="" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="start_time">Start Time (Question can be attempted after this time) : <span style="color: red">*</span></label>
                                <input class="form-control" id="start_time" type="text"
                                       placeholder="Start Time" name="start_time" required=""
                                       value="<?php echo date('Y-m-d H:i:s'); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="end_time">End Time (Question can be attempted before this time) : <span style="color: red">*</span></label>
                                <input class="form-control" id="end_time" type="text" placeholder="End Time"
                                       name="end_time" required="" value="<?php echo date('Y-m-d H:i:s'); ?>">
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
                                       value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="min_pass_percentage">Minimum Percentage Required to Pass : <span
                                        style="color: red">*</span></label>
                                <input class="form-control" id="min_pass_percentage" type="number"
                                       placeholder="Minimum Percentage Required to Pass" name="min_pass_percentage"
                                       required="" value="">
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
                                       value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="negative_marks_per_question">Incorrect Score : <span style="color: red">*</span></label>
                                <select class="form-control" id="negative_marks_per_question"
                                        placeholder="Incorrect Score" name="negative_marks_per_question" required="">
                                    <option value="0">0</option>
                                    <option value="1/4">1/4</option>
                                    <option value="1/3">1/3</option>
                                    <option value="1/2">1/2</option>
                                    <option value="1">1</option>
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
                                        <input class="form-check-input" type="radio" name="question_explanation" value="1">Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="question_explanation" value="0" checked>No
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Common Merit Link: <span style="color: red">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="common_merit_link" value="1">Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="common_merit_link" checked value="0">No
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
                                        <input class="form-check-input" type="radio" name="pdf_paper_link" value="1">Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="pdf_paper_link" checked value="0">No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">CBT Practice Link: <span style="color: red">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cbt_practice_link" value="1">Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cbt_practice_link" checked value="0">No
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
                                        <input class="form-check-input" type="radio" name="show_answersheet" value="1">Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="show_answersheet" checked value="0">No
                                    </label>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label for="package_image" class="col-form-label">Quiz Image :<span style="color: red;">*</span></label>
                            <input type="file" class="form-control" id="quiz_image" name="package_image">

                        </div>
                    </div><br>
                      <div class="col-lg-6">
                            <div class="form-group">
                                <label for="quiz-packages">Choose Packages : <span style="color: red">*</span></label>
                                <div class="checkbox">
                                    <?php
                                    foreach ($packages as $package) {
                                        echo '<label><input type="checkbox" name="quiz_packages[]" value="' . $package->package_id . '"';
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
                    <input type="hidden" name="req_id" value="<?php echo @$edit_data->quiz_id; ?>">
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