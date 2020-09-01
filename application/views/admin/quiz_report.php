<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

  <div class="app-title">
    <div>
      <h1><i class="fa fa-area-chart"></i> Questionnaire Result</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Questionnaire Result</a></li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          
            <form name="search-form" action="" method="GET">
                <div class="row">
                    <div class="col-md-4">
                      <select class="form-control" name="sby_quiz">
                        <?php
                            if(count($quizes) > 0) {
                                foreach($quizes as $quiz) {
                                    if(@$_GET['sby_quiz'] == $quiz->quiz_id)
                                        $selected = 'selected="selected"'; 
                                    else
                                        $selected = ''; 
                                    echo '<option value="'. $quiz->quiz_id .'" '. $selected .'>'. $quiz->quiz_title .'</option>';
                                }
                            }
                        ?>
                      </select>
                    </div>
                    From :
                    <div class="form-group col-md-2">
                      <input class="form-control" type="date" name="from_date" <?php if(!empty(@$_GET['from_date'])) { echo 'value="'. $_GET['from_date'] .'"'; } ?>>
                    </div>
                    
                    To :
                    <div class="form-group col-md-2">
                      <input class="form-control" type="date" name="to_date" <?php if(!empty(@$_GET['to_date'])) { echo 'value="'. $_GET['to_date'] .'"'; } ?>>
                    </div>
                    
                    <div class="form-group col-md-3">
                        <input type="submit" class="btn btn-success" name="search" value="Get Result">
                        &nbsp;&nbsp;<a class="btn btn-danger" href="<?php echo base_url() ?>report">Reset</a>
                    </div>
                </div>
            </form>
          <br/>

          <table class="table table-hover table-bordered" id="sampleTable">
            <thead>
              <tr>
                <th>User</th>
                <th>Branch Location</th>
                <th>Zone</th>
                <th>Submit Date</th>
                <th>Submit Time</th>
                <th>Total Attempt</th>
                <th>Correct Answer</th>
                <th>Incorrect Answer</th>
                <th>Marks Obtained</th>
                <th>% Result</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                 <?php
                    if(count($report_data) > 0) {
                        foreach ($report_data as $data) {
                          ?>
                          <tr>
                              <td><?php echo $data['name']; ?></td>
                              <td><?php echo $data['branch_location']; ?></td>
                              <td><?php echo $data['zone']; ?></td>
                              <td><?php echo date('d-m-Y', strtotime($data['submission_date'])); ?></td>
                              <td><?php echo date('h:i A', strtotime($data['submission_date'])); ?></td>
                              <td><?php echo $data['total_attempt']; ?></td>
                              <td><?php echo $data['correct_ans']; ?></td>
                              <td>
                                <?php 
                                    echo ( intval($data['total_attempt']) - intval($data['correct_ans']) ); 
                                ?> 
                              </td>
                              <td align="center">
                                <?php
                                    echo (intval($data['marks_per_question']) * intval($data['correct_ans'])); 
                                ?>
                              </td>
                               <td align="center">
                                <span class="badge badge-success">
                                <?php
                                    $tot_q = intval($data['tot_question']);
                                    $cor = intval($data['correct_ans']);
                                    $per_res = ( ($cor * 100) / $tot_q );
                                    echo number_format($per_res, 2) . ' %';
                                ?>
                                </span>
                              </td>
                              <td>
                                <a href="<?php echo base_url() . 'report-details/' . $data['quiz_id'] . '/' . $data['user_id']; ?>" class="badge badge-primary">
                                  <i class="fa fa-eye" aria-hidden="true"></i> View Details
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