<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('header'); ?>
<body>
    <form id="msform">
        <fieldset>
            <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/logo.png" alt="logo">
            <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/oncquest.png" alt="logo">
            <hr>

            <?php if($show_quiz) { ?>
                <h2 class="fs-title" style="color: blue;">
                    <?php echo @$quiz_data[0]->quiz_title; ?>
                </h2>
                
                <hr>
                <a href="<?php echo base_url() ?>quiz-question/<?php echo md5(@$quiz_data[0]->quiz_id); ?>" style="text-decoration: none; background-color: #4CAF50;border: none;color: white;padding: 20px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;border-radius: 25px;">Start Quiz </a>
            <?php } else { ?>
                <h2 class="fs-title" style="color: blue;">
                    <?php echo @$quiz_data[0]->quiz_title; ?>
                </h2>
                <h2 class="fs-title" style="color: red;">
                    Sorry! Quiz has been closed now.
                </h2>
            <?php } ?>
            <hr>
        </fieldset>
    </form>

<?php $this->load->view('footer'); ?>
<script type="text/javascript">
    <?php if(count($draft_answer) > 0) { echo 'window.location.href = "'. base_url() .'quiz-question/'. md5(@$quiz_data[0]->quiz_id) .'"'; } ?>
</script>

</body>
</html>