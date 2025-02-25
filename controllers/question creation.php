<?php include_once '../db/dbh.php'; ?>
<?php
//adding questions to a quiz 
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
    if (isset($_SESSION['NIC'])) {
        //through url
        $QuizID = mysqli_real_escape_string($conn, $_GET['QuizID']);
        $NIC = $_SESSION['NIC'];
        $sql = "SELECT CourseID FROM quiz WHERE QuizID ='$QuizID'";
        $result_set2 = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_array($result_set2)) {
            $CourseID = $row['CourseID'];
            $sql = "SELECT * FROM quiz WHERE QuizID ='$QuizID' and UploaderID='$NIC'";
            $result_set1 = mysqli_query($conn, $sql);
            if ($row = mysqli_fetch_array($result_set1)) {
                if (isset($_POST)) {
                    if (isset($_POST['data'])) {
                        //posted data
                        $questions = $_POST['data'];
                        foreach ($questions as $var) {
                            $type = $var['0'];
                            $number = $var['1'];
                            $question = $var['2'];
                            //short answer
                            if ($type === "short") {
                                $answer = $var['3'];
                                $mark = $var['4'];
                                $sql = "INSERT INTO `question`(`QuizID`, `QuestionNumber`, `QuestionType`,`Question`,`Mark`) VALUES ('$QuizID','$number','$type','$question','$mark');";
                                $result = mysqli_query($conn, $sql);
                                $sql = "SELECT QuestionID FROM question where QuizID='$QuizID' and QuestionNumber='$number'";
                                $result_set = mysqli_query($conn, $sql);
                                $r = mysqli_fetch_assoc($result_set);
                                $QuestionID = $r['QuestionID'];
                                $sql = "INSERT INTO `short_correct_answer`(`QuestionID`, `Answer1`) VALUES ('$QuestionID','$answer');";
                                $result = mysqli_query($conn, $sql);
                            }
                            //mcq
                            if ($type === "mcq") {
                                $sql = "INSERT INTO `question`(`QuizID`, `QuestionNumber`, `QuestionType`,`Question`,`Mark`) VALUES ('$QuizID','$number','$type','$question','$mark');";
                                $result = mysqli_query($conn, $sql);
                                $answer1 = $var['3'];
                                $answer2 = $var['4'];
                                $answer3 = $var['5'];
                                $answer4 = $var['6'];
                                $answer = $var['7'];
                                if ($answer === 1) {
                                    $answer = $var['3'];
                                } else if ($answer === 2) {
                                    $answer = $var['4'];
                                } else if ($answer === 3) {
                                    $answer = $var['5'];
                                } else if ($answer === 4) {
                                    $answer = $var['6'];
                                }
                                $mark = $var['8'];
                                $sql = "SELECT QuestionID FROM question where QuizID='$QuizID' and QuestionNumber='$number'";
                                $result_set = mysqli_query($conn, $sql);
                                $r = mysqli_fetch_assoc($result_set);
                                $QuestionID = $r['QuestionID'];
                                $sql = "INSERT INTO `mcq`(`QuestionID`, `AnswerChoice1`, `AnswerChoice2`, `AnswerChoice3`, `AnswerChoice4`) VALUES ('$QuestionID','$answer1','$answer2','$answer3','$answer4');";
                                $result = mysqli_query($conn, $sql);
                                $sql = "INSERT INTO `mcq_correct_answer`(`QuestionID`, `CorrectAnswer`) VALUES ('$QuestionID','$answer')";
                                $result = mysqli_query($conn, $sql);
                            }
                            //True&False
                            if ($type === "tf") {
                                $answer = $var['3'];
                                $mark = $var['4'];
                                $sql = "INSERT INTO `question`(`QuizID`, `QuestionNumber`, `QuestionType`,`Question`,`Mark`) VALUES ('$QuizID','$number','$type','$question','$mark');";
                                $result = mysqli_query($conn, $sql);
                                $sql = "SELECT QuestionID FROM question where QuizID='$QuizID' and QuestionNumber='$number'";
                                $result_set = mysqli_query($conn, $sql);
                                $r = mysqli_fetch_assoc($result_set);
                                $QuestionID = $r['QuestionID'];
                                $sql = "INSERT INTO `true_false_correct_answer`(`QuestionID`, `CorrectAnswer`) VALUES ('$QuestionID','$answer');";
                                $result = mysqli_query($conn, $sql);
                            }
                        }
                        //kill the session
                        unset($_SESSION['NIC']);
                    }
                }

            } else {
                mysqli_close($conn);
                header("Location: ../views/add quiz.php?attempt=unauthorized");
            }
        } else {
            mysqli_close($conn);
            header("Location: ../views/add quiz.php??attempt=invalid");
        }
    } else {
        mysqli_close($conn);
        header("Location: ../views/add quiz.php?attempt=delayed");
    }
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>
