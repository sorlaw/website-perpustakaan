
<!DOCTYPE html>
<html lang="en">

<?php 
session_start();
include('../config/database.php');
if(isset($_POST['kirim'])) {
  $kelas = $_POST['kelas'];
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $telp = $_POST['no_hp'];
  $q = mysqli_query($con, "INSERT INTO `siswa` ( nama_siswa,kelas,no_telp,verifikasi, username, password  ) VALUES ('$nama', '$kelas', '$telp', '0', '$username', '$password')");
  if ($q) {
      echo '<div class="alert alert-success alert-dismissable">
              <a href="" class="close" data-dismiss="alert" aria-label="close">×</a>
              Registrasi Berhasil Tunggu verifikasi oleh admin
              </div>';
      header('location:sign-in.php');      
  }
}

?>

<?php include('../assets/header.php'); ?>

<body class="">
  <main class="main-content  mt-0">
    <div class="container">
      <div class="row mt-lg-5 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Silahkan daftar</h5>
            </div>
            <div class="card-body">
              <form role="form" method="post">
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Masukkan nama" aria-label="Name" name="nama">
                </div>
                <div class="mb-3">
                  <input type="number" class="form-control" placeholder="Kelas" name="kelas">
                </div>
                <div class="mb-3">
                  <input type="number" class="form-control" placeholder="Masukkan no hp" name="no_hp">
                </div>
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Masukkan username" name="username">
                </div>
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Masukkan Password" aria-label="Password" name="password">
                </div>
                
                <div class="text-center">
                  <button type="submit" name="kirim" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="sign-in.html" class="text-dark font-weight-bolder">Sign in</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
 
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
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