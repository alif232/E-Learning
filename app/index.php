<?php
// Check for alert messages in the URL
$alertMessage = '';
$alertClass = 'alert-danger'; // Default alert class for errors
if (isset($_GET['pesan'])) {
    switch ($_GET['pesan']) {
        case 'email_tidak_ditemukan':
            $alertMessage = 'Email not found. Please check and try again.';
            break;
        case 'password_salah':
            $alertMessage = 'Incorrect password. Please try again.';
            break;
        case 'level_tidak_dikenal':
            $alertMessage = 'Unknown user level. Please contact support.';
            break;
        case 'registrasi_berhasil':
            $alertMessage = 'Registration successful! Please log in.';
            $alertClass = 'alert-success'; // Change alert class to success for registration
            break;
        default:
            $alertMessage = '';
    }
}
?>
<?php
// Check for alert messages in the URL
$alertMessage = '';
$alertClass = 'alert-danger'; // Default alert class for errors
if (isset($_GET['pesan'])) {
    switch ($_GET['pesan']) {
        case 'email_tidak_ditemukan':
            $alertMessage = 'Email not found. Please check and try again.';
            break;
        case 'password_salah':
            $alertMessage = 'Incorrect password. Please try again.';
            break;
        case 'level_tidak_dikenal':
            $alertMessage = 'Unknown user level. Please contact support.';
            break;
        case 'registrasi_berhasil':
            $alertMessage = 'Registration successful! Please log in.';
            $alertClass = 'alert-success'; // Change alert class to success for registration
            break;
        default:
            $alertMessage = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon.png">
    <title>e-Present - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <img src="../assets/img/login.png" alt="Student Learning">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome to e-Present</h1>
                                        <!-- Alert Message within the container -->
                                        <?php if ($alertMessage): ?>
                                        <div class="alert <?php echo $alertClass; ?>" id="alertMessage">
                                            <?php echo $alertMessage; ?>
                                            <span class="close-btn" onclick="closeAlert()">×</span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <form class="user" action="Proses.php?act=login" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="register">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <script>
        // Close alert when close button is clicked
        function closeAlert() {
            document.getElementById("alertMessage").style.display = "none";
        }
    </script>

</body>

</html>