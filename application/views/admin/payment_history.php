                  
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-product-hunt"></i>Payment History</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Payment History</a></li>
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
                        <a class="btn btn-success" style="color:#fff;float:right;" href="javascript:;" onclick="printDiv();"><i class="fa fa-print"></i> Print </a>
                        <a class="btn btn-success" style="color:#fff;float:right;margin-left: 5PX;" href="<?php echo base_url(); ?>paymentspdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF </a>
                    </div>

                    <br/>
                    <!-- id="DivIdToPrint" -->
                    <!-- id="sampleTable" -->
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th style="width: 42px;">Sr. No.</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Package</th> <th>payment ID</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                       
                        if (count($payments) > 0) {
                           // echo "<pre>";print_r($payments);die;
                            $sr_no = 1;
                            foreach ($payments as $package) {
                                     $pack_ar=[];
	                                 $packids=$package->pack_id;
	                                 if(isJson($packids)){
	                                    $pack_ar=json_decode($packids);
	                                 }
                                      ?>
                                <tr>
                                    <td><?php echo $sr_no ?></td>
                                   
                                    <td><?php echo getUName($package->user_id); ?></td>
                                   
                                    <td><?php echo getEmail($package->user_id); ?></td>
                                    <td>
                                    
                                    <?php 
                                        if(count($pack_ar)>1)
                                        {
                                             $i=1;
                                            foreach($pack_ar as $x)
                                            {
                                              if($i<count($pack_ar))
                                               echo getPackName($x)." , ";
                                              else
                                                echo getPackName($x);
                                               $i++;
                                            }
                                        }
                                        else
                                         {
                                             echo getPackName($packids);
                                         }
                                 ?> 


                                    </td>
                                    <td><?php echo $package->payment_id ?></td>
                                    <td><?php echo $package->amount; ?></td>
                                    
                                    <td><?php echo $package->status ?></td>
                                    
                                    <td><?php echo $package->date; ?></td>
                                    
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