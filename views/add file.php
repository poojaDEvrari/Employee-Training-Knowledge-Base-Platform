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
    ?>
    <?php include 'basictemplate.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 10px 30px">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">TrainMe.lk</a>
                </li>
                <li class="breadcrumb-item active">Upload Course Material</li>
            </ol>
            <div class="row">
                <div class="col-md-12 col-sm-10">
                    <form action="../controllers/upload.php?NIC=<?php echo $NIC ?> " method="post"
                          enctype="multipart/form-data">
                        <div class="form-group ">
                            <label class="control-label requiredField" for="courseID">
                                Course ID
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="courseID" name="ID" placeholder="ID of the course"
                                   type="text"/>
                        </div>
                        <div class="form-group ">
                            <label class="control-label requiredField" for="name">
                                Name
                                <span class="asteriskField">*</span>
                            </label>
                            <input class="form-control" id="name" name="name" placeholder="Name" type="text"/>
                        </div>
                        <div class="form-group ">
                            <input name="file" type="file"/>
                        </div>
                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary " name="btn-upload" type="submit">
                                    Upload
                                </button>
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
            //unsuccessful attempt
            if (window.location.search.indexOf('attempt=unauthorized') > -1) {
                alert('You are not eligible to upload files to this particular course!');
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