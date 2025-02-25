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
    <?php include 'basictemplate.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">Register User</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <form action="../controllers/registration.php" method="POST">
                        <div class="form-group ">
                            <label class="control-label requiredField" for="title">
                                Title
                                <span class="asteriskField">*</span>
                            </label>
                            <select class="form-control" id="title" name="title" class='form-control' required>
                                <option id="mr" value="Mr.">Mr.</option>
                                <option id="mrs" value="Mrs.">Mrs.</option>
                                <option id="miss" value="Miss">Miss</option>
                                <option id="rev" value="Rev.">Rev.</option>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="name">
                                Name
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="name" name="name" placeholder="Name" type="text" required/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="nic">
                                NIC Number
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="nic" name="nic" placeholder="National ID number" type="text"
                                   required/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="status">
                                Status
                                <span class="asteriskField">*</span>
                            </label>
                            <?php
                            include_once "../db/dbh.php";
                            $result = $conn->query("select RoleID, Status from role order by RoleID");
                            echo "<select name='status' id='status' class='form-control' required>";
                            while ($row = $result->fetch_assoc()) {
                                unset($id, $name);
                                $id = $row['RoleID'];
                                $status = $row['Status'];
                                echo '<option value="' . $id . '">' . $status . '</option>';
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="email">
                                Email
                            </label>
                            <input class="form-control" id="email" name="email" placeholder="Email Address" type="email"
                                   required/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="contact">
                                Contact Number
                            </label>
                            <input class="form-control" id="contact" name="contact" placeholder="Telephone Number"
                                   type="number" required/>
                        </div>
                        <b>
                            <i>Company Membership (if available)</i>
                        </b>
                        <div class="form-group ">
                            <BR>
                            <label class="control-label requiredField" for="company">
                                Company ID
                            </label>
                            <input class="form-control" id="company" name="company"
                                   placeholder="Company ID - only if available" required type="text"
                            />
                        </div>
                        <BR>
                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary " name="" type="submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
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
        <script src="js/registration.js"></script>
        <script>
            if (window.location.search.indexOf('attempt=invalid') > -1) {
                alert('Invalid Details Entered!');
            }
            else if (window.location.search.indexOf('attempt=success') > -1) {
                alert('User was successfully registered! Username & Password have been sent to his email account.');
            }
            else if (window.location.search.indexOf('attempt=unauthorized') > -1) {
                alert('Only HR Department are allowed to register users!');
            }
        </script>
    </div>
    </body>

    </html>
    <?php
} else {
    header("Location: ../index.php?attempt=fail");
}
?>