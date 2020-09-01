

    
    <script src="<?php echo base_url(); ?>/assets/web/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/web/js/owl.carousel.min.js"></script>

    <script src="<?php echo base_url(); ?>/assets/web/js/main.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
     <script src="<?=base_url();?>assets/js/simple-rating.js"></script>
      <script src="<?php echo base_url();?>assets/share/jquery.floating-social-share.min.js"></script>
      

    <script>
     
  $( function() {
        $("body").floatingSocialShare({
             buttons: [
      "facebook", "linkedin", "pinterest", "reddit", 
      "telegram", "tumblr", "twitter", "viber", "vk", "whatsapp"
    ],
    text: "share with: ",
        });

    $('.rating').rating();

   
  } );
  </script>

</body>
</html>