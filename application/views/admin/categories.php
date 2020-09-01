<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/header'); ?>
<body class="app sidebar-mini rtl">
<?php $this->load->view('admin/sidebar'); ?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-question-circle"></i> Manage Categories</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Manage Categories</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="quiz-duration"><strong>Categories</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                        <?php
                            foreach ($categories as $category) { ?>
                                <tr>
                                    <td>
                                        <input type="text" value="<?php echo $category->category_name; ?>" class="form-control" onBlur="updateCategory(this.value, <?php echo $category->id; ?>)">
                                    </td>
                                    <td><a href="<?php echo base_url()?>delete-category/<?php echo $category->id; ?>" class="btn btn-danger">Delete</a></td>
                                </tr>
                            <?php }
                        ?>
                        <tr>
                            <form action="<?php echo base_url(); ?>add-category/" method="POST">
                            <td>
                                <div class="form-group">
                                    <input type="text" name="category_name" value="" class="form-control">
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Add New</button>
                            </td>
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
    <?php
        if($this->session->flashdata('msg')) {
            echo 'showNotification("'. $this->session->flashdata('msg') .'", "success");';
        } else if ($this->session->flashdata('msg')) {
            echo 'showNotification("'. $this->session->flashdata('error') .'", "error");';
        }
    ?>

    function updateCategory(value, id) {
        $.ajax({
            url: "<?php echo base_url();?>update-category",
            method: "POST", 
            data: {
               category_name: value,
               category_id: id
            },
            dataType:'json',
            cache: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    showNotification(response.message, "success");
                } else {
                    showNotification(response.message, "error")
                }
            },
            error: function (data) {
                showNotification(response.message, "error");
                window.location.reload(function () {
                    setTimeout(2000);
                });

            }
        });
    }
</script>
</body>
</html>