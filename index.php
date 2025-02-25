<script>
    //login fail -> alert
    if (window.location.search.indexOf('attempt=fail') > -1) {
        alert('Invalid Username or Password');
    }
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Start Bootstrap Template</title>
    <!-- Bootstrap core CSS-->
    <link href="views/js/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="views/js/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="views/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
            <form action="controllers/login check.php" method="POST">
                <div class="form-group">
                    <label for="platformID">Platform ID</label>
                    <input class="form-control" id="platformID" name='user' placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="Password1">Password</label>
                    <input class="form-control" id="Password1" type="password" name="pass" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Remember Password</label>
                    </div>
                </div>
                <input class="btn btn-primary btn-block" type=submit name='submit' value='Login'>
            </form>
            <div class="text-center">
                <a class="d-block small" href="">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="views/js/vendor/jquery/jquery.min.js"></script>
<script src="views/js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="views/js/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
