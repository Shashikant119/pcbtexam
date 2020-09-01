<!DOCTYPE html>
<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<body class="app sidebar-mini rtl">
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="bs-component">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="active">
                                <table class="table table-hover table-bordered" role="grid" aria-describedby="tbl-activeuser_info">
                                    <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>UserId</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Date Of Birth</th>
                                        <th>Address</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sr_no = 1;
                                        foreach ($active_users as $user) {
                                            ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $sr_no; ?></td>
                                                    <td style="text-align: center;"><?php echo $user->username; ?></td>
                                                    <td style="text-align: center;"><?php echo $user->name; ?></td>
                                                    <td style="text-align: center;"><?php echo $user->email; ?></td>
                                                    <td style="text-align: center;"><?php echo $user->mobile; ?></td>
                                                    <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($user->dob)); ?></td>
                                                    <td style="text-align: center;"><?php echo $user->address; ?></td>
                                                </tr>
                                                <?php
                                                $sr_no++;
                                              }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
</body>
</html>





