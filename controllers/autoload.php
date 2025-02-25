<?php
//autoload data for team registration page
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else {
    $NIC = NULL;
}
if ($NIC) {
    //database configuration
    include_once '../db/dbh.php';
    //through url
    $courseID = mysqli_escape_string($conn, $_GET['CourseID']);
    $sql = "SELECT Credits,Description FROM course where CourseID='$courseID'";
    $result = mysqli_query($conn, $sql);
    $result_set = mysqli_fetch_assoc($result);
    //to count total students enrolled
    $sql = "SELECT COUNT(TraineeID) from course_enrolls WHERE CourseID='$courseID'";
    $r = mysqli_query($conn, $sql);
    $r1 = mysqli_fetch_assoc($r);
    $enrolls = $r1['COUNT(TraineeID)'];
    $credits = $result_set['Credits'];
    $description = $result_set['Description'];
    //displaying data
    echo $credits;
    echo " ";
    echo $enrolls;;
    echo " ";
    echo $description;
    mysqli_close($conn);
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>