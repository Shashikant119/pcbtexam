                  
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-product-hunt"></i>Appreciation List</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Appreciation List</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            </div>
                        </div>
                        
                    </div>
                    <br/>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th style="width: 42px;">Sr. No.</th>
                             <th> Name</th>
                              <th>User Name</th> <th>Email</th>
                              <th>Words</th>
                              <th>Rating</th>
                              <!--<th>Date</th>-->
                               <th>Action</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($appreciations) > 0) {
                           // echo "<pre>";print_r($payments);die;
                            $sr_no = 1;
                            foreach ($appreciations as $app) {
                               ?>
                                <tr>
                                    <td><?php echo $sr_no ?></td>
                                     <td><?php echo getName($app->user_id); ?></td>
                                    <td><?php echo getUName($app->user_id); ?></td>
                                     <td><?php echo getEmail($app->user_id); ?></td>
                                  
                                    <td style='max-width:200px;word-wrap:break-word'><?php echo ($app->feedback); ?></td>
                                   
                                    <td><?php echo $app->rating; ?></td>
                                   <!-- <td><?php echo date("Y-m-d",strtotime($app->date)); ?></td>
                                    -->
                                    
                                    <td>
                            <a href="<?=base_url();?>admin-edit-appreciation/<?=$app->id;?>"  class="btn btn-info btn-sm"  >Edit</a>
                            <a href="<?=base_url();?>admin-delete-appreciation/<?=$app->id;?>"  class="btn btn-danger btn-sm"  >Delete</a>

                                    </td>
                                    
                                </tr>
                                <?php
                                $sr_no++;
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