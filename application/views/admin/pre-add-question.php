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

                            <label><strong>Add New Question</strong></label>

                        </div>

                        <div class="col-lg-6">

                            <a class="btn btn-success pull-right mr-2" data-toggle="modal" data-target="#uploadQuestion" href="javascript:void(0)">Upload Question</a>

                        </div>

                    </div>

                    <div class="modal-header">



                    </div>

                    <!-- Add New Question Form -->

                    <form action="<?php echo base_url(); ?>add-question" method="POST" name="pre-question-form">

                        <div class="modal-body">

                            <div class="form-group">

                                <div class="col-md-6">

                                    <label for="question_type" class="col-form-label">Select Question Type<span style="color: red;">*</span></label>

                                    <select class="form-control" name="question_type" id="question_type" required onchange="toggleOptions(this.value)">

                                        <?php foreach (QuestionBank::QUESTION_TYPE as $key => $value) { ?>

                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>

                                        <?php } ?>

                                    </select>

                                    <?php echo form_error("question_type"); ?>

                                </div>

                            </div>



                            <div class="form-group" id="number_of_option_row">

                                <div class="col-md-6">

                                    <label for="number_of_option" class="col-form-label">Number of Option<span style="color: red;">*</span></label>

                                    <input type="number" class="form-control" id="number_of_option" name="number_of_option" value="<?php echo set_value('number_of_option', 4); ?>" required>

                                    <?php echo form_error("number_of_option"); ?>

                                </div>

                            </div>

                        <div class="modal-footer">

                            <div class="col-md-6">

                                <button type="submit" class="btn btn-primary pull-right">Next</button>

                                <button type="button" class="btn btn-danger pull-right mr-2">Cancel</button>

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



<?php $this->load->view('admin/footer'); ?>



<script type="text/javascript">

    <?php

    if($this->session->flashdata('msg')) {

        echo 'showNotification("'. $this->session->flashdata('msg') .'");';

    }

    ?>



    function toggleOptions(q_type) {

        if (q_type == <?php echo QuestionBank::LONG_ANSWER; ?> || q_type == <?php echo QuestionBank::SHORT_ANSWER; ?>) {

            $("#number_of_option_row").hide();

        } else {

            $("#number_of_option_row").show();

        }

    }

</script>

</body>

</html>