<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="robots" content="nofollow, noindex">
    <!--Favicon-->
    <link rel="icon" href="img/fav.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>/assets/web/ques/img/logo.png">
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700|Questrial&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/web/ques/sass/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/web/ques/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/magnific-popup.css">
    
    <title>PCBT</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <style>
    @font-face {
	font-family: 'k010';
	src: url('<?php echo base_url(); ?>/assets/fonts/k010.eot');
	src: local('k010'), url('<?php echo base_url(); ?>/assets/fonts/k010.woff') format('woff'), url('<?php echo base_url(); ?>/assets/fonts/k010.ttf') format('truetype');
     }
    video{
        height:100%!important;
    }
    .white-popup {
  position: relative;
  background: #FFF;
  padding: 20px;
  width: auto;
  max-width: 500px;
  margin: 20px auto;
}
     .unselectable { 
      -webkit-user-select: none; 
      -webkit-touch-callout: none; 
      -moz-user-select: none; 
      -ms-user-select: none; 
      user-select: none;    
     
  }
  
        .form-check-input {
            margin-top: -1px !important;
        }
        .ans-and-marked-li {
            background-position: -65px -176px !important;
        }
        .heading-title{
           text-align: center;
    margin-top: 19px;
    font-size: 39px;
    font-family: fantasy;
    color: #034649;
    text-shadow: 1px 5px #f4c621;
    -moz-text-shadow: 1px 5px #f4c621;
    -webkit-text-shadow: 1px 5px #f4c621;
}


        }
        .goog-logo-link {
   visibility:hidden !important;
} 

.goog-te-gadget{
   color: transparent !important;
}
.goog-tooltip {
    display: none !important;
}
.goog-tooltip:hover {
    display: none !important;
}
.goog-text-highlight {
    background-color: transparent !important;
    border: none !important; 
    box-shadow: none !important;
}
.form-question p img{
    width:80px!important;
    height:60px!important;
}
    </style>

</head>

<body class="unselectable">
    
<div class="top__nav1 unselectable" style='padding:10px;background: #b4dcf3;'>
    <div class="container-fluid">
        <div class="row">
             <div class="col-md-1">
                 <a class="navbar-brand" href="">
                    <img width="150" height='80' src="<?=base_url();?>assets/images/tr_logo.png" alt="">
                </a>
             </div>
             <div class="col-md-11">
                 <h1 class="heading-title">PRATAP'S CBT ONLINE EXAM PORTAL - PHASE-IV, LUCKNOW, UP-226005</h1>
             </div>
        </div>
    </div>
</div>

<div class="top__nav" style="height:40px;padding-top: 10px;">
    <div class="container-fluid">
        <div class="row">
             <div class="col-md-3 text-center">
                 <h4>PACKAGE - <?php echo $package->package_name; ?>
                  </h4>
             </div>
             <div class="col-md-3 text-center">
                 <h4>EXAM NAME - <?php echo $quiz->quiz_title; ?></h4>
             </div>
              <div class="col-md-3 text-center">
                 <button style='margin: 0;
    outline: 0;
    border: 0;
    color: white;
    font-weight: bold;
    font-size: 14px;
    background:#ef2f2feb;' type='button' data-toggle="modal" data-target="#all-question-list">QUESTION LIST</button>
             </div>
            
            <div class="col-md-3 text-center">
                <div class="row">
                    <div class="col-md-6" style="text-align:right">
                        <h3>View in:</h3>
                    </div>
                    <div class="col-md-6">
                         <div id="google_translate_element"></div>
                    </div>
                </div>
              
               </div>
        </div>
    </div>
</div>
<?php if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); ?>

<!-- Modal -->
<div class="modal fade" id="all-question-list" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">All Question in this Quiz</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php
                    $i = 1;
                    foreach ($questions as $row) {
                ?>
                <div>
                    <p style="font-size: 13px"><strong><?php echo $i; ?></strong> ) <?php echo $row->question; ?></p>
                </div>
                <?php
                        $i++;
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $questionStatus = $this->OnlineExam->getAllQuestionStatus();
                $not_visited = 0;
                $marked_for_review = 0;
                $not_answered = 0;
                $answered = 0;
                $answered_and_marked_for_review = 0;

                foreach ($questionStatus as $key => $value) {
                    if ($value->question_status == 0) {
                        $not_visited++;
                    } else if ($value->question_status == 4) {
                        $marked_for_review++;
                    } else if ($value->question_status == 2) {
                        $not_answered++;
                    } else if ($value->question_status == 3) {
                        $answered++;
                    } else if ($value->question_status == 1) {
                        $answered_and_marked_for_review++;
                    }
                }
                ?>


<?php
    $current_question = !empty($this->session->userdata('current_question')) ? $this->session->userdata('current_question') : 0;
    if($current_question) {
        $question = $this->OnlineExam->getQuestionById($current_question);
    } else {
        $question = $this->OnlineExam->getTestQuestion($this->session->userdata('offset'), $current_question);
    }
?>
<div class="nav__big d-flex  border-nav" style="height:97px;border-bottom: 5px solid black;">
    <div class="nav__big-left w-100" style='padding: 16px;'>
        
         <div class="row text-center">
                    <div class="col-1 border-rr">
                        <div class="row">
                            <div class="col-12 p-0">
                                <p class="mb-0">Answered</p>
                                <br>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-green anserd"><?php echo $answered; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 border-rr">
                        <div class="row">
                            <div class="col-12 p-0">
                                <p class="mb-0 px-3">Answered & Marked for Review<br>(will be considered for evaluation)</p>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-purple-2 ansandmarked ans-and-marked"><?php echo $answered_and_marked_for_review; ?></span>
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
                                <span class="answered answered-orange notans"><?php echo $not_answered; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-3 border-rr">
                        <div class="row">
                            <div class="col-12 p-0">
                                <p class="mb-0">Not answered & Marked for Review</p>
                                <br>
                            </div>
                            <div class="col-12">
                                <span class="answered answered-purple markrev"><?php echo $marked_for_review; ?></span>
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
                                <span class="answered answered-gray ntvisited"><?php echo $not_visited; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    <div class="nav__big-right d-flex ml-auto w-25 p-3 border-nav-left position-relative">
       <!-- <img class="w-20" src="<?php echo base_url(); ?>/assets/web/ques/images/user.jpg" alt="">-->

        <div>
            <h3 class="p-2" style='font-size:17px;'>
<i class="fa fa-user-circle-o" style='font-size:22px;'></i>&nbsp;&nbsp;
                <?php echo $user->username; ?> </h3>
           
            
            <span class="" style="font-size: 15px">
                <b>&nbsp;<i class="fa fa-clock-o" style='font-size:24px;'></i>&nbsp;&nbsp; <span id='timer'></span> </b>
                 <b>&nbsp;<i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo date("d M Y");?> </b>
            </span>
            <br>
           
        </div>
    </div>
</div>
<div class="nav__big d-flex  border-nav overflow-hidden" style='max-height:315px;'>
    <div class="nav__big-left pb-2 px-2 w-100" >
       
        <?php
        if ($question) {
            $this->session->set_userdata('current_question', $question->id);
            ?>
            <div class="p-5 show_question" >
                <h4 style="margin-bottom: 10px;font-family:<?=($question->lang=='hi')?'k010!important':'inherit';?>"><span class="quesnum"><?php echo $this->session->userdata('offset') + 1; ?> ) </span><?php echo $question->question; ?></h4>
                <?php 
                $str='';
               if($question->video_url)
                {
                    $str=base_url()."uploads/video/".$question->video_url;
                   echo '<div class="white-popup mfp-hide" id="video"><video width="98%" height="100%" controls>
                          <source src="'.$str.'" type="video/mp4">
                        
                        Your browser does not support the video tag.
                        </video></div>';
                    echo '<a class="video-link" href="#video">Open Video</a><br>';
                }
               elseif($question->audio_url)
               {
                   $str=base_url()."uploads/audio/".$question->audio_url;
                   echo '<audio controls>
                               <source src="'.$str.'" type="audio/mpeg">
                            Your browser does not support the audio element.
                            </audio><br>';
               }
               elseif($question->image_url){
                   $str=base_url()."uploads/image/".$question->image_url;

                   echo '<a class="image-link" href="'.$str.'">Open Image</a><br>';
               }

             ?>
                <input type="hidden" name="question_id" id="question_id" value="<?php echo $question->id; ?>">
                <input type="hidden" name="offset" id="offset" value="<?php echo $this->session->userdata('offset'); ?>">
                <form action="#" class="form-question" style="    font-size: 15px;">
                  <p>A)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_1" name="inlineRadioOptions" value="option_1">&nbsp;&nbsp;<?php echo $question->option_1; ?>
                     <?php  if($question->option_1_url){
                       $str=base_url()."uploads/options/".$question->option_1_url;
    
                       echo '&nbsp;&nbsp;<a class="option_1_url" href="'.$str.'">Open Image</a><br>';
                   }?>
                  
                  </p>
                  <p>  B)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_2" name="inlineRadioOptions" value="option_2">&nbsp;&nbsp;<?php echo $question->option_2; ?>
                  <?php  if($question->option_2_url){
                       $str=base_url()."uploads/options/".$question->option_2_url;
    
                       echo '&nbsp;&nbsp;<a class="option_2_url" href="'.$str.'">Open Image</a><br>';
                   }?></p>
                  <p> 
                    C)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_3" name="inlineRadioOptions" value="option_3">&nbsp;&nbsp;<?php echo $question->option_3; ?>
                    <?php  if($question->option_3_url){
                       $str=base_url()."uploads/options/".$question->option_3_url;
    
                       echo '&nbsp;&nbsp;<a class="option_3_url" href="'.$str.'">Open Image</a><br>';
                   }?>
                    <br></p> 
                    <p> D)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_4" name="inlineRadioOptions" value="option_4">&nbsp;&nbsp;<?php echo $question->option_4; ?>
                    <?php  if($question->option_4_url){
                       $str=base_url()."uploads/options/".$question->option_4_url;
    
                       echo '&nbsp;&nbsp;<a class="option_4_url" href="'.$str.'">Open Image</a><br>';
                   }?>
                   </p> 
                    
                </form>
            </div>
        <?php } else {
            echo '<div class="alert alert-warning" >you have visited all question please submit your answer!! </div>';
        } ?>
    </div>
  
    <div class="nav__big-right d-flex ml-auto w-25 px-3 border-nav-left toggle-right position-relative" >
        <div class="navigation__right w-100">
            <div id="toggle_btn" style='top:20%'><i class="fa fa-angle-left" aria-hidden="true"></i></div>
          <!---  <h4 style="height: 43px;padding-top: 5px;">Choose A Question</h4>-->
            <div class="scroll_area p-3" >
                <ul class="change_selection" >
                    <?php
                    if ($questionStatus) {
                       //echo "<pre>";print_r($questionStatus);die;
                        $im = 0;
                        $str='';
                        foreach ($questionStatus as $key => $value) {
                            $im++;
                           
                            if ($value->question_status == 0 ) { ?>
                                <li id="qli-<?php echo $im - 1; ?>"><a href="#"  onclick="change_question('<?php echo $value->id; ?>', '<?php echo $im - 1; ?>');"><?php echo $im; ?></a></li>
                                <?php
                            } else if ($value->question_status == 4) {
                                echo '<li id="qli-'. ($im - 1). '"><a href="#" class="q-marked" onclick="change_question(' . $value->id . ', '. ($im - 1) .');">' . $im . '</a></li>';
                            } else if ($value->question_status == 2) {
                                echo '<li id="qli-'. ($im - 1). '"><a href="#"  class="q-orange" onclick="change_question(' . $value->id . ', '. ($im - 1) .');">' . $im . '</a></li>';
                            } else if ($value->question_status == 3) {
                                echo '<li id="qli-'. ($im - 1). '"><a href="#" class="q-green" onclick="change_question(' . $value->id . ', '. ($im - 1) .');">' . $im . '</a></li>';
                            } else if ($value->question_status == 1) {
                                echo '<li id="qli-'. ($im - 1). '"><a href="#" class="answered answered-purple-2 ansandmarked ans-and-marked-li" onclick="change_question(' . $value->id . ', '. ($im - 1) .');">' . $im . '</a></li>';
                            }
                        }
                    } ?>
                </ul><br><br><br><br><br><br><br><br>
            </div>
        </div>
    </div>
</div>

<div class="nav__big d-flex  overflow-hidden" >
    <div class="nav__big-left align-items-center  w-100">
        <div class="nav__two d-flex p-2 align-items-center pt-3" style='background:orange'>
            <div class="nav__left d-flex align-items-center">
                <a href="#" class="btn btn-default border-dark  mr-3 mark-for-review-and-next" style="background: #714f91 !important; color: #fff; border-color: #714f91 !important;">Mark for Review & Next</a>
                <a href="javascript:void(0)" class="btn btn-default border-dark clearress" style="background: #b72e25; border-color: #b72e25 !important; color: white;">Clear Response</a>
            </div>
            <div class="nav__right d-flex ml-auto">
                <a href="#" class="btn btn-primary mr-3 previous-question">Back</a>
                <a href="#" class="btn btn-primary save-and-next" style="background: #4ba328; border-color: #4ba328 !important;">Save & Next</a>
            </div>
        </div>
    </div>
    <div class="nav__big-right d-flex ml-auto w-25 p-3 border-nav-left justify-content-center submit"
         style="background-color: #ffa500;padding: 6px!important;
    padding-top: 9px!important;">
        <a href="#" class="btn btn-primary pull-left">Submit</a>
    </div>
    <form class="" id="auto-submit" method="POST" action="<?php echo base_url(); ?>/submit-test">

    </form>
</div>

<div class="nav__big d-flex  overflow-hidden" style='padding:10px;background:#4e85c5'>
    <marquee><h3 style='color:white'>FOR ANY KIND OF ACCESSING PROBLEM OR FOR ANY QUERIES ABOUT OUR PCBT SERVICE PORTAL , CALL/W-SMS AT OUR QUICK HELPLINE NO-9828474951</h3></marquee>
</div>


<script type="text/javascript">
 

    <?php
    $total_time = $this->session->userdata('duration');
    $time_spent = $this->OnlineExam->getQuizStartedTime();
    $total_time = ($total_time * 60);
    $time_left = $total_time - $time_spent;
    ?>
    var c = <?php echo $time_left; ?>;
    var t;
    timedCount();
    var inc=0;
window.onload=function(){
    if(!localStorage.getItem("inc"))
        {
         localStorage.setItem("inc", "0");
          location.reload();
     }
     else
     {
        var x=localStorage.getItem("inc");
        console.log(x);
        if(x%2==0 && x>0)
            location.reload();
       x++;
     }
     $("#qli-0 a").addClass('q-orange');
    $(".notans").text("1");
    $(".goog-logo-link").empty();
    $('.goog-te-gadget').html($('.goog-te-gadget').children());
}

    function timedCount() {
        var hours = parseInt(c / 3600) % 24;
        var minutes = parseInt(c / 60) % 60;
        var seconds = c % 60;

        var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);

        $('#timer').html(result);
        if(c <= 0 ){
                // setConfirmUnload(false);
                confirm('You have reached the maximum time limit allowed for this quiz, confirm to submit the test');
                $("#auto-submit").submit();
            }
        c = c - 1;
        t = setTimeout(function () {
            timedCount()
        }, 1000);
    }
</script>
<script type="text/javascript">

    function change_question(qid, offset) {
        event.preventDefault();
        var question = $("#question_id").val();
        var answer = $('input[name=inlineRadioOptions]:checked').val();
         scrollTop(offset);
        $.ajax({
            url: '<?php echo base_url();?>question-by-id',
            type: 'POST',
            data: {
                id: question,
                selected_answer: answer,
                next_question: qid,
                offset: offset
            },
            success: function (data) {
                getUpdatedQuestionStatus(offset);
                $(".show_question").html(data);
                
                getAllQuestionStatus();
            }
        });
    }

    $(".save-and-next").click(function (event) {
        event.preventDefault();
        var question = $("#question_id").val();
        var selected = $('input[name=inlineRadioOptions]:checked').val();
        //console.log(question);
        var offset = $("#offset").val();
          scrollTop(offset);
        $.ajax({
            url: '<?php echo base_url();?>next-question',
            type: 'POST',
            data: {
                id: question,
                selected_answer: selected,
                offset: offset,
                mark_for_review: "NO"
            },
            success: function (data) {
                   getUpdatedQuestionStatus(offset+1);
                
             
                getAllQuestionStatus();
                   $(".show_question").html(data);
            }
        });
    });

    $(".previous-question").click(function (event) {
        event.preventDefault();
        var question = $("#question_id").val();
        var answer = $('input[name=inlineRadioOptions]:checked').val();
        var offset = $("#offset").val();
       backscrollTop(offset);
        if (offset == 0) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url();?>previous-question',
            type: 'POST',
            data: {
                id: question,
                selected_answer: answer,
                offset: offset,
                mark_for_review: "NO"
            },
            success: function (data) {
                getUpdatedQuestionStatus(offset-1);
                 
                getAllQuestionStatus();
                $(".show_question").html(data);
               
            }
        });
    });
    $(".clearress").click(function (event) {
        $('input[name="inlineRadioOptions"]').prop('checked', false);
    });

  $(".final-submit").click(function (event) {

        var confirmation = confirm("Are you sure want to submit this test");
        if (confirmation == true) {
            $.ajax({
                url: '<?php echo base_url();?>submit-test',
                type: 'POST',
                data: {},
                success: function (data) {
                    
                    $('#myModal').modal('hide');
                    window.location.href = '<?php echo base_url();?>' + 'my-progress';
                }
            });
        }
    });

    $(".submit").click(function (event) {
        $('#myModal').modal('show');
        getAllQuestionStatus();
    });

    $(".mark-for-review-and-next").click(function (event) {
        event.preventDefault();
        var question = $("#question_id").val();
        var answer = $('input[name=inlineRadioOptions]:checked').val();
        var offset = $("#offset").val();
        scrollTop(offset);
        $.ajax({
            url: '<?php echo base_url();?>next-question',
            type: 'POST',
            data: {
                id: question,
                selected_answer: answer,
                offset: offset,
                mark_for_review: "YES"
            },
            success: function (data) {
                getUpdatedQuestionStatus(offset+1);
                
                getAllQuestionStatus();
                 $(".show_question").html(data);
               
            }
        });
    });

    function getAllQuestionStatus() {
        $.ajax({
            url: '<?php echo base_url();?>question-status',
            type: 'POST',
            data: {id: '1'},
            success: function (data) {
                var obj = JSON.parse(data);
                $(".anserd").html(obj.answered);
                $(".markrev").html(obj.marked_for_review);
                $(".notans").html(obj.not_answered);
                $(".ntvisited").html(obj.not_visited);
                $(".ans-and-marked").html(obj.answered_and_marked_for_review);
            }
        });
    }

    function getUpdatedQuestionStatus(offset) {
        $.ajax({
            url: '<?php echo base_url();?>get-updated-question-status',
            type: 'POST',
            data: {id: '1'},
            success: function (data) {
                $(".change_selection").html(data);
                // response = JSON.parse(data);
                /*$.each(response, function (key, value) {
                    $("#qli-"+key+" a").attr("class", value);
                    if (key === offset) {
                        alert("HIIIII");
                        $("#qli-"+offset)[0].scrollIntoView();
                    }

                })*/
            }
        });
    }
     var d=0;
    function scrollTop(offset)
    {
        var elmnt = document.getElementById("qli-"+offset);
       
        elmnt.scrollIntoView();
     
        $('.show_question')[0].scrollIntoView();
    }
     function backscrollTop(offset)
    {
      var elmnt = document.getElementById("qli-"+offset);
        
        elmnt.scrollIntoView();
     
        $('.show_question')[0].scrollIntoView();
     
    }
</script>

<script src="<?php echo base_url(); ?>/assets/web/ques/js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url(); ?>/assets/web/ques/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/web/ques/js/main.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/jquery.magnific-popup.min.js"></script>
</body>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content" style="width: 600px">
            <div class="modal-header">
                <h4 class="modal-title"><b>ATTENTION PLEASE</b><br>DEAR USER YOUR ATTEMPTING MCQs TEST SERIES ARE AS
                    FOLLOWS:</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="nav__right d-flex ml-auto align-items-center pb-2">
                    <div class="row text-center">
                        <div class="col-2 border-rr">
                            <div class="row">
                                <div class="col-12 p-0"><p class="mb-0" style="font-size: 12px">Answered</p></div>
                                <div class="col-12">
                                    <span class="answered answered-green anserd">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 border-rr">
                            <div class="row">
                                <div class="col-12 p-0">
                                    <p class="mb-0 px-3" style="font-size: 12px">Answered & Marked for Review (will be considered for
                                        evaluation)</p>
                                </div>
                                <div class="col-12">
                                    <span class="answered answered-purple-2 ansandmarked ans-and-marked">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 border-rr">
                            <div class="row">

                                <div class="col-12 p-0">
                                    <p class="mb-0" style="font-size: 12px">Not Answered</p>
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
                                    <p class="mb-0" style="font-size: 12px">Not answered & Marked for <br> Review</p>
                                </div>
                                <div class="col-12">
                                    <span class="answered answered-purple markrev">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <div class="col-12 p-0">
                                    <p class="mb-0" style="font-size: 12px">Not Visited</p>
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

            <div class="modal-footer">
                <p>ARE YOU SURE WANT TO SUBMIT PCBT TEST SERIES?</p>
                <div class="final-submit1 pull-left" style="background-color: #4e86c559">
                    <form class="" method="POST" action="<?php echo base_url(); ?>/submit-test">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
                <button type="button" class="btn btn-default pull-right"
                        style="background-color: #e4de0f; border-color: #e4de0f;" data-dismiss="modal">Close
                </button>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
   <script type="text/javascript">
$(document).ready(function() {
  $('.image-link').magnificPopup({type:'image'});
   $('.video-link').magnificPopup({type:'inline'});
    $('.option_1_url').magnificPopup({type:'image'});  $('.option_2_url').magnificPopup({type:'image'});
      $('.option_3_url').magnificPopup({type:'image'});  $('.option_4_url').magnificPopup({type:'image'});
});
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'as,ta,en,hi,te,ur,pa,mr,ml,kn,gu,bn'}, 'google_translate_element');
}





    </script>
   
</html>