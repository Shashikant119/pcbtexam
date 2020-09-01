<style>
     @font-face {
	font-family: 'k010';
	src: url('<?php echo base_url(); ?>/assets/fonts/k010.eot');
	src: local('k010'), url('<?php echo base_url(); ?>/assets/fonts/k010.woff') format('woff'), url('<?php echo base_url(); ?>/assets/fonts/k010.ttf') format('truetype');
     }
</style>

<section class="grid__view mt-4">
    <div class="container">
    

           <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <?php if ($this->session->flashdata('msg')) { echo $this->session->flashdata('msg'); } ?>
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
                <h2 class="text-center mt-2">
                    PCBT EXAM NAME - <?php echo $result->quiz_name; ?></h2>
            </div>
        </div><br><br>
        <div class="row answer-sheet" id='answer-sheet' >
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><h5>Answer Sheet</h5></div>
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

                                   // echo $letter;die;
                            ?>
                                    <div class="<?php if (!empty($sheet->user_answer)) { if ($sheet->is_correct == 1) { echo 'correct'; } else { echo 'incorrect';} } ?>" style="padding: 1.25rem;">
                                        <p><strong>Question <?php echo $i; ?>)</strong> 
                                        <span style="font-family:<?=($sheet->lang=='hi')?'k010!important':'inherit';?>">
                                            
                                            <?php echo $sheet->question; ?>
                                        </span>
                                        </p>
                     <p>A)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_1_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_1") { echo "checked"; }?> name="radio<?php echo $sheet->question_id; ?>"" disabled value="<?php echo $question->option_1; ?>">&nbsp;&nbsp;<?php echo $sheet->option_1; ?></p>
                      <p>B)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_2_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_2") { echo "checked"; }?> name="radio<?php echo $sheet->question_id; ?>"" disabled value="<?php echo $question->option_2; ?>">&nbsp;&nbsp;<?php echo $sheet->option_2; ?></p>
                       <p>C)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_1_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_3") { echo "checked";}?> name="radio<?php echo $sheet->question_id; ?>"" disabled value="<?php echo $question->option_3; ?>">&nbsp;&nbsp;<?php echo $sheet->option_3; ?></p>
                        <p>D)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_1_<?php echo $sheet->question_id; ?>" <?php if ($sheet->user_answer == "option_4") { echo "checked";}?> name="radio<?php echo $sheet->question_id; ?>"" disabled value="<?php echo $question->option_4; ?>">&nbsp;&nbsp;<?php echo $sheet->option_4; ?></p>

                                       <div class="mt-4">
                                        <span class="text-dark"><strong>Correct Option: </strong><?php echo $letter." ".$sheet->{$correct_answer}; ?></span>
                                    </div>

                                        <?php
                                            if ($result->question_explanation) {
                                        ?>
                                                <div class="mt-2">
                                                    <span class="text-dark"><strong>Explanation: </strong><?php echo $sheet->answer_explanation; ?></span>
                                                </div>
                                        <?php
                                            }
                                        ?>
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
<script>

    $(document).keyup(function(evtobj) {     
                if (!(evtobj.altKey || evtobj.ctrlKey || evtobj.shiftKey)){
    if (evtobj.keyCode == 16) {return false;}
                    if (evtobj.keyCode == 17) {return false;}
   
                }
});
document.addEventListener('contextmenu', event => event.preventDefault());
  document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 67 || 
             e.keyCode === 86 || 
             e.keyCode === 85 || 
             e.keyCode === 117)) {
          
            return false;
        } 
       if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
          return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
             return false;
          }
};
</script>
