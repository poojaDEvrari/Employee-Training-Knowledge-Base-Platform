<?php
//employees enter themselves to a team
session_start();
if (isset($_SESSION['trainee'])) {
    ?>
    <?php
    $NIC = $_SESSION['trainee'];
    include '../db/dbh.php';
    //through url
    $TeamID = mysqli_real_escape_string($conn, $_GET['TeamID']);
    $sql = "SELECT * FROM course_enrolls WHERE CourseID = (SELECT CourseID FROM team WHERE TeamID='$TeamID') and TraineeID = '$NIC'";
    $r = mysqli_query($conn, $sql);
    //check whether employee has enrolled to the course
    if ($r) {
        $sql = "SELECT * FROM team_registration NATURAL JOIN team WHERE UserType='$NIC' and CourseID=(SELECT CourseID FROM team WHERE TeamID='$TeamID')";
        $result_set = mysqli_query($conn, $sql);
        if ($data = mysqli_fetch_array($result_set)) {
            $sql = "SELECT CourseID FROM team WHERE TeamID='$TeamID'";
            $r2 = mysqli_query($conn, $sql);
            if ($d2 = mysqli_fetch_array($r2)) {
                $CourseID = $d2['CourseID'];
            }
            mysqli_close($conn);
            header("Location: ../views/view course.php?CourseID='.$CourseID.'?attempt=invalid");
        } else {
            $sql = "SELECT CourseID FROM team WHERE TeamID='$TeamID'";
            $r2 = mysqli_query($conn, $sql);
            if ($d2 = mysqli_fetch_array($r2)) {
                $CourseID = $d2['CourseID'];
            }
            $sql = "INSERT INTO `team_registration`(`TeamID`, `UserType`,`TeamType`) VALUES ('$TeamID','$NIC',NULL);";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                mysqli_close($conn);
                header("Location: ../views/view course.php?CourseID=$CourseID&attempt=success");
            } else {
                mysqli_close($conn);
                header("Location: ../views/view course.php?CourseID=$CourseID&attempt=fail");
            }
        }
    } else {
        mysqli_close($conn);
        header("Location: ../views/view course.php?CourseID=$CourseID&attempt=invalid");
    }


    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>