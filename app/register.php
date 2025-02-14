<?php
$alertMessage = '';
if (isset($_GET['pesan'])) {
    switch ($_GET['pesan']) {
        case 'password_tidak_sesuai':
            $alertMessage = 'Passwords do not match. Please try again.';
            break;
        case 'registrasi_gagal':
            $alertMessage = 'Registration failed. Please try again.';
            break;
        case 'registrasi_berhasil':
            $alertMessage = 'Registration successful! Please log in.';
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
    <title>e-Present - Register</title>

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

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">
                        <img src="../assets/img/login.png" alt="Student Learning">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <?php if ($alertMessage): ?>
                            <div class="alert alert-danger"><?php echo $alertMessage; ?></div>
                            <?php endif; ?>
                            <form class="user" action="Proses.php?act=register" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Your Name" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <select name="kelas" class="form-control" required>
                                        <option selected>----- Select a class -----</option>
                                        <?php
                                            include '../koneksi.php';
                                            $sql = "SELECT * FROM kelas";
                                            $result = mysqli_query($con, $sql);

                                            while ($row = mysqli_fetch_assoc($result)){
                                                echo "<option value='{$row['nama']}'>{$row['nama']}</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address" name="email" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password"
                                            name="repeat_password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login">Already have an account? Login!</a>
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

</body>

</html>