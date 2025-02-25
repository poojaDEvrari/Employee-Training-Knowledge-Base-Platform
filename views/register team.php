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
                <li class="breadcrumb-item active">Register Team</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <h5>Course Details</h5>
                    <BR>
                    <form action="../controllers/team registration.php" method="POST">
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
                            mysqli_close($conn);
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
                                      name="description" placeholder="Course Description"
                                      rows="4" required></textarea>
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
                            <label class="control-label requiredField" for="Enrolls">
                                Enrolled Students
                                <span class="asteriskField">*</span>
                            </label>
                            <input readonly class="form-control" id="Enrolls" name="Enrolls"
                                   placeholder="Total enrolls for the subject" type="text"
                            />
                        </div>
                        <BR>
                        <h5>Team Formation</h5>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="Number">
                                No of Teams
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="Number" name="Number" placeholder="Total number of teams"
                                   type="number" min="0" required
                                   onchange="minFunction()"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="Max">
                                Maximum Per Team
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="Max" name="Max"
                                   placeholder="Maximum number of members per team" required type="number" min="0"
                                   onchange="minFunction()"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="Min">
                                Minimum Per Team
                                <span class="asteriskField">*</span>
                            </label>
                            <input readonly class="form-control" id="Min" name="Min"
                                   placeholder="Minimum number of members per team" type="number" min="1"
                                   required/>
                        </div>
                        <div class="form-group">
                            <div>
                                <h6>
                                    <input id="Random" name="Random" type="checkbox"> &nbsp; &nbsp; Randomly Pick </h6>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary " name="" type="submit">
                                    Form Teams
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
            function minFunction() {
                var Min = document.getElementById("Min").value;
                var Max = document.getElementById("Max").value;
                var Number = document.getElementById("Number").value;
                var Enrolls = document.getElementById("Enrolls").value;

                if (Max > 1) {
                    document.getElementById("Min").value = Max - 1;
                    Min = document.getElementById("Min").value;
                }
                if (Max == 1) {
                    document.getElementById("Min").value = Max;
                    Min = document.getElementById("Min").value;
                }

                if (Min * Number == Enrolls) {
                    document.getElementById("Min").value = Max;
                    Min = document.getElementById("Min").value;
                }

                if (Max * Number == Enrolls) {
                    document.getElementById("Min").value = Max;
                    Min = document.getElementById("Min").value;
                }

                if (Min > 0 && Min <= Max && Min * Number <= Enrolls && Max * Number >= Enrolls) {
                    console.log("Entered values are fine!");
                }

                if (Min < 1 || Max < Min) {
                    console.log("Entered values are wrong");
                    document.getElementById("Min").value = "";
                    document.getElementById("Max").value = "";
                    Min = document.getElementById("Min").value;
                    Max = document.getElementById("Max").value;
                } else if (Min * Number > Enrolls || Max * Number < Enrolls) {
                    console.log("Entered values are wrong");
                    document.getElementById("Min").value = "";
                    document.getElementById("Max").value = "";
                    document.getElementById("Number").value = "";
                }

            }

            $('[name=AutoSelect]').on('change', function () {
                var id = $('[name=AutoSelect]').val();
                if (id.length === 0) {
                    document.getElementById("Credits").value = "";
                    document.getElementById("description").value = "";
                    document.getElementById("courseID").value = "";
                    document.getElementById("Enrolls").value = "";
                    document.getElementById("Min").value = "";
                    document.getElementById("Max").value = "";
                    document.getElementById("Number").value = "";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("courseID").value = id;
                            document.getElementById("Credits").value = this.responseText.split(" ")[0];
                            document.getElementById("description").value = this.responseText.split(" ").slice(2).toString().replace(",",
                                " ");
                            document.getElementById("Enrolls").value = this.responseText.split(" ")[1];
                            document.getElementById("Min").value = "";
                            document.getElementById("Max").value = "";
                            document.getElementById("Number").value = "";
                        }
                    };
                    xmlhttp.open("GET", "../controllers/autoload.php?CourseID=" + id, true);
                    xmlhttp.send();
                }
            });
        </script>
        <script>
            if (window.location.search.indexOf('attempt=invalid') > -1) {
                alert('Invalid Data Entered! Try Again!');
            }
            else if (window.location.search.indexOf('attempt=unauthorized') > -1) {
                alert(' You are not eligible to register teams for this particular course!');
            }
            else if (window.location.search.indexOf('attempt=success') > -1) {
                alert('Teams were successfully created');
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