<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('header'); ?>
<body>

<form id="msform" action="" method="">
    <fieldset>
        <img class="brand-logo" src="<?php echo base_url(); ?>step-assets/images/logo.png" alt="logo">
        <hr>
        <h2 class="fs-title">Sign In</h2>
        <center><span style="color: red;" id="error-area"></span></center>
        <hr>
        <div class="form-group text-left">
            <label for="exampleInputEmail1">Email :</label>
            <input type="email" class="form-control" id="username" aria-describedby="username" placeholder="youremail@oncquiest.com" name="username" onfocus="clearError();">
            <small class="form-text text-muted">
                (Registered with Oncquest)
            </small><br/><br/>
            <p class="form-text text-muted" style="color: green;" id="got-user"></p>
        </div>

        <div class="form-group text-left" id="otp-section" style="display: none;">
            <label for="otp-number">OTP Number :</label>
            <input type="text" class="form-control" id="otp-number" aria-describedby="otp-number" placeholder="OTP Number" name="otp_number" onfocus="clearError();" maxlength="6">
            <small class="form-text text-muted">We’hv sent an <strong> OTP</strong> to
                <span id="sent-on"></span> 
                <a href="#">Resend OTP</a>
            </small>
        </div> 

        <input type="button" id="btn-login" class="action-button" value="Submit" />
        <input type="button" id="btn-otp-submit" class="action-button" value="Submit" style="display: none;" />

        <p><small style="font-size: 12px;">Difficulty in Sign In? <a href="#">Click here</a></small></p>
    </fieldset>
</form>

<?php $this->load->view('footer'); ?>
<script type="text/javascript">
$( document ).ready(function() {

    $("#btn-login").click(function(){

        let username = $("#username").val();
        if(username != '' && username != null) {
            $.ajax({
                url: 'http://localhost/qms/' + 'exist-user',
                crossDomain: true,
                async: false,
                type: 'post',
                data: {"username": username},
              /*  beforeSend: function() {
                    $("#btn-login").val('Sending...');
                    $("#btn-login").prop('disabled', true);
                },*/
                success: function(data) {
                    alert(data);
                    resObj = JSON.parse(data);
                    if(resObj.status == '1') {
                        $("#username").attr('readonly', true);
                        $("#got-user").html('We found you <strong style="font-weight: bold;">' + resObj.res + '</strong>');
                        $("#sent-on").html(resObj.otp_sent);
                        $("#otp-section").show();
                        $("#btn-login").hide();
                        $("#btn-otp-submit").show();
                    } else {
                        $("#error-area").html(resObj.res);
                    }
                    $("#btn-login").prop('disabled', false);
                    $("#btn-login").val('Submit');
                },
                complete: function() {
                    $("#btn-login").prop('disabled', false);
                    $("#btn-login").val('Submit');
                }
            });
        } else {
            $("#error-area").html('Please enter your email registered with Oncquest');
        }
    });

    $("#btn-otp-submit").click(function(){
        let username = $("#username").val();
        let otpNumber = $("#otp-number").val();
        if(username != '' && otpNumber != '') {
            $.ajax({
                url: 'http://localhost/qms/' + 'verify-otp',
                crossDomain: true,
                async: false,
                type: 'post',
                data: {"username": username, "otp" : otpNumber},
                beforeSend: function() {
                    $("#btn-otp-submit").val('Sending...');
                    $("#btn-otp-submit").prop('disabled', true);
                },
                success: function(data) {
                    resObj = JSON.parse(data);
                    if(resObj.status == '1') {
                        window.location.href = resObj.redirect;
                    } else {
                        $("#error-area").html(resObj.res);
                    }
                    $("#btn-otp-submit").prop('disabled', false);
                    $("#btn-otp-submit").val('Submit');
                },
                complete: function() {
                    $("#btn-otp-submit").prop('disabled', false);
                    $("#btn-otp-submit").val('Submit');
                }
            });
        } else {
            $("#error-area").html('Please enter OTP');
        }
    });

});

function clearError() {
    $("#error-area").html('');
}
</script>>

</body>
</html>