<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('admin/header'); ?>


<body class="app sidebar-mini rtl">

<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

  <div class="app-title">
    <div>
      <h1><i class="fa fa-users"></i> User Management</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">User Management</a></li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
      
        <div class="bs-component">
          <!--<ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#active"><strong>Active Users (<?php echo count($active_users); ?>)</strong></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#inactive"><strong>Deleted Users (<?php echo count($deactive_users); ?>)</strong></a></li>
          </ul>-->
          
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="active">
              <br/>
              






         <table class="table table-hover table-bordered" id="tbl-activeuser">
                <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Package Name</th>
                    <th>Start date </th>
                    <th>End Date </th>
                    <th>Created At </th>
                   
                  </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($packuser) > 0) {
                          $sr_noo = 1;
                          foreach ($packuser as $pack) {
                            ?>
                          
                            <tr>
                              <td><?php echo $sr_noo; ?></td>
                              <td><?php echo $pack->package_name; ?><br>Duration:<?php echo $pack->package_duration ;?></td>
                              <td><?php echo $pack->package_start; ?></td>
                              <td><?php echo $pack->end_enddate; ?></td>
                               <td><?php echo $pack->end_enddate; ?></td>

                            </tr>
                            <?php
                                $sr_noo++;
                        
                          }
                        }
                    ?> 
                </tbody>
              </table>










                </tbody>
              </table>
            </div>
          
        </div>
        </div>
      </div>
    </div>
  </div>



</main>




















<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
     $('#tbl-activeuser').DataTable( { "aaSorting": [] } );
     $('#tbl-deactiveuser').DataTable( { "aaSorting": [] } );
     <?php 
        if($this->session->flashdata('msg')) {
          echo 'showNotification("'. $this->session->flashdata('msg') .'");';
        }
     ?>
</script>
</body>
</html>


