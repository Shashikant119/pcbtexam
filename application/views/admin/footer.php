<div class="modal" tabindex="-1" role="dialog" id="uploadQuestion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>upload-question" name="upload-question" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="category" class="col-form-label">Select Category<span
                                        style="color: red;">*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category->id; ?>"> <?php echo $category->category_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="level" class="col-form-label">Select Level<span
                                        style="color: red;">*</span></label>
                            <select class="form-control" name="level" id="level" required>
                                <?php foreach ($levels as $level) { ?>
                                    <option value="<?php echo $level->id; ?>"> <?php echo $level->level_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="question_file" class="col-form-label">Select File<span
                                        style="color: red;">*</span></label>
                            <input type="file" name="question_file" class="form-control" id="question_file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload Question</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Essential javascripts for application to work-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="<?php echo base_url(); ?>assets/js/plugins/pace.min.js"></script>
<!-- Datepicker -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datepicker.min.js"></script>
<!-- Alert Messages -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-notify.min.js"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/dataTables.bootstrap.min.js"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/chart.js"></script>
 
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!-- common js -->
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>