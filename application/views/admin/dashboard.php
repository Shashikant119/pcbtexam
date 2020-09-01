<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
  <?php $this->load->view('admin/sidebar'); ?>

  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        <p></p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>

    
    <div class="row">
      <div class="col-md-6 col-lg-6">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
          <div class="info">
            <h4>Coming soon</h4>
            
          </div>
        </div>
      </div>
     <!--  <div class="col-md-6 col-lg-6">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
          <div class="info">
            <h4><a href="<?php echo base_url() . 'quiz-management'; ?>">Total Quiz List</a> -: <b><?php echo $total_quizes; ?></b></h4>
            
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-6">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-money fa-3x"></i>
          <div class="info">
            <h4><a href="<?php echo base_url() . 'payments'; ?>">Total Payments Received</a> -: <b><?php echo $total_payments; ?></b></h4>
            
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-6">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-question fa-3x"></i>
          <div class="info">
            <h4><a href="<?php echo base_url() . 'question-bank'; ?>">Total Questions</a> -: <b><?php echo $total_questions; ?></b></h4>
            
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-6">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-file-archive-o fa-3x"></i>
          <div class="info">
            <h4><a href="<?php echo base_url() . 'admin_package'; ?>">Total Packages</a> -: <b><?php echo $total_packages; ?></b></h4>
            
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-6">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-500px fa-3x"></i>
          <div class="info">
            <h4><a href="<?php echo base_url() . 'report'; ?>">Total Results</a> -: <b><?php echo $total_results; ?></b></h4>
            
          </div>
        </div>
      </div>
    </div> -->

  </main>
  <?php $this->load->view('admin/footer'); ?>
  
</body>
</html>