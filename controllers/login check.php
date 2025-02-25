<?php
include_once '../db/dbh.php';
if (isset($_POST['submit'])) {

    if (!empty($_POST['user']) && !empty($_POST['pass'])) {

        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

        //password encryption
        $encrypt_password = md5($pass);

        $query = mysqli_query($conn, "SELECT * FROM hr_department WHERE NIC='$user' AND Password='$encrypt_password'");
        $numrows = mysqli_num_rows($query);
        if ($numrows != 0) {
            //HR Department
            session_start();
            $_SESSION['hr_dept'] = $user;
            mysqli_close($conn);
            header("Location: ../views/blank.php");
        } else {
            $query = mysqli_query($conn, "SELECT * FROM course_provider WHERE NIC='$user' AND Password='$encrypt_password'");
            $numrows = mysqli_num_rows($query);
            if ($numrows != 0) {
                //Course Provider
                session_start();
                $_SESSION['course_provider'] = $user;
                mysqli_close($conn);
                header("Location: ../views/blank.php");
            } else {
                $query = mysqli_query($conn, "SELECT * FROM trainee WHERE NIC='$user' AND Password='$encrypt_password'");
                $numrows = mysqli_num_rows($query);
                if ($numrows != 0) {
                    //Employee
                    session_start();
                    $_SESSION['trainee'] = $user;
                    mysqli_close($conn);
                    header("Location: ../views/blankEmployee.php");
                } else {
                    //Outsider
                    mysqli_close($conn);
                    header("Location: ../index.php?attempt=fail");
                }
            }
        }
    } else {
        mysqli_close($conn);
        header("Location: ../index.php?attempt=fail");
    }
}
?>