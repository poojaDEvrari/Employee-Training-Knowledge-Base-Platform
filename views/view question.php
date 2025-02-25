<?php
session_start();
if (isset($_SESSION['hr_dept'])) {
    $NIC = $_SESSION['hr_dept'];
    include 'basictemplate.php';
} else if (isset($_SESSION['course_provider'])) {
    $NIC = $_SESSION['course_provider'];
    include 'basictemplate.php';
} else if (isset($_SESSION['trainee'])) {
    $ID = $_SESSION['trainee'];
    $NIC = $_SESSION['trainee'];
    include 'basictemplateEmployee.php';
} else {
    $NIC = NULL;
}
if ($NIC) {
    ?>
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
                        $Question = mysqli_real_escape_string($conn, $_GET['QuestionID']);
                        $sql = "SELECT * FROM q_a_question LEFT OUTER JOIN q_a_category ON (q_a_question.Category = q_a_category.ID) WHERE q_a_question.ID='$Question'";
                        $result0 = mysqli_query($conn, $sql);
                        if ($row0 = mysqli_fetch_array($result0)) {
                            $Name = $row0['Name'];
                            $Heading = $row0['Heading'];
                        }
                        ?>
                        <li class="breadcrumb-item active">Q & A Page</li>
                        <li class="breadcrumb-item active">
                            <?php echo $Name ?>
                        </li>
                        <li class="breadcrumb-item active">
                            <?php echo $Heading ?>
                        </li>
                    </ol>
                    <link href="css/styleQA.css" rel="stylesheet">
                    <!-- END BREADCRUMBS -->
                    <!-- ARTICLES CATEGORIES SECTION -->
                    <div class="col-md-8 padding-20">
                        <div class="row">
                            <!-- BREADCRUMBS -->
                            <!-- END BREADCRUMBS -->
                            <!-- ARTICLE  -->
                            <?php
                            include_once '../db/dbh.php';
                            echo '<div class="panel panel-default">';
                            //$Question = $_GET['QuestionID'];
                            $sql = "SELECT *,Name FROM q_a_question LEFT OUTER JOIN q_a_category ON (q_a_question.Category = q_a_category.ID) WHERE q_a_question.ID='$Question'";
                            $result1 = mysqli_query($conn, $sql);
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $Name = $row1['Name'];
                                $Heading = $row1['Heading'];
                                $Date = $row1['Date'];
                                $Message = $row1['Message'];
                                $Tags = $row1['Tags'];
                                echo '<div class="article-heading margin-bottom-5">';
                                echo '<a href="#">';
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
                                $sql = "SELECT comments.ID FROM comments LEFT OUTER JOIN q_a_question ON (comments.Question = q_a_question.ID) WHERE q_a_question.ID='$Question'";
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
                                echo '<a href="#">';
                                echo '<i class="fa fa-comments-o"></i>' . $num . ' Comments </a>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="article-content">';
                                echo $Message;
                                echo '</div>';
                                echo '<div class="article-content">';
                                echo '<div class="article-tags">';
                                echo '<b>Tags:</b>';
                                $word = "";
                                $Tags = explode(",", $Tags);
                                for ($i = 0; $i < sizeof($Tags); $i++) {
                                    echo '<a href="#" class="btn btn-default btn-o btn-sm">' . $Tags[$i] . '</a>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '<hr class="style-three">';
                                echo '<div class="article-feedback">';
                                echo '<h2>';
                                echo '<small>Was This Article Helpful?</small>';
                                echo '</h2>';
                                echo '<button type="button" class="btn btn-success btn-o btn-wide">';
                                echo '<i class="fa fa-thumbs-o-up"></i> Yes</button>';
                                echo '&nbsp; &nbsp; &nbsp;';
                                echo '<button type="button" class="btn btn-danger btn-o btn-wide">No';
                                echo '<i class="fa fa-thumbs-o-down"></i>';
                                echo '</button>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>

                            <!-- END ARTICLE -->

                            <!-- COMMENTS  -->
                            <?php
                            include_once '../db/dbh.php';
                            echo '<div class="panel panel-default">
                    <div class="article-heading">
                        <i class="fa fa-comments-o"></i> Comments (' . $num . ')
                    </div>';
                            $sql = "SELECT comments.ID,comments.Message,comments.UploaderName FROM comments LEFT OUTER JOIN q_a_question ON (comments.Question = q_a_question.ID) WHERE q_a_question.ID='$Question'";
                            $result4 = mysqli_query($conn, $sql);
                            while ($row4 = mysqli_fetch_array($result4)) {
                                $comment = $row4['ID'];
                                $Message = $row4['Message'];
                                $uploaderName = $row4['UploaderName'];
                                echo
                                    '<div class="article-content">
                            <div class="article-comment-top">
                                <div class="comments-user">
                                    <img src="images/user.png" alt="gomac user">
                                    <div class="user-name">' . $uploaderName . '</div>';
                                echo '<div class="comment-post-date">Posted On
                                        <span class="italics">20 May, 2016</span>
                                    </div>
                                </div>';
                                echo '<div class="comments-content">
                                    <p>' . $Message . '</p>
                                        <script>
                                        function reply(id){
                                            document.getElementById("reply").value = id;
                                            document.getElementById("focus").focus();
                                            document.getElementById("type").options[1].selected=true;
                                        }
                                        </script>
                                        <div class="article-read-more">
                                            <button class="btn btn-default btn-sm" onclick="reply(' . $comment . ')">
                                            <i class="fa fa-reply"></i> Reply</button>
                                        </div>
                                </div>';
                                $sql = "SELECT Reply,comment_reply.UploaderName FROM comment_reply LEFT OUTER JOIN comments ON (comment_reply.Comment = comments.ID) WHERE Comment='$comment'";
                                $result5 = mysqli_query($conn, $sql);
                                while ($row5 = mysqli_fetch_array($result5)) {
                                    $reply = $row5['Reply'];
                                    $replierName = $row5['UploaderName'];
                                    echo '<div class="article-comment-second">
                                    <div class="comments-user">
                                        <img src="images/user.png" alt="gomac user">
                                        <div class="user-name">' . $replierName . '</div>
                                        <div class="comment-post-date">Posted On
                                            <span class="italics">20 May, 2016</span>
                                        </div>
                                    </div>
                                    <div class="comments-content">
                                        <p>' . $reply . '
                                        </p>
                                    </div>
                                </div>';
                                }
                                echo '</div>';
                                echo '</div>';

                            }

                            ?>
                            <!-- END FIRST LEVEL COMMENT 2 -->
                            <!--hr class="style-three"-->
                            <!-- LEAVE A REPLY SECTION -->

                            <!-- END LEAVE A REPLY SECTION -->
                        </div>
                        <!-- END COMMENTS -->

                    </div>
                    <div class="panel-transparent">
                        <div class="article-heading">
                            <i class="fa fa-comment-o"></i> Leave a Reply
                        </div>
                        <form method="POST" class="comment-form" action="../controllers/reply.php">
                            <label>Comment Type:</label>
                            <select type="text" name="type" id="type" class="form-control">
                                <option value="comment">Comment</option>
                                <option value="reply">Reply</option>
                            </select>
                            <label>Name:</label>
                            <input type="text" name="name" id="focus">
                            <br>
                            <label>Email (Optional):</label>
                            <input type="text" name="email">
                            <br>
                            <label>Comment:</label>
                            <textarea rows="5" cols="2" name="comment"></textarea>
                            <input type="hidden" id="reply" value="" name="reply">
                            <input type="hidden" id="id" value=<?php echo $Question ?> name="id">
                            <button type="submit" value="Submit" class="btn btn-wide btn-primary">Post Comment</button>
                        </form>
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
        }
        else if (window.location.search.indexOf('attempt=success') > -1) {
            alert('Comment was successfully posted!');
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