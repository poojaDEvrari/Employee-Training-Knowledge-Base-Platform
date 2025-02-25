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
                <li class="breadcrumb-item active">View Course Details</li>
            </ol>
            <div class="row">
                <div class="col-12">
                    <?php

                    $CourseID = mysqli_real_escape_string($conn, $_GET['CourseID']);
                    $sql = "SELECT * FROM course where CourseID = '$CourseID' ";
                    $result_set = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result_set)) {
                        $Title = $row['Title'];
                        $Description = $row['Description'];
                        $Credits = $row['Credits'];
                        $SubjectID = $row['SubjectID'];
                    }

                    $sql = "SELECT * FROM subject where SubjectID = '$SubjectID' ";
                    $result_set = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result_set)) {
                        $SubjectTitle = $row['Title'];
                    }

                    $sql = "SELECT * FROM hr_department where NIC = (SELECT TrainerID from course_responsibility where CourseID = '$CourseID') ";
                    $result_set = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_array($result_set)) {
                        $FullName = $row['FullName'];
                        $Email = $row['Email'];
                        $Contact = $row['Contact'];
                        $Trainer = $row['NIC'];
                    } else {

                        $sql = "SELECT * FROM course_provider where NIC = (SELECT TrainerID from course_responsibility where CourseID = '$CourseID') ";
                        $result_set = mysqli_query($conn, $sql);
                        if ($row = mysqli_fetch_array($result_set)) {
                            $FullName = $row['FullName'];
                            $Email = $row['Email'];
                            $Contact = $row['Contact'];
                            $Trainer = $row['NIC'];
                        } else {
                            $FullName = "Not available";
                            $Email = "Not available";
                            $Contact = "Not available";
                        }
                    }
                    ?>
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
                        <form action="/action_page.php">
                            <div class="row">
                                <div class="col-25">
                                    <label for="cid">Course ID</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="cid" name="cid" placeholder="Course ID" readonly value="' . $CourseID . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="cname">Course Name</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="cname" name="cname" placeholder="Course Name" readonly value="' . $Title . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="credits">Credits</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="credits" name="credits" placeholder="Credits" readonly value="' . $Credits . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="subject">Subject</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="subject" name="subject" placeholder="Subject Name" readonly value="' . $SubjectID . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="description">Description</label>
                                </div>
                                <div class="col-75">
                                    <textarea readonly id="description" name="description" placeholder="Description" style="height:100px"><?php echo $Description ?></textarea>
                                </div>
                            </div>
                            <div>
                                <BR>
                                <h5>Course-Provider Details</h5>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="fullname">Name</label>
                                </div>
                                
                                <div class="col-75">
                                    <?php
                                        echo '<a href="view profile.php?UserID='.$Trainer.'">';           
                                    ?>
                                    <?php echo '<input type="text" id="fullname" name="fullname" placeholder="Name of the course provider" readonly value="' . $FullName . '">' ?>
                                    <?php
                                        echo '</a>';
                                    ?>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="email" name="email" placeholder="Email" readonly value="' . $Email . '">' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="contact">Contact   </label>
                                </div>
                                <div class="col-75">
                                    <?php echo '<input type="text" id="contact" name="contact" placeholder="Contact Number" readonly value="' . $Contact . '">' ?>
                                </div>
                            </div>    
                            <?php
                            $sql = "SELECT * FROM course_enrolls WHERE CourseID='$CourseID' and TraineeID='$NIC'";
                            $result_set1 = mysqli_query($conn, $sql);
                            if ($row = mysqli_fetch_array($result_set1)) {
                                $available = True;
                            } else {
                                $sql = "SELECT * FROM course_responsibility WHERE CourseID='$CourseID' and TrainerID='$NIC'";
                                $result_set2 = mysqli_query($conn, $sql);
                                if ($row = mysqli_fetch_array($result_set2)) {
                                    $available = True;
                                } else {
                                    $available = False;
                                }
                            }
                            if ($available) {
                                ?>
                                <div>
                                    <BR>
                                    <h5>Quizzes Available</h5>
                                </div>
                                <BR>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <i class="fa fa-table"></i> Quizzes Available
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                   cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Quiz Number</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Quiz Name</i>
                                                        </h6>
                                                    </td>
                                                    <?php
                                                    if ($available and isset($_SESSION['trainee'])) {
                                                        echo '<td style = "text-align: center;"><h6><i>Quiz Status / Marks</i></h6></td>';
                                                    } else {
                                                        echo '<td style = "text-align: center;"><h6><i>Completed</i></h6></td>';
                                                        echo '<td style = "text-align: center;"><h6><i>Marks Obtained</i></h6></td>';
                                                    }
                                                    ?>
                                                </tr>
                                                </thead>
                                                <?php
                                                $sql = "SELECT * FROM quiz WHERE CourseID='$CourseID'";
                                                $result_set = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result_set)) {
                                                    ?>
                                                    <tbody>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <i>
                                                                <?php echo $row['QuizNumber'] ?>
                                                            </i>
                                                        </td>
                                                        <?php
                                                        $QuizID = $row['QuizID'];
                                                        if ($available and isset($_SESSION['trainee'])) {
                                                            echo '<td style = "text-align: center;"><i>' . $row['QuizName'] . '</i></td>';
                                                            $sql = "SELECT * FROM marks WHERE QuizID='$QuizID' and TraineeID='$NIC'";
                                                            $result_check = mysqli_query($conn, $sql);
                                                            if ($row1 = mysqli_fetch_array($result_check)) {
                                                                $sql = "SELECT SUM(Mark) FROM question WHERE QuizID='$QuizID'";
                                                                $r = mysqli_query($conn, $sql);
                                                                $data = mysqli_fetch_array($r);
                                                                $total = $data['SUM(Mark)'];
                                                                if ($total != 0) {
                                                                    $sql = "SELECT SUM(Mark) FROM marks WHERE QuizID='$QuizID' and TraineeID='$NIC'";
                                                                    $r2 = mysqli_query($conn, $sql);
                                                                    $data2 = mysqli_fetch_array($r2);
                                                                    $obtainedMark = $data2['SUM(Mark)'];
                                                                    $final = strval(ceil($obtainedMark * 100 / $total)) . "%";
                                                                    //echo $obtainedMark;
                                                                } else {
                                                                    $final = "Evaluation Completed";
                                                                }

                                                                echo '<td style = "text-align: center;">' . $final . '</td>';
                                                            } else {
                                                                echo '<td style = "text-align: center;"><a href="answer quiz.php?QuizID=' . $QuizID . '">View Quiz</a></td>';
                                                            }
                                                        } else {
                                                            echo '<td style = "text-align: center;"><a href="answer quiz.php?QuizID=' . $row['QuizID'] . '">View Quiz</a></td>';
                                                            $sql = "SELECT SUM(Mark) FROM `marks` WHERE `QuizID`='$QuizID' and `TraineeID`IN (SELECT `TraineeID` from `course_enrolls` WHERE `CourseID`='$CourseID')";
                                                            $r5 = mysqli_query($conn, $sql);
                                                            $data3 = mysqli_fetch_array($r5);
                                                            $totalmarks = 0;
                                                            if ($data3) {
                                                                $totalmarks = $data3['SUM(Mark)'];
                                                            }
                                                            $sql = "SELECT COUNT(DISTINCT TraineeID) FROM `marks` WHERE `QuizID`='$QuizID'";
                                                            $r6 = mysqli_query($conn, $sql);
                                                            $data4 = mysqli_fetch_array($r6);
                                                            $done = 0;
                                                            if ($data4) {
                                                                $done = $data4['COUNT(DISTINCT TraineeID)'];
                                                            }
                                                            $sql = "SELECT COUNT(TraineeID) from course_enrolls WHERE CourseID='$CourseID'";
                                                            $r7 = mysqli_query($conn, $sql);
                                                            $data5 = mysqli_fetch_array($r7);
                                                            $students = 0;
                                                            if ($data5) {
                                                                $students = $data5['COUNT(TraineeID)'];
                                                            }
                                                            $sql = "SELECT SUM(Mark) FROM question WHERE QuizID='$QuizID'";
                                                            $r = mysqli_query($conn, $sql);
                                                            $data = mysqli_fetch_array($r);
                                                            $total = $data['SUM(Mark)'];
                                                            $fullmarks = strval(ceil($done * 100 / $students)) . "%";
                                                            echo '<td style = "text-align: center;">' . $fullmarks . '</td>';
                                                            if ($students == 0) {
                                                                $success = strval(0) . "%";
                                                            }
                                                            else if($total == 0){
                                                                $success = "Evaluation";
                                                            } else {
                                                                $success = strval(ceil($totalmarks * 100 / ($total * $students))) . "%";
                                                            }
                                                            echo '<td style = "text-align: center;">' . $success . '</td>';
                                                        }
                                                        ?>

                                                    </tr>
                                                    </tbody>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <BR>
                                    <h5>Course Material</h5>
                                </div>
                                <BR>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <i class="fa fa-table"></i> Course Material
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                   cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Name</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>Type</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>File Size(KB)</i>
                                                        </h6>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <h6>
                                                            <i>View</i>
                                                        </h6>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <?php
                                                $sql = "SELECT * FROM course_content WHERE CourseID='$CourseID'";
                                                $result_set = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result_set)) {
                                                    ?>
                                                    <tbody>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <i>
                                                                <?php echo $row['Name'] ?>
                                                            </i>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <i>
                                                                <?php echo $row['Type'] ?>
                                                            </i>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <i>
                                                                <?php echo $row['Size'] ?>
                                                            </i>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <a href="../uploads/<?php echo $row['CourseID'] ?>/<?php echo $row['Content'] ?>"
                                                               target="_blank">View File</a>
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
                                <BR>
                                <BR>
                                <?php
                            }
                            ?>
                            <div>
                                <BR>
                                <h5>Subject Groups</h5>
                            </div>
                            <BR>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fa fa-table"></i> Subject Groups
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <?php
                                            function getTeamMemberCount($TeamID, $count)
                                            {
                                                include '../db/dbh.php';
                                                $sql = "SELECT TeamType FROM team_registration WHERE TeamType IS NOT NULL and TeamID='$TeamID'";
                                                $result = mysqli_query($conn, $sql);
                                                while ($data = mysqli_fetch_array($result)) {
                                                    $team = $data['TeamType'];
                                                    $sql = "SELECT COUNT(UserType) FROM team_registration WHERE UserType IS NOT NULL and TeamID='$team'";
                                                    $result1 = mysqli_query($conn, $sql);
                                                    while ($result2 = mysqli_fetch_array($result1)) {
                                                        $count = $count + $result2['COUNT(UserType)'];
                                                        $count = getTeamMemberCount($team, $count);
                                                    }
                                                }
                                                return $count;
                                            }

                                            ?>
                                            <thead>
                                            <tr>
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

                                                <?php
                                                if ($available) {
                                                    echo '<td style = "text-align: center;"><h6><i>Status</i></h6></td>';
                                                    echo '<td style = "text-align: center;"></td>';
                                                } else {
                                                    echo '<td style = "text-align: center;"><h6><i>Capacity</i></h6></td>';
                                                }
                                                ?>
                                            </tr>
                                            </thead>
                                            <?php
                                            $sql = "SELECT * FROM team WHERE CourseID='$CourseID'";
                                            $result_set = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($result_set)) //$TeamID = $row['TeamID'];
                                            {
                                                ?>
                                                <tbody>
                                            <tr>
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
                                                <?php
                                                if ($available or isset($_SESSION['course_provider']) or isset($_SESSION['hr_dept'])) {
                                                    $RegisteredTeam = 0;
                                                    $sql = "SELECT TeamID FROM team LEFT OUTER JOIN team_registration using(TeamID) WHERE UserType='$NIC' and CourseID='$CourseID' ";
                                                    $r3 = mysqli_query($conn, $sql);
                                                    if ($r4 = mysqli_fetch_array($r3)) {
                                                        $RegisteredTeam = $r4['TeamID'];
                                                    }
                                                    $sql = "SELECT COUNT(UserType) FROM team_registration WHERE UserType IS NOT NULL and TeamID='$row[TeamID]'";
                                                    $r = mysqli_query($conn, $sql);
                                                    if ($r1 = mysqli_fetch_array($r)) {
                                                        $count = $r1['COUNT(UserType)'];
                                                        $TeamID = $row['TeamID'];
                                                        $count = getTeamMemberCount($TeamID, $count);
                                                        if ($count >= $row['Capacity']) {
                                                            echo '<td style = "text-align: center;">Full</td>';
                                                            if ($TeamID == $RegisteredTeam) {
                                                                echo '<td style = "text-align: center;">Registered</td>';
                                                            }
                                                        } else {
                                                            $Capacity = $row['Capacity'];
                                                            echo '<td style = "text-align: center;">' . $count . '/' . $Capacity . '</td>';
                                                            if ($TeamID == $RegisteredTeam) {
                                                                echo '<td style = "text-align: center;">Registered</td>';
                                                            } else {
                                                                if ($RegisteredTeam > 0) {
                                                                    echo '<td style = "text-align: center;">Unavailable</td>';

                                                                } else {
                                                                    if ($available && isset($_SESSION['trainee'])) {
                                                                        echo '<td style = "text-align: center;"><a href="../controllers/team inclusion.php?TeamID=' . $TeamID . '">Register</a></td>';
                                                                    }
                                                                }

                                                            }
                                                        }
                                                    
                                                        echo '<td style = "text-align: center;"><a href="view team.php?TeamID=' . $TeamID . '">View More</a></td>';
                                                    }

                                                    ?>
                                                    </tr>
                                                    </tbody>
                                                    <?php
                                                } else {
                                                    echo '<td style = "text-align: center;"><i>' . $row['Capacity'] . '</i></td>';
                                                }
                                                
                                            }
                                            ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            if (window.location.search.indexOf('attempt=fail') > -1) {
                alert('Invalid Details Entered!');
            }
        </script>
    </div>
    </body>

    </html>
    <?php
    mysqli_close($conn);
}
else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>