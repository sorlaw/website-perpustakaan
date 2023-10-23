<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include('../config/database.php');
if (empty($_SESSION['level'])) {
  @header('location:sign-in.php');
}
// Ketika buku di pinjam
if (isset($_POST['pinjam'])) {
  $id_buku = $_POST['id_buku'];
  $q = mysqli_query($con, "UPDATE `buku` SET status_buku = 'tunggu' WHERE id_buku = '$id_buku'");
}
// menunggu izin dari petugas
if (isset($_POST['dipinjam'])) {
  if ($_SESSION['level'] == 'petugas') {

    $id_buku = $_POST['id_buku'];
    $q = mysqli_query($con, "UPDATE `buku` SET status_buku = 'dipinjam' WHERE id_buku = '$id_buku'");
  } else {
    echo "<script>alert('harap tunggu konfirmasi dari admin')</script>";
  }
}
// ketika buku dikembalikan
if (isset($_POST['dikembalikan'])) {
  $id_buku = $_POST['id_buku'];
  $q = mysqli_query($con, "UPDATE `buku` SET status_buku = 'ada' WHERE id_buku = '$id_buku'");
}
// menghapus buku
if (isset($_POST['hapus'])) {
  $id_buku = $_POST['id_buku'];
  $d = "SELECT gambar FROM `buku` WHERE id_buku = '$id_buku'";
  $m = mysqli_query($con, $d);
  $makan = $m->fetch_assoc();
  if ($d) {
    unlink('../assets/images/' . $makan['gambar']);
  }
  $q = mysqli_query($con, "DELETE FROM `buku` WHERE id_buku = '$id_buku'");
}

// mengedit buku
if (isset($_POST['edit_buku'])) {
  $nama_buku = $_POST['nama_buku'];
  $penerbit = $_POST['penerbit'];
  $penulis = $_POST['penulis'];
  $id_buku = $_POST['id_buku'];


  //upload
  $ekstensi_diperbolehkan = array('jpg', 'png');
  $foto = $_FILES['gambar']['name'];
  $x = explode(".", $foto);
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['gambar']['tmp_name'];
  if (!empty($foto)) {
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
      $d = "SELECT gambar FROM `buku` WHERE id_buku = '$id_buku'";
      $m = mysqli_query($con, $d);
      $makan = $m->fetch_assoc();
        unlink('../assets/images/' . $makan['gambar']);
      $q = "UPDATE `buku` SET nama_buku = '$nama_buku', penerbit = '$penerbit', penulis = '$penulis', gambar = '$foto' WHERE id_buku = '$id_buku'";
      $r = mysqli_query($con, $q);
      if ($r) {

        move_uploaded_file($file_tmp, '../assets/images/' . $foto);
      }
    }
  } else {
    $q = "UPDATE `buku` SET nama_buku = '$nama_buku', penerbit = '$penerbit', penulis = '$penulis', gambar = '' WHERE id_buku = '$id_buku'";
    $r = mysqli_query($con, $q);
  }
}

// menambahkan buku
if (isset($_POST['tambah_buku'])) {
  $nama_buku = $_POST['nama_buku'];
  $penerbit = $_POST['penerbit'];
  $penulis = $_POST['penulis'];
  //upload
  $ekstensi_diperbolehkan = array('jpg', 'png');
  $foto = $_FILES['foto']['name'];
  $x = explode(".", $foto);
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['foto']['tmp_name'];
  if (!empty($foto)) {
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
      $q = "INSERT INTO `buku` (id_buku, nama_buku, penerbit, penulis, gambar, status_buku) VALUES ('', '$nama_buku', '$penerbit', '$penulis', '$foto', 'ada')";
      $r = mysqli_query($con, $q);
      if ($r) {
        move_uploaded_file($file_tmp, '../assets/images/' . $foto);
      }
    }
  } else {
    $q = "INSERT INTO `buku`( nama_buku, penerbit, penulis, gambar, status_buku) VALUES ( '$nama_buku', '$penerbit', '$penulis', '', 'ada')";
    $r = mysqli_query($con, $q);
  }
}
?>

<?php include('../assets/header.php'); ?>

<body class="g-sidenav-show  bg-gray-100">
  <?php include('../assets/sidebar.php'); ?>

  <div class="container-fluid mt-7">

    <div class="row">
      <div class="col-md-10 offset-2">
        <?php

        if ($_SESSION['level'] == 'petugas') { ?>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah buku
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" placeholder="k" name="nama_buku">
                      <label for="floatingInput">Nama Buku</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" name="penerbit" class="form-control" id="floatingInput" placeholder="k">
                      <label for="floatingInput">Penerbit</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" name="penulis" class="form-control" id="floatingInput" placeholder="k">
                      <label for="floatingInput">Penulis</label>
                    </div>
                    <div class="mb-3">
                      <label for="formFile" class="form-label">Masukkan Gambar</label>
                      <input class="form-control" name="foto" type="file" id="formFile">
                    </div>
                    <button type="submit" class="btn btn-primary" name="tambah_buku">Tambah</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Buku</th>
              <th scope="col">Penerbit</th>
              <th scope="col">Penulis</th>
              <th scope="col">Gambar</th>
              <th scope="col">Status Buku</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $q = mysqli_query($con, "SELECT * FROM `buku`");
            $r = mysqli_num_rows($q);

            $n = 1;
            if ($r > 0) {
              // Loop melalui hasil query menggunakan for loop
              for ($i = 0; $i < $r; $i++) {
                $row = $q->fetch_assoc();
                // Tampilkan data
                // $_SESSION['id_buku'] = $row['id_buku'];
                ?>
                <tr>
                  <th scope="rows">
                    <?= $n++ ?>
                  </th>
                  <td class="border border-light">
                    <?= $row['nama_buku'] ?>
                  </td>
                  <td class="border border-light">
                    <?= $row['penerbit'] ?>
                  </td>
                  <td class="border border-light">
                    <?= $row['penulis'] ?>
                  </td>
                  <td>
                    <?php
                    if ($row['gambar'] == '') {
                      echo '<img style="max-height: 100px"
                        src="../assets/images/no-foto.png" alt=""
                         class="img img-thumbnail ">';
                    } else {
                      echo '<img style="max-height: 100px"
                          src="../assets/images/' . $row['gambar'] . '" alt=""
                                       class="img img-thumbnail ">';
                    } ?>
                  </td>
                  <td class="border border-light">
                    <form action="" method="post" enctype="multipart/form-data">
                      <?php
                      if ($row['status_buku'] == 'ada') {
                        ?>
                        <input type="hidden" name="id_buku" value="<?= $row["id_buku"] ?>"><button type="submit" name="pinjam"
                          class="btn btn-primary">Ada</button>
                        <?php
                        if ($_SESSION['level'] == 'petugas') { ?>

                          <button type="submit" name="hapus" class="btn btn-danger">
                            <i class="fa-solid fa-trash fa-xl text-black d-inline-block"></i>
                          </button>
                          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="fa-solid fa-pencil fa-xl text-black d-inline-block"></i>
                          </button>
                          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-floating mb-3">
                                      <input type="text" class="form-control" id="floatingInput" placeholder="k"
                                        name="nama_buku">
                                      <label for="floatingInput">Nama Buku</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                      <input type="text" name="penerbit" class="form-control" id="floatingInput"
                                        placeholder="k">
                                      <label for="floatingInput">Penerbit</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                      <input type="text" name="penulis" class="form-control" id="floatingInput" placeholder="k">
                                      <label for="floatingInput">Penulis</label>
                                    </div>
                                    <div class="mb-3">
                                      <label for="formFile" class="form-label">Masukkan Gambar</label>
                                      <input class="form-control" name="gambar" type="file" id="formFile">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="edit_buku">edit</button>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                        }
                        ?>
                        <?php
                      } else if ($row['status_buku'] == 'tunggu') {
                        ?>
                          <?php
                          if ($_SESSION['level'] == 'petugas') { ?>
                            <input type="hidden" name="id_buku" value="<?= $row["id_buku"] ?>">
                          <?php
                          }
                          ?>
                          <button type="submit" name="dipinjam" class="btn btn-info">Ditunggu</button>
                          <?php
                          if ($_SESSION['level'] == 'petugas') { ?>

                            <button type="submit" name="hapus" class="btn btn-danger">
                              <i class="fa-solid fa-trash fa-xl text-black d-inline-block"></i>
                            </button>

                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                              <i class="fa-solid fa-pencil fa-xl text-black d-inline-block"></i>
                            </button>
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                              aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="k"
                                          name="nama_buku">
                                        <label for="floatingInput">Nama Buku</label>
                                      </div>
                                      <div class="form-floating mb-3">
                                        <input type="text" name="penerbit" class="form-control" id="floatingInput"
                                          placeholder="k">
                                        <label for="floatingInput">Penerbit</label>
                                      </div>
                                      <div class="form-floating mb-3">
                                        <input type="text" name="penulis" class="form-control" id="floatingInput" placeholder="k">
                                        <label for="floatingInput">Penulis</label>
                                      </div>
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Masukkan Gambar</label>
                                        <input class="form-control" name="gambar" type="file" id="formFile">
                                      </div>
                                      <button type="submit" class="btn btn-primary" name="edit_buku">edit</button>
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php
                          }
                          ?>

                        <?php
                      } else {
                        ?>
                          <?php
                          if ($_SESSION['level'] == 'petugas') { ?>
                            <input type="hidden" name="id_buku" value="<?= $row["id_buku"] ?>">
                          <?php
                          }
                          ?>

                          <button type="submit" name="dikembalikan" class="btn btn-secondary">Dipinjam</button>
                          <?php
                          if ($_SESSION['level'] == 'petugas') { ?>

                            <button type="submit" name="hapus" class="btn btn-danger">
                              <i class="fa-solid fa-trash fa-xl text-black d-inline-block"></i>
                            </button>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                              <i class="fa-solid fa-pencil fa-xl text-black d-inline-block"></i>
                            </button>
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                              aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                      <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="k"
                                          name="nama_buku">
                                        <label for="floatingInput">Nama Buku</label>
                                      </div>
                                      <div class="form-floating mb-3">
                                        <input type="text" name="penerbit" class="form-control" id="floatingInput"
                                          placeholder="k">
                                        <label for="floatingInput">Penerbit</label>
                                      </div>
                                      <div class="form-floating mb-3">
                                        <input type="text" name="penulis" class="form-control" id="floatingInput" placeholder="k">
                                        <label for="floatingInput">Penulis</label>
                                      </div>
                                      <div class="mb-3">
                                        <label for="formFile" class="form-label">Masukkan Gambar</label>
                                        <input class="form-control" name="gambar" type="file" id="formFile">
                                      </div>
                                      <button type="submit" class="btn btn-primary" name="edit_buku">edit</button>
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  </div>
                                </div>
                              </div>
                            </div>


                          <?php
                          }
                          ?>
                        <?php
                      }
                      ?>

                    </form>
                  </td>
                </tr>
                <?php
              }
            } else {
              echo "Tidak ada data yang ditemukan.";
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>



  <?php include('../assets/footer.php'); ?>

</body>

</html>