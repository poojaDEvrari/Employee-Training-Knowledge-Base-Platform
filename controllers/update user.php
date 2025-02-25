<!------------------------ Updating user details by the user himself -------------------------------------------->
<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else if (isset($_SESSION['trainee'])) {
    $NIC = $_SESSION['trainee'];
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <?php
    include_once '../db/dbh.php';

    //getting data
    $Name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $Contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $Email = mysqli_real_escape_string($conn, $_POST['email']);
    $ID = mysqli_real_escape_string($conn, $_GET['UserID']);
    $sql = "SELECT * FROM platform_user WHERE NIC ='$ID' and NIC='$NIC' ";
    $result_set1 = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result_set1)) {

        //querry
        $sql = "SELECT NIC FROM hr_department WHERE NIC='$ID'";
        $result = mysqli_query($conn, $sql);
        $numrows = mysqli_num_rows($result);
        if ($numrows != 0) {
            $sql = "UPDATE `hr_department` SET `FullName` = '$Name', `Contact` = '$Contact', `Email` = '$Email'  WHERE `NIC`='$ID'";
            $result_set = mysqli_query($conn, $sql);
            if ($result_set) {
                mysqli_close($conn);
                header("Location:../views/view profile.php?UserID=$ID&attempt=successful");
            } else {
                mysqli_close($conn);
                header("Location:../views/view profile.php?UserID=$ID&attempt=invalid");
            }
        } else {
            $sql = "SELECT NIC FROM course_provider WHERE NIC='$ID'";
            $result = mysqli_query($conn, $sql);
            $numrows = mysqli_num_rows($result);
            if ($numrows != 0) {
                $sql = "UPDATE `course_provider` SET `FullName` = '$Name', `Contact` = '$Contact', `Email` = '$Email'  WHERE `NIC`='$ID'";
                $result_set = mysqli_query($conn, $sql);
                if ($result_set) {
                    mysqli_close($conn);
                    header("Location:../views/view profile.php?UserID=$ID&attempt=successful");
                } else {
                    mysqli_close($conn);
                    header("Location:../views/view profile.php?UserID=$ID&attempt=invalid");
                }
            } else {
                $sql = "SELECT NIC FROM trainee WHERE NIC='$ID'";
                $result = mysqli_query($conn, $sql);
                $numrows = mysqli_num_rows($result);
                if ($numrows != 0) {
                    $sql = "UPDATE `trainee` SET `FullName` = '$Name', `Contact` = '$Contact', `Email` = '$Email'  WHERE `NIC`='$ID'";
                    $result_set = mysqli_query($conn, $sql);
                    if ($result_set) {
                        mysqli_close($conn);
                        header("Location:../views/view profile.php?UserID=$ID&attempt=successful");
                    } else {
                        mysqli_close($conn);
                        header("Location:../views/view profile.php?UserID=$ID&attempt=invalid");
                    }
                } else {
                    mysqli_close($conn);
                    header("Location:../views/view profile.php?UserID=$ID&attempt=unauthorized");
                }
            }
        }


    } else {
        mysqli_close($conn);
        header("Location: ../views/view profile.php?UserID=$ID&attempt=unauthorized");
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>