<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRATAP'S CBT QUIZ PORTAL</title>
    <!--Favicon-->
    <link rel="icon" href="<?php echo base_url();?>/assets/web/images/fav.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>/assets/web/images/fav.png">
    <!--Fonts/Icons CSS-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/bootstrap.min.css">
    <!--Owl slider CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/owl.carousel.min.css">
    <!--Main and Responsive CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/main.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/style.css?v=1.2">
    <style>
         @font-face {
	font-family: 'k010';
	src: url('<?php echo base_url(); ?>/assets/fonts/k010.eot');
	src: local('k010'), url('<?php echo base_url(); ?>/assets/fonts/k010.woff') format('woff'), url('<?php echo base_url(); ?>/assets/fonts/k010.ttf') format('truetype');
     }
    </style>
</head>

<body>
<div class="nav__bar">
    <div class="container">
        <ul class="nav_social">
            <li>
                <a href="<?php echo base_url('report')?>">Back To Quiz Results</a>
            </li>
        </ul>
        <ul class="nav_social ml-auto">
        </ul>
    </div>
</div>
<div class="rambow"></div>
<section class="grid__view mt-4">
    <div class="container">
        <!--<h4>Answer Sheet</h4>-->
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <?php
                $attempts = ((int)$result->no_of_attempts % 10);
                $no_of_attempts = "";
                if ($attempts == 1) {
                    $no_of_attempts = $result->no_of_attempts . "st";
                } else if ($attempts == 2) {
                    $no_of_attempts = $result->no_of_attempts . "nd";
                } else if ($attempts == 3) {
                    $no_of_attempts = $result->no_of_attempts . "rd";
                } else {
                    $no_of_attempts = $result->no_of_attempts . "th";
                }

                ?>
                <h3 class="text-center">HELLO <?php echo $result->name; ?>! This is your <?php echo $no_of_attempts; ?> Attempt</h3>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12">
                <h2 class="text-center mt-2"><?php echo $result->quiz_name; ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <h4 class="text-center mt-3 mb-0"> CANDIDATE DETAILS</h4>

                <table class="table table-bordered">
                    <tr>
                        <th>USER ID</th>
                        <td><?php echo $result->username;?></td>
                    </tr>
                    <tr>
                        <th>NAME</th>
                        <td><?php echo $result->name;?></td>
                    </tr>
                    <tr>
                        <th>EMAIL ID</th>
                        <td><?php echo $result->email;?></td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td><?php echo $result->dob;?></td>
                    </tr>
                    <tr>
                        <th>MOBILE</th>
                        <td><?php echo $result->mobile;?></td>
                    </tr>
                    <tr>
                        <th>ADDRESS</th>
                        <td><?php echo $result->address;?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <h4 class="text-center mt-3">DETAILS OF CANDIDATE'S ATTEMPTING MCQs IN CBT EXAM SERIES</h4>
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th rowspan="2">Date <hr>Start Time</th>
                        <th rowspan="2">Time Spent</th>
                        <th colspan="2">Answered</th>
                        <th colspan="3">Not Answered</th>
                        <th rowspan="2">Total MCQs</th>
                    </tr>
                    <tr class="text-center">
                        <td>Answered</td>
                        <td>Answered & Marked for Review</td>
                        <td>Not Answered</td>
                        <td>Not Answered & Marked for Review</td>
                        <td>Not Visited</td>
                    </tr>
                    <tr class="text-center">
                 <td rowspan="2">
            <?php echo date("d M y",strtotime($result->created_date)); ?>
                <hr>
           <?php echo date("h:i:s a",strtotime($result->created_date)); ?>
                 
            </td>
                       
                        <td rowspan="2">
                            <?php
                            $hours = floor($result->time_spent / 3600);
                            $minutes = floor(($result->time_spent / 60));
                            $seconds = $result->time_spent % 60;

                            if($seconds < 10) {
                                $seconds = "0".$seconds;
                            }
                            if($minutes < 10) {
                                $minutes = "0".$minutes;
                            }

                            echo "0$hours:$minutes:$seconds";
                            ?>

                        </td>
                        <td><?php echo $result->answered; ?></td>
                        <td><?php echo $result->answered_and_marked_for_review; ?></td>
                        <td><?php echo $result->not_answered; ?></td>
                        <td><?php echo $result->not_answered_and_marked_for_review; ?></td>
                        <td><?php echo $result->not_visited; ?></td>
                        <td rowspan="4"><?php echo $result->number_of_questions; ?></td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2"><?php echo ($result->answered + $result->answered_and_marked_for_review); ?></td>
                        <td colspan="3"><?php echo ($result->not_answered + $result->not_answered_and_marked_for_review + $result->not_visited); ?></td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2" rowspan="2">Final Scoring</td>
                        <td>Correct</td>
                        <td>Wrong</td>
                        <td colspan="3">Not Answered</td>
                    </tr>
                    <tr class="text-center">
                        <td><?php echo $result->correct; ?></td>
                        <td><?php echo $result->wrong; ?></td>
                        <td colspan="3"><?php echo ($result->not_answered + $result->not_answered_and_marked_for_review + $result->not_visited); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <h4 class="text-center mt-3 mb-0">FINAL ANALYTICAL SCORING/RESULT OF CANDIDATE'S RESPONSE</h4>

                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>ANALYTICAL SCORING/RESULT</th>
                        <th>IN MARKS</th>
                        <th>IN PERCENTAGE</th>
                    </tr>
                    <tr class="text-center">
                        <th>SCORE OBTAINED</th>
                        <td><?php echo number_format($result->total_marks_obtained,2); ?></td>
                        <td><?php echo $result->total_percentage_obtained; ?></td>
                    </tr>
                    <tr class="text-center">
                        <th>NEGATIVE MARKING (<?php
        $result->negative_marking=number_format($result->negative_marking,2); 
                      if($result->negative_marking=='0.25')
                            echo '1/4';
                     elseif($result->negative_marking=='0.33')
                         echo '1/3';
                      elseif($result->negative_marking=='0.50')
                         echo '1/2';
                     else
                        echo $result->negative_marking;

                            ?>)
                        </th>
                        <td><?php echo number_format($result->negative_marks_obtained,2); ?></td>
                        <td><?php echo $result->negative_percentage_obtained; ?></td>
                    </tr>
                    <tr class="text-center">
                        <th>NET SCORE OBTAINED</th>
                        <td><?php echo number_format($result->net_marks_obtained,2); ?></td>
                        <td><?php echo $result->net_percentage_obtained; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><h5>Answer Sheet</h5></div>
                    <div class="card-body" style="padding: 0px;">
                        <?php
                        $i = 1;
                        foreach ($answer_sheet as $sheet) {
                            $temp_correct = json_decode($sheet->correct_option);
                            $correct_answer = $temp_correct[0];
                                $letter='';

                                   switch($correct_answer){
                                    case 'option_1':
                                        $letter='(A)';
                                        break;
                                     case 'option_2':
                                        $letter='(B)';
                                        break;
                                     case 'option_3':
                                        $letter='(C)';
                                        break;
                                     case 'option_4':
                                        $letter='(D)';
                                        break;
                                    default:

                                   }
                        ?>
                            <div class="<?php if (!empty($sheet->user_answer)) { if ($sheet->is_correct == 1) { echo 'correct'; } else { echo 'incorrect';} } ?>" style="padding: 1.25rem;">
                                <p><strong>Question <?php echo $i; ?>)</strong> <?php echo $sheet->question; ?></p>
                                <div class="form-check form-check mb-3 d-flex align-items-center form-group">
                                    <input class="form-check-input" disabled type="radio" name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_1_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_1") { echo "checked"; }?>>
                                    <label class="form-check-label" for="option_1_<?php echo $sheet->question_id; ?>" style="margin-top: 15px; color: #3f3f40;"> A) <?php echo $sheet->option_1; ?></label>
                                </div>
                                <div class="form-check form-check mb-3 d-flex align-items-center form-group">
                                     <input class="form-check-input" disabled type="radio" name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_2_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_2") { echo "checked"; } ?>>
                                    <label class="form-check-label" for="option_2_<?php echo $sheet->question_id; ?>" style="margin-top: 15px; color: #3f3f40;"> B) <?php echo $sheet->option_2; ?></label>
                                </div>
                                <div class="form-check form-check mb-3 d-flex align-items-center form-group">
                                   <input class="form-check-input" disabled type="radio" name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_3_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_3") { echo "checked"; } ?>>
                                    <label class="form-check-label" for="option_3_<?php echo $sheet->question_id; ?>" style="margin-top: 15px; color: #3f3f40;"> C) <?php echo $sheet->option_3; ?></label>
                                </div>
                                <div class="form-check form-check mb-3 d-flex align-items-center form-group">
                                   <input class="form-check-input" disabled type="radio" name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_4_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_4") { echo "checked"; } ?>>
                                    <label class="form-check-label" for="option_4_<?php echo $sheet->question_id; ?>" style="margin-top: 15px; color: #3f3f40;"> D) <?php echo $sheet->option_4; ?></label>
                                </div>
                                <div class="mt-4">
                                    <span class="text-dark"><strong>Correct Option: </strong><?php echo $letter." ".$sheet->{$correct_answer}; ?></span>
                                </div>
                            </div>
                            <hr style="margin-top: -1px; margin-bottom: -1px; border: 1px solid rgba(0, 0, 0, 0.1) !important;">

                            <?php
                            $i++;
                            echo "\n";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>