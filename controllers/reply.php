<?php
//replying to a comment
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else if (isset($_SESSION['trainee'])) {
    $ID = $_SESSION['trainee'];
    $NIC = $_SESSION['trainee'];
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <?php
    include_once '../db/dbh.php';
    //posted data
    $UploaderName = mysqli_real_escape_string($conn, $_POST['name']);
    $Question = mysqli_real_escape_string($conn, $_POST['id']);
    $Type = mysqli_real_escape_string($conn, $_POST['type']);

    $Comment = ($_POST['comment']);
    $Comment = mysqli_real_escape_string($conn, $Comment);
    date_default_timezone_set('Asia/Colombo');
    $date = date('Y-m-d H:i:s');
    if (isset($_POST['reply'])) {
        $reply = $_POST['reply'];
    }
    if ($Type == "comment") {
        $sql = "INSERT INTO `comments`(`Question`,`Message`,`UploaderID`,`UploaderName`,`Date`) VALUES ('$Question','$Comment','$NIC','$UploaderName','$date')";
    } else {
        $sql = "INSERT INTO `comment_reply`(`Comment`,`Reply`,`UploaderID`,`UploaderName`,`Date`) VALUES ('$reply','$Comment','$NIC','$UploaderName','$date')";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
        //sending notifications to the uploader
        $sql = "SELECT UploaderID from q_a_question WHERE ID='$Question'";
        $r3 = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($r3)) {
        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d H:i:s');
        $message = "".$UploaderName. " recently commented on your post in the forum!";
        $postedby = $row['UploaderID'];
        $t = "New Comment";
        $c = "Forum";
        $sql = "INSERT INTO `notification`(`NIC`,`Date`,`Title`,`Message`,`ReadN`,`Category`,`RelavantID`) VALUES ('$postedby','$date','$t','$message',False,'$c','$Question')";
        mysqli_query($conn,$sql);
        }
        mysqli_close($conn);
        header("Location: ../views/view question.php?QuestionID=$Question?attempt=success");
    } else {
        mysqli_close($conn);
        header("Location: ../views/view question.php?QuestionID=$Question?attemt=fail");
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>