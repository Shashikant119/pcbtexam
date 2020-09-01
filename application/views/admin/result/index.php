<!DOCTYPE html>

<html lang="en">

<?php $this->load->view('admin/header'); ?>

<body class="app sidebar-mini rtl">

<?php $this->load->view('admin/sidebar'); ?>

<main class="app-content">

    <div class="app-title">

        <div>

            <h1><i class="fa fa-question-circle"></i>Result Management</h1>

            <p></p>

        </div>

        <ul class="app-breadcrumb breadcrumb">

            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

            <li class="breadcrumb-item"><a href="#">Results</a></li>

        </ul>

    </div>



    <div class="row">

        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">

                    <div class="row">

                        <div class="col-lg-6">

                            <label><strong>Result Management</strong></label>

                        </div>

                        <div class="col-lg-6">

                            <a class="btn btn-success pull-right" href="javascript:void(0)" data-target="#generateReport" data-toggle="modal">Generate Report</a>
                            <a class="btn btn-success" style="color:#fff;float:right;margin-right:5px;" href="javascript:;" onclick="printDiv();"><i class="fa fa-print"></i> Print </a>
                            <a class="btn btn-success" style="color:#fff;float:right;margin-right:5px;" href="<?php echo base_url(); ?>resultpdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF </a>

                        </div>

                    </div>

                    <br/>

                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>

                        <tr>

                            <th>Result Id</th>

                            <th>User ID</th>

                            <th>User Name</th>

                            <th>Quiz Name</th>

                            <th>No. Of Attempt</th>

                            <th>Status</th>

                            <th>Net Marks Obtained</th>

                            <th>Net Percentage Obtained</th>

                            <th>Action</th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php

                        if (count($results) > 0) {

                            foreach ($results as $result) {

                                ?>

                                <tr>

                                    <td><?php echo $result->id; ?></td>

                                    <td><?php echo $result->username; ?></td>

                                    <td><?php echo $result->student_name; ?></td>

                                    <td><?php echo $result->quiz_name; ?></td>

                                    <td><?php echo $result->no_of_attempts; ?></td>

                                    <td><?php echo $result->status ? "Pass" : "Fail"; ?></td>

                                    <td><?php echo number_format($result->net_marks_obtained,2); ?></td>

                                    <td><?php echo $result->net_percentage_obtained; ?>%</td>

                                    <td>

                                        <a href="<?php echo base_url(); ?>admin-report/<?php echo $result->id; ?>"

                                           class="btn btn-success">View

                                        </a>

                                        <a onclick="return confirm('Do you want to delete the result?');" href="<?php echo base_url(); ?>report-delete/<?php echo $result->id; ?>"

                                           class="btn btn-danger mt-1">Delete

                                        </a>

                                    </td>

                                </tr>

                                <?php

                            }

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

<div class="modal" tabindex="-1" role="dialog" id="generateReport">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Upload Question</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <form action="<?php echo base_url(); ?>report/generate" name="upload-question" method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-group">

                        <div class="col-md-12">

                            <label for="category" class="col-form-label">Select Quiz<span

                                    style="color: red;">*</span></label>

                            <select class="form-control" name="quiz_id" id="category" required>

                                <?php foreach ($quizes as $quiz) { ?>

                                    <option value="<?php echo $quiz->quiz_id; ?>"> <?php echo $quiz->quiz_title; ?></option>

                                <?php } ?>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Generate Report</button>

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


<script type="text/javascript">
     function printDiv() 
    {

      var divToPrint=document.getElementById('sampleTable');

      var newWin=window.open('','Print-Window');

      newWin.document.open();

      newWin.document.write('<html><body onload="window.print()"><table border="1" cellspacing="0">'+divToPrint.innerHTML+'</table></body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();},10);

    }
    $(document).ready(function(){
        $("input").attr('autocomplete', 'off');
    });
    </script>
</body>

</html>