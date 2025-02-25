<!------------------------ Create a Subject -------------------------------------------->
<?php
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
    ?>
    <?php
    include_once '../db/dbh.php';

    //getting data
    $ID = mysqli_real_escape_string($conn, $_POST['ID']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    if ($description == "") {
        $description = "Not Available";
    }
    //querry
    $sql = "INSERT INTO `subject`(`SubjectID`, `title`, `description`) VALUES ('$ID','$title','$description');";

    $result = mysqli_query($conn, $sql);

    //success
    if ($result) {

        //Passing quiz data to next page
        mysqli_close($conn);
        header("Location:../views/add subject.php?attempt=success");
    } //if invalid data
    else {
        mysqli_close($conn);
        header("Location: ../index.php?attempt=invalid");
    }

    //header("Location: ../add question.php?createquiz=success");
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>