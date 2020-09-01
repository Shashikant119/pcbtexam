<section class="grid__view mt-4">
    <div class="container">
        <h4>Bulk Payment</h4>
       
        <div class="row mt-md-3">
            
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody>
                        <tr class="thead-dark" style="white-space: nowrap;">
                            <th>#</th>
                            <th>Package Image</th>
                            <th>Package Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Total PCBT Test</th>
                           
                            <th>Frequency</th>
                          
                        </tr>
                        <?php if (count($packages)>0) {
                $user_id=$this->session->userdata('loginid');
                     $count = 0;
                foreach ($packages as $key => $package) {
    if($package->package_type=='Free'  || isUserPackage($user_id,$package->package_id))
                        continue;
              
                                $count++;

                                if (!$package->image) {
                                    $package->image = "dummy-image.jpg";
                                }
                                ?>
                                <tr>
                                    <td><?php echo $count; ?>
            <input type="checkbox" name="packages[]" id="pack-<?=$package->package_id;?>" value="<?=$package->package_id;?>" data-amount="<?=$package->package_price;?>"/>
                                    </td>
                                    <td><img src="<?php echo base_url().'assets/images/packages/'.$package->image; ?>" alt="" height="55" width="70"></td>

                                    <td><?php echo $package->package_name; ?></td>
                                    <td><?php echo $package->package_type; ?></td>
                                    <td width="20%"><?php if ($package->package_type == 'Free') {
                                            echo '<i class="fa fa-inr" aria-hidden="true"></i>' . '00.00';
                                        } else {
                                            echo '<i class="fa fa-inr" aria-hidden="true"></i>' . $package->package_price;
                                        } ?></td>
                                    <td><?php echo $package->package_duration . 'days'; ?></td>
                                    <td><?php echo $package->total_cbt_test; ?></td>
                                    <!--<td><?php /*echo $package->mcq_in_cbt; */?></td>-->
                                    <td><?php echo $package->frequency_of_cbt; ?></td>
                                  
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if (count($packages)>0) {?>
            <div class="col-md-12 text-center">
                <form action="<?=base_url();?>bulk-payment" method="post">
                    <input type="hidden" id="packinput" name="packids"/>
                <button class="btn btn-success" onclick="makeBulkPayment(event)" type="button">Make Payment</button>
<br>
            </form>
            </div><?php }?>
        </div>

        <div class="my-3 text-center mb-4">
            <a href="#0" class="btn btn-primary mx-2"> <span> Back</span></a>
            <a href="#0" class="btn btn-primary"> <span>Next</span> </a>
        </div>

    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
      var SITEURL = "<?php echo base_url() ?>";
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
var pack_ids = [];
 var totalAmount =0;
$('input[type="checkbox"]').change(function(event) {
      if($(this).is(':checked'))
      {
           pack_ids.push($(this).val());
           amt=parseInt($(this).attr('data-amount'));
           totalAmount=totalAmount+amt;
           pack_ids = pack_ids.filter( onlyUnique );
          $("#packinput").val(JSON.stringify(pack_ids));
    }
    else
    {
        item=$(this).val();
        var index = pack_ids.indexOf(item);
        if (index !== -1) pack_ids.splice(index, 1);
        pack_ids = pack_ids.filter( onlyUnique );
        amt=$(this).attr('data-amount');
        totalAmount=totalAmount-amt;
        $("#packinput").val(JSON.stringify(pack_ids));

    }
});
    function makeBulkPayment(e)
    {  
        e.preventDefault();
           
            var product_id =$("#packinput").val();
               $.ajax({
            url: SITEURL + 'User_questionire/orderId',
            type: 'post',
          
            data: {
                 amount : totalAmount*100,product_id:product_id
            }, 
            success: function (msg) {
                order_id=msg;
                       if(msg.length>0)
                        { 
                            openR(totalAmount,product_id,order_id);
                        }
                        else
                         alert('Error  in payment');
            }
        });
    }
     function openR(amount,pack,orderid)
  {
       var options = {
    "key": "rzp_live_jwsPSDG8TDC9I1",
    "amount": amount*100, // 2000 paise = INR 20
    "name": '<?php echo $this->session->userdata('name');?>',
    "description": "Payment",
    "prefill":{
        "email":'<?php echo $this->session->userdata('email');?>',
        'contact':'<?php echo $this->session->userdata('mobile');?>'
    },
    "image": SITEURL+'assets/web/images/logo-new.jpg',
    "order_id":orderid,
    "handler": function (response){
          $.ajax({
            url: SITEURL + 'User_questionire/bulkpaymentSuccess',
            type: 'post',
          
            data: {
                razorpay_payment_id: response.razorpay_payment_id , amount : amount ,product_id : pack,razorpay_order_id:response.razorpay_order_id,server_order_id:orderid
            }, 
            success: function (msg) {
                       if(msg.length>0)
                        { alert('Payment made succesfully');
                         location.reload();
                        }
                        else
                         alert('Error occured in payment');
            }
        });
      
    },
 
    "theme": {
        "color": "#528FF0"
    }
  };
  var rzp1 = new Razorpay(options);
  rzp1.open();
  }
    </script>