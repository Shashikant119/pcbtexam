<!DOCTYPE html>
<html lang="eng">
<head >
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Robots Please remove during Live-->
    <meta name="robots" content="nofollow, noindex">
    <!--Favicon-->
    <link rel="icon" href="img/fav.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>/assets/web/ques/img/logo.png">
    <!--Fonts/Icons CSS-->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700|Questrial&display=swap" rel="stylesheet">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/ques/css/bootstrap.min.css">
    <!--Main and Responsive CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/ques/sass/main.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/web/ques/css/responsive.css">
    <title>PCBT</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body onload="getallcntdataonload()" class="newquestd">
<div class="top__nav">
    <div class="container-fluid">
        <div class="top__nav-data">
            <h5>Mock link 2nd Stage CBT for ALP Technicians </h5>
            <span data-toggle="modal" data-target="#myinstruction" >Instructions</span>
        </div>
    </div>
</div>
<?php if( $this->session->flashdata('msg')) echo  $this->session->flashdata('msg');?>

<!-- Modal -->
<div class="modal fade" id="myinstruction" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Test Instruction</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                1    You have not visited the question yet.
                2   You have not answered the question.
                3   You have answered the question.
                4   You have NOT answered the question, but have marked the question for review.
                5   The question(s) "Answered and Marked for Review" will be considered for evaluation.
                The ‘Marked for Review’ status for a question simply indicates that you would like to look at that question again.
                You can click on the ">" arrow which appears to the left of question number box to minimise the question number box. This will enable you to view the question on a bigger area of the screen. To view the question number box again, you can click on "<" arrow which appears on the right side of the screen.
                You can click on  to navigate to the bottom and  to navigate to the top of the question area, without scrolling.
                The summary of number of questions answered, not answered, not visited, marked for review and answered and marked for review will be displayed above the question number box.
                C Answering a Question
                The questions will appear on the screen in serial order from question number 1 to 100, which can be answered one by one as given below:

                a. To select your answer, click on the button of one of the options
                b. To deselect your chosen answer, click on the button of the chosen option again or click on the Clear Response button
                c. To change your chosen answer, click on the button of option you want to choose.
                d. To save your answer, you MUST click on the Save & Next button.
                e. In case of doubt on the option marked for a question, the question can be marked for review by clicking Mark for Review & Next button. In case the marked option is not reviewed, the originally marked option shall be considered for evaluation.
                To change your answer to a question that has already been answered, first click on that question number from the question number box and follow the procedure for answering as mentioned at 1 above.
                D Instruction for enlarging images
                To view the image provided in the question in a bigger size, click on the image and rotate the scrolling wheel on the mouse
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="nav__big d-flex  border-nav">
    <div class="nav__big-left w-75">
        <div class="nav__two d-flex p-2 align-items-center" style="background-color: #eee">
            <div class="col-md-3 pull-right" style="background:#e4e4e4f0; border:#dcdcdc 2px solid;border-radius:5px;">
                <h3 class="text-danger "><b>&nbsp; Timer: <span id='timer'></span> </b></h3>
            </div>
        </div>

        <div class="nav__two d-flex p-2 ">

            <div class="nav__right d-flex ml-auto align-items-center">
                <a href="#" class="btn-arrow "> <i class="fa fa-caret-right" aria-hidden="true"></i></a>


            </div>
        </div>
    </div>
    <div class="nav__big-right d-flex ml-auto w-25 p-3 border-nav-left">
        <img class="w-20" src="<?php echo base_url();?>/assets/web/ques/images/user.jpg" alt="">
        <h3 class="p-3"><?php echo $user[0]->username;?> </h3>
    </div>
</div>


<div class="nav__big d-flex  border-nav overflow-hidden">
    <div class="nav__big-left pb-2 px-2 w-100">
        <div class="nav__two d-flex m-2 q-font">
            <div class="nav__left d-flex align-items-center">

            </div>
            <div class="nav__right d-flex ml-auto align-items-center pb-2">
                <div class="row text-center">
                    <div class="col-2 border-rr">
                        <div class="row">
                            <div class="col-12 p-0">
                                <p class="mb-0">Answered</p>
                                <br>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-green anserd">0</span>
                            </div>

                        </div>
                    </div>
                    <div class="col-4 border-rr">
                        <div class="row">
                            <div class="col-12 p-0">
                                <p class="mb-0 px-3">Answered & Marked for Review (will be considered for evaluation)</p>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-purple-2 ansandmarked">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 border-rr">
                        <div class="row">

                            <div class="col-12 p-0">
                                <p class="mb-0">Not Answered</p>
                                <br>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-orange notans">0</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-2 border-rr">
                        <div class="row">
                            <div class="col-12 p-0">
                                <p class="mb-0">Not answered & Marked for <br> Review</p>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-purple markrev">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row">
                            <div class="col-12 p-0">
                                <p class="mb-0 ">Not Visited</p>
                                <br>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-gray ntvisited">0</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="nav__two d-flex p-3 q-font align-items-center justify-content-end" style="background-color: #4e85c5 ">
            <div class="nav__left d-flex align-items-center mr-auto">
                <h3 style="color:#fff;">Question Type : <span>MCQ</span></h3>
            </div>

            <div class="nav__left d-flex ">
                <span class="mr-3" style="color:#fff;">View in:</span> <select class="choose_lang auditlogSelect" onchange="changeLang(this.value)"> <option selected="selected" value="1">English</option><option value="2">Hindi</option><option value="3">Marathi</option><option value="4">Tamil</option><option value="5">Punjabi</option><option value="6">Bengali</option><option value="8">Telugu</option><option value="9">Malayalam</option><option value="10">Assamese</option><option value="11">Gujrati</option><option value="13">Urdu</option><option value="17">kannada</option><option value="19">Odia</option><option value="22">Manipuri</option><option value="24">Konkani</option></select>
            </div>

        </div>
        <?php  $quest = $this->User_model->getquestiontodisplay();
        if($quest){
            ?>

            <div class="p-5 newquest">
                <h4><span class="quesnum">1)</span><?php echo $quest[0]->question;?></h4>
                <input  type="hidden" name="quesid" id="quesis" value="<?php echo $quest[0]->id;?>">
                <form action="#" class="form-question">
                    <div class="form-check form-check mb-3 d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option_1">
                        <label class="form-check-label" for="inlineRadio1"> <?php echo $quest[0]->option_1;?></label>
                    </div>
                    <div class="form-check form-check mb-3 d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option_2">
                        <label class="form-check-label" for="inlineRadio1"> <?php echo $quest[0]->option_2;?></label>
                    </div>
                    <div class="form-check form-check mb-3 d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option_3">
                        <label class="form-check-label" for="inlineRadio1"><?php echo $quest[0]->option_3;?></label>
                    </div>
                    <div class="form-check form-check mb-3 d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option_4">
                        <label class="form-check-label" for="inlineRadio2"> <?php echo $quest[0]->option_4;?></label>
                    </div>
                </form>
            </div>
        <?php } else { echo '<div class="alert alert-warning" >you have visited all question please submit your answer!! </div>';} ?>


    </div>
    <div class="nav__big-right d-flex ml-auto  w-25  px-3 border-nav-left toggle-right position-relative">
        <div class="navigation__right w-100">
            <div id="toggle_btn"><i class="fa fa-angle-left" aria-hidden="true"></i></div>

            <h4>Part A</h4>
            <?php  $questcnt=$this->User_model->getallquestiontodisplay();
            ?>
            <div class="scroll_area p-3">
                <h5>Choose a Questions</h5>
                <ul class="changeselection">
                    <?php
                    if($questcnt) { $im=0;
                        foreach ($questcnt as $key => $value) {
                            $im++;
                            if($value->questionattendent==0) { ?> <li><a href="#" onclick="changeques('<?php echo $value->id;?>');"><?php echo $im;?></a></li>
                                <?php
                            }
                            else if($value->questionattendent==4){ echo '<li><a href="#" class="q-marked" onclick="changeques('.$value->id.');">'.$im.'</a></li>';}
                            else if ($value->questionattendent==2){ echo '<li><a href="#" class="q-orange" onclick="changeques('.$value->id.');">'.$im.'</a></li>';}
                            else if ($value->questionattendent==3){ echo '<li><a href="#" class="q-green" onclick="changeques('.$value->id.');">'.$im.'</a></li>';}
                            else if ($value->questionattendent==1){ echo '<li><a href="#" class="answered q-marked" onclick="changeques('.$value->id.');">'.$im.'</a></li>';}
                        }
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="nav__big d-flex  overflow-hidden">
    <div class="nav__big-left  align-items-center  w-75">
        <div class="nav__two d-flex p-2 align-items-center pt-3">
            <div class="nav__left d-flex align-items-center">
                <a href="#" class="btn btn-default border-dark  mr-3 markandnextques">Mark for Review & Next</a>
                <a href="#" class="btn btn-default border-dark clearress ">Clear Response</a>
            </div>
            <div class="nav__right d-flex ml-auto">
                <a href="#" class="btn btn-primary mr-3 backdata">Save & Back</a>
                <a href="#" class="btn btn-primary  saveandnextques " >Save & Next</a>
            </div>
        </div>
    </div>
    <div class="nav__big-right d-flex ml-auto  w-25  p-3 border-nav-left justify-content-center submitres" style="background-color: #4e86c559">
        <a href="#" class="btn btn-primary ">Submit</a>
    </div>



</div>

<!-- Modal -->
<div class="modal fade" id="myModal"  role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="width:800px;height:300px;">
            <div class="modal-header">
                <h4 class="modal-title"><b>ATTNTION PLEASE</b><br>DEAR USER YOUR ATTEMPTING MCQs TEST SERIES ARE AS FOLLOWS:</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <b> <p><div class="nav__right d-flex ml-auto align-items-center pb-2">
                            <div class="row text-center">
                                <div class="col-2 border-rr">
                                    <div class="row">
                                        <div class="col-12 p-0">
                    <p class="mb-0">Answered</p>
                    <br>
            </div>
            <div class="col-12">
                <span class="answered answered-green anserd">0</span>
            </div>

        </div>
    </div>
    <div class="col-4 border-rr">
        <div class="row">
            <div class="col-12 p-0">
                <p class="mb-0 px-3">Answered & Marked for Review (will be considered for evaluation)</p>
            </div>
            <div class="col-12">
                <span class="answered answered-purple-2 ansandmarked">0</span>
            </div>
        </div>
    </div>
    <div class="col-2 border-rr">
        <div class="row">

            <div class="col-12 p-0">
                <p class="mb-0">Not Answered</p>
                <br>
            </div>
            <div class="col-12">
                <span class="answered answered-orange notans">0</span>
            </div>
        </div>
    </div>

    <div class="col-2 border-rr">
        <div class="row">
            <div class="col-12 p-0">
                <p class="mb-0">Not answored & Marked for <br> Review</p>
            </div>
            <div class="col-12">
                <span class="answered answered-purple markrev">0</span>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="row">
            <div class="col-12 p-0">
                <p class="mb-0 ">Not Visited</p>
                <br>
            </div>
            <div class="col-12">
                <span class="answered answered-gray ntvisited">0</span>
            </div>
        </div>
    </div>
</div>
</b>

</div>
<div class="modal-footer">
    ARE YOU SURE WANT TO SUBMIT PCBT TEST SERIES?
</div>  <div class=" submitresfinal pull-left" style="background-color: #4e86c559">
    <a href="#" class="btn btn-primary ">Submit</a>
</div>
<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    //TIMER SCRIPT
    <?php      $total_time=$this->session->userdata('duration');

    $total_time = $total_time*60;?>
    var c = <?php   echo  $total_time;?>;

    var t;
    timedCount();
    function timedCount() {
        var hours = parseInt( c / 3600 ) % 24;
        var minutes = parseInt( c / 60 ) % 60;
        var seconds = c % 60;

        var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);

        $('#timer').html(result);
        /*    if(c == 0 ){
                setConfirmUnload(false);
                //alert('Thank you for attemt your Test.');
                // Save test counter by ajax code
                $.ajax({
                    url:'save_test_counter.php',
                    data:{counsId:counsId},
                    success:function(data)
                    {
                         $("#practice_form").submit();
                    }
                })

            }*/
        c = c - 1;
        t = setTimeout(function(){ timedCount() }, 1000);
    }
</script>
<script type="text/javascript">

    function changeques(dataid) {
        event.preventDefault();
        var user_name = $("#quesis").val();
        var ele= $('input[name=inlineRadioOptions]:checked').val();
        $.ajax({
            url:'<?php echo base_url();?>/changequestionbyquesid',
            type: 'POST',
            data: {id: user_name,ansopt:ele,dataid:dataid},
            success: function(data1){

                $(".newquest").html(data1);
                mycountdata();
                getallcntdata();
            }
        });
    }


    $(".saveandnextques").click(function(event) {
        event.preventDefault();
        var user_name = $("#quesis").val();
        var ele= $('input[name=inlineRadioOptions]:checked').val();

        $.ajax({
            url:'<?php echo base_url();?>/changequestion',
            type: 'POST',
            data: {id: user_name,ansopt:ele},
            success: function(data1){

                $(".newquest").html(data1);
                mycountdata();
                getallcntdata();
            }
        });
    });

    $(".backdata").click(function(event) {

        event.preventDefault();

        var user_name = $("#quesis").val();
        var ele= $('input[name=inlineRadioOptions]:checked').val();

        $.ajax({
            url:'<?php echo base_url();?>/changequestionback',
            type: 'POST',
            data: {id: user_name,ansopt:ele},
            success: function(data1){

                $(".newquest").html(data1);
                mycountdata();
                getallcntdata();
            }
        });
    });


    $(".clearress").click(function(event) {
        $('input[name="inlineRadioOptions"]').prop('checked', false);
    });

    $(".submitresfinal").click(function(event)
    {
        var gg=confirm("Are you sure want to submit form");
        if(gg==true)
        {
            $.ajax({
                url:'<?php echo base_url();?>/finalsubmitform',
                type: 'POST',
                data: {},
                success: function(data1)
                {

                    $(".newquestd").html(data1);
                    $('#myModal').modal('hide');
                    mycountdata();
                    getallcntdata();
                }
            });
        }
    });

    $(".submitres").click(function(event) {
        $('#myModal').modal('show');
    });



    $(".markandnextques").click(function(event) {
        event.preventDefault();
        var user_name = $("#quesis").val();
        var ele= $('input[name=inlineRadioOptions]:checked').val();
        $.ajax({
            url:'<?php echo base_url();?>/changequestionandmark',
            type: 'POST',
            data: {id: user_name,ansopt:ele},
            success: function(data1){

                $(".newquest").html(data1);
                mycountdata();
                getallcntdata();
            }
        });
    });


    function getallcntdataonload() {
        $.ajax({
            url:'<?php echo base_url();?>getallcntdata',
            type: 'POST',
            data: {id:'1'},
            success: function(data1)
            {
                var obj = JSON.parse(data1);
                var ntbisit=obj.notvisited-1;
                var ntbians=obj.notans+1;

                $(".anserd").html(obj.answred);
                $(".markrev").html(obj.markedforreview);
                $(".notans").html(ntbians);
                $(".ntvisited").html(ntbisit);
                $(".ansandmarked").html(obj.ansmarkedforreview);
            }
        });

    }
    function getallcntdata() {

        $.ajax({
            url:'<?php echo base_url();?>getallcntdata',
            type: 'POST',
            data: {id:'1'},
            success: function(data1)
            {
                var obj = JSON.parse(data1);
                $(".anserd").html(obj.answred);
                $(".markrev").html(obj.markedforreview);
                $(".notans").html(obj.notans);
                $(".ntvisited").html(obj.notvisited);
                $(".ansandmarked").html(obj.ansmarkedforreview);
            }
        });
    }

    function mycountdata() {
        $.ajax({
            url:'<?php echo base_url();?>/changequestioncnt',
            type: 'POST',
            data: {id:'1'},
            success: function(data1)
            {
                $(".changeselection").html(data1);
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("div").mousemove(function(event) {
            var user_name = $("#quesis").val();
            $.ajax({
                url:'<?php echo base_url();?>/getquestionnumber',
                type: 'POST',
                data: {id: user_name},
                success: function(data1){

                    $(".quesnum").html(data1);

                }
            });
        });

        window.setInterval(function(){
            var user_name = $("#quesis").val();
            $.ajax({
                url:'<?php echo base_url();?>/getquestionnumber',
                type: 'POST',
                data: {id: user_name},
                success: function(data1){
                    $(".quesnum").html(data1);
                }
            });
        }, 192);
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        //Disable cut copy paste
        $('body').bind('cut copy paste', function (e) {
            e.preventDefault();
        });
        //Disable mouse right click
        $("body").on("contextmenu",function(e){
            return false;
        });
    });
    document.onkeydown = function (e) {
        e.preventDefault();
    }
</script>
<script src="<?php echo base_url();?>/assets/web/ques/js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url();?>/assets/web/ques/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>/assets/web/ques/js/main.js"></script>
</body>

</html>