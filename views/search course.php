<!--------------------------------------------- Search Course Result--------------------------------------------->

<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
    include 'basictemplate.php';
    include_once '../db/dbh.php';
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
    include 'basictemplate.php';
    include_once '../db/dbh.php';
} else if (isset($_SESSION['trainee'])) {
    $NIC = $_SESSION['trainee'];
    include 'basictemplateEmployee.php';
    include_once '../db/dbh.php';
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <!-- Breadcrumbs-->
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">Search Results</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Search Results
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <td style="text-align: center;">
                                            <h5>
                                                <i>CourseID</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h5>
                                                <i>Title</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h5>
                                                <i>Description</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h5>
                                                <i>Credits</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;"></td>
                                    </tr>
                                    </thead>
                                    <?php
                                    $CourseID = mysqli_real_escape_string($conn, $_GET['ID']);
                                    $Name = mysqli_real_escape_string($conn, $_GET['cname']);
                                    $Credits = mysqli_real_escape_string($conn, $_GET['credits']);
                                    $all = "none";
                                    if (isset($_GET['all'])) {
                                        $all = mysqli_real_escape_string($conn, $_GET['all']);
                                    }
                                    $sql = "SELECT * FROM course WHERE 1=1";
                                    if ($all === "none") {
                                        if (!empty($CourseID)) {
                                            $sql .= " and CourseID like '%$CourseID%'";
                                        }
                                        if (!empty($Credits)) {
                                            $sql .= " and Credits = '%$Credits%'";
                                        }
                                        if (!empty($Name)) {
                                            $sql .= " and Title like '%$Name%'";
                                        }
                                    }
                                    $result_set = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result_set)) {
                                        ?>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: center;">
                                                <?php echo $row['CourseID'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Title'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Description'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Credits'] ?>
                                            </td>
                                            <!--td><a href="uploads/<//?php echo $row['file'] ?>" target="_blank">view file</a></td-->
                                            <td style="text-align: center;">
                                                <a href="view course.php?CourseID=<?php echo $row['CourseID'] ?>">View</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </container-fluid>
        </div>
        </content-wrapper>
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