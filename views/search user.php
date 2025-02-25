<!--------------------------------------------- Search Course Result--------------------------------------------->
<?php
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
    include 'basictemplate.php';
    ?>
    <?php
    include_once '../db/dbh.php';
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
                                                <i>User ID</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h5>
                                                <i>Name</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h5>
                                                <i>Email</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;">
                                            <h5>
                                                <i>Role</h5>
                                            </i>
                                        </td>
                                        <td style="text-align: center;"></td>
                                    </tr>
                                    </thead>
                                    <?php


                                    $NIC = mysqli_real_escape_string($conn, $_GET['AutoSelect']);
                                    $Name = mysqli_real_escape_string($conn, $_GET['name']);
                                    $Email = mysqli_real_escape_string($conn, $_GET['email']);
                                    //if($Email == NULL){
                                    //$Email="/";
                                    //}
                                    $Department = mysqli_real_escape_string($conn, $_GET['department']);
                                    //echo $Department;
                                    $sql = "SELECT * FROM (SELECT * FROM hr_department LEFT OUTER JOIN platform_user using (NIC) union SELECT * FROM course_provider LEFT OUTER JOIN  platform_user using (NIC) union SELECT * FROM trainee LEFT OUTER JOIN platform_user using (NIC)) AS DETAILS WHERE 1=1";
                                    if (!empty($NIC)) {
                                        $sql .= " and NIC like '%$NIC%'";
                                    }
                                    if (!empty($Name)) {
                                        $sql .= " and FullName like '%$Name%'";
                                    }
                                    if (!empty($Email)) {
                                        $sql .= " and Email like '%$Email%'";
                                    }
                                    if (!empty($Department)) {
                                        $sql .= " and RoleID=$Department";
                                    }
                                    $result_set = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result_set)) {
                                        ?>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: center;">
                                                <?php echo $row['NIC'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['FullName'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Email'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php
                                                if ($row['RoleID'] == 1) {
                                                    echo "HR Department";
                                                } else if ($row['RoleID'] == 2) {
                                                    echo "Course Provider";
                                                } else if ($row['RoleID'] == 3) {
                                                    echo "Employee";
                                                } ?>
                                            </td>
                                            <!--td><a href="uploads/<//?php echo $row['file'] ?>" target="_blank">view file</a></td-->
                                            <td style="text-align: center;">
                                                <a href="view profile.php?UserID=<?php echo $row['NIC'] ?>">View
                                                    More</a>
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