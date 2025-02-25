<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
} else {
    $NIC = NULL;
}
if ($NIC) {
    include_once '../db/dbh.php';
    ?>


    <?php
    //check if the quiz was created shortly before
    if (isset($_SESSION['NIC'])) {
        $QuizID = mysqli_real_escape_string($conn, $_GET['QuizID']);
        $NIC = $_SESSION['NIC'];
        $sql = "SELECT CourseID FROM quiz WHERE QuizID ='$QuizID'";
        $result_set2 = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_array($result_set2)) {
            $CourseID = $row['CourseID'];
            $sql = "SELECT * FROM course_responsibility WHERE CourseID ='$CourseID' and TrainerID='$NIC'";
            $result_set1 = mysqli_query($conn, $sql);
            if ($row = mysqli_fetch_array($result_set1)) {
                ?>
                <?php include 'basictemplate.php'; ?>
                <div class="content-wrapper">
                    <div class="container-fluid" style="padding: 10px 30px">
                        <!-- Breadcrumbs-->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">TrainMe.lk</a>
                            </li>
                            <li class="breadcrumb-item active">Create questionnaire</li>
                        </ol>
                        <div class="row">
                            <div class="col-md-12 col-sm-10">


                                <form id="questionForm">
                                    <div class="form-group" id="div_radio.activeinactive.select">
                                        <label class="control-label requiredField"
                                               for="div_radio.activeinactive.select">
                                            Select the type of the question
                                            <span class="asteriskField">*</span>
                                        </label>
                                        <div class="form-group">
                                            <label class="radio-inline" style="padding: 10px 10px;">
                                                <input name="radio.activeinactive.select" type="radio" required
                                                       onclick="handleClick('MCQ');" value="MCQ"/> MCQ
                                            </label>
                                            <label class="radio-inline" style="padding: 10px 10px;">
                                                <input name="radio.activeinactive.select" type="radio"
                                                       onclick="handleClick('Short');" value="Short"/> Short Answers
                                            </label>
                                            <label class="radio-inline" style="padding: 10px 10px;">
                                                <input name="radio.activeinactive.select" type="radio"
                                                       onclick="handleClick('TF');" value="TF"/> True & False Question
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label requiredField" for="question">
                                            Question
                                            <span class="asteriskField">*</span>
                                        </label>
                                        <textarea style="height:60px" class="form-control" id="question" name="question"
                                                  placeholder="Type the question" rows="4"
                                                  required></textarea>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label requiredField" for="marks">
                                            Marks
                                            <span class="asteriskField">*</span>
                                        </label>
                                        <input class="form-control" id="marks" name="marks"
                                               placeholder="Available marks for the question" type="number" required
                                        />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label requiredField">
                                            Answer Choices / Answer
                                        </label>
                                    </div>
                                    <div id="mcq">
                                        <div class="form-group">
                                            <input class="form-control" id="choice" name="choice" placeholder="Choice 1"
                                                   type="text"/>
                                        </div>
                                        <div class="form-group ">
                                            <input class="form-control" id="choice2" name="choice"
                                                   placeholder="Choice 2" type="text"/>
                                        </div>
                                        <div class="form-group ">
                                            <input class="form-control" id="choice3" name="choice"
                                                   placeholder="Choice 3" type="text"/>
                                        </div>
                                        <div class="form-group ">
                                            <input class="form-control" id="choice4" name="choice"
                                                   placeholder="Choice 4" type="text"/>
                                        </div>
                                        <div class="form-group ">
                                            <input style="border: dashed" class="form-control" id="ansmcq" name="choice"
                                                   required placeholder="Correct Answer : Choice Number"
                                                   type="number" min="1" max="4"/>
                                        </div>
                                    </div>
                                    <div id="tf">
                                        <div class="form-group" id="div_radio.activeinactive-tf">
                                            <div class="">
                                                <label class="radio-inline" style="padding: 10px 10px;">
                                                    <input id="tfRadio" name="radio.activeinactive.tf" type="radio"
                                                           value="Active"/> True
                                                </label>
                                                <label class="radio-inline" style="padding: 10px 10px;">
                                                    <input name="radio.activeinactive.tf" type="radio"
                                                           value="Not active yet"/> False
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="short">
                                        <div class="form-group">
                                            <label class="form-group" for="short_answer">
                                            </label>
                                            <input class="form-control" id="short_answer" name="shortanswer"
                                                   placeholder="Answer for the question" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <input class="btn btn-primary " name="next" type="submit" value="Next">
                                            <input style="margin-left: 10%" class="btn btn-primary " name="submit"
                                                   value="Submit" type="submit">
                                        </div>
                                    </div>
                                </form>
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
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Select "Logout" below if you are ready to end your current
                                    session.
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <a class="btn btn-primary" href="../controllers/logout.php">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bootstrap core JavaScript-->
                    <script src="js/vendor/jquery/jquery.min.js"></script>
                    <script src="js/jquery-3.3.1.min.js"></script>
                    <script src="js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <!-- Core plugin JavaScript-->
                    <script src="js/vendor/jquery-easing/jquery.easing.min.js"></script>
                    <!-- Custom scripts for all pages-->
                    <script src="js/sb-admin.min.js"></script>
                    <script src="js/add question.js"></script>
                </div>
                </body>

                </html>
                <?php
            } else {
                mysqli_close($conn);
                header("Location: add quiz.php?attempt=unauthorized");
            }
        } else {
            mysqli_close($conn);
            header("Location: add quiz.php?attempt=invalid");
        }
    } else {
        //Quiz was created a long time ago
        mysqli_close($conn);
        header("Location: add quiz.php?attempt=delayed");
    }
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>