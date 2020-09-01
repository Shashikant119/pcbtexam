<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

<body>
    <form id="msform">
        <fieldset>
            <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/logo.png" alt="logo">
            <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/oncquest.png" alt="logo">
            <hr/>

            <h2 class="fs-title first-heading" style="font-weight:900"><span class="heading-span">Keep It Up</span><span>Marks Obtained : <?php echo $marks; ?> </span></h2>
            <hr>

            <div class="total-question">
                <table style="width:100%">
                    <tr>
                        <td>Total Question Attempted</td>
                        <td><?php echo $attmpted; ?></td>
                    </tr>
                    <tr>
                        <td>Correct Answers</td>
                        <td><?php echo $correct_ans; ?></td>
                    </tr>
                    <tr>
                        <td>Incorrect Correct Answers</td>
                        <td><?php echo ($attmpted - $correct_ans); ?></td>

                    </tr>
                </table>
                <br>
            </div>
           <div style="text-align:right">
            <center>
                <a href="<?php echo base_url() ?>get-result/<?php echo md5($result_link); ?>" class="btn-green" style="text-decoration: none;">Extract Your Answer Sheet</a>
            </center>
            
            <a target="_blank" href="https://www.oncquest.net/about-us/an-overview/"  class="btn-green second-heading" style="text-decoration: none;">Know About Oncquest</a> </div>
            
            <br/>

            <h3 class="second-heading"><span>Topper of the month : <?php echo date('F', strtotime('-1 months')) . '-' . date('Y', strtotime('-1 months')); ?> </span></h3>
            <div class="owl-carousel owl-theme">
                <?php
                    if(count($month_toppers)) {
                        foreach($month_toppers as $topper) {
                            echo '<div class="item">
                                     <h4>'. $topper['name'] .' ('. $topper['zone'] .')</h4>
                                  </div>';
                        }      
                    } else {
                        echo '<div class="item">
                                 <h4>No toppers found.</h4>
                              </div>';
                    }
                ?>
                <!--
                <div class="item">
                    <h4>Jyoti (North Zone)</h4>
                </div>
                <div class="item">
                    <h4>Arti (West Zone)</h4>
                </div>
                <div class="item">
                    <h4>Rahul (North Zone)</h4>
                </div>
                <div class="item">
                    <h4>Subha (East Zone)</h4>
                </div>
                <div class="item">
                    <h4>RJ (South Zone)</h4>
                </div>
                -->
            </div>
        </fieldset>
    </form>

<?php $this->load->view('footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $(document).ready(function() {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items: 2,
            loop: true,
            margin: 10,
            autoplay: true,
            nav: true,
            dots: false,
            autoplayTimeout: 5000,
            autoplayHoverPause: true
        });
    });
</script>
</body>
</html>