<section class="grid__view mt-4">
    <div class="container">
        <h4>Common Merit List</h4>
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="post" action="#0">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <span class="input-group-btn">
                          <button class="btn btn-warning" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                <tr class="thead-dark" style="white-space: pre">
                    <th>Rank</th>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Quiz Name</th>
                    <th>Status</th>
                    <th>No. of Attempt</th>
                    <th>Net Marks Obtained</th>
                    <th>Net Percentage Obtained</th>
                    <!--<th>Action</th>-->
                </tr>

                <?php $i = 1; foreach ($results as $result) { ?>
                    <tr style="white-space: nowrap;" class="<?php if ($this->session->userdata('user_id') == $result->user_id){ echo "alert-success"; }?>">
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $result->username; ?></td>
                        <td><?php echo $result->name; ?></td>
                        <td><?php echo $result->quiz_title; ?></td>
                        <td><?php echo $result->status ? "Pass" : "Fail"; ?></td>
                        <td><?php echo $result->no_of_attempts; ?></td>
                        <td><?php echo number_format($result->net_marks_obtained,2); ?></td>
                        <td><?php echo $result->net_percentage_obtained; ?></td>
                        <!--<td>
                            <a href="<?php /*echo base_url("my-progress/view/".$result->id)*/?>" class="btn btn-success">View</a>
                        </td>-->
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="my-3 text-center mb-4">
            <a href="#0" class="btn btn-primary mx-2"> <span>Back</span></a>
            <a href="#0" class="btn btn-primary"> <span>Next</span> </a>
        </div>
    </div>
</section>