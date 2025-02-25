<?php
include_once '../db/dbh.php';
?>
<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else if (isset($_SESSION['trainee'])) {
    $NIC = $_SESSION['trainee'];
    $QID = mysqli_real_escape_string($conn, $_GET['QuizID']);
    $sql = "SELECT * FROM course_enrolls WHERE TraineeID='$NIC' and CourseID = (SELECT CourseID from quiz where QuizID='$QID')";
    $result_set1 = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result_set1)) {
        $NIC = $_SESSION['trainee'];
    } else {
        $NIC = NULL;
    }
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <?php
    if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
        include 'basictemplate.php';
    } else {
        include 'basictemplateEmployee.php';
    }
    ?>
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">Answer Quiz</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <?php
                    $QuizID = $_GET['QuizID'];
                    $sql = "SELECT * FROM question where QuizID = '$QuizID' order by QuestionID";
                    $result_set = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result_set))
                    {
                    if ($row['QuestionType'] == "mcq"){
                        $QuestionID = $row['QuestionID'];
                        ?>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="question">
                                <?php echo $row['QuestionNumber'] ?> )
                                <?php echo $row['Question'] ?>
                            </label>
                        </div>
                        <?php
                        $sql2 = "SELECT * FROM mcq where QuestionID = $QuestionID ";
                        $result_set2 = mysqli_query($conn, $sql2);
                        if ($row = mysqli_fetch_array($result_set2)) {
                            $Answer1 = $row['AnswerChoice1'];
                            $Answer2 = $row['AnswerChoice2'];
                            $Answer3 = $row['AnswerChoice3'];
                            $Answer4 = $row['AnswerChoice4'];
                        }
                        ?>
                        <div id="mcq">
                            <?php $questions_array = array(

                                '<div>'
                                . '<input id="option1" type="radio" qType="mcq" name= "' . $QuestionID . '" value="' . $Answer1 . '">' . '
                                     <label for="option1"><span><span>&nbsp;</span></span>' . $Answer1 . '</label>
                                  </div>',

                                '<div>'
                                . '<input id="option2" type="radio" qType="mcq" name= "' . $QuestionID . '" value="' . $Answer2 . '">' . '
                                      <label for="option2"><span><span>&nbsp;</span></span><span><span></span></span>' . $Answer2 . '</label>
                                  </div>',

                                '<div>'
                                . '<input id="option3" type="radio" qType="mcq" name= "' . $QuestionID . '" value="' . $Answer3 . '">' . '
                                      <label for="option3"><span><span>&nbsp;</span></span>' . $Answer3 . '</label>
                                  </div>',

                                '<div>'
                                . '<input id="option4" type="radio" qType="mcq" name= "' . $QuestionID . '" value="' . $Answer4 . '">' . '
                                      <label for="option4"><span><span>&nbsp;</span></span>' . $Answer4 . '</label>
                                  </div>',

                            );

                            shuffle($questions_array);
                            for ($i = 1; $i < 5; $i++) {
                                echo array_shift($questions_array);
                            }
                            ?>
                        </div>
                        <BR>
                        <?php
                    }
                    else if ($row['QuestionType'] == "tf"){
                        $QuestionID = $row['QuestionID'];
                        ?>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="question">
                                <?php echo $row['QuestionNumber'] ?> )
                                <?php echo $row['Question'] ?>
                            </label>
                        </div>
                        <div id="tf">
                            <div>
                                <?php echo '<input id="option1" type="radio" qType="tf" name= "' . $QuestionID . '" value="True">' ?>
                                <label for="option1">
                        <span>
                          <span>&nbsp;</span>
                        </span>True</label>
                            </div>
                            <div>
                                <?php echo '<input id="option2" type="radio" qType="tf" name= "' . $QuestionID . '" value="False">' ?>
                                <label for="option2">
                        <span>
                          <span>&nbsp;</span>
                        </span>False</label>
                            </div>
                        </div>
                        <BR>
                        <?php
                    }
                    else if ($row['QuestionType'] == "short"){
                    $QuestionID = $row['QuestionID'];
                    ?>
                    <div id="short" class="form-group>
                    <label class="control-label requiredField" for="short_answer">
                        <?php echo $row['QuestionNumber'] ?> )
                        <?php echo $row['Question'] ?>
                    </label>
                    <?php echo '<input class="form-control" id="short_answer" placeholder="Answer for the question" qType="short" type="text" name= "' . $QuestionID . '" >' ?>
                </div>
                <BR>
                <?php
                }
                }
                ?>
                <div class="form-group">
                    <div>
                        <input style="margin-left: 90%" class="btn btn-primary " name="submit" value="Submit"
                               type="submit">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright © TrainMe.lk</small>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../controllers/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="js/vendor/jquery/jquery.min.js"></script>
    <script src="js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="js/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <script src="js/answer question.js"></script>
    <script type="text/javascript">
        //To access the variable
        var QuizID = "<?= $QID ?>";
    </script>
    <script>
        //fail
        if (window.location.search.indexOf('attempt=invalid') > -1) {
            alert('Invalid Details Entered!');
        }
        //empty
        else if (window.location.search.indexOf('attempt=empty') > -1) {
            alert('No data was received! Try Again!');
        }
    </script>
    </div>
    </body>

    </html>
    <?php
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>