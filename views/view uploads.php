<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <?php
    include_once '../db/dbh.php';
    ?>
    <?php include 'basictemplate.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">View Uploads</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> View Uploads
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <td style="text-align: center;">
                                            <h6>
                                                <i>CourseID</h6>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h6>
                                                <i>Name</h6>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h6>
                                                <i>Type</h6>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h6>
                                                <i>File Size(KB)</h6>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h6>
                                                <i>View</h6>
                                            </i>
                                        </td>
                                    </tr>
                                    </thead>
                                    <?php
                                    //search by uploader id
                                    $sql = "SELECT * FROM course_content WHERE UploaderID = '$NIC'";
                                    $result_set = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result_set)) {
                                        ?>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: center;">
                                                <?php echo $row['CourseID'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Name'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Type'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Size'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="../uploads/<?php echo $row['CourseID'] ?>/<?php echo $row['Content'] ?>"
                                                   target="_blank">view file</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <?php
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <BR>
                    <a href="add file.php">upload new files...</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        <footer class="sticky-footer">
            <div class="container">
                <div class="text-center">
                    <small>Copyright © TrainMe.lk</small>
                </div>
            </div>
        </footer>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="../controllers/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="js/vendor/jquery/jquery.min.js"></script>
        <script src="js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="js/vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
    </div>
    </body>

    </html>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>