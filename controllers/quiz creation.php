<!------------------------ Create a Quiz -------------------------------------------->
<?php
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
    ?>
    <?php
    include_once '../db/dbh.php';

    //getting data
    $ID = mysqli_real_escape_string($conn, $_POST['ID']);
    //through url
    $NIC = mysqli_real_escape_string($conn, $_GET['NIC']);
    $sql = "SELECT * FROM course_responsibility WHERE CourseID ='$ID' and TrainerID='$NIC' ";
    $result_set1 = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result_set1)) {
        //posted data
        $number = mysqli_real_escape_string($conn, $_POST['number']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);

        //querry
        $sql = "INSERT INTO `quiz`(`CourseID`, `QuizNumber`, `QuizName`,`UploaderID`) VALUES ('$ID','$number','$name','$NIC');";

        $result = mysqli_query($conn, $sql);

        //success
        if ($result) {
            $_SESSION['NIC'] = $NIC;
            $sql = "SELECT * FROM course_enrolls WHERE CourseID='$ID'";
            $r3 = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($r3)) {
                //notify enrolled students
                date_default_timezone_set('Asia/Colombo');
                $date = date('Y-m-d H:i:s');
                $message = "New quiz has been created lately for " . $ID . " course!";
                $traineeID = $row['TraineeID'];
                $t = "New Quiz Added";
                $c = "Course";
                $sql = "INSERT INTO `notification`(`NIC`,`Date`,`Title`,`Message`,`ReadN`,`Category`,`RelavantID`) VALUES ('$traineeID','$date','$t','$message',False,'$c','$ID')";
                mysqli_query($conn, $sql);
            }
            $sql = "SELECT QuizID FROM quiz where CourseID='$ID' and QuizNumber='$number'";
            $result_set = mysqli_query($conn, $sql);
            $result = mysqli_fetch_assoc($result_set);
            $QuizID = $result['QuizID'];
            //Passing quiz data to next page
            mysqli_close($conn);
            header("Location:../views/add question.php?QuizID=$QuizID");
        } //if invalid data
        else {
            mysqli_close($conn);
            header("Location: ../index.php?attempt=invalid");
        }
    } else {
        mysqli_close($conn);
        header("Location: ../views/add quiz.php?attempt=unauthorized");
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>