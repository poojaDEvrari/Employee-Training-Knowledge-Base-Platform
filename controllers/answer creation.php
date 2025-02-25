<?php
//submitting answers to database
session_start();
if (isset($_SESSION['trainee'])) {
    include_once '../db/dbh.php';
    $NIC = $_SESSION['trainee'];
    //from url
    $QID = mysqli_real_escape_string($conn, $_GET['QuizID']);
    $sql = "SELECT * FROM course_enrolls WHERE TraineeID='$NIC' and CourseID = (SELECT CourseID from quiz where QuizID='$QID')";
    $result_set1 = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result_set1)) {
        $NIC = $_SESSION['trainee'];
    } else {
        $NIC = NULL;
    }
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <?php
    include_once '../db/dbh.php';

    if (isset($_POST)) {
        if (isset($_POST['data'])) {
            //posted data
            $answers = $_POST['data'];
            foreach ($answers as $var) {
                $questionID = $var['0'];
                $answer = $var['1'];
                $sql = "SELECT QuestionType,QuizID,Mark FROM question where QuestionID='$questionID'";
                $result_set = mysqli_query($conn, $sql);
                $result = mysqli_fetch_assoc($result_set);
                $QuestionType = $result['QuestionType'];
                $Mark = $result['Mark'];
                $QuizID = $result['QuizID'];
                //mcq
                if ($QuestionType === "mcq") {
                    $sql = "SELECT CorrectAnswer FROM mcq_correct_answer where QuestionID='$questionID'";
                    $result_set = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_assoc($result_set);
                    $CorrectAnswer = $result['CorrectAnswer'];
                }
                //true&false
                if ($QuestionType === "tf") {
                    $sql = "SELECT CorrectAnswer FROM true_false_correct_answer where QuestionID='$questionID'";
                    $result_set = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_assoc($result_set);
                    $CorrectAnswer = $result['CorrectAnswer'];
                }
                //short answer
                if ($QuestionType === "short") {
                    $sql = "SELECT Answer1 FROM short_correct_answer where QuestionID='$questionID'";
                    $result_set = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_assoc($result_set);
                    $CorrectAnswer = $result['Answer1'];
                }
                //marking questions
                if ($answer === $CorrectAnswer) {
                    $Attainedmark = $Mark;
                } else {
                    $Attainedmark = 0;
                }
                //marks->database
                $sql = "INSERT INTO `marks` (`TraineeID`,`QuestionID`,`QuizID`,`Mark`) VALUES ('$NIC','$questionID','$QuizID','$Attainedmark');";
                $result_set = mysqli_query($conn, $sql);
                if ($result_set) {
                    //saving provided answers -> database
                    $sql = "INSERT INTO `provided_answers` (`QuestionID`,`TraineeID`,`Answer`) VALUES ('$questionID','$NIC','$answer');";
                    $result = mysqli_query($conn, $sql);
                } else {
                    mysqli_close($conn);
                    header("Location: ../views/answer quiz.php?QuizID=$QID&attempt=invalid");
                }
            }
        } else {
            mysqli_close($conn);
            header("Location: ../views/answer quiz.php?QuizID=$QID&attempt=empty");
        }
    } else {
        mysqli_close($conn);
        header("Location: ../views/answer quiz.php?QuizID=$QID&attempt=empty");
    }

    ?>
    <?php
    mysqli_close($conn);
    header("Location: ../views/view enrolled.php?attempt=success");
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>			