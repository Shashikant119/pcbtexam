<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-question-circle"></i> Manage Questions</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Manage Questions</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <label><strong>Question Bank</strong></label>
                            
                        </div>
                       
                    </div>
                      <div id="search" class="row">
                          <div class="col-md-12">
                          <form action="<?php echo base_url(); ?>question-bank" method="post">
                          <input class="typeahead" type="text" name="question_name" value="" placeholder="Search Question..">
                          <input type="submit" value="Search"/>
                          </form>
                          </div>
                      </div>
                    <br/>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Question Type</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($questions) > 0) {$i=1;
                            foreach ($questions as $question) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td style="font-family:<?=($question->lang=='hi')?'k010!important':'inherit';?>"><?php echo $question->question; ?></td>
                                    <td><?php echo QuestionBank::QUESTION_TYPE[$question->question_type]; ?></td>
                                    <td><?php if (!empty($question->category_name)) {
                                            echo $question->category_name;
                                        } else {
                                            echo "---";
                                        } ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>edit-question/<?php echo $question->question_id; ?>"
                                           class="badge badge-success">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                        </a>
                                        <a href="<?php echo base_url() . 'delete-question/' . $question->question_id ?>"
                                           class="badge badge-danger"
                                           onclick="return confirm('Do you want to delete this question ?');">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                           $i++; }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Upload question modal -->
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
<!-- Upload question modal -->
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
    $('#sampleTable').DataTable({"aaSorting": []});


    <?php
    if ($this->session->flashdata('msg')) {
        echo 'showNotification("' . $this->session->flashdata('msg') . '");';
    }
    ?>
</script>

</body>
</html>