<?php
//reading a notification
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider']) or isset($_SESSION['trainee'])) {
    if (isset($_POST['ID'])) {
        include_once '../db/dbh.php';
        //through url
        $ID = mysqli_real_escape_string($conn, $_POST['ID']);
        $sql = "UPDATE notification SET ReadN='1' WHERE NotificationID='$ID'";
        $result_set = mysqli_query($conn, $sql);

        $sql = "SELECT Category, RelavantID from notification where NotificationID='$ID'";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_array($result)) {
            $category = $row['Category'];
            $rel = $row['RelavantID'];
        }
        if ($category == "Course") {
            mysqli_close($conn);
            header("Location: ../views/view course.php?CourseID=$rel");
        } else if ($category == "Forum") {
            mysqli_close($conn);
            header("Location: ../views/view question.php?QuestionID=$rel");
        } else {
            mysqli_close($conn);
            header("Location: ../views/view question.php");
        }
    }

} else {
    header("Location: ../index.php?attempt=fail");
}
?>