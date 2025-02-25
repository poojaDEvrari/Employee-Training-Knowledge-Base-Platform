<?php
session_start();
if (isset($_SESSION['hr_dept']) or isset($_SESSION['course_provider'])) {
    ?>
    <?php include 'basictemplate.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">Upload Status</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <div id="body">
                        <?php
                        if (isset($_GET['success'])) {
                            ?>
                            <label>File Uploaded Successfully... </label>
                            <BR>
                            <label><a href="view uploads.php">click here to view file.</a></label>
                            <?php
                        } else if (isset($_GET['fail'])) {
                            ?>
                            <label>Problem While File Uploading !</label>
                            <BR>
                            <label>Try to upload anyy files that are in one of these formats (PDF, DOC, EXE, VIDEO, MP3,
                                ZIP,etc...)</label>
                            <BR>
                            <label><a href="add file.php">Upload Again</a></label>
                            <?php
                        }
                        ?>

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
    </div>
    </body>

    </html>
    <?php
} else {
    header("Location: ../index.php?attempt=fail");
}
?>