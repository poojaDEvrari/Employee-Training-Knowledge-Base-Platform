<?php
//autoload data to enroll course page
session_start();
if (isset($_SESSION['trainee'])) {
    ?>
    <?php
    include_once '../db/dbh.php';
    //through url
    $courseID = $_GET['CourseID'];
    $sql = "SELECT Credits,Description FROM course where CourseID='$courseID'";
    $result = mysqli_query($conn, $sql);
    $result_set = mysqli_fetch_assoc($result);
    $credits = $result_set['Credits'];
    $description = $result_set['Description'];
    $sql2 = "SELECT PrerequisiteID from prerequisite WHERE CourseID='$courseID'";
    $result2 = mysqli_query($conn, $sql2);
    $prereq = array();
    //sorting the prerequisite-courses list
    while ($row = mysqli_fetch_array($result2)) {
        $p = $row['PrerequisiteID'];
        array_push($prereq, $p);
    }
    //data display
    echo $credits;
    echo " ";
    echo implode(",", $prereq);
    echo " ";
    echo $description;

    ?>


    <?php
    mysqli_close($conn);
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>