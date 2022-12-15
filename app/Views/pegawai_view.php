<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

  <div class="container" style="max-width: 80%; margin-top: 20px;">
    <div class="card">
      <div class="card-header  bg-secondary text-white">
        Data Pegawai
      </div>
      <div class="card-body">

        <!-- form search -->
        <form action="" method="get">
          <div class="input-group mb-3">
            <input type="text" class="form-control" value="<?php echo $katakunci ?>" name="katakunci" placeholder="Masukkan Kata Kunci" aria-label="Masukkan Kata Kunci" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
          </div>
        </form>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Tambah Pegawai
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Pegawai</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <!-- form input -->
              <div class="modal-body">
                <!-- error -->
                <div class="alert alert-danger error" role="alert" style="display: none;">

                </div>

                <!-- success -->
                <div class="alert alert-primary sukses" role="alert" style="display: none;">

                </div>

                <div class="mb-3 row">
                  <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputNama">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="inputDepartemen" class="col-sm-2 col-form-label">Departemen</label>
                  <div class="col-sm-10">
                    <select name="inputDepartemen" class="form-select" id="inputDepartemen">
                      <option value="finance">Finance</option>
                      <option value="marketing">Marketing</option>
                      <option value="developer">Developer</option>
                    </select>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputAlamat">
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary tombol-tutup" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="tombolSimpan">Simpan</button>
              </div>
            </div>
          </div>
        </div>


        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Departemen</th>
              <th>Alamat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($dataPegawai as $k => $v) {
              $nomor = $nomor + 1;
            ?>
              <tr>
                <td><?php echo $nomor ?></td>
                <td><?php echo $v['nama'] ?></td>
                <td><?php echo $v['email'] ?></td>
                <td><?php echo $v['departemen'] ?></td>
                <td><?php echo $v['alamat'] ?></td>
                <td>
                  <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="edit(<?php echo $v['id'] ?>)">Edit</button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?php echo $v['id'] ?>)">Delete</button>

                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php
        $linkPagination = $pager->links();
        $linkPagination = str_replace('<li class="active">', '<li class="page-item active">', $linkPagination);
        $linkPagination = str_replace('<li>', '<li class="page-item">', $linkPagination);
        $linkPagination = str_replace("<a", "<a class='page-link'", $linkPagination);
        echo $linkPagination;
        ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>


  <script>
    function hapus($id) {
      var result = confirm('Yakin mau melakukan proses delete');
      if (result) {
        window.location = "<?php echo site_url("pegawai/hapus") ?>/" + $id;
      }
    }

    function edit($id) {
      $.ajax({
        url: "<?php echo base_url("pegawai/edit") ?>/" + $id,
        type: "get",
        success: function(hasil) {
          var $obj = $.parseJSON(hasil);
          if ($obj.id != '') {
            $('#inputId').val($obj.id);
            $('#inputNama').val($obj.nama);
            $('#inputEmail').val($obj.email);
            $('#inputDepartemen').val($obj.departemen);
            $('#inputAlamat').val($obj.alamat);
          }
        }

      });
    }

    function bersihkan() {
      $('#inputId').val('');
      $('#inputNama').val('');
      $('#inputEmail').val('');
      $('#inputAlamat').val('');
    }
    $('.tombol-tutup').on('click', function() {
      if ($('.sukses').is(":visible")) {
        window.location.href = "<?php echo current_url() . "?" . $_SERVER['QUERY_STRING'] ?>";
      }
      $('.alert').hide();
      bersihkan();
    });

    $('#tombolSimpan').on('click', function() {
      var $id = $('#inputId').val();
      var $nama = $('#inputNama').val();
      var $email = $('#inputEmail').val();
      var $departemen = $('#inputDepartemen').val();
      var $alamat = $('#inputAlamat').val();

      $.ajax({
        url: "pegawai/simpan",
        type: "post",
        data: {
          id: $id,
          nama: $nama,
          email: $email,
          departemen: $departemen,
          alamat: $alamat
        },
        success: function(hasil) {
          var $obj = $.parseJSON(hasil);
          if ($obj.sukses == false) {
            $('.sukses').hide();
            $('.error').show();
            $('.error').html($obj.error);
          } else {
            $('.error').hide();
            $('.sukses').show();
            $('.sukses').html($obj.sukses);
          }
        }
      });
      bersihkan();

    });
  </script>

</body>

</html>