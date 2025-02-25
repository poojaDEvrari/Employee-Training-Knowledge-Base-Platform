<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else if (isset($_SESSION['trainee'])) {
    //$ID = $_SESSION['trainee'];
    $NIC = $_SESSION['trainee'];
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <?php include '../db/dbh.php' ?>
    <?php
    if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
        include 'basictemplate.php';
    } else {
        include 'basictemplateEmployee.php';
    }
    ?>
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">View Personal Details</li>
            </ol>
            <div class="row">
                <div class="col-12">

                    <style>
                        * {
                            /* box-sizing: border-box; */
                        }

                        input[type=text],
                        select,
                        textarea {
                            /* margin-left: -70px; */
                            width: 100%;
                            padding: 12px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            resize: vertical;
                        }

                        label {
                            padding: 12px 12px 12px 0;
                            display: inline-block;
                        }

                        input[type=submit] {
                            background-color: #4CAF50;
                            color: white;
                            padding: 12px 20px;
                            border: none;
                            border-radius: 4px;
                            cursor: pointer;
                            float: right;
                        }

                        input[type=submit]:hover {
                            background-color: #45a049;
                        }

                        .container-div {
                            /* margin-left: 30px; */
                            border-radius: 5px;
                            background-color: #f2f2f2;
                            padding: 20px;
                            margin-bottom: 50px;
                        }

                        .col-25 {
                            float: left;
                            width: 25%;
                            margin-left: 20px;
                            margin-top: 6px;
                        }

                        .col-75 {
                            float: left;
                            width: 65%;
                            margin-top: 6px;
                        }

                        /* Clear floats after the columns */

                        .row:after {
                            content: "";
                            display: table;
                            clear: both;
                        }

                        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */

                        @media screen and (max-width: 600px) {
                            .col-25,
                            .col-75,
                            input[type=submit] {
                                width: 100%;
                                margin-top: 0;
                            }
                        }
                    </style>
                    <div class="container container-div">
                        <?php
                        $ID = mysqli_real_escape_string($conn, $_GET['UserID']);
                        $sql = "SELECT * FROM (SELECT * FROM hr_department LEFT OUTER JOIN platform_user using (NIC) union SELECT * FROM course_provider LEFT OUTER JOIN  platform_user using (NIC) union SELECT * FROM trainee LEFT OUTER JOIN platform_user using (NIC)) AS DETAILS WHERE NIC = '$ID'";
                        $result_set = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result_set)) {
                        $Title = $row['Title'];
                        $FullName = $row['FullName'];
                        $Email = $row['Email'];
                        $Contact = $row['Contact'];

                        ?>
                        <?php
                        if ($ID === $NIC) {
                        ?>
                        <form action="../controllers/update user.php?UserID=<?php echo $ID ?>" method="POST">
                            <div class="row">
                                <div class="col-25">
                                    <label for="uid">Register ID</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="uid" name="uid" readonly value="' . $ID . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="title">Title</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="title" name="title" readonly value="' . $Title . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="fullname">Full Name</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="fullname" name="fullname" placeholder="Full Name" value="' . $FullName . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="email" name="email" placeholder="Email Address" value="' . $Email . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="contact">Contact</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="contact" name="contact" placeholder="Contact Number" value="' . $Contact . '">' ?>
                                </div>
                            </div>
                            <BR>
                            <div class="form-group">
                                <div>
                                    <button class="btn btn-primary " name="update-user" type="submit">
                                        Update
                                    </button>
                                </div>
                            </div>
                            <?php
                            }
                            else{
                            ?>
                            <form>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="uid">Register ID</label>
                                    </div>
                                    <div class="col-75">
                                        <?php echo '<input type="text" id="uid" name="uid" readonly value="' . $ID . '">' ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="title">Title</label>
                                    </div>
                                    <div class="col-75">
                                        <?php echo '<input type="text" id="title" name="title" readonly value="' . $Title . '">' ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="fullname">Full Name</label>
                                    </div>
                                    <div class="col-75">
                                        <?php echo '<input type="text" id="fullname" name="fullname" placeholder="Full Name" readonly value="' . $FullName . '">' ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="col-75">
                                        <?php echo '<input type="text" id="email" name="email" placeholder="Email Address" readonly value="' . $Email . '">' ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="contact">Contact</label>
                                    </div>
                                    <div class="col-75">
                                        <?php echo '<input type="text" id="contact" name="contact" placeholder="Contact Number" readonly value="' . $Contact . '">' ?>
                                    </div>
                                </div>
                                <?php
                                }
                                }
                                ?>
                            </form>

                            <?php
                            $sql = "SELECT NIC FROM trainee WHERE NIC='$ID'";
                            $r = mysqli_query($conn, $sql);
                            $numrows = mysqli_num_rows($r);
                            if ($numrows != 0) {
                                ?>
                                <div>
                                    <BR>
                                    <h5>Group Details</h5>
                                </div>
                                <BR>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <i class="fa fa-table"></i> Groups
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                   cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Course ID</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Name</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Team Number</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i></i>
                                                        </h6>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <?php
                                                $sql = "SELECT * FROM team LEFT OUTER JOIN team_registration Using(TeamID) WHERE UserType='$ID'";
                                                $result_set = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result_set)) //$TeamID = $row['TeamID'];
                                                {
                                                $TeamID = $row['TeamID'];
                                                ?>
                                                <tbody>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <?php echo $row['CourseID'] ?>
                                                        </i>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <?php if ($row['Name'] === NULL) {
                                                                echo "NULL";
                                                            } else {
                                                                echo $row['Name'];
                                                            } ?>
                                                        </i>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <?php echo $row['TeamNo'] ?>
                                                        </i>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <a href="view team.php?TeamID=<?php echo $TeamID ?>">
                                                                View More
                                                            </a>
                                                        </i>
                                                    </td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div>
                                    <BR>
                                    <h5>Courses Conducted</h5>
                                </div>
                                <BR>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <i class="fa fa-table"></i> Course Details
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                   cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Course ID</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Title</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Credits</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i></i>
                                                        </h6>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <?php
                                                $sql = "SELECT * FROM course LEFT OUTER JOIN course_responsibility Using(CourseID) WHERE TrainerID='$ID'";
                                                $result_set = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result_set)) //$TeamID = $row['TeamID'];
                                                {
                                                $CourseID = $row['CourseID'];
                                                ?>
                                                <tbody>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <?php echo $row['CourseID'] ?>
                                                        </i>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <?php echo $row['Title'] ?>
                                                        </i>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <?php echo $row['Credits'] ?>
                                                        </i>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <i>
                                                            <a href="view course.php?CourseID=<?php echo $CourseID ?>">
                                                                View More
                                                            </a>
                                                        </i>
                                                    </td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
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
        <script src="js/vendor/datatables/jquery.dataTables.js"></script>
        <script src="js/vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <script>
            if (window.location.search.indexOf('attempt=invalid') > -1) {
                alert('Invalid Details Entered!');
            }
            else if (window.location.search.indexOf('attempt=successful') > -1) {
                alert('User Details Updated!');
            }
            else if (window.location.search.indexOf('attempt=unauthorized') > -1) {
                alert('You do not have priviledges to alter details of this particular user!');
            }
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