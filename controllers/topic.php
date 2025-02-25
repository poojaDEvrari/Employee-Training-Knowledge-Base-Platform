<?php
//adding a topic in Q&A form
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
    $Topic = $_POST['topic'];
    $Topic = mysqli_real_escape_string($conn, $Topic);
    $Category = mysqli_real_escape_string($conn, $_POST['id']);
    $Description = ($_POST['description']);
    $Description = mysqli_real_escape_string($conn, $Description);
    date_default_timezone_set('Asia/Colombo');
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `q_a_question`(`Category`,`Heading`,`Message`,`UploaderID`,`UploaderName`,`Date`) VALUES ('$Category','$Topic','$Description','$NIC','$UploaderName','$date')";
    $result = 0;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        mysqli_close($conn);
        header("Location: ../views/view category.php?CategoryID=$Category?attempt=success");
    } else {
        mysqli_close($conn);
        header("Location: ../views/view category.php?CategoryID=$Categoryattempt=fail");
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>