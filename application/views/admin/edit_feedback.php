<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-question-circle"></i> Edit Appreciation</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Edit Appreciation</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="<?php echo base_url(); ?>admin-update-appreciation" method="POST" >
                    <div class="row">
                         <div class="col-md-6">
                                     <div class="form-group">
                                            <label  class="col-form-label">State</label>
                                            <input type="text" class="form-control"  name="state"  required="" value="<?php echo $appreciation->state; ?>">
                                        </div>
                                    </div>
                         
                                <div class="col-md-6">
                                     <div class="form-group">
                                            <label for="rating" class="col-form-label">Rating</label>
                                            <input type="number" class="form-control"  name="rating"  required="" value="<?php echo $appreciation->rating; ?>">
                                        </div>
                                    </div>
                            </div>
                             <div class="row">
                      
                               <div class="col-md-12">
                            <div class="form-group">
                                    <label for="question_text" class="col-form-label">Words</label>
                                    <textarea class="form-control" id="question_text" name="feedback" required="" maxlength="150"><?php echo $appreciation->feedback; ?></textarea>

                                     <input type="hidden" class="form-control"  name="id" value="<?php echo $appreciation->id; ?>">
                                </div>
                            </div>
                            </div>
                     <div class="row">
                        
                            <div class="col-md-6 pull-left">
                                <button type="submit" class="btn btn-primary pull-right">Update</button>
                              
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
<?php $this->load->view('admin/footer'); ?>

</body>
</html>