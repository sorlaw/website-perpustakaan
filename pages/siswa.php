<?php

session_start();
include('../config/database.php');
if (empty($_SESSION['level'])) {
  @header('location:sign-in.php');
}

if (isset($_POST['ganti_akses'])) {
  $id_siswa = $_POST['id_siswa'];
    $d = "SELECT verifikasi FROM `siswa` WHERE id_siswa = '$id_siswa'";
    $m = mysqli_query($con, $d);

  $isi = $m->fetch_assoc();
  if ($isi['verifikasi'] == '1') {
    $q = "UPDATE `siswa` SET verifikasi = '0' WHERE id_siswa = '$id_siswa'";
      $r = mysqli_query($con, $q);
  }else{
    $q = "UPDATE `siswa` SET verifikasi = '1' WHERE id_siswa = '$id_siswa'";
      $r = mysqli_query($con, $q);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include('../assets/header.php'); ?>

<body class="g-sidenav-show bg-gray-100">

  <?php include('../assets/sidebar.php'); ?>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-10 offset-2">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Kelas</th>
              <?php
                    if ($_SESSION['level'] == 'petugas') {
                      ?>
              <th scope="col">Verifikasi</th>
              <?php
                    }
                  ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $q = mysqli_query($con, "SELECT * FROM `siswa`");
            $r = mysqli_num_rows($q);

            $n = 1;
            if ($r > 0) {
              for ($i = 0; $i < $r; $i++) {
                $row = $q->fetch_assoc();

                ?>
                <tr>
                  <th scope="rows">
                    <?= $n++ ?>
                  </th>
                  <td class="border border-light">
                    <?= $row['nama_siswa'] ?>
                  </td>
                  <td class="border border-light">
                    <?= $row['kelas'] ?>
                  </td>
                  <?php
                    if ($_SESSION['level'] == 'petugas') {
                      ?>

<td class="border border-light">
  <form method="post">
  <?php if ($row['verifikasi'] == '1') {
    ?>
    <input type="hidden" name="id_siswa" value="<?= $row["id_siswa"] ?>"><button type="submit"
      name="ganti_akses" class="btn btn-primary">izinkan</button>
    <?php
  } else { ?>
    <input type="hidden" name="id_siswa" value="<?= $row["id_siswa"] ?>"><button type="submit"
      name="ganti_akses" class="btn btn-danger">dilarang</button>
  <?php } ?>
  </form>
</td>
                      <?php
                    }
                  ?>
                </tr>
                <?php
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>



  <?php include('../assets/footer.php') ?>

</body>

</html>