<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('header'); ?>
<body>
    <form id="msform">
        <fieldset>
            <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/logo.png" alt="logo">
            <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/oncquest.png" alt="logo">
            <hr/>

            <p>
                <span style="font-size: 20px; font-weight: bold; color: red;">
                    <?php echo $msg; ?>     
                </span>
            </p>

            <hr/>
        </fieldset>
    </form>

<?php $this->load->view('footer'); ?>
</body>
</html>