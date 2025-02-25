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
                    <li class="breadcrumb-item active">View Team Details</li>
                </ol>
                <div class="row">
                    <div class="col-12">
                        <?php

                    $TeamID = mysqli_real_escape_string($conn, $_GET['TeamID']);
                    $sql = "SELECT CourseID,Name,TeamNo,team.Description,Capacity FROM team LEFT OUTER JOIN course using(CourseID) where TeamID = '$TeamID' ";
                    $result_set = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result_set)) {
                        $Title = $row['Name'];
                        $Description = $row['Description'];
                        $TeamNo = $row['TeamNo'];
                        $CourseID = $row['CourseID'];
                        $Capacity = $row['Capacity'];
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
                            <?php
                            $sql = "SELECT * FROM team_registration WHERE TeamID='$TeamID' and UserType='$NIC'";
                            $result_set1 = mysqli_query($conn, $sql);
                            if ($row = mysqli_fetch_array($result_set1)) {
                            ?>
                                <form action="../controllers/update team.php?TeamID=<?php echo $TeamID ?>" method="POST">
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="cname">Team Name</label>
                                        </div>
                                        <div class="col-75">
                                            <?php echo '<input type="text" id="cname" name="cname" placeholder="Course Name" value="' . $Title . '">' ?>
                                        </div>
                                    </div>
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
                                            <label for="teamno">Team Number</label>
                                        </div>
                                        <div class="col-75">
                                            <?php echo '<input type="text" id="teamno" name="teamno" placeholder="Team Number" readonly value="' . $TeamNo . '">' ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="capacity">Capacity</label>
                                        </div>
                                        <div class="col-75">
                                            <?php echo '<input type="text" id="capacity" name="capacity" placeholder="Team Capacity" readonly value="' . $Capacity . '">' ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="col-75">
                                            <textarea id="description" name="description" placeholder="Description" style="height:100px">
                                                <?php echo $Description ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <BR>
                                    <div class="form-group">
                                        <div>
                                            <button class="btn btn-primary " name="update-team" type="submit">
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
                                            <label for="cname">Team Name</label>
                                        </div>
                                        <div class="col-75">
                                            <?php echo '<input type="text" id="cname" name="cname" placeholder="Course Name" readonly value="' . $Title . '">' ?>
                                        </div>
                                    </div>
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
                                            <label for="teamno">Team Number</label>
                                        </div>
                                        <div class="col-75">
                                            <?php echo '<input type="text" id="teamno" name="teamno" placeholder="Team Number" readonly value="' . $TeamNo . '">' ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="capacity">Capacity</label>
                                        </div>
                                        <div class="col-75">
                                            <?php echo '<input type="text" id="capacity" name="capacity" placeholder="Team Capacity" readonly value="' . $Capacity . '">' ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="col-75">
                                            <textarea readonly id="description" name="description" placeholder="Description" style="height:100px">
                                                <?php echo $Description ?>
                                            </textarea>
                                        </div>
                                    </div>
                                 <?php   
                                    }
                                ?>    
                                    <?php
                            $sql = "SELECT * FROM course_enrolls WHERE CourseID='$CourseID' and TraineeID='$NIC'";
                            $result_set1 = mysqli_query($conn, $sql);
                            
                                $sql = "SELECT * FROM course_responsibility WHERE CourseID='$CourseID' and TrainerID='$NIC'";
                                $result_set2 = mysqli_query($conn, $sql);
                                if ($row = mysqli_fetch_array($result_set2)) {
                                    $available = True;
                                } else {
                                    $available = False;
                                }
                            
                            ?>
                                        <div>
                                            <BR>
                                            <h5>Team Members</h5>
                                        </div>
                                        <BR>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <i class="fa fa-table"></i> Team Members
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
                                                                            <i>Title</h5>
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
                                                                    <?php
                                                                    if($available){
                                                                        echo '<td style="text-align: center;"></td>';    
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                    $sql = "SELECT * FROM (SELECT * FROM hr_department LEFT OUTER JOIN platform_user using (NIC) union SELECT * FROM course_provider LEFT OUTER JOIN  platform_user using (NIC) union SELECT * FROM trainee LEFT OUTER JOIN platform_user using (NIC)) AS DETAILS WHERE NIC IN (SELECT UserType FROM team_registration WHERE TeamID='$TeamID')";
                                    $result_set = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result_set)) {
                                        $User = $row['NIC'];
                                        ?>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: center;">
                                                <?php echo $row['NIC'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Title'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['FullName'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo $row['Email'] ?>
                                            </td>
                                            <?php
                                                if($available){
                                                    echo '<td style="text-align: center;">';
                                                    echo '<a href="view profile.php?UserID='.$User.'">View More</a>';
                                                    echo '</td>';    
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    alert('Team Details Updated!');
                }
                else if (window.location.search.indexOf('attempt=unauthorized') > -1) {
                    alert('You do not have priviledges to alter details of this particular team!');
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