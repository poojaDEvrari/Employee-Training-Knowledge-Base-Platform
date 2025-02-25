<!-----------------------------------------Basic Template ------------------------------------------>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TrainMe.lk</title>
    <!-- Bootstrap core CSS-->
    <link href="js/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="js/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <!--script type="text/javascript" src="typeahead.js"></script-->
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="navbar-header">
        <img src="images/brand-logo.png" style="height: 32px; margin-top: -10px;">
        <a class="navbar-brand" href="#">TrainMe.lk</a>
    </div>    
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="blankEmployee.php">
                    <i class="fa fa-fw fa-home"></i>
                    <span class="nav-link-text">Home</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseViewCourse"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-graduation-cap"></i>
                    <span class="nav-link-text">Course</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseViewCourse">
                    <li>
                        <a href="enroll course.php">Enroll</a>
                    </li>
                    <li>
                        <a href="search.php">Search</a>
                    </li>
                    <li>
                        <a href="view enrolled.php">Enrolled Courses</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-tachometer"></i>
                    <span class="nav-link-text">Leader-Board</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseLeaderBoard">
                    <li>
                        <a href="login.html">Login Page</a>
                    </li>
                    <li>
                        <a href="register.html">Registration Page</a>
                    </li>
                    <li>
                        <a href="forgot-password.html">Forgot Password Page</a>
                    </li>
                    <li>
                        <a href="blank.html">Blank Page</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                <a class="nav-link" href="question answer.php">
                    <i class="fa fa-fw fa-comments-o"></i>
                    <span class="nav-link-text">Q&A Forum</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-edit"></i>
                    <span class="nav-link-text">Notice Board</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseNoticeBoard">
                    <li>
                        <a href="login.html">Login Page</a>
                    </li>
                    <li>
                        <a href="register.html">Registration Page</a>
                    </li>
                    <li>
                        <a href="forgot-password.html">Forgot Password Page</a>
                    </li>
                    <li>
                        <a href="blank.html">Blank Page</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                <a class="nav-link" href="view profile.php?UserID=<?php echo $NIC ?>">
                    <i class="fa fa-fw fa-heartbeat"></i>
                    <span class="nav-link-text">Profile</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-envelope"></i>
                    <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
                    <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">New Messages:</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>David Miller</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome!
                            These messages clip off when they reach the end
                            of the box so they don't overflow over to the sides!
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>Jane Smith</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00
                            instead of 4:00. Thanks!
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>John Doe</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">I've sent the final files over to you for review. When
                            you're able to sign off of them let me know and we can
                            discuss distribution.
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="#">View all messages</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="d-lg-none">Alerts</span>
                    <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle" id="yellow"></i>
            </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">New Alerts:</h6>
                    <script>
                        //document.getElementById('yellow').colo
                        function handleClick(NotificationID) {
                            $.ajax({
                                type: "POST",
                                url: '../controllers/Read.php',
                                data: {
                                    ID: NotificationID
                                },
                            });
                        }
                    </script>
                    <?php
                    if (isset($_SESSION['trainee'])) {
                        $NIC = $_SESSION['trainee'];
                        include_once '../db/dbh.php';
                        $sql = "SELECT * FROM notification WHERE NIC='$NIC' and ReadN=0";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<div class="dropdown-divider"></div>';
                                $NID = $row['NotificationID'];
                                $sql = "SELECT Category, RelavantID from notification where NotificationID='$NID'";
                                $result_set = mysqli_query($conn, $sql);
                                if ($data = mysqli_fetch_array($result_set)) {
                                    $category = $data['Category'];
                                    $rel = $data['RelavantID'];
                                }
                                if ($category == "Course") {
                                    echo '<a class="dropdown-item" href="view course.php?CourseID='.$rel.'" onclick="handleClick(' . $row['NotificationID'] . ');" >';
                                } else if ($category == "Forum") {
                                    echo '<a class="dropdown-item" href="view question.php?QuestionID='.$rel.'" onclick="handleClick(' . $row['NotificationID'] . ');" >';
                                } else {
                                    echo '<a class="dropdown-item" onclick="handleClick(' . $row['NotificationID'] . ');" >';
                                }
                                echo '<span class="text-success">';
                                echo '<strong>';
                                echo '<i class="fa fa-long-arrow-up fa-fw"></i>' . $row['Title'] . '</strong></span>';
                                echo '<div class="dropdown-message small">' . $row['Message'] . '.</div></a>';
                            }
                        }
                        if (mysqli_num_rows($result) == 0) {
                            echo '<script>
                (document.getElementById("yellow").style.display="none");
                      </script>';
                        }

                    }
                    ?>
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0 mr-lg-2">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Search for...">
                        <span class="input-group-btn">
                      <button class="btn btn-primary" type="button">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                    </div>
                </form>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>