<!------------------------ Create a Quiz -------------------------------------------->
<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    ?>
    <?php
    include_once '../db/dbh.php';

    //getting data
    $Title = mysqli_real_escape_string($conn, $_POST['title']);
    $Name = mysqli_real_escape_string($conn, $_POST['name']);
    $NIC = mysqli_real_escape_string($conn, $_POST['nic']);
    $Status = mysqli_real_escape_string($conn, $_POST['status']);
    $Email = mysqli_real_escape_string($conn, $_POST['email']);
    $Contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $Company = mysqli_real_escape_string($conn, $_POST['company']);
    if ($Company == "") {
        $Company = "NULL";
    }
    function rand_string($length)
    {   
        //for password creation
        $chars = "abcdefghijklmnopqrstuvwxyz!@#ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

    $password = rand_string(8);
    $pass = mysqli_real_escape_string($conn, $password);

    //password encryption
    $encrypt_password = md5($pass);

    $sql = "INSERT INTO `platform_user`(`NIC`, `RoleID`, `CompanyID`) VALUES ('$NIC','$Status','$Company');";

    $result = mysqli_query($conn, $sql);

    //success
    if ($result) {

        if ($Status == 1 or $Status == 2) {
            $sql = "INSERT INTO `trainer`(`NIC`,`Degree`) VALUES ('$NIC','B Sc Engineering');";
            $result_set = mysqli_query($conn, $sql);
            if ($result_set) {
                if ($Status == 1) {
                    $sql = "INSERT INTO `hr_department`(`NIC`, `Password`,`Title`,`FullName`,`Email`,`Contact`) VALUES ('$NIC','$encrypt_password','$Title','$Name','$Email','$Contact');";
                } else {
                    $sql = "INSERT INTO `course_provider`(`NIC`, `Password`,`Title`,`FullName`,`Email`,`Contact`) VALUES ('$NIC','$encrypt_password','$Title','$Name','$Email','$Contact');";
                }
            } else {
                mysqli_close($conn);
                header("Location: ../views/register user?attempt=invalid");
            }
        } else if ($Status == 3) {
            $sql = "INSERT INTO `trainee`(`NIC`, `Password`,`Title`,`FullName`,`Email`,`Contact`) VALUES ('$NIC','$encrypt_password','$Title','$Name','$Email','$Contact');";
        }
        $result_set = mysqli_query($conn, $sql);
        if ($result_set) {
            //sending emails
            $python = exec("python C:/xampp/cgi-bin/sendemail.py -u $NIC -p $password -e $Email");
            //$python = exec("python sendemail.py -u $NIC -p $password -e $Email");
            if ($python) {
                echo "Email with new account details was sent to the user successfully";
            } else {
                echo "Email wasn't sent successfully";
            }
            mysqli_close($conn);
            header("Location: ../views/register user.php?attempt=success");
        } else {
            mysqli_close($conn);
            header("Location: ../views/register user.php?attempt=invalid");
        }
    } else {
        mysqli_close($conn);
        header("Location: ../views/register user.php?attempt=invalid");
    }
    ?>
    <?php
} else if (isset($_SESSION['course_provider'])) {
    mysqli_close($conn);
    header("Location: ../views/register user.php?attempt=unauthorized");
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>