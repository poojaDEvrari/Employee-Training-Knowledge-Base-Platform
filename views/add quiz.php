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
                <li class="breadcrumb-item active">Create Quiz</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <form action="../controllers/quiz creation.php?NIC=<?php echo $NIC ?>" method="POST">
                        <div class="form-group ">
                            <label class="control-label requiredField" for="title">
                                Course Title
                                <span class="asteriskField">*</span>
                            </label>
                            <?php
                            //Autoload course details
                            include_once "../db/dbh.php";
                            $result = $conn->query("select CourseID, Title, Max(QuizNumber) from course LEFT OUTER JOIN quiz using(CourseID) GROUP BY CourseID");
                            echo "<select name='AutoSelect' class='form-control' required>";
                            echo '<option id = "Title" value="">' . NULL . '</option>';
                            while ($row = $result->fetch_assoc()) {
                                unset($id, $name);
                                $id = $row['CourseID'];
                                $name = $row['Title'];
                                $number = $row['Max(QuizNumber)'];
                                echo '<option name="' . $id . '" value="' . $id . '" num="' . $number . '">' . $name . '</option>';
                            }

                            echo "</select>";
                            ?>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="courseID">
                                Course ID
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="courseID" name="ID" placeholder="ID of the course"
                                   type="text"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="quiz number">
                                Quiz Number
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="quiz number" name="number" placeholder="Quiz count"
                                   type="text"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="quiz name">
                                Quiz Name
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="quiz name" name="name" placeholder="Name of the quiz"
                                   type="text" required/>
                        </div>
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
        <script>
            if (window.location.search.indexOf('attempt=invalid') > -1) {
                alert('Invalid Data Entered! Try Again!');
            }
            else if (window.location.search.indexOf('attempt=unauthorized') > -1) {
                alert(' You are not eligible to create assignments for this particular course!');
            }
            else if (window.location.search.indexOf('attempt=delayed') > -1) {
                alert('Questions should be submitted right after creating a quiz! Create a quiz again!');
            }
            else if (window.location.search.indexOf('attempt=success') > -1) {
                alert('Quiz was successfullt added');
            }
        </script>
        <script>
            $('[name=AutoSelect]').on('change', function () {
                var id = $('[name=AutoSelect]').val();
                if (id.length === 0) {
                    document.getElementById("courseID").value = "";
                    document.getElementById("quiz number").value = "";
                }
                var num = parseInt($(`[name=${id}]`).attr("num")) + 1;
                if (isNaN(num)) {
                    num = 1;
                }
                document.getElementById("courseID").value = id;
                document.getElementById("quiz number").value = num;
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