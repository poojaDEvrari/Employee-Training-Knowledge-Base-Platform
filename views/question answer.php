<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
    include 'basictemplate.php';
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
    include 'basictemplate.php';
} else if (isset($_SESSION['trainee'])) {
    $NIC = $_SESSION['trainee'];
    include 'basictemplateEmployee.php';
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
    <!--link href="css/bootstrap.css" rel="stylesheet"-->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <div class="content-wrapper">
        <!-- /.container-fluid-->
        <div class="container-fluid" style="padding: 10px 40px">
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <!-- BREADCRUMBS -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">TrainMe.lk</a>
                        </li>
                        <li class="breadcrumb-item active">Q & A Page</li>
                    </ol>
                    <link href="css/styleQA.css" rel="stylesheet">
                    <div class="panel-transparent">
                        <div class="article-heading">
                            <i class="fa fa-comment-o"></i> Add a Category
                        </div>
                        <form method="POST" class="comment-form" action="../controllers/category.php">
                            <label>Category:</label>
                            <input type="text" name="category" required>
                            <br>
                            <label>Description:</label>
                            <textarea rows="5" cols="2" id="description" name="description" required></textarea>
                            <button type="submit" value="Submit" class="btn btn-wide btn-primary">Add Category</button>
                        </form>
                    </div>
                    <hr class="style-three">
                    <div class="row">
                        <?php
                        include_once '../db/dbh.php';
                        $sql = "SELECT * FROM q_a_category";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $Name = $row['Name'];
                            $ID = $row['ID'];
                            echo '<div class="col-md-6 margin-bottom-20">';
                            echo '<div class="fat-heading-abb">';
                            echo '<a href="view category.php?CategoryID=' . $ID . '" id=' . $ID . '>';
                            echo '<i class="fa fa-folder"></i>';
                            echo $Name;
                            $sql = "SELECT COUNT(*) FROM q_a_question WHERE Category='$ID'";
                            $count = mysqli_query($conn, $sql);
                            if ($count2 = mysqli_fetch_array($count)) {
                                $count3 = $count2['COUNT(*)'];
                            }
                            echo '<span class="cat-count">&nbsp(' . $count3 . ')</span>';
                            echo '</a>';
                            echo '</div>';
                            echo '<div class="fat-content-small padding-left-30">';
                            echo '<ul>';
                            $sql = "SELECT * FROM q_a_question WHERE Category='$ID'";
                            $result_set = mysqli_query($conn, $sql);
                            while ($questions = mysqli_fetch_array($result_set)) {
                                $heading = $questions['Heading'];
                                $QID = $questions['ID'];
                                echo '<li>';
                                echo '<a href="view question.php?QuestionID=' . $QID . '">';
                                echo '<i class="fa fa-file-text-o">';
                                echo '</i>';
                                echo $heading;
                                echo '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                        }
                        mysqli_close($conn);

                        ?>
                    </div>
                    <!-- END ARTICLES CATEOGIRES SECTION -->
                </div>
            </div>

            <!-- SIDEBAR STUFF -->
            <!-- END SIDEBAR STUFF -->
        </div>
    </div>
    <!-- END MAIN SECTION -->

    <!-- FOOTER -->
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
    <script>
        if (window.location.search.indexOf('attempt=fail') > -1) {
            alert('Invalid Details Entered!');
        }
        else if (window.location.search.indexOf('attempt=success') > -1) {
            alert('A new category was successfully added to the forum!');
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