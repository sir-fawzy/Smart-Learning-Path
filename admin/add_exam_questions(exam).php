<?php
include "../connection.php";
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add Assessment Questions</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Assessment Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Time Limit</th>
                                    <th scope="col">Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                $res = mysqli_query($link, "SELECT * FROM exam_category");

                                while ($row = mysqli_fetch_array($res)) {
                                    $count++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $count; ?></th>
                                        <td><?php echo $row["category"]; ?></td>
                                        <td><?php echo ucfirst($row["assessment_category"]); ?></td>
                                        <td><?php echo $row["due_date"] ? $row["due_date"] : "Not Set"; ?></td>
                                        <td><?php echo $row["time_limit"] ? $row["time_limit"] . " minutes" : "Not Set"; ?>
                                        </td>
                                        <td><a href="add_edit_questions.php?id=<?php echo $row["id"]; ?>">Select</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- End of card -->
            </div>
        </div> <!-- End of row -->
    </div> <!-- End of animated fadeIn -->
</div> <!-- End of content -->

<!-- Include the footer file -->
<?php
include "footer.php";
?>