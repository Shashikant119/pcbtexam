                  
<!DOCTYPE html>
<html lang="en">
    <body class="app sidebar-mini rtl">

<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered">
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
</body>
</html>