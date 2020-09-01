<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>


<div class="jumbotron text-center" style="background:white">
  <h1 class="display-3">
<?php if(isset($error)){?>
  	<i class="glyphicon glyphicon-remove" style="color: #f8fff8;
    padding: 16px;
    border-radius: 50%;
    background: #c2321b;"></i>
<?php } if(isset($msg)){?>
<i class="glyphicon glyphicon-ok" style="color: #f8fff8;
    padding: 16px;
    border-radius: 50%;
    background: #6bc21b;"></i>

<?php }?>
</h1>
  <p class="lead"><strong><?php echo (isset($msg))?$msg:$error;?></p>
 
  
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="<?php echo base_url('index.php/packages');?>" role="button">Go Back</a>
  </p>
</div>
</body>
</html>