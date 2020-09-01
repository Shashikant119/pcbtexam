<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('header'); ?>
<style>
    #main-text {
    display: flex;
}
#main-text > div {
    flex: 0 0 50%;
    text-align: left;
}
#main-text > div:last-child{text-align:right;}
</style>
<body>
    <form id="msform" name="question-form" method="POST" action="<?php echo base_url(); ?>save-answer">
        <?php
            if(count($draft_answer) > 0) {
                $first_tab = 'style="display: none;"';
            } else {
                $first_tab = 'style="display: block;"';
            }
            
            if(count($quiz_data) > 0) {
                $counter = 1;
                foreach($quiz_data as $quiz) {
                    //draft ans
                    $active_tab = 'style="display: none;"';
                    $checked = '';
                    
                    if ( count($draft_answer) > 0) {
                        foreach($draft_answer as $draft_ans) {
                            if($quiz->question_id == $draft_ans->question_id) {
                                $checked = $draft_ans->user_answer;
                            }
                        }
                        
                        if ($draft_answer[(count($draft_answer) - 1)]->question_id == $quiz->question_id) {
                            $active_tab = 'style="display: block;"';
                        }
                    } else {
                        if ($counter == 1) {
                            $active_tab = $first_tab;
                        }
                    }
        ?>
                    <fieldset <?php echo $active_tab; ?>>
                        
                        <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/logo.png" alt="logo" />
                        <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/oncquest.png" alt="logo" />
                        <hr/>
                        
                        <div id="main-text">
                            <div> Question <?php echo $counter; ?> of <?php echo count($quiz_data); ?> </div>
                            <?php if($counter == count($quiz_data)) { ?>
                                <div> </div>
                            <?php } else { ?>
                                <div> <p class="skip" style="color: blue;cursor: pointer;">Skip <i class="fa fa-angle-double-right" aria-hidden="true"></i></p> </div>
                            <?php } ?>
                        </div>
                             
                        <hr/>
                        <div class="text-left">
                            <h4 class="quiz-heading"><?php echo $quiz->question; ?></h4>
                            <div class="quiz-row">
                                
                                <div class="q-tab">
                                    <label class="radio">
                                        <input type="radio" value="option_1" name="question_<?php echo $quiz->question_id; ?>" class="ans-opt" <?php echo ($checked == 'option_1') ? 'checked="true"' : '' ; ?> onchange="saveDraftAnswer();">
                                        <span class="outer"><span class="inner"></span></span>
                                        <p><?php echo $quiz->option_1; ?></p>
                                    </label>
                                </div>
                                
                                <div class="q-tab">
                                    <label class="radio">
                                        <input type="radio" value="option_2" name="question_<?php echo $quiz->question_id; ?>" class="ans-opt" <?php echo ($checked == 'option_2') ? 'checked="true"' : '' ; ?> onchange="saveDraftAnswer();">
                                        <span class="outer"><span class="inner"></span></span>
                                        <p><?php echo $quiz->option_2; ?></p>
                                    </label>
                                </div>
                                
                                <div class="q-tab">
                                    <label class="radio">
                                        <input type="radio" value="option_3" name="question_<?php echo $quiz->question_id; ?>" class="ans-opt" <?php echo ($checked == 'option_3') ? 'checked="true"' : '' ; ?> onchange="saveDraftAnswer();">
                                        <span class="outer"><span class="inner"></span></span>
                                        <p><?php echo $quiz->option_3; ?></p>
                                    </label>
                                </div>
            
                                <div class="q-tab">
                                    <label class="radio">
                                        <input value="option_4" type="radio" name="question_<?php echo $quiz->question_id; ?>" class="ans-opt" <?php echo ($checked == 'option_4') ? 'checked="true"' : '' ; ?> onchange="saveDraftAnswer();">
                                        <span class="outer"><span class="inner"></span></span>
                                        <p><?php echo $quiz->option_4; ?></p>
                                    </label>
                                </div>
            
                            </div>
                        </div>
                        <hr/>
                        <?php if($counter != 1) { ?>
                        <input type="button" name="previous" class="previous action-button" value="Previous" />
                        <?php } ?>
            
                        <?php if($counter == count($quiz_data)) { ?>
                        <input type="submit" name="submit" class="action-button" onclick="return submitAnswer();" value="Submit" />
                        <?php } else { ?>
                        <input type="button" name="next" class="next action-button" value="Next" />
                        <?php } ?>
                    </fieldset>
        <?php
                    $counter++;
                }
            } else {
                echo '<h3>No question found in this quiz.</h3>';
            }
        ?>
        <input type="hidden" name="quizid" value="<?php echo @$quiz_data[0]->quiz_id; ?>">
    </form>

<?php $this->load->view('footer'); ?>
<script type="text/javascript">
    function submitAnswer() {
        let attempt = 0;
        $(".ans-opt").each( function(){
            if( $(this).prop("checked") ) {
                attempt++;
            }
        });
        if( confirm('Total question attempted : ' + attempt + '\n Are you sure to submit your answer ?' ) )
            return true;
        else
            return false;
    }
    
    //draft saving
    function saveDraftAnswer() {
        var form = $("#msform");
        var formData = new FormData(form[0]);
        $.ajax({
            url: '<?php echo base_url() . "User_questionire/save_draft_user_answer"; ?>',
            crossDomain: true,
    		async: false,
    		type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                //ok
            }
        });
    }
</script>

</body>
</html>