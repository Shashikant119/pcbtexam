<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

  <div class="app-title">
    <div>
      <h1><i class="fa fa-area-chart"></i> Questionnaire Result Details</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Questionnaire Result Details</a></li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <a class="btn btn-secondary pull-right" href="<?php echo base_url() ?>report/">Back To Result</a> <br/><br/><br/>
          <table class="table table-hover table-bordered" id="sampleTable">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>Question</th>
                <th>Correct Answer</th>
                <th>User Answer</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
                 <?php
                    if(count($report_data) > 0) {
                        $sr_no = 1;
                        foreach ($report_data as $data) {
                          ?>
                          <tr>
                              <td><?php echo $sr_no++; ?></td>
                              <td><?php echo $data['question']; ?></td>
                              <td><?php echo $data[$data['correct_option']]; ?></td>
                              <td><?php echo empty($data[$data['user_answer']]) ? '-' : $data[$data['user_answer']]; ?></td>
                              <td align="center">
                                <?php
                                    if(!empty($data[$data['user_answer']])) {
                                        if($data['is_correct'] == '1') {
                                            echo '<h3><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></h3>';
                                        } else {
                                            echo '<h3><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></h3>';
                                        }
                                    } else {
                                        echo '-';   
                                    }
                                ?>
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
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script type="text/javascript">
     $('#sampleTable').DataTable( { "aaSorting": [], dom: 'lBfrtip', buttons: [ 'excel', 'pdf', 'print' ] } );
     <?php
        if($this->session->flashdata('msg')) {
          echo 'showNotification("'. $this->session->flashdata('msg') .'");';
        }
     ?>
</script>
</body>
</html>