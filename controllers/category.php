<?php
//adding a new category in Q&A form
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
    //through url
    $Category = mysqli_real_escape_string($conn, $_POST['category']);
    //posted data
    $Description = ($_POST['description']);
    $Description = mysqli_real_escape_string($conn, $Description);
    //setting the timezone
    date_default_timezone_set('Asia/Colombo');
    $date = date('Y-m-d H:i:s');
    //new data->database
    $sql = "INSERT INTO `q_a_category`(`Name`,`Date`,`Description`,`UploaderID`) VALUES ('$Category','$date','$Description','$NIC')";
    $result = 0;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        mysqli_close($conn);
        header("Location: ../views/question answer.php?attempt=success");
    } else {
        mysqli_close($conn);
        header("Location: ../views/question answer.php?attempt=fail");
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>