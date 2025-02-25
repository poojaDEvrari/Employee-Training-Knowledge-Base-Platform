<?php
//uploading course material
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
    ?>
    <?php
    include_once '../db/dbh.php';
    if (isset($_POST['btn-upload'])) {
        //through url
        $NIC = mysqli_real_escape_string($conn, $_GET['NIC']);
        //posted data
        $ID = mysqli_real_escape_string($conn, $_POST['ID']);
        $sql = "SELECT * FROM course_responsibility WHERE CourseID ='$ID' and TrainerID='$NIC' ";
        $result_set1 = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_array($result_set1)) {
            $Name = mysqli_real_escape_string($conn, $_POST['name']);
            $file = strval($Name) . rand(1000, 100000) . "-" . $_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $try = false;
            if (file_exists("../uploads/$ID")) {
                $ID = strval($ID);
                $folder = "../uploads/$ID/";
            } else {
                //create a new file for the course if already not existing
                $try = mkdir("../uploads/$ID");
                if ($try) {
                    $folder = "../uploads/$ID/";
                } else {
                    $folder = "../uploads/";
                }
            }

            // new file size in KB
            $new_size = $file_size / 1024;
            // new file size in KB

            // make file name in lower case
            $new_file_name = strtolower($file);
            // make file name in lower case

            $final_file = str_replace(' ', '-', $new_file_name);
            //echo $final_file;
            if (move_uploaded_file($file_loc, $folder . $final_file)) {
                $sql = "INSERT INTO course_content(CourseID,Name,Content,Type,Size,UploaderID) VALUES('$ID','$Name','$final_file','$file_type','$new_size','$NIC')";
                mysqli_query($conn, $sql);
                $sql = "SELECT * FROM course_enrolls WHERE CourseID='$ID'";
                $r2 = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($r2)) {
                    date_default_timezone_set('Asia/Colombo');
                    $date = date('Y-m-d H:i:s');
                    $message = "Course materials have been uploaded recently to " . $ID . " course!";
                    $traineeID = $row['TraineeID'];
                    $t = "Course Material Added";
                    $c = "Course";
                    $sql = "INSERT INTO `notification`(`NIC`,`Date`,`Title`,`Message`,`ReadN`,`Category`,`RelavantID`) VALUES ('$traineeID','$date','$t','$message',False,'$c','$ID')";
                }


                ?>
                <script>
                    alert('successfully uploaded');
                    window.location.href = '../views/uploaded.php?success';
                </script>
                <?php
            } else {
                mysqli_close($conn);
                ?>
                <script>
                    alert('error while uploading file');
                    window.location.href = '../views/uploaded.php?fail';
                </script>
                <?php
            }
        } else {
            mysqli_close($conn);
            header("Location: ../views/add file.php?attempt=unauthorized");
        }
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>