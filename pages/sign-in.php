<!DOCTYPE html>
<html lang="en">
<?php

include('../config/database.php');
if (isset($_POST['cek'])) { 
  $pilihan = $_POST['pilihan'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($pilihan == 'siswa') {
      $q = mysqli_query($con, "SELECT * FROM siswa WHERE username = '$username' AND password = '$password' AND verifikasi = '1'");
      $r = mysqli_num_rows($q);
        if ($r == 1) {
            $d = mysqli_fetch_object($q);
            session_start();
            $_SESSION['level'] = 'siswa';
            header('location:siswa.php');
        } else {
            echo '<div class="alert alert-danger alert-dismissable" >
        <a href="" class="close" data-dismiss="alert" ></a>
        data yang anda masukan salah atau belum terverifikasi
        </div>';
        }
    } else if ($pilihan == 'petugas') {
        $q = mysqli_query($con, "SELECT * FROM `petugas` WHERE username='$username' AND password='$password'");
        $r = mysqli_num_rows($q);
        if ($r == 1) {
            $d = mysqli_fetch_object($q);
            session_start();
            $_SESSION['level'] = 'petugas';
            header('location:daftar-buku.php');
        }
    }
}
?>

<?php include('../assets/header.php') ?>

<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Masukkan username dan password</p>
                </div>
                <div class="card-body">
                  <form role="form" method="post">
                    <div class="mb-3">
                    <input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Email" name="username">
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password">
                    </div>
                    <label for="Default select example" class="form-label">Login sebagai :</label>
                            <select class="form-select" aria-label="Default select example" name="pilihan">
                                <option value="siswa">Siswa</option>
                                <option value="petugas">Petugas</option>
                            </select>
                    
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" name="cek">Sign in</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="sign-up.php" class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>