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
            <form action="" name="quiz-form" method="POST">
                <div class="tile">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="quiz-name">Quiz Name : <span style="color: red">*</span></label>
                                <input class="form-control" id="quiz-name" type="text" name="quiz_name"
                                       placeholder="Quiz Name" required="" maxlength="255"
                                       value="<?php echo @$edit_data->quiz_title; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="no_of_question">No Of Question : <span style="color: red">*</span></label>
                                <input class="form-control" id="no_of_question" type="number"
                                       placeholder="No Of Question" name="no_of_question" required=""
                                       value="<?php echo @$edit_data->no_of_question; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="duration">Duration (In Minutes) : <span style="color: red">*</span></label>
                                <input class="form-control" id="duration" type="number" placeholder="Duration"
                                       name="duration" required="" value="<?php echo @$edit_data->duration; ?>">
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
                                       value="<?php echo @$edit_data->max_attempts; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="min_pas_percentage">Minimum Percentage Required to Pass : <span
                                            style="color: red">*</span></label>
                                <input class="form-control" id="min_pas_percentage" type="number"
                                       placeholder="Minimum Percentage Required to Pass" name="min_pas_percentage"
                                       required="" value="<?php echo @$edit_data->min_pas_percentage; ?>">
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
                                       value="<?php echo @$edit_data->marks_per_question; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="neg_marks_per_question">InCorrect Score : <span style="color: red">*</span></label>
                                <input class="form-control" id="neg_marks_per_question" type="number"
                                       placeholder="InCorrect Score" name="neg_marks_per_question" required=""
                                       value="<?php echo @$edit_data->neg_marks_per_question; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="quiz-packages">Choose Packages : <span style="color: red">*</span></label>
                                <div class="checkbox">
                                    <?php $prev_pack = array();
                                    $prev_pack = @$edit_data->quiz_packages;
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
                    <input type="hidden" name="req_id" value="<?php echo @$edit_data->quiz_id; ?>">
                </div>
            </form>
        </div>
    </div>

</main>
<?php $this->load->view('admin/footer'); ?>
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>
</body>
</html>