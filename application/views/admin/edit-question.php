<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-question-circle"></i> Edit Question</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Edit Question</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>
                                <strong>
                                    Edit Question: <?php echo QuestionBank::QUESTION_TYPE[$question->question_type];?> <?php if (QuestionBank::SHORT_ANSWER != $question->question_type && $question->question_type != QuestionBank::LONG_ANSWER) { echo "(".$question->number_of_option.")"; }?>
                                </strong>
                            </label>
                        </div>
                        <div class="col-lg-6">
                         
                        </div>
                    </div>
                    <div class="modal-header">

                    </div>
                    <!-- Add New Question Form -->
                    <form action="<?php echo base_url(); ?>edit-question/<?php echo $question->question_id; ?>" method="POST" name="question-form" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="category" class="col-form-label">Select Category<span style="color: red;">*</span></label>
                                    <select class="form-control" name="category" id="category" required>
                                        <?php foreach ($categories as $category) { ?>
                                            <option value="<?php echo $category->id; ?>" <?php if ($question->category_id == $category->id){ echo "selected"; } ?> > <?php echo $category->category_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="level" class="col-form-label">Select Level<span style="color: red;">*</span></label>
                                    <select class="form-control" name="level" id="level" required>
                                        <?php foreach ($levels as $level) { ?>
                                            <option <?php if ($question->level_id == $level->id){ echo "selected"; } ?> value="<?php echo $level->id; ?>"><?php echo $level->level_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="question_text" class="col-form-label">Question :<span style="color: red;">*</span></label>
                                    <textarea class="form-control" id="question_text" name="question_text" required="" maxlength="255">
                                        <span style="font-family:<?=($question->lang=='hi')?'k010!important':'inherit';?>"><?php echo $question->question; ?>
                                        </span>
                                        </textarea>
                                </div>
                            </div>
                             
                        
                            <?php if($question->question_type !== QuestionBank::LONG_ANSWER && $question->question_type !== QuestionBank::SHORT_ANSWER) {
                                for($i = 1; $i <= $question->number_of_option; $i++) { $option = "option_".$i; 
                                
                                   $op_url="option_".$i."_url";
                                ?>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="option_<?php echo $i;?>" class="col-form-label">Option <?php echo $i; ?> :<span style="color: red;">*</span></label>
                                            <textarea type="text" class="form-control" id="option_<?php echo $i;?>" name="option_<?php echo $i;?>" maxlength="200" required="" value=""><?php echo $question->{$option}; ?></textarea>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="answer_explanation" class="col-form-label">Option <?=$i;?> Image :</label>
                                            <input type='file' class="form-control" id="op<?=$i;?>_url" name="<?=$op_url;?>"  />
                                         <?php if($question->{$op_url}){?>  
                                          <a href="<?=base_url();?>uploads/options/<?=$question->{$op_url};?>" target='_blank'  >Link</a>
                                         <a class="btn btn-danger btn-sm" type="button" href="javascript:delete_res('op<?=$i;?>');"><i class="fa fa-remove"></i></a>
                                          <?php } ?>
                                         </div>
                                                </div>
                                <?php }
                            } ?>

                            <?php if ($question->question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER || $question->question_type == QuestionBank::MULTIPLE_CHOICE_SINGLE_ANSWER) { ?>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="correct_option" class="col-form-label">Correct Answer :<span style="color: red;">*</span></label>
                                        <select class="form-control" id="correct_option" name="correct_option[]" required <?php if ($question->question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) { echo "multiple"; }?>>
                                            <?php for ($i = 1; $i <= $question->number_of_option; $i++) { ?>
                                                <option <?php if (in_array("option_".$i, json_decode($question->correct_option))) { echo "selected"; } ?> value="option_<?php echo $i; ?>">Option <?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($question->question_type == QuestionBank::LONG_ANSWER || $question->question_type == QuestionBank::SHORT_ANSWER) { ?>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="correct_option" class="col-form-label">Correct Answer :<span style="color: red;">*</span></label>
                                        <input class="form-control" id="correct_option" name="correct_option[]" required value="<?php echo @json_decode($question->correct_option)[0]; ?>">
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="answer_explanation" class="col-form-label">Answer Explanation:</label>
                                    <textarea class="form-control" id="answer_explanation" name="answer_explanation" maxlength="2000"><?php echo $question->answer_explanation; ?></textarea>
                                </div>
                            </div>
                             <div class="form-group">
                                <div class="col-md-6">
                                    <label for="answer_explanation" class="col-form-label">Attach Video :</label>
                                    <input type='file' class="form-control" id="video_url" name="video_url" />
                        <?php if($question->video_url){?> <a href="<?=base_url();?>uploads/video/<?=$question->video_url;?>" target='_blank'  >Link</a>
                        <a class="btn btn-danger btn-sm" type="button" href="javascript:delete_res('video');"><i class="fa fa-remove"></i></a>
                         <?php }?>

                                </div>
                            </div>
                             <div class="form-group">
                                <div class="col-md-6">
                                    <label for="answer_explanation" class="col-form-label">Attach Audio :</label>
                                    <input type='file' class="form-control" id="audio_url" name="audio_url" >
                       <?php if($question->audio_url){?>  <a href="<?=base_url();?>uploads/audio/<?=$question->audio_url;?>" target='_blank' >Link</a>
                       <a class="btn btn-danger btn-sm" type="button" href="javascript:delete_res('audio');"><i class="fa fa-remove"></i></a>
                        <?php }?>
                                </div>
                            </div>
                             <div class="form-group">
                                <div class="col-md-6">
                                    <label for="answer_explanation" class="col-form-label">Attach Image :</label>
                                    <input type='file' class="form-control" id="image_url" name="image_url"  />
                     <?php if($question->image_url){?>  
                      <a href="<?=base_url();?>uploads/image/<?=$question->image_url;?>" target='_blank'  >Link</a>
                     <a class="btn btn-danger btn-sm" type="button" href="javascript:delete_res('image');"><i class="fa fa-remove"></i></a>
                      <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary pull-right">Update</button>
                                <a href="<?php echo base_url();?>question-bank" class="btn btn-danger pull-right mr-2">Cancel</a>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>


<?php $this->load->view('admin/footer'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
<script type="text/javascript">
	function delete_res(type)
	{
		
		var qid='<?=$question->question_id;?>';
		 $.ajax({
     url:'<?=base_url()?>delete-q-file',
     method: 'post',
     data: {qid: qid,type:type},
        success: function(response){
        alert(response);
     }
   });
	}
    <?php
    if ($question->question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) {
        echo "$('#correct_option').select2();";
    }
    if($this->session->flashdata('msg')) {
        echo 'showNotification("'. $this->session->flashdata('msg') .'");';
    }
    ?>

</script>
</body>
</html>