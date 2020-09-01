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
            <div class="tile">
                <div class="tile-body">

                    <form class="row" name="search-quiz" action="" method="GET">
                        <div class="form-group col-md-10"></div>
                        <!--
            <div class="form-group col-md-2">
              <select class="form-control" name="by_status">
                  <option value="">Select Status</option>
                  <option value="o" <?php if (@$_GET['by_status'] == 'o') {
                            echo 'selected="selected"';
                        } ?>>Open</option>
                  <option value="c" <?php if (@$_GET['by_status'] == 'c') {
                            echo 'selected="selected"';
                        } ?>>Closed</option>
              </select>
            </div>
            
            From :
            <div class="form-group col-md-2">
              <input class="form-control" type="date" name="from_date" <?php if (!empty(@$_GET['from_date'])) {
                            echo 'value="' . $_GET['from_date'] . '"';
                        } ?>>
            </div>
            
            To :
            <div class="form-group col-md-2">
              <input class="form-control" type="date" name="to_date" <?php if (!empty(@$_GET['to_date'])) {
                            echo 'value="' . $_GET['to_date'] . '"';
                        } ?>>
            </div>
            
            <div class="form-group col-md-3 align-self-end">
              <button class="btn btn-primary" type="submit">Get</button>
              <a class="btn btn-danger" href="<?php echo base_url() ?>quiz-management">Reset</a>
            </div>
            -->
                        <div class="form-group col-md-2">
                            <a class="btn btn-success pull-right" href="<?php echo base_url() ?>add-quiz/">Add New
                                Quiz</a>
                        </div>
                    </form>
                    <hr/>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Sr. No.</th>
                             <th>Image</th>
                            <th>Quiz Name</th>
                            <th>No. Of Questions</th>
                            <th>Duration (In Min)</th>
                            <th>Allow Max Attempt</th>
                            <th>Correct Score</th>
                            <th>Negative Score</th>
                            <th>Min % To Pass</th>
                            <!--<th>Packages</th>-->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($quizes) > 0) {
                            $sr_no = 1;
                            foreach ($quizes as $quiz) {
                                ?>
                                <tr>
                                    <td><?php echo $sr_no; ?></td>
                                    <td><img src="<?php echo base_url('/assets/images/quiz/'). $quiz->image; ?>" height="55" width="70"></td>
                                    <td><?php echo $quiz->quiz_title; ?></td>
                                    <td><?php echo $quiz->number_of_questions; ?></td>
                                    <td><?php echo $quiz->duration; ?></td>
                                    <td><?php echo $quiz->max_attempts_allowed; ?></td>
                                    <td align="center"><?php echo $quiz->marks_per_question; ?></td>
                                    <td align="center"><?php echo $quiz->negative_marks_per_question; ?></td>
                                    <td align="center"><?php echo $quiz->min_pass_percentage; ?></td>
                                    <!--<td align="center"><?php /*echo str_replace(',', '<br/>', $quiz->packages); */?></td>-->
                                    <td>
                                        <a href="<?php echo base_url() . 'edit-quiz/' . $quiz->quiz_id; ?>"
                                           class="badge badge-primary">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                        </a>

                                        <a href="<?php echo base_url() . 'delete-quiz/' . $quiz->quiz_id; ?>"
                                           class="badge badge-danger"
                                           onclick="return confirm('Do you want to delete this quiz ?');">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </a>

                                        <a href="<?php echo base_url() . 'manage-quiz/' . $quiz->quiz_id; ?>"
                                           class="badge badge-warning">
                                            <i class="fa fa-question-circle" aria-hidden="true"></i>Manage Quiz
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $sr_no++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</main>
<!-- upload question modals -->
<div class="modal fade" id="uploadQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="upload_question_form" id="upload_question_form" method="POST" action=""
                  enctype="multipart/form-data">
                <div class="modal-body" id="question-div-body">
                    <center>
                        <div id="res-msg"></div>
                    </center>
                     <div class="form-group">
                            <label for="package_image" class="col-form-label">Quiz Image :<span style="color: red;">*</span></label>
                            <input type="file" class="form-control" id="quiz_image" name="package_image">

                        </div>
                    <div class="form-group">
                        <label for="question-file" class="col-form-label">Upload File :<span
                                    style="color: red;">*</span></label>
                        <input type="file" class="form-control" id="question-file" name="question_file" required=""
                               accept=".xls, .xlsx">
                        <p>
                            <small><strong>Allowed File Extension : .xls, .xlsx<strong></small>
                        </p>
                        <p><a href="<?php echo base_url() ?>assets/sample-excel.xlsx">Click to download sample excel
                                file.</a></a></p>
                    </div>
                </div>
                <div id="loader-body" style="display: none;">
                    <center>
                        <img src="<?php echo base_url() ?>assets/images/loader.gif">
                        <br/>Please wait while we uploading your questions!
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="uploadQuestion();" id="btn-qupload">Upload
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-cmodal">Cancel</button>
                </div>
                <input type="hidden" name="quiz_id_for_question" id="quiz_id_for_question">
            </form>
        </div>
    </div>
</div>
<!-- upload modal -->
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
    $('#sampleTable').DataTable({"aaSorting": []});

    function uploadQuestion() {
        let fileData = $("#question-file").val();
        if (fileData != '' && fileData != null) {
            var ext = $('#question-file').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
                alert('Invalid file extension.');
                $('#question-file').val('');
            } else {
                var form = $("#upload_question_form");
                var formData = new FormData(form[0]);
                $.ajax({
                    url: '<?php echo base_url() . "Quiz/upload_draw_question"; ?>',
                    crossDomain: true,
                    async: false,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $("#question-div-body").hide();
                        $("#loader-body").show();
                    },
                    success: function (data) {
                        $("#res-msg").html(data);

                        $("#question-div-body").show();
                        $("#loader-body").hide();

                        location.reload();
                    },
                    complete: function () {
                        $("#question-div-body").show();
                        $("#loader-body").hide();
                    }
                });
            }
        } else {
            alert("Please choose excel file to upload.");
        }
    }

    function setQuizId(element) {
        let quizId = $(element).attr('data-quiz');
        $("#quiz_id_for_question").val(quizId);
    }

    <?php
    if ($this->session->flashdata('msg')) {
        echo 'showNotification("' . $this->session->flashdata('msg') . '");';
    }
    ?>
</script>
</body>
</html>