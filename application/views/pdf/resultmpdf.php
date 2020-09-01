<!DOCTYPE html>
<html lang="en">
<body class="app sidebar-mini rtl">
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
           <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Result Id</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Quiz Name</th>
                            <th>No. Of Attempt</th>
                            <th>Status</th>
                            <th>Net Marks Obtained</th>
                            <th>Net Percentage Obtained</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($results) > 0) {
                            foreach ($results as $result) {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $result->id; ?></td>
                                    <td style="text-align: center;"><?php echo $result->username; ?></td>
                                    <td style="text-align: center;"><?php echo $result->student_name; ?></td>
                                    <td style="text-align: center;"><?php echo $result->quiz_name; ?></td>
                                    <td style="text-align: center;"><?php echo $result->no_of_attempts; ?></td>
                                    <td style="text-align: center;"><?php echo $result->status ? "Pass" : "Fail"; ?></td>
                                    <td style="text-align: center;"><?php echo number_format($result->net_marks_obtained,2); ?></td>
                                    <td style="text-align: center;"><?php echo $result->net_percentage_obtained; ?>%</td>
                                </tr>
                                <?php
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
</body>
</html>