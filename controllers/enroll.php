<?php
//enroll an employee to a new course
session_start();
if (isset($_SESSION['trainee'])) {
    ?>
    <?php
    include_once '../db/dbh.php';
    //through url
    $CourseID = mysqli_real_escape_string($conn, $_POST['courseID']);
    $NIC = $_SESSION['trainee'];
    $sql = "SELECT * FROM prerequisite WHERE CourseID='$CourseID'";
    $result_set = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result_set)) {
        //check if employee has registered to all prereq courses
        $PCourseID = $row['PrerequisiteID'];
        $sql = "SELECT * FROM course_enrolls WHERE CourseID ='$PCourseID' and TraineeID='$NIC'";
        $result_set1 = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_array($result_set1)) {
            echo "";
        } else {

            mysqli_close($conn);
            header("Location: ../views/enroll course.php?attempt=invalid");
            exit();
        }
    }
    //enroll data->database
    $sql = "INSERT INTO `course_enrolls`(`CourseID`, `TraineeID`) VALUES ('$CourseID','$NIC');";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        mysqli_close($conn);
        header("Location:../views/enroll course.php?attempt=success");
    } else {
        mysqli_close($conn);
        header("Location:../views/enroll course.php?attempt=fail");
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>