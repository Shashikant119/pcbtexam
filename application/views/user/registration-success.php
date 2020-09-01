<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
    .hv:hover{
        background:#0fad00;
        color:white;
    }
</style>
<div class="container" style='font-weight: bold;font-family:raleway;
'><br><br>
<div class="row " style='text-align:left'>
    <div class="col-sm-12" style="padding: 27px;
    padding-top: 0px;
    padding-bottom: 69px;
    margin:auto;">
    
    
    <div class="card card-bordered">
        
        <div class="card-body" style='padding-left: 15%;padding-bottom: 20px;
        border-radius: 100px;border:2px solid #0fad00;padding-top:20px;'>
        <h2 style="
        color: #0fad00;text-align:left;padding-left:20%;
        ">Dear User , Registration Success!</h2>
        <hr style="background:#0fad00;height:3px;width:435px;margin-top:0;padding-left:20%">

        <p style="font-size:15px;color:#5C5C5C;margin-left: 5%;">THANK YOU FOR REGISTRATION AT InnoKnova Exam Portal YOUR REGISTRATION DETAILS HAS BEEN SUBMITTED SUCCESSFULLY.</p>
        <p style="font-size:15px;color:#5C5C5C;text-align: left;
        ">Your Login Credential Details (Control Panel) are As Below - </p>
        <p style="font-size: 16px;
        font-weight: bold;margin-left: 24%;"><span style='color:#1c19fa;'>&nbsp;&nbsp;&nbsp;&nbsp;User Id</span> &nbsp;&nbsp;&nbsp;&nbsp;: <strong style="color:red"><?php echo $username; ?></strong></p>
        <p style="font-size: 16px;
        font-weight: bold;margin-left: 24%;"><span style='color:#1c19fa;'>Password &nbsp;&nbsp;&nbsp;&nbsp;: </span><strong style='color:red'><?php echo $password; ?></strong></p>
        <p style="font-size:15px;color:#5C5C5C;text-align: left;
        ">Note - It's Only One Time Registration Process. So Please, Save Above Details.A Separate Email Also Sent To Your Registered Email Id</p>
                   <!--  <p style="font-size:15px;color:#5C5C5C;text-align: left;
                    margin-left: 5%;"> and A Text SMS To Your Mobile No. For Future Reference.</p> -->
                    <br><br>
                    <div style='padding-left:25%'>   <a href="<?php echo base_url(); ?>" class="btn btn-success hv" style='background: #ffc107;
                    font-size: 16px;
                    padding-left: 50px;
                    padding-right: 50px;
                    color: white;
                    font-weight: bold;
                    border-radius: 9px;'> Click Here For Login Panel </a></div>
                </div>
            </div>
        </div>
    </div>
</div>