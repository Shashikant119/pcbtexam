<section class="latest mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12"><br>
                 <h3 style="margin-bottom:0;background:none;color:black;font-size: 24px;">Payment History</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                          <tr class="thead-dark">
                            <th>Amount(Rs.)</th>
                            <th>Package Name</th>
                            <th>Payment Id</th>
                            <th>Status</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
            <?php if(count($payments)>0){
                  foreach($payments as $r){
                         $pack_ar=[];
                         $packids=$r->pack_id;
                         if(isJson($packids)){
                            $pack_ar=json_decode($packids);
                         }


                    ?>
                          <tr>
                            <td><?=$r->amount;?></td>
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
                            <td><?=$r->payment_id;?></td>
                            <td><?=$r->status;?></td>
                            <td><?=$r->date;?></td>
                          </tr>
                      <?php }} else{?>
                         <tr>
                            <td colspan='3'>No Payments Made</td>
                        </tr>
                    <?php }?>
                        </tbody>
                </table>
                </div>
            </div>
            
        </div>
    </div>
</section>