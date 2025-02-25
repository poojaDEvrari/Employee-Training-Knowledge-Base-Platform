<?php
session_start();
if (isset($_SESSION['trainee'])) {
    $NIC = $_SESSION['trainee'];
    }
    else{
        $NIC = NULL;
    }
    if($NIC){
    ?>
    <?php include 'basictemplateEmployee.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">Enroll To A Course</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <form action="../controllers/enroll.php" method="POST">
                        <div class="form-group ">
                            <label class="control-label requiredField" for="title">
                                Course Title
                                <span class="asteriskField">*</span>
                            </label>
                            <?php
                            include_once "../db/dbh.php";
                            $result = $conn->query("select CourseID, Title, Credits, Description from course order by Title ASC");
                            echo "<select name='AutoSelect' class='form-control' required>";
                            echo '<option id = "Title" value="">' . NULL . '</option>';
                            while ($row = $result->fetch_assoc()) {
                                unset($id, $name);
                                $id = $row['CourseID'];
                                $name = $row['Title'];
                                echo '<option id="Title" value="' . $id . '">' . $name . '</option>';
                            }

                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="courseID">
                                Course ID
                                <span class="asteriskField">*</span>
                            </label>
                            <input readonly class="form-control" id="courseID" name="courseID"
                                   placeholder="ID of the course" type="text"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="description">
                                Course Description
                                <span class="asteriskField">*</span>
                            </label>
                            <textarea style="height:60px" readonly class="form-control" id="description"
                                      name="description" placeholder="Course Description" rows="4" required></textarea>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="Credits">
                                Credits
                                <span class="asteriskField">*</span>
                            </label>
                            <input readonly class="form-control" id="Credits" name="Credits"
                                   placeholder="Credits for the subject" type="text"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="Prereq">
                                Prerequisite Courses
                            </label>
                            <input readonly class="form-control" id="Prereq" name="Prereq"
                                   placeholder="Prerequisite Courses" type="text"/>
                        </div>
                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary " name="" type="submit">
                                    Enroll
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
        <script src="JS/jquery-3.3.1.min.js"></script>
        <script src="js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="js/vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="JS/sb-admin.min.js"></script>
        <script>
            if (window.location.search.indexOf('attempt=fail') > -1) {
                alert('Invalid Details Entered!');
            }
            else if (window.location.search.indexOf('attempt=success') > -1) {
                alert('Successfully enrolled!');
            }
            else if (window.location.search.indexOf('attempt=invalid') > -1) {
                alert('You have to enroll for all the cources required');
            }
        </script>
        <script>

            $('[name=AutoSelect]').on('change', function () {
                var id = $('[name=AutoSelect]').val();
                if (id.length === 0) {
                    document.getElementById("Credits").value = "";
                    document.getElementById("description").value = "";
                    document.getElementById("courseID").value = "";
                    document.getElementById("Prereq").value = "";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("courseID").value = id;
                            document.getElementById("Credits").value = this.responseText.split(" ")[0];
                            document.getElementById("description").value = this.responseText.split(" ").slice(2).toString().replace(","," ");
                            document.getElementById("Prereq").value = this.responseText.split(" ")[1];
                        }
                    };
                    xmlhttp.open("GET", "../controllers/enroll-autoload.php?CourseID=" + id, true);
                    xmlhttp.send();
                }
            });


        </script>

    </div>
    </body>

    </html>
    <?php
    mysqli_close($conn);
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>
