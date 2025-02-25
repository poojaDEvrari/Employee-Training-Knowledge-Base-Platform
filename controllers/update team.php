<!------------------------ Update a team name by team member -------------------------------------------->
<?php
session_start();
if (isset($_SESSION['trainee'])) {
    $NIC = $_SESSION['trainee'];
    ?>
    <?php
    include_once '../db/dbh.php';

    //getting data
    $Name = mysqli_real_escape_string($conn, $_POST['cname']);
    $Description = mysqli_real_escape_string($conn, $_POST['description']);
    $ID = mysqli_real_escape_string($conn, $_GET['TeamID']);
    $sql = "SELECT * FROM team_registration WHERE TeamID ='$ID' and UserType='$NIC' ";
    $result_set1 = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result_set1)) {

        //querry
        $sql = "UPDATE `team` SET `Name` = '$Name', `Description` = '$Description' WHERE `TeamID`='$ID'";

        $result = mysqli_query($conn, $sql);

        //success
        if ($result) {
            mysqli_close($conn);
            header("Location:../views/view team.php?TeamID=$ID&attempt=successful");
        } //if invalid data
        else {
            mysqli_close($conn);
            header("Location:../views/view team.php?TeamID=$ID&attempt=invalid");
        }
    } else {
        mysqli_close($conn);
        header("Location: ../views/view team.php?TeamID=$ID&attempt=unauthorized");
    }
    ?>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>