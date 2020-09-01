<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRATAP'S CBT QUIZ PORTAL</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/web/style.css?v=1.2">

  <style>
 @font-face {
	font-family: 'k010';
	src: url('<?php echo base_url(); ?>/assets/fonts/k010.eot');
	src: local('k010'), url('<?php echo base_url(); ?>/assets/fonts/k010.woff') format('woff'), url('<?php echo base_url(); ?>/assets/fonts/k010.ttf') format('truetype');
     }
    .c { font-family: 'k010'!important; }


@page :first {    
    header: html_firstpageheader;
    footer: html_firstpagefooter;
    margin:5px;
     margin-top:170px;
}
@page {    
   
   margin-top:40px;
}
</style>



</head>

<body>
 <htmlpageheader name="firstpageheader" style="display:none">
    <div style="text-align:center" >
        <img src="https://pcbtexamportal.com/assets/images/header.png" />
    </div>
</htmlpageheader>

<htmlpagefooter name="firstpagefooter" style="display:none">
    <div style="text-align:center" style="padding-top:10px;"><br><br>
        <img src="https://pcbtexamportal.com/assets/images/footer.png"/>
    </div>
</htmlpagefooter>


<section >
    <div class="container">
        <div class="row" >
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
            <h3 style="text-align: center">HELLO <?php echo $result->name; ?>! This is your <?php echo $no_of_attempts; ?> Attempt<br>
             PCBT EXAM NAME - <?php echo $result->quiz_name; ?></h3>
           
            <h3 style="text-align: center">
            <b>CANDIDATE DETAILS</b></h3>
            
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                 <table width="100%" class="table-bordered" style="border-spacing: 0px">
                    <tr>
                        <th style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px; text-align: left">USER
                            ID
                        </th>
                        <td style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px;"><?php echo $result->username; ?></td>
                    </tr>
                    <tr>
                        <th style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px; text-align: left">NAME
                        </th>
                        <td style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px; "><?php echo $result->name; ?></td>
                    </tr>
                    <tr>
                        <th style="padding-top: 8px; padding-bottom: 8px; padding-left: 10px; text-align: left">EMAIL
                            ID
                        </th>
                        <td style="padding-top: 8px; padding-bottom: 10px; padding-left: 8px;"><?php echo $result->email; ?></td>
                    </tr>
                    <tr>
                        <th style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px; text-align: left">DOB
                        </th>
                        <td style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px;"><?php echo $result->dob; ?></td>
                    </tr>
                    <tr>
                        <th style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px; text-align: left">
                            MOBILE
                        </th>
                        <td style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px;"><?php echo $result->mobile; ?></td>
                    </tr>
                    <tr>
                        <th style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px; text-align: left">
                            ADDRESS
                        </th>
                        <td style="padding-top: 8px; padding-bottom: 8px; padding-left: 8px;"><?php echo $result->address; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <h4 style="text-align: center">DETAILS OF CANDIDATE'S ATTEMPTING MCQs IN CBT TEST SERIES</h4>
                <table class="table-bordered" width="100%" style="border-spacing: 0px">
                    <tr style="text-align: center">
                        <th rowspan="2" style="padding-top: 8px; padding-bottom: 8px;">Date  <hr> Start Time</th>
                        <th rowspan="2" style="padding-top: 8px; padding-bottom: 8px;">Time Spent</th>
                        <th colspan="2" style="padding-top: 8px; padding-bottom: 8px;">Answered</th>
                        <th colspan="3" style="padding-top: 8px; padding-bottom: 8px;">Not Answered</th>
                        <th rowspan="2" style="padding-top: 8px; padding-bottom: 8px;">Total MCQs</th>
                    </tr>
                    <tr style="text-align: center">
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center">Answered</td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center">Answered & Marked for Review</td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;">Not Answered</td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;">Not Answered & Marked for Review</td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;">Not Visited</td>
                    </tr>
                    <tr style="text-align: center;">
                        <td rowspan="2"  style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php 
                echo date("d M y",strtotime($result->created_date)); ?>
                <hr>
              <?php  echo date("h:i:s a",strtotime($result->created_date));?></td>
                      
                        <td rowspan="2" style="padding-top: 8px; padding-bottom: 8px; text-align: center;">
                            <?php
                            $hours = floor($result->time_spent / 3600);
                            $minutes = floor(($result->time_spent / 60));
                            $seconds = $result->time_spent % 60;

                            if ($seconds < 10) {
                                $seconds = "0" . $seconds;
                            }

                            echo "0$hours:$minutes:$seconds";
                            ?>

                        </td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->answered; ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->answered_and_marked_for_review; ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->not_answered; ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->not_answered_and_marked_for_review; ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->not_visited; ?></td>
                        <td rowspan="4"
                            style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->number_of_questions; ?></td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="2"
                            style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo($result->answered + $result->answered_and_marked_for_review); ?></td>
                        <td colspan="3"
                            style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo($result->not_answered + $result->not_answered_and_marked_for_review + $result->not_visited); ?></td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="2" rowspan="2" style="padding-top: 8px; padding-bottom: 8px; text-align: center;">Final Scoring</td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;">Correct</td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;">Wrong</td>
                        <td colspan="3" style="padding-top: 8px; padding-bottom: 8px; text-align: center;">Not Answered</td>
                    </tr>
                    <tr style="text-align: center">
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->correct; ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->wrong; ?></td>
                        <td colspan="3"
                            style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo($result->not_answered + $result->not_answered_and_marked_for_review + $result->not_visited); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <h4 style="text-align: center">FINAL ANALYTICAL SCORING/RESULT OF CANDIDATE'S RESPONSE</h4>

                <table class="table-bordered" width="100%" style="border-spacing: 0px">
                    <tr style="text-align: center">
                        <th style="padding-top: 8px; padding-bottom: 8px; text-align: center;">ANALYTICAL SCORING/RESULT</th>
                        <th style="padding-top: 8px; padding-bottom: 8px; text-align: center;">IN MARKS</th>
                        <th style="padding-top: 8px; padding-bottom: 8px; text-align: center;">IN PERCENTAGE</th>
                    </tr>
                    <tr style="text-align: center">
                        <th style="padding-top: 8px; padding-bottom: 8px; text-align: center;">SCORE OBTAINED</th>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->total_marks_obtained; ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->total_percentage_obtained; ?></td>
                    </tr>
                    <tr style="text-align: center">
                        <th style="padding-top: 8px; padding-bottom: 8px; text-align: center;">NEGATIVE MARKING
                       (
       <?php
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
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo number_format($result->negative_marks_obtained,2); ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->negative_percentage_obtained; ?></td>
                    </tr>
                    <tr style="text-align: center">
                        <th style="padding-top: 8px; padding-bottom: 8px; text-align: center;">NET SCORE OBTAINED</th>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo number_format($result->net_marks_obtained,2); ?></td>
                        <td style="padding-top: 8px; padding-bottom: 8px; text-align: center;"><?php echo $result->net_percentage_obtained; ?></td>
                    </tr>
                </table>
            </div>
        </div>
<br><br><br><br><br><br>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card">
                  
                    <div class="card-body" style="padding: 0px;">
                        <?php
                        $i = 1;
                        foreach ($answer_sheet as $sheet) {
                            $temp_correct = json_decode($sheet->correct_option);
                            if(!is_array($temp_correct))
                                          $temp_correct=['option_'.$temp_correct];
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
                            <div class="" style="padding: 1.25rem;">
                                <p ><strong>Question <?php echo $i; ?>)</strong>
                                <?php if($sheet->lang=='hi'){?>
                                 <span class='c'>
                                     <?php 
                                    
                                     echo $sheet->question; ?>
                                        </span>
                                        <?php } else{
                                        
                                         echo $sheet->question;
                                         } ?>
                                </p>
                                <div style="margin-bottom: 5px;">
                                    A) <input class="form-check-input" type="radio"
                                           name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_1_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_1") {
                                        echo "checked='true'";
                                    } ?>>
                                    <label class="form-check-label" for="option_1_<?php echo $sheet->question_id; ?>"
                                           style="margin-top: 15px; color: #3f3f40;"><?php echo $sheet->option_1; ?></label>
                                </div>
                                <div style="margin-bottom:1px;">
                                    B) <input class="form-check-input" type="radio"
                                           name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_2_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_2") {
                                        echo "checked='true'";
                                    } ?>>
                                    <label class="form-check-label" for="option_2_<?php echo $sheet->question_id; ?>"
                                           style="margin-top: 15px; color: #3f3f40;"><?php echo $sheet->option_2; ?></label>
                                </div>
                                <div style="margin-bottom: 5px;">
                                    C) <input class="form-check-input" type="radio"
                                           name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_3_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_3") {
                                        echo "checked='true'";
                                    } ?>>
                                    <label class="form-check-label" for="option_3_<?php echo $sheet->question_id; ?>"
                                           style="margin-top: 15px; color: #3f3f40;"><?php echo $sheet->option_3; ?></label>
                                </div>
                                <div style="margin-bottom: 5px;">
                                    D) <input class="form-check-input" type="radio"
                                           name="radio<?php echo $sheet->question_id; ?>"
                                           id="option_4_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_4") {
                                        echo "checked='true'";
                                    } ?>>
                                    <label class="form-check-label" for="option_4_<?php echo $sheet->question_id; ?>"
                                           style="margin-top: 15px; color: #3f3f40;"><?php echo $sheet->option_4; ?></label>
                                </div>
                                <div style="margin-bottom: 10px;margin-top: 15px;">
                                    <span class="text-dark"><strong>Correct Option: </strong><?php echo $letter." ".$sheet->{$correct_answer}; ?></span>
                                </div>

                                <?php
                                if (!empty($result->question_explanation) ){
                                    ?>
                                    <div style="margin-bottom: 5px;">
                                        <span class="text-dark"><strong>Explanation: </strong><?php echo $sheet->answer_explanation; ?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr style="margin-top: 1px; margin-bottom: 2px; border: 1px solid rgba(0, 0, 0, 0.1) !important;">

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