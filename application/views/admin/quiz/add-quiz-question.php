<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-question-circle"></i> Add Questions to Quiz</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Add Questions to Quiz</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="label-text"><strong>Quiz Name: </strong><?php echo $quiz->quiz_title?></label>
                        </div>
                        <div class="col-lg-6">
                            <a class="btn btn-success pull-right" href="<?php echo base_url(); ?>manage-quiz/<?php echo $quiz->quiz_id?>">Back To Quiz</a>
                            <!--<a class="btn btn-success pull-right mr-2" data-toggle="modal"
                               data-target="#uploadQuestionModal" href="javascript:void(0)">Upload Question</a>-->
                        </div>
                    </div>
                    <br/>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Question Type</th>
                            <th>Category Name / Level Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($questions) > 0) {
                            foreach ($questions as $question) {
                                ?>
                                <tr>
                                    <td><?php echo $question->question_id; ?></td>
                                    <td><?php echo $question->question; ?></td>
                                    <td><?php echo QuestionBank::QUESTION_TYPE[$question->question_type]; ?></td>
                                    <td><?php if (!empty($question->category_name) && !empty($question->level_name)) {
                                            echo $question->category_name . " / " . $question->level_name;
                                        } else {
                                            echo "---";
                                        } ?></td>
                                    <td>
                                        <a id="btn-<?php echo $question->question_id;?>" href="javascript:void(0)" <?php if (!in_array($question->question_id, $added_question_ids)) {?> onclick="addQuestionToQuiz('<?php echo $question->question_id; ?>', '<?php echo $quiz->quiz_id; ?>')" <?php }  ?> class="btn btn-primary"><?php if (!in_array($question->question_id, $added_question_ids)) { echo "Add"; } else {echo "Added"; } ?></a>
                                        <!--<a href="<?php /*echo base_url() . 'delete-question/' . $question->question_id */?>"
                                           class="badge badge-danger"
                                           onclick="return confirm('Do you want to delete this question ?');">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </a>-->
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
    </div>

</main>
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
    $('#sampleTable').DataTable({"aaSorting": []});
    <?php
    if ($this->session->flashdata('msg')) {
        echo 'showNotification("' . $this->session->flashdata('msg') . '");';
    }
    ?>
    function addQuestionToQuiz(question_id, quiz_id) {
        $("#btn-"+question_id).attr("disabled", true);
        $.ajax({
            url: '<?php echo base_url(); ?>quiz/add-question',
            type: 'POST',
            data: {"question_id": question_id, "quiz_id": quiz_id},
            dataType:'json',
            cache: false,
            success: function (data) {
                if (data.success) {
                    // showNotification(data.message, "success");
                    $("#btn-"+question_id).text("Added");
                } else {
                    showNotification(data.message, "error")
                }
            }
            /*complete: function () {
                $("#loader-area-section").hide();
                $("#updateq-form-section").show();
            }*/
        });
    }
</script>
</body>
</html>