<section class="grid__view mt-4">
    <div class="container">
        <h4>Packages Pricing</h4>
        <div class="row">
            <div class="col-6">
                <form method="post" action="#0">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <span class="input-group-btn">
                          <button class="btn btn-warning" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <p style="float:right;">
                    <a href="<?php echo base_url('packages'); ?>?view=table" class="btn btn-success">Table View</a>
                </p>
            </div>
        </div>
        <div class="row  mt-md-3">
            <div class="col-md-12">
                <div class="row ">
                    <?php 
                 
               $user_id=$this->session->userdata('loginid');

                    if ($packages) {
                        $count = 0;
                        foreach ($packages as $key => $package) {
                      
                       $isUserPackage=isUserPackage($user_id,$package->package_id);
                       $isPackValid=isPackValid($user_id,$package->package_id);
                         $count++;
                            if (!$package->image) {
                                $package->image = "dummy-image.jpg";
                            }
                            ?>
                            <div class="col-md-4 text-center">
                                <div class="card panel-pricing mt-3">
                                    <!--<div class="card-header">-->
                                        <div class="grid_logo p-3 alert-warning"><img
                                                    src="<?php echo base_url() . 'assets/images/packages/' . $package->image; ?>"
                                                    alt="" style="height:200px; width:400px;"></div>
                                        <h4 class="alert alert-warning" style='margin:0'><?php echo $package->package_name; ?></h4>
                                    <!--</div>-->
                                    <!--<div class="card-body">-->
                                        <ul class="list-group text-center list-group-flush">
                                            <li class="list-group-item">Package Type : <?php echo $package->package_type; ?></li>
                                            <li class="list-group-item">Package Price :
                                                <?php
                                                if (strtolower($package->package_type) == 'free') {
                                                    echo '<i class="fa fa-inr" aria-hidden="true"></i>' . '00.00';
                                                } else {
                                                    echo '<i class="fa fa-inr" aria-hidden="true"></i> ' . $package->package_price;
                                                } ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong> <i class="fa fa-clock-o"></i> Duration : <?php echo $package->package_duration . ' Days'; ?></strong>
                                            </li>
                                            <li class="list-group-item">Total PCBT Test : <?php echo $package->total_cbt_test; ?></li>
                                            <!--<li class="list-group-item">Number of MCQS : <?php /*echo $package->mcq_in_cbt; */?></li>-->
                                            <li class="list-group-item">Frequency : <?php echo $package->frequency_of_cbt; ?></li>
                                        </ul>
                                    <!--</div>-->
                                    <div style="margin:20px;">
                    <?php 
    if(($isUserPackage && $isPackValid) || strtolower($package->package_type) == 'free'){?>
                          <a href="<?php echo base_url('my-quiz/' . $package->package_id); ?>"
                                   class="btn btn-success">Open Package </a>
                    <?php } else{?>
                       
                       <a href=""
               class="btn btn-success sub" data-packid="<?php echo $package->package_id;?>" data-amount="<?php echo $package->package_price;?>">SUBSCRIBE NOW</a>
                <?php }?>
                                    </div>
                                </div>
                            </div>

                        <?php }
                    } ?>
                </div>
                <div class="my-3 text-right mb-2">
                    <a href="#0" class="btn btn-primary mx-2"> <span> Back</span></a>
                    <a href="#0" class="btn btn-primary"> <span>Next</span> </a>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
   
var key='rzp_live_4uLIFVhbDTCVte';
var SITEURL = "<?php echo base_url() ?>";
  $('body').on('click', '.sub', function(e){
    var totalAmount = $(this).attr("data-amount");
    var product_id =  $(this).attr("data-packid");
     e.preventDefault();
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
  });
 
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
            url: SITEURL + 'User_questionire/paymentSuccess',
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