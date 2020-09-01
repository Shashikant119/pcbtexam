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
                <input type="hidden" name="quiz_id" value="<?php echo @$quiz->quiz_id; ?>">
                <table class="table table-bordered">
                    <tr>
                        <th>Quiz Name</th>
                        <td><?php echo $quiz->quiz_title; ?></td>
                    </tr>
                    <tr>
                        <th>Start Time</th>
                        <td><?php echo $quiz->start_time; ?></td>
                    </tr>
                    <tr>
                        <th>End Time</th>
                        <td><?php echo $quiz->end_time; ?></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><?php echo $quiz->duration; ?> Minutes</td>
                    </tr>
                    <tr>
                        <th>Max Attempts Allowed</th>
                        <td><?php echo $quiz->max_attempts_allowed; ?></td>
                    </tr>
                    <tr>
                        <th>Min Percentage Required to Pass</th>
                        <td><?php echo $quiz->min_pass_percentage; ?></td>
                    </tr>
                    <tr>
                        <th>Correct Score</th>
                        <td><?php echo $quiz->marks_per_question; ?></td>
                    </tr>
                    <tr>
                        <th>Negative Marks</th>
                        <td><?php echo $quiz->negative_marks_per_question; ?></td>
                    </tr>
                    <tr>
                        <th>Max Attempts Allowed</th>
                        <td><?php echo $quiz->max_attempts_allowed; ?></td>
                    </tr>
                    <tr>
                        <th>Question Explanation</th>
                        <td><?php echo $quiz->question_explanation ? 'YES' : 'NO' ; ?></td>
                    </tr>
                    <tr>
                        <th>Common Merit Link</th>
                        <td><?php echo $quiz->common_merit_link ? 'YES' : 'NO' ; ?></td>
                    </tr>
                    <tr>
                        <th>PDF Paper Link</th>
                        <td><?php echo $quiz->pdf_paper_link ? 'YES' : 'NO' ; ?></td>
                    </tr>
                    <tr>
                        <th>CBT Practice Link</th>
                        <td><?php echo $quiz->cbt_practice_link ? 'YES' : 'NO' ; ?></td>
                    </tr>
                </table>

                <div class="tile-footer">
                    <!--<button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-danger" href="<?php /*echo base_url() */ ?>quiz-management/">Cancel</a>-->
                </div>

                <div class="title">
                    <div class="tile-title">
                        <div class="row">
                            <div class="col-md-6">Questions Added To This Quiz</div>
                            <div class="col-md-6">
                                <a href="<?php echo base_url();?>quiz/add-question/<?php echo $quiz->quiz_id; ?>" class="btn btn-primary pull-right">Add Questions</a>
                                <a class="btn btn-danger pull-right mr-1" href="<?php echo base_url()  ?>quiz-management/">Back To Quiz</a>
                            </div>
                        </div>
                    </div>

                    <div class="title-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Question Type</th>
                                <th>Category Name</th>
                                <th>Level Name</th>
                                <th>Action</th>
                            </tr>

                            <?php foreach ($added_questions as $question) { ?>
                                <tr id="question-<?php echo $question->question_id; ?>">
                                    <td><?php echo $question->question_id; ?></td>
                                    <td><?php echo $question->question; ?></td>
                                    <td><?php echo QuestionBank::QUESTION_TYPE[$question->question_type]; ?></td>
                                    <td><?php echo $question->category_name; ?></td>
                                    <td><?php echo $question->level_name; ?></td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="removeQuizQuestion('<?php echo $question->question_id;?>', '<?php echo $quiz->quiz_id; ?>')">Remove</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('admin/footer'); ?>
<script type="text/javascript">
    <?php
        if($this->session->flashdata('msg')) {
            echo 'showNotification("'. $this->session->flashdata('msg') .'");';
        }
    ?>
    function removeQuizQuestion(question, quiz) {
        $.ajax({
            url: '<?php echo base_url(); ?>quiz/remove-quiz-question',
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                "question_id": question,
                "quiz_id": quiz
            },
            success: function(data) {
                $("#question-"+question).remove();
                window.location.reload();
            },
        });
    }
</script>
</body>
</html>