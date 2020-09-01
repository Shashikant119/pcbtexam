<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Robots Please remove during Live-->
    <meta name="robots" content="nofollow, noindex">
    <!--Favicon-->
    <link rel="icon" href="<?php echo base_url();?>/assets/web/ques/img/fav.png">
    <link rel="apple-touch-icon-precomposed" href="img/logo.png">
    <!--Fonts/Icons CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700|Questrial&display=swap" rel="stylesheet">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!--Main and Responsive CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/ques/sass/main.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/ques/css/responsive.css">
    <title>PCBT</title>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <style>
        .table-bordered td, .table-bordered th {
            border: 1px solid #8e8e8e !important;
        }
        .equal-width tr th,.equal-width tr td{
            width:50%!important;
        }
    </style>
</head>

<body>
<div class="nav__big d-flex  border-nav">
    <div class="nav__big-left">
        <div class="nav__two d-flex p-3 q-font align-items-center justify-content-end" style="background-color: #4e85c5 ;padding:10px;">
            <div class="nav__left d-flex align-items-center mr-auto">
                <h2 style="color:#fff;">Instructions</h2>
            </div>
            <div class="nav__left d-flex ">
                <!--<span class="mr-3" style="color:#fff;">View in:</span>
                     <select class="choose_lang auditlogSelect" onchange="changeLang(this.value)">
                     <option selected="selected" value="1">English</option><option value="2">Hindi</option>
                     <option value="3">Marathi</option><option value="4">Tamil</option><option value="5">Punjabi</option>
                     <option value="6">Bengali</option><option value="8">Telugu</option><option value="9">Malayalam</option>
                     <option value="10">Assamese</option><option value="11">Gujrati</option><option value="13">Urdu</option>
                     <option value="17">kannada</option><option value="19">Odia</option><option value="22">Manipuri</option>
                     <option value="24">Konkani</option>
                </select>-->
            </div>
        </div>

        <div class="container-fluid">
            <div class="p-3">
                <div class="position-relative">
                    <?php if( $this->session->flashdata('msg'))echo  $this->session->flashdata('msg');?>
                    <div class="text-center mb-3">
                        <h3> Please read the instructions carefully</strong></h3>
                    </div>
                    <?php if (!$user) {
                        echo '<font color="red"> Sorry No Packages Found! </font>';
                    } ?>

                    <?php
                    if (!$quiz) {
                        echo '<span class="text-danger"> Sorry Packages has not any quiz for you </span>';
                    }
                    else {
                        ?>
                        <table class="table table-hover table-bordered equal-width">
                            <tbody>
                            <tr>
                                <th aria-label="Quiz Name: activate to sort column ascending">Quiz Name</th>
                                <td><?php echo $quiz->quiz_title;?></td>
                            </tr>
                            <tr>
                                <th aria-label="Duration (In Min): activate to sort column ascending">Duration (In Min)</th>
                                <td><?php echo $quiz->duration;?></td>
                            </tr>
                            <tr>
                                <th aria-label="Allow Max Attempt: activate to sort column ascending">Max Attempts Allowed</th>
                                <td><?php echo $quiz->max_attempts_allowed;?></td>
                            </tr>
                            <tr>
                                <th aria-label="Allow Max Attempt: activate to sort column ascending">No Of Attempts Left</th>
                                <td><?php echo $attempts_left; ?></td>
                            </tr>
                           <!-- <tr>
                                <th aria-label="Correct Score: activate to sort column ascending">Correct Score</th>
                                <td><?php echo $quiz->number_of_questions;?></td>
                            </tr>-->
                           
                            <tr>
                                <th aria-label="Allow Max Attempt: activate to sort column ascending">Marks Per Question</th>
                                <td><?php echo $quiz->marks_per_question;?></td>
                            </tr>
                           <tr>
                                <th aria-label="Negative Score: activate to sort column ascending">Negative Score</th>
                                <td><?php echo $quiz->negative_marks_per_question;?></td>
                            </tr>
                            <tr role="row" class="odd">
                                <th aria-label="Min % To Pass: activate to sort column ascending">Min % To Pass</th>
                                <td><?php echo $quiz->min_pass_percentage;?></td>
                            </tr>
                            </tbody>
                        </table>

                        <?php
                    }
                    ?>

                    <h3 class="text-center mt-5 mb-1"><strong>General Instructions About Attempting CBT Test </strong></h3>

                    <h4 class="mt-2">A. Color Coding of Questions-</h4>
                    <table class="table table-bordered table-hover instruction_area">
                        <tbody>
                        <tr>
                            <td style="text-align: center;width: 61px;"><span title="Not Visited" class="not_visited">1</span></td>
                            <td>You have not visited the question yet.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;width: 61px;"><span title="Not Answered" class="not_answered">2</span></td>
                            <td>You have not answered the question.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;width: 61px;"><span title="Answered" class="answered">3</span></td>
                            <td>You have answered the question.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;width: 61px;"><span title="Marked for Review" class="review">4</span></td>
                            <td>You have NOT answered the question, but have marked the question for review.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;width: 61px;"><span title="Answered &amp; Marked for Review" class="review_marked_considered">5</span></td>
                            <td>The question(s) "Answered and Marked for Review" will be considered for evaluation.</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4>B. Answering a Question-</h4>

                    <ol>
                        <li>To select your answer, click on the button of one of the options</li>
                        <li>To deselect your chosen answer, click on the Clear Response button</li>
                        <li>To change your chosen answer, click on the option of your choice</li>
                        <li><strong>To save your answer, you MUST click on the Save & Next button.</strong></li>
                        <li><strong style="text-decoration: underline">Mark for Review Questions can be finalized/saved by clicking on Save & Next button</strong></li>
                        <li>In case of doubt on the option marked for a question, the question can be marked for review by clicking Mark for Review & Next button. In case the marked question is not reviewed, the originally marked option shall be considered for evaluation.</li>
                        
                        <li>To visit Old Questions, first click on that question number from the question number box.</li>
                    </ol>
                    <!--<ol>
                        <li>The questions will appear on the screen in serial order from question number 1 to 100, which can be answered one by one as given below:<br> <br> a. To select your answer, click on the button of one of the options<br> b. To deselect
                            your chosen answer, click on the button of the chosen option again or click on the Clear Response button<br> c. To change your chosen answer, click on the button of option you want to choose.<br> <strong>d. <u>To save your answer, you MUST click on the Save &amp; Next button</u></strong><u>.</u><br>                            e. In case of doubt on the option marked for a question, the question can be marked for review by clicking <strong>Mark for Review &amp; Next </strong><strong>button</strong><strong>. </strong>In case the marked option is not
                            reviewed, the originally marked option shall be considered for evaluation.</li>
                        <li>To change your answer to a question that has already been answered, first click on that question number from the question number box and follow the procedure for answering as mentioned at 1 above.</li>
                    </ol>-->
                    <!--<h4>D Instruction for enlarging images</h4>
                    <p> To view the image provided in the question in a bigger size, click on the image and rotate the scrolling wheel on the mouse</p>-->
                    <h4>C. Declaration by User- </h4>
                    <div class="p-3">
                        <i style="color:red;" class="d-block mb-2">Please note all questions will appear in your default language. This language can be changed for a particular question later on.</i>
                        <form action="<?php echo base_url('index.php/online-test');?>" method="post">
                            <div class="form-group form-check">
                                <label style="margin-left: 7px" class="form-check-label" for="read_ins"><input style="margin-top: 5px" type="checkbox" class="form-check-input" name="instructions" value="agree" id="read_ins">
                                <input type="hidden" name="user" value="<?php echo $this->session->userdata('user_id') ;?>">
                                 I have read and understood the instructions. All computer hardware allotted to me are in proper working condition. I declare that I am not in possession of / not wearing / not carrying any prohibited gadget like mobile phone, bluetooth devices etc. /any prohibited material with me into the Examination Hall.I agree that in case of not adhering to the instructions, I shall be liable to be debarred from this Test and/or to disciplinary action, which may include ban from future Tests / Examinations</label>
                            </div>
                            <div class="nav__two d-flex align-items-center pt-3" style="margin-bottom:50px;">
                                <div class="nav__right d-flex ml-auto pull-right">
                                    <a href="javascript:window.history.back();" class="btn btn-default border-dark mr-2 ">Back</a>
                                    <input type="submit"  name="submit" id="jump_to_test" value="Proceed" disabled="disabled"   class="btn btn-primary ">
                                </div>
                            </div><br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $('#read_ins').click(function () {
        if ($(this).is(':checked')) {
            $('#jump_to_test').removeAttr('disabled'); //enable button
        } else {
            $('#jump_to_test').attr('disabled', true); //disable button
        }
    });

</script>

<script src="<?php echo base_url();?>/assets/web/ques/js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url();?>/assets/web/ques/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>/assets/web/ques/js/main.js"></script>
</body>

</html>