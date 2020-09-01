<?php  defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>QUIZ | Login</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h3 class="login-head">QUIZ Admin Login</h3>
      </div>
      <div class="login-box">
        <form class="login-form" action="<?php echo base_url();?>admin-login" method="POST">
          <center><img src="<?php echo base_url(); ?>assets/images/oncquest.png" alt="ONCQUEST"></center>
      	  <hr/>
      	  <center><?php if(!empty($error_msg)) echo '<span style="color: red">'. $error_msg .'</span>'; ?></center>
          <div class="form-group">
            <label class="control-label">Username :</label>
            <input class="form-control" type="text" placeholder="Username" name="username" minlength="5" maxlength="30" required="" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">Password :</label>
            <input class="form-control" type="password" name="password" maxlength="15" minlength="5" placeholder="Password" required="">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="btn_login"><i class="fa fa-sign-in fa-lg fa-fw"></i>Submit</button>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>