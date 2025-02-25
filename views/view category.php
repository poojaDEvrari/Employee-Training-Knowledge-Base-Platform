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
                        <?php
                        include_once '../db/dbh.php';
                        $Category = mysqli_real_escape_string($conn, $_GET['CategoryID']);
                        $sql = "SELECT * FROM q_a_category WHERE ID='$Category'";
                        $result0 = mysqli_query($conn, $sql);
                        if ($row0 = mysqli_fetch_array($result0)) {
                            $Name = $row0['Name'];
                        }
                        //mysqli_close($conn);    
                        ?>
                        <li class="breadcrumb-item active">Q & A Page</li>
                        <li class="breadcrumb-item active">
                            <?php echo $Name ?>
                        </li>
                    </ol>
                    <link href="css/styleQA.css" rel="stylesheet">
                    <hr class="style-three">
                    <!-- LEAVE A REPLY SECTION -->
                    <div class="panel-transparent">
                        <div class="article-heading">
                            <i class="fa fa-comment-o"></i> Add a Topic
                        </div>
                        <form method="POST" class="comment-form" action="../controllers/topic.php">
                            <label>Topic:</label>
                            <input type="text" name="topic">
                            <br>
                            <label>Name:</label>
                            <input type="text" name="name" id="focus">
                            <br>
                            <label>Email (Optional):</label>
                            <input type="text" name="email">
                            <br>
                            <label>Description:</label>
                            <textarea rows="5" cols="2" name="description" id="description"></textarea>
                            <input type="hidden" id="id" value=<?php echo $Category ?> name="id">
                            <button type="submit" value="Submit" class="btn btn-wide btn-primary">Post Topic</button>
                        </form>
                    </div>
                    <!-- END BREADCRUMBS -->
                    <!-- ARTICLES CATEGORIES SECTION -->
                    <div class="col-md-8 padding-20">
                        <div class="row">
                            <!-- BREADCRUMBS -->
                            <!-- END BREADCRUMBS -->
                            <!-- ARTICLE  -->
                            <?php
                            include_once '../db/dbh.php';
                            $Category = mysqli_real_escape_string($conn, $_GET['CategoryID']);
                            $sql = "SELECT Count(q_a_question.ID),Name FROM q_a_question LEFT OUTER JOIN q_a_category ON (q_a_question.Category = q_a_category.ID) WHERE Category='$Category'";
                            $result1 = mysqli_query($conn, $sql);
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $Count = $row1['Count(q_a_question.ID)'];
                                $Name = $row1['Name'];
                                echo '<div class="fb-heading">';
                                echo '<i class="fa fa-folder"></i>';
                                echo "Category: ";
                                echo $Name;
                                echo '<span class="cat-count">(' . $Count . ')</span>';
                                echo '</div>';
                                echo '<hr class="style-three">';
                                echo '<div class="panel panel-default">';
                                ?>

                                <?php
                                include_once '../db/dbh.php';

                                $sql = "SELECT * FROM q_a_question WHERE Category='$Category'";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $Heading = $row['Heading'];
                                    $Message = $row['Message'];
                                    $Date = $row['Date'];
                                    $Tags = $row['Tags'];
                                    $ID = $row['ID'];
                                    $sql = "SELECT comments.ID FROM comments LEFT OUTER JOIN q_a_question ON (comments.Question = q_a_question.ID) WHERE q_a_question.ID='$ID'";
                                    $result2 = mysqli_query($conn, $sql);
                                    $num = 0;
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $num = $num + 1;
                                        $comment = $row2['ID'];
                                        $sql = "SELECT COUNT(Reply) FROM comment_reply LEFT OUTER JOIN comments ON (comment_reply.Comment = comments.ID) WHERE Comment='$comment'";
                                        $result3 = mysqli_query($conn, $sql);
                                        if ($row3 = mysqli_fetch_array($result3)) {
                                            $num = $num + $row3['COUNT(Reply)'];
                                        }
                                    }
                                    echo '<div class="article-heading-abb">';
                                    echo '<a href="view question.php?QuestionID=' . $ID . '">';
                                    echo '<i class="fa fa-pencil-square-o"></i>' . $Heading . '</a>';
                                    echo '</div>';
                                    echo '<div class="article-info">';
                                    echo '<div class="art-date">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-calendar-o"></i> 20 May, 2016 </a>';
                                    echo '</div>';
                                    echo '<div class="art-category">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-folder"></i>' . $Name . '</a>';
                                    echo '</div>';
                                    echo '<div class="art-comments">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-comments-o"></i>' . $num . ' Comments </a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<div class="article-content">';
                                    echo '<p class="block-with-text">';
                                    echo $Message;
                                    echo '</div>';
                                    echo '<div class="article-read-more">';
                                    echo '<a href="view question.php?QuestionID=' . $ID . '" class="btn btn-default btn-wide">Read more...</a>';
                                    echo '</div>';
                                }
                                echo '</div>';
                            }

                            ?>

                        </div>

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
        } else if (window.location.search.indexOf('attempt=success') > -1) {
            alert('Topic was successfully added!');
        }
    </script>
    </div>
    </body>

    </html>
    <?php
    mysqli_close($conn);
} else {
    mysqli_close($conn);
    header("Location: ../index.php?attempt=fail");
}
?>