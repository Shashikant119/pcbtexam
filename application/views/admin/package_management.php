                                        style="color: red;">*</span></label>
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-product-hunt"></i>Package Management</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Package Management</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <a class="btn btn-success pull-right" data-toggle="modal" data-target="#addQuestionModal"
                               href="javascript:void(0)">Add New Package</a>
                        </div>
                    </div>
                    <br/>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th style="width: 42px;">Sr. No.</th>
                            <th>Package Image</th>
                            <th>Package Name</th>
                            <th>Package Type</th>
                            <th>Package Price</th>
                            <th>Package Duration</th>
                            <th>Total CBT Tests</th>
                            <th>Frequency Of CBT</th>
                            <th style="width: 90px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($packages) > 0) {
                            $sr_no = 1;
                            foreach ($packages as $package) {
                                if (!$package->image) {
                                    $package->image = 'dummy-image.jpg';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $sr_no ?></td>
                                    <td><img src="<?php echo base_url('/assets/images/packages/'). $package->image; ?>" height="55" width="70"></td>
                                    <td><?php echo $package->package_name; ?></td>
                                    <td><?php echo $package->package_type; ?></td>
                                    <td><?php echo '₹ ' . $package->package_price; ?></td>
                                    <td><?php echo $package->package_duration; ?></td>
                                    <td><?php echo $package->total_cbt_test; ?></td>
                                    <td><?php echo $package->frequency_of_cbt; ?></td>
                                    <td>
                                        <a class="badge badge-success" data-toggle="modal"
                                           data-target="#editQuestionModal" href="javascript:void(0)"
                                           data-package_name="<?php echo $package->package_name; ?>"
                                           data-package_image="<?php echo $package->image; ?>"
                                           data-package_type="<?php echo $package->package_type; ?>"
                                           data-package_price="<?php echo $package->package_price; ?>"
                                           data-duration="<?php echo $package->package_duration; ?>"
                                           data-total_cbt="<?php echo $package->total_cbt_test; ?>"
                                           data-frequency="<?php echo $package->frequency_of_cbt; ?>"
                                           data-row-id="<?php echo $package->package_id; ?>"
                                           onclick="editPackage(this)">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                        </a>
                                        <a href="<?php echo base_url() . 'del-package/' . $package->package_id; ?>"
                                           class="badge badge-danger"
                                           onclick="return confirm('Do you want to delete this package ?');">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $sr_no++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- add question modals -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>packages/" method="POST" name="package-form" enctype="multipart/form-data">
                <div class="modal-body">
                     <div class="form-group">
                            <label for="package_image" class="col-form-label">Package Thumbnail :<span style="color: red;">*</span></label>
                            <input type="file" class="form-control" id="package_image" name="package_image">

                        </div>
                    <div class="form-group">
                        <label for="package_name" class="col-form-label">Package Details :<span
                                    style="color: red;">*</span></label>
                        <textarea class="form-control" id="package_name" name="package_name" required=""
                                  maxlength="2000"></textarea>
                    </div>
                   
                    <div class="form-group">
                        <label for="package_type">Package Type : <span style="color: red">*</span></label>
                        <select class="form-control" id="package_type" name="package_type" required="" onchange="onChangePack1(this.value);">
                            <option value="Free" <?php if (@$edit_data->package_type == 'Free') echo 'selected="selected"'; ?>>
                                Free
                            </option>
                            <option value="Paid" <?php if (@$edit_data->package_type == 'Paid') echo 'selected="selected"'; ?>>
                                Paid
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="package_price">Package Price :</label>
                        <input type="text" class="form-control pack_price" id="package_price" name="package_price" value="0.0">
                    </div>
                    <div class="form-group">
                        <label for="package_duration">Package Duration/Validity (In Days) : <span
                                    style="color: red">*</span></label>
                        <input type="number" class="form-control" id="package_duration" name="package_duration"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="total_cbt_test">Total CBT Tests : <span style="color: red">*</span></label>
                        <input type="number" class="form-control" id="total_cbt_test" name="total_cbt_test" required="">
                    </div>
                    <div class="form-group">
                        <label for="frequency_of_cbt">Frequency : <span
                                    style="color: red">*</span></label>
                          <select class="form-control" id="frequency_of_cbt" name="frequency_of_cbt" placeholder='Select frequency'>

               <option value="2 CBT/Day">2 CBT/Day</option>
               <option value="1 CBT/Day">1 CBT/Day</option>
               
               <option value="1 CBT/2 Days">1 CBT/2 Days</option>
               <option value="1 CBT/3 Days">1 CBT/3 Days</option>
               <option value="1 CBT/5 Days">1 CBT/5 Days</option>
               <option value="1 CBT/6 Days">1 CBT/6 Days</option>
               <option value="1 CBT/10 Days">1 CBT/10 Days</option>
               <option value="1 CBT/15 Days">1 CBT/15 Days</option>
               <option value="1 CBT/30 Days">1 CBT/30 Days</option>
               
                            </select>
                          
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--edit question modals -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="updateq-form-section">
                <form id="update-form" action="<?php echo base_url(); ?>index.php/update-package/" method="POST" name="edit-package-form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="epackage_name" class="col-form-label">Package Details :<span
                                        style="color: red;">*</span></label>
                            <textarea class="form-control" id="epackage_name" name="package_name" required=""
                                      maxlength="2000"></textarea>
                        </div>
                    <div class="form-group">
                            <label for="package_image" class="col-form-label">Package Thumbnail :<span style="color: red;">*</span></label>
                            <input type="file" class="form-control" id="epackage_image" name="package_image">

                        </div>
                        <div class="form-group">
                            <label for="epackage_type">Package Type : <span style="color: red">*</span></label>
    <select class="form-control" id="epackage_type" name="package_type" required="" onchange="onChangePack(this.value);">
                                <option value="Free">Free</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="epackage_price">Package Price :</label>
                            <input type="text" class="form-control pack_price" id="epackage_price" name="package_price">
                        </div>
                        <div class="form-group">
                            <label for="epackage_duration">Package Duration/Validity (In Days) : <span
                                        style="color: red">*</span></label>
                            <input type="number" class="form-control" id="epackage_duration" name="package_duration"
                                   required="">
                        </div>
                        <div class="form-group">
                            <label for="etotal_cbt_test">Total CBT Tests : <span style="color: red">*</span></label>
                            <input type="number" class="form-control" id="etotal_cbt_test" name="total_cbt_test"
                                   required="">
                        </div>
                        <div class="form-group">
                            <label for="efrequency_of_cbt">Frequency Of CBT: <span
                                        style="color: red">*</span></label>
         <select class="form-control" id="efrequency_of_cbt" name="frequency_of_cbt" placeholder='Select frequency'>

                <option value="2CBT/Day">2CBT/Day</option>
               <option value="1CBT/Day">1CBT/Day</option>
               
               <option value="1CBT/2 Days">1CBT/2 Days</option>
               <option value="1CBT/3 Days">1CBT/3 Days</option>
               <option value="1CBT/5 Days">1CBT/5 Days</option>
               <option value="1CBT/6 Days">1CBT/6 Days</option>
               <option value="1CBT/10 Days">1CBT/10 Days</option>
               <option value="1CBT/15 Days">1CBT/15 Days</option>
               <option value="1CBT/30 Days">1CBT/30 Days</option>
               
                            </select>
                          
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    <input type="hidden" id="req-edit-id" name="req_edit_id" value="">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal code end -->
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
    $('#sampleTable').DataTable({"aaSorting": []});
    <?php
    if ($this->session->flashdata('msg')) {
        echo 'showNotification("' . $this->session->flashdata('msg') . '");';
    }
    ?>
function onChangePack(val)
{
  if(val=='Free')
  {
      $("#epackage_price").val('0.0');
  }
}
function onChangePack1(val)
{
  if(val=='Free')
  {
      $("#package_price").val('0.0');
  }
}
    function editPackage(obj) {
        $("#epackage_name").val($(obj).data("package_name"));
        $("#epackage_type").val($(obj).data("package_type"));
        $("#epackage_price").val($(obj).data("package_price"));
        $("#epackage_duration").val($(obj).data("duration"));
        $("#efrequency_of_cbt").val($(obj).data("frequency"));
        $("#etotal_cbt_test").val($(obj).data("total_cbt"));
        $("#req-edit-id").val($(obj).data("row-id"));
    }
</script>
</body>
</html>