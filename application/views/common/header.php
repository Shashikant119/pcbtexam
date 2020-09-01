<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRATAP'S CBT EXAM PORTAL</title>
    <!--Favicon-->
    <link rel="icon" href="<?php echo base_url();?>/assets/web/images/fav.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>/assets/web/images/fav.png">
    <!--Fonts/Icons CSS-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/bootstrap.min.css">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
    <!--Owl slider CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/owl.carousel.min.css">
    <!--Main and Responsive CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/main.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/style.css?v=1.2">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/share/jquery.floating-social-share.min.css">
     <script src="<?php echo base_url(); ?>/assets/web/js/jquery-3.4.1.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
    .logo-text{
    font-size: 32px ; text-align: center; color: #f5a540;line-height: 100px;
}
    @media screen and (max-width: 690px) {
  .logo-text {
   font-size: 20px;
   line-height: 10px;
  }
  .center{
    text-align:center;
  }
}
.heading-title{
    font-family: fantasy;
    font-size: 38px !important;
   text-align: center; color:#00b8ff;
    margin-left: 65px; margin-right: 50px
}
.c a{
    color:white;font-size: 14px;
}
.c{
    text-align:center;
}
.share_social li a .fa-facebook {
    background: #0e7bc7;
    display: block;
     }
.share_social li a .fa-twitter {
    background: #00c3ff;
    display: block;
}
.share_social li a .fa-instagram {
    background: #ff009d;
    display: block;
}
 .share_social li a .fa {
    width: 50px;
    height: 50px;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    line-height: 50px;
    font-size: 18px;
}
.share_social{
    list-style:none;position:fixed;left:0;left: 0;
    padding: 0;
    top: 276px;
    z-index: 9;
}
@media screen and (max-width: 800px) {
  .c {
    text-align:center!Important;
  }
  .heading-title{
    font-family: fantasy;
   text-align: center;
    margin: 0;
    color:#00b8ff;
   
}
}
.dropdown-menu li a {
    color:black!important;
}
.wt{
     position: fixed;
    right: 0px;
   
    top: 50%;
    font-size: 26px;
    text-align: center;
    color: white;
    z-index: 9999999;
    -ms-transform: translateY( -50%);
  transform: translateY( -50%);
}
.wt p{
    margin:0;
}
.wt .phoneMe{
    background:black;color:white;padding:5px;width: 51px;
}
.wt .whatsa{
    background:#50d550;color:white;padding:5px;width: 51px;
}
</style>
<noscript>
    <style>
        body{
            display:none!important;
        }
    </style>
</noscript>
</head>

<body style='position:relative'>
   
  <div class="wt">
  <p><a href="tel:+919828474951" class="phoneMe"><i class="fa fa-phone"></i></a></p>
  <p><a href="https://api.whatsapp.com/send?phone=919828474951" class="whatsa "><i class="fa fa-whatsapp"></i></a></p>
  </div>
<div class="nav__bar">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-4 c">
                    <a href="#0">For Any Queries , Call/W SMS @9828474951</a>
           </div>
            <div class="col-md-4 c" style="text-align:right">
                 <a href="#0"><i class="fa fa-envelope-o" aria-hidden="true"></i> pcbtsamiksha@gmail.com</a>
            </div>
             <div class="col-md-4 c" style="text-align:right">
                  <a href="#0"><i class="fa fa-map-marker" aria-hidden="true"></i> Lucknow,Uttar Pradesh-226005</a>
             </div>
             
       </div>
    </div>
</div>
<div class="rambow"></div>
<div class="top__nav">

    <div class="container-fluid">
        <div class='row'>
            <div class='col-md-2 text-center'>
                <a class="navbar-brand" href="">
                    <img width="100" src="<?php echo base_url();?>assets/web/images/logo-new.jpg" alt="">
                </a>
            </div>
            <div class='col-md-8 text-center'>
         <a href="" class="navbar-text" style="margin-top: 29px;">
                    <strong class='heading-title'>PRATAP'S CBT ONLINE EXAM PORTAL - PHASE-IV</strong>
                </a>

            </div>
            <div class='col-md-2 text-center'>
                   <div class='row'>
                      <div class='col-md-12 center ' style="padding-top: 18px;">
                           <a href="<?php echo base_url('show-bulk-payment'); ?>" style='padding: 15px;
    font-size: 14px;
    padding-right: 19px;' class="btn btn-primary text-uppercase mt-1">
                            <i style="font-size:21px;"class='fa fa-credit-card'></i>
                        &nbsp;Bulk Payment</a>
                      </div>
                      <div class='col-md-12 text-center'>
                           <a href="<?php echo base_url('user-profile'); ?>" style="padding: 12px;
    padding-right: 37px;" class="btn btn-primary text-uppercase text-center mt-1"><span>&nbsp;<img src="<?php echo base_url();?>/assets/web/images/user.png" alt="">&nbsp; <?php echo $user->username;?></span></a>

                      </div>
                  </div>
            </div>


        </div>
        
        
        
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto w-100 justify-content-between text-uppercase font-weight-bold">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo base_url('index.php/user-profile');?>">My Profile
                        <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('index.php/packages');?>">Packages Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('index.php/my-packages');?>">My Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('my-progress');?>">My Progress</a>
                </li>
                 
                <li class="dropdown nav-item">
        <a style="margin-top: 7px;
    color: black;"  class="dropdown-toggle" data-toggle="dropdown" href="#">Appreciation
        <span class="caret"></span></a>
        <ul class="dropdown-menu" style="width: 181px;
    
    padding: 10px;background: orange;">
          <li><a href="<?=base_url();?>appreciation-list">Appreciation List</a><hr></li>
          <li><a href="<?=base_url();?>appreciation">New Appreciation</a></li>
         
        </ul>
      </li>
                <!--<li class="nav-item">
                    <a class="nav-link" href="<?php /*echo base_url('user_questionire/instruction');*/?>">Test</a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('user-payment');?>">Payment History</a>
                </li>
                <li class="nav-item">
            <?php 
            $logoutLink=base_url('user-logout');
           

            ?>
                    <a class="nav-link" href="<?php echo $logoutLink;?>">Log Out</a>
                </li>
            </ul>
        </div>
    </div>

   
</nav>
 <?php if($this->session->userdata('loginid'))
{
  
    $uid=$this->session->userdata('loginid');
    $q=$this->db->get_where('qms_users',['user_id'=>$uid])->row();
    $email=$q->email;
    $phone=$q->mobile;
    $dob=$q->dob;
    $address=$q->address;
    if(empty($phone) || empty($address))
    {
        $str='<div class="container" style="margin:10px;">
              <div class="row"><div class="col-md-12">
                   <center><div class="alert alert-danger">
             Your Profile is incomeplete ,Please Complete Your profile     
           </div></center></div></div></div>';
        echo $str;
    }

}
?>