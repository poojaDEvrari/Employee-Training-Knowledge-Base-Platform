<!---------------------------------------------------Search a Course ----------------------------------->
<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
    include 'basictemplate.php';
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
    include 'basictemplate.php';
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
                <li class="breadcrumb-item active">Search A User</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <form action="search user.php" method="GET">
                        <div class="form-group ">
                            <label class="control-label requiredField" for="AutoSelect">
                                User ID
                            </label>
                            <?php
                            include_once "../db/dbh.php";
                            $result = $conn->query("select NIC,RoleID from platform_user");
                            echo "<select name='AutoSelect' class='form-control' >";
                            echo '<option id = "NIC" value="">' . NULL . '</option>';
                            while ($row = $result->fetch_assoc()) {
                                unset($nic, $role, $name);
                                $nic = $row['NIC'];
                                $role = $row['RoleID'];
                                $name = 3;
                                if ($role == 1) {
                                    //$name = "1";
                                    $result_set = $conn->query("select FullName from hr_department where NIC='$nic'");
                                    while ($data = $result_set->fetch_assoc()) {
                                        unset($name);
                                        $name = $data['FullName'];
                                    }
                                }
                                if ($role == 2) {
                                    //$name = "2";
                                    $result_set = $conn->query("select FullName from course_provider where NIC='$nic'");
                                    if ($data = $result_set->fetch_assoc()) {
                                        unset($name);
                                        $name = $data['FullName'];
                                    }
                                }
                                if ($role == 3) {
                                    //$name = "3";
                                    $result_set = $conn->query("select FullName from trainee where NIC='$nic'");
                                    if ($data = $result_set->fetch_assoc()) {
                                        unset($name);
                                        $name = $data['FullName'];
                                    }
                                }
                                echo '<option id="' . $nic . '" name="' . $name . '" value="' . $nic . '" >' . $nic . '</option>';
                            }
                            mysqli_close($conn);
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="name">
                                Name
                            </label>
                            <input class="form-control" id="user name" name="name" placeholder="Name of the user"
                                   type="text"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="department">
                                Department
                            </label>
                            <select class="form-control" id="department" name="department"
                                    placeholder="Department of the user" type="text"/>
                            <option value="0"></option>
                            <option value="1">HR Department</option>
                            <option value="2">Course Provider</option>
                            <option value="3">Employee</option>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="email">
                                Email
                            </label>
                            <input class="form-control" id="email" name="email" placeholder="Email Address of the user"
                                   type="text"/>
                        </div>
                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary " name="search-course" type="submit">
                                    Search
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        </container-fluid>
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
        <script>
            $('[name=AutoSelect]').on('change', function () {
                var id = $('[name=AutoSelect]').val();
                if (id.length === 0) {
                    document.getElementById("user name").value = "";
                }
                var name = $(`[id=${id}]`).attr("name");
                document.getElementById("user name").value = name;
            });
        </script>
    </div>
    </body>

    </html>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>