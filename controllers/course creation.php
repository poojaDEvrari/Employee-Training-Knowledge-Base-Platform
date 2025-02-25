<!------------------------ Create a Quiz -------------------------------------------->
<?php
//to create a quiz
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
    ?>
    <?php
    include_once '../db/dbh.php';

    //getting data
    $NIC = $_GET['NIC'];
    //$ID = $_POST['ID'];
    $ID = mysqli_real_escape_string($conn, $_POST['ID']);
    //$subjectID = $_POST['subject'];
    $subjectID = mysqli_real_escape_string($conn, $_POST['subject']);
    //$title = $_POST['title'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    //$description = $_POST['description'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    //$credits = $_POST['credits'];
    $credits = mysqli_real_escape_string($conn, $_POST['credits']);
    if ($credits == 0 or $credits == "") {
        $credits = "Non-GPA";
    }
    //$prereqID = $_POST['PcourseID'];
    $prereqID = mysqli_real_escape_string($conn, $_POST['PcourseID']);
    //querry
    $sql = "INSERT INTO `course`(`CourseID`, `subjectID`, `title`, `description`,`Credits`) VALUES ('$ID','$subjectID','$title','$description','$credits');";

    $result = mysqli_query($conn, $sql);

    //success
    if ($result) {

        //checking for authenticity
        $sql = "INSERT INTO `course_responsibility`(`CourseID`, `TrainerID`) VALUES ('$ID','$NIC');";
        $result_set = mysqli_query($conn, $sql);

        if ($prereqID != "") {
            $array = explode(',', $prereqID);
            foreach ($array as $value) {
                //to notify trainees about the new course 
                $sql = "INSERT INTO `prerequisite`(`CourseID`, `PrerequisiteID`) VALUES ('$ID','$value');";
                mysqli_query($conn, $sql);
                date_default_timezone_set('Asia/Colombo');
                $date = date('Y-m-d H:i:s');
                $message = "New course " . $title . " " . $ID . " has been created!";
                $sql = "SELECT TraineeID FROM course_enrolls WHERE CourseID='$value'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $traineeID = $row['TraineeID'];
                    $t = "New Course Added";
                    $c = "Course";
                    $sql = "INSERT INTO `notification`(`NIC`,`Date`,`Title`,`Message`,`ReadN`,`Category`,`RelavantID`) VALUES ('$traineeID','$date','$t','$message',False,'$c','$value')";
                    mysqli_query($conn, $sql);
                }
            }
            mysqli_close($conn);
            header("Location:../views/add course.php?attempt=success");
        } else {
            mysqli_close($conn);
            header("Location:../views/add course.php?attempt=success");
        }
    } //if invalid data
    else {
        mysqli_close($conn);
        header("Location: ../views/add course.php?attempt=fail");
    }

    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>