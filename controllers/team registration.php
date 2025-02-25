<?php
//HR/Course Providers creating teams
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <?php
    include_once '../db/dbh.php';
    $CourseID = mysqli_real_escape_string($conn, $_POST['courseID']);
    $Random = False;
    //random team inclusion requested or not
    if (isset($_POST['Random'])) {
        $Random = True;
    }
    //posted data
    $Min = mysqli_real_escape_string($conn, $_POST['Min']);
    $Max = mysqli_real_escape_string($conn, $_POST['Max']);
    $Number = mysqli_real_escape_string($conn, $_POST['Number']);
    $Enrolls = mysqli_real_escape_string($conn, $_POST['Enrolls']);
    $TeamNo = 0;

    $sql = "SELECT * from course_responsibility WHERE CourseID='$CourseID' and TrainerID='$NIC'";
    $k = -1;
    //to give team names to teams
    $alphabet = range('A', 'Z');
    rsort($alphabet);
    $r = mysqli_query($conn, $sql);
    $q = mysqli_num_rows($r);
    if ($q > 0) {
        $sql = "SELECT MAX(TeamNo) FROM team WHERE CourseID='$CourseID'";
        $result_set = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_array($result_set)) {
            if ($row['MAX(TeamNo)'] === NULL) {
                $TeamNo = 1;
            } else {
                $TeamNo = $row['MAX(TeamNo)'] + 1;
            }
        }

        if ($Max * $Number > $Enrolls) {
            $balance = $Enrolls - $Min * $Number;
        }

        $TeamArray = array();


        $k++;

        //team forming procedure
        for ($i = 0; $i < $balance; $i++) {
            $k++;
            $num = $k % 5;
            if ($num === 1) {
                $l = array_pop($alphabet);
            }
            $letter = "Team " . $l . " " . strval($num);
            $sql = "INSERT INTO `team`(`Name`,`CourseID`, `TeamNo`,`Capacity`) VALUES ('$letter','$CourseID','$TeamNo','$Max');";
            mysqli_query($conn, $sql);
            $TeamNo = $TeamNo + 1;
            $last = mysqli_insert_id($conn);
            array_push($TeamArray, $last);
        }
        for ($j = 0; $j < $Number - $balance; $j++) {
            $k++;
            $num = $k % 5;
            if ($num === 1) {
                $l = array_pop($alphabet);
            }
            $letter = "Team " . $l . " " . strval($num);
            $sql = "INSERT INTO `team`(`Name`,`CourseID`, `TeamNo`,`Capacity`) VALUES ('$letter','$CourseID','$TeamNo','$Min');";
            mysqli_query($conn, $sql);
            $TeamNo = $TeamNo + 1;
            $last = mysqli_insert_id($conn);
            array_push($TeamArray, $last);
        }

        //Randomly selecting employees in to teams
        if ($Random) {
            $sql = "SELECT TraineeID FROM course_enrolls WHERE CourseID='$CourseID'";
            $result_set = mysqli_query($conn, $sql);
            $IDArray = array();
            $total = 0;
            while ($row = mysqli_fetch_array($result_set)) {
                array_push($IDArray, $row['TraineeID']);
                $total = $total + 1;
            }
            shuffle($IDArray);

            foreach ($TeamArray as $value) {
                $sql = "SELECT Capacity FROM team WHERE TeamID='$value'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $TeamID = $value;
                    $Capacity = $row['Capacity'];
                }
                $i = 0;
                while ($i < $Capacity) {
                    $user = array_shift($IDArray);
                    $sql = "INSERT INTO `team_registration`(`TeamID`, `UserType`,`TeamType`) VALUES ('$TeamID','$user',NULL);";
                    mysqli_query($conn, $sql);
                    $i = $i + 1;
                    date_default_timezone_set('Asia/Colombo');
                    $date = date('Y-m-d H:i:s');
                    $message = "You have been included to a new team for " . $CourseID . " course!";
                    $t = "Included to New Team";
                    $c = "Course";
                    $sql = "INSERT INTO `notification`(`NIC`,`Date`,`Title`,`Message`,`ReadN`,`Category`,`RelavantID`) VALUES ('$user','$date','$t','$message',False,'$c','$CourseID')";
                    mysqli_query($conn, $sql);
                }
            }
            mysqli_close($conn);
            header("Location: ../views/register team.php?attempt=success");

        } else {
            mysqli_close($conn);
            header("Location: ../views/register team.php?attempt=success");
        }
        ?>
        <?php
    } else {
        mysqli_close($conn);
        header("Location: ../views/register team.php?attempt=unauthorized");
    }
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>