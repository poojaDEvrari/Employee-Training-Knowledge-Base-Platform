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
                <li class="breadcrumb-item active">Create Course</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <form action="../controllers/course creation.php?NIC=<?php echo $NIC ?>" method="POST">
                        <div class="form-group ">
                            <label class="control-label requiredField" for="courseID">
                                Course ID
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="courseID" name="ID" placeholder="ID of the course"
                                   type="text" required/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="subjectID">
                                Subject ID
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="subjectID" name="subject" placeholder="Subject ID"
                                   type="text" required/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="title">
                                Course Title
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="title" name="title" placeholder="Title of the Course"
                                   type="text" required/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="credits">
                                Credits
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="credits" name="credits"
                                   placeholder="Credit amount of the Course" type="number" min="0"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="description">
                                Course Description
                                <span class="asteriskField">*</span>
                            </label>
                            <textarea style="height:60px" class="form-control" id="description" name="description"
                                      placeholder="Course Description" rows="4"
                                      required></textarea>
                        </div>
                        <b>
                            <i>Prerequisite Courses (if any)</i>
                        </b>
                        <div class="form-group ">
                            <BR>
                            <label class="control-label requiredField" for="Ptitle">
                                Prerequisite Course Title
                            </label>
                            <div>
                                <select id="prereq" multiple="multiple" class="form-control">
                                    <?php
                                    //Autoload Course Titles
                                    include_once "../db/dbh.php";
                                    $result = $conn->query("select CourseID, Title, Credits, Description from course order by Title ASC");
                                    while ($row = $result->fetch_assoc()) {
                                        unset($id, $name);
                                        $id = $row["CourseID"];
                                        $name = $row["Title"];
                                        echo '<option value="' . $id . '">' . $name . '</option>';
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="PcourseID">
                                Prerequisite Course ID
                            </label>
                            <input readonly class="form-control" id="PcourseID" name="PcourseID"
                                   placeholder="ID of the prerequisite course" type="text"
                            />
                        </div>
                        <BR>
                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary " name="" type="submit">
                                    Create
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
        <script src="js/bootstrap-multiselect.js"></script>
        <script>

            //MultiSelect function
            $(document).ready(function () {
                $('#prereq').multiselect();

                $('#prereq').on('change', function () {
                    var ids = $('#prereq').val();
                    $('#PcourseID').val(ids);
                });


            });
        </script>
        <script>
            //fail
            if (window.location.search.indexOf('attempt=fail') > -1) {
                alert('Invalid Details Entered!');
            }
            //success
            else if (window.location.search.indexOf('attempt=success') > -1) {
                alert('Course was successfully created!');
            }
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