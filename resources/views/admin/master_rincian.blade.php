<!DOCTYPE html>
<html>
<head>
  @include('admin.css')
  <style>
    @media only screen and (max-width: 768px){
        .dt-layout-row {
            position: relative;
            overflow: hidden;
        }
        .dt-layout-table {
            overflow-x: auto;
            white-space: wrap;
        }
        .dt-layout-table td{
            max-width: 500px;
        }
      }
  </style>
</head>
<body>
  @include('admin.header')
  @include('admin.sidebar')
  <div class="page-content">
    <div class="page-header">
      <div class="container-fluid">
        <div class="block">
          <div class="title"><strong>Daftar Rincian Kegiatan</strong></div>
          <!-- Tombol untuk membuka modal tambah rincian -->
          <button type="button" class="btn btn-info" style="margin-bottom: 5px" data-toggle="modal" data-target="#addModal">Tambah Rincian</button>
          <!-- Tombol untuk membuka modal upload file Excel -->
          <button type="button" class="btn btn-success" style="margin-bottom: 5px" data-toggle="modal" data-target="#uploadModal">Import Excel</button>
        
            <div class="table-responsive">
            <table class="table">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Uraian Kegiatan</th>
                    <th>Uraian Rencana Kinerja</th>
                    <th style="min-width: 85px">Aksi</th> <!-- Tambahkan kolom aksi -->
                  </tr>
                </thead>
                <tbody>
                  @foreach($rincian as $item)
                  <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->uraian_kegiatan }}</td>
                    <td>{{ $item->uraian_rencana_kinerja}}</td>
                    <td>
                        <div class="d-inline-block flex">
                            <button class="btn btn-success btn-sm edit-btn" style="display: inline-block;" data-rincian_id="{{ $item->rincian_id }}" data-uraian_kegiatan="{{ $item->uraian_kegiatan }}" data-uraian_rencana_kinerja="{{ $item->uraian_rencana_kinerja }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" style="display: inline-block;" rincian_id="{{ $item->rincian_id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>    
            </div>          
        </div>
      </div>
    </div>
  </div>

  <!-- Modal untuk tambah rincian -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Tambah Rincian Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('add_rincian') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="kode">Kode</label>
              <input type="text" class="form-control" id="kode" name="kode" required>
            </div>
            <div class="form-group">
              <label for="keg">Kegiatan</label>
              <input type="text" class="form-control" id="keg" name="keg" required>
            </div>
            <div class="form-group">
              <label for="rk">Rencana Kinerja</label>
              <input type="text" class="form-control" id="rk" name="rk" required>
            </div>
            <div class="form-group">
              <label for="iki">Indikator Kinerja</label>
              <input type="text" class="form-control" id="iki" name="iki" required>
            </div>
            <div class="form-group">
              <label for="uraian_kegiatan">Uraian Kegiatan</label>
              <input type="text" class="form-control" id="uraian_kegiatan" name="uraian_kegiatan" required>
            </div>
            <div class="form-group">
              <label for="uraian_rencana_kinerja">Uraian Rencana Kinerja</label>
              <input type="text" class="form-control" id="uraian_rencana_kinerja" name="uraian_rencana_kinerja" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal untuk upload file Excel -->
  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel">Upload File Excel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form untuk upload file menggunakan Dropzone -->
          <form action="{{ route('upload_excel_rincian') }}" method="POST" class="dropzone" id="excelDropzone" enctype="multipart/form-data">
            @csrf
            <div class="dz-message">
              Tarik file ke sini atau klik untuk mengunggah
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-success" id="uploadButton">Upload</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel">Update Rincian Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="updateForm">
            @csrf
            <input type="hidden" id="update_rincian_id" name="rincian_id">
            <div class="form-group">
              <label for="update_uraian_kegiatan">Uraian Kegiatan</label>
              <input type="text" class="form-control" id="update_uraian_kegiatan" name="uraian_kegiatan" required>
            </div>
            <div class="form-group">
              <label for="update_uraian_rencana_kinerja">Uraian Rencana Kinerja</label>
              <input type="text" class="form-control" id="update_uraian_rencana_kinerja" name="uraian_rencana_kinerja" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" id="updateButton">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  

  <!-- JavaScript files-->
  <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
  <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('admincss/js/charts-home.js')}}"></script>
  <script src="{{asset('admincss/js/front.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
        $('table').DataTable();
    });
  </script>
  <script>
    // Inisialisasi Dropzone
    Dropzone.options.excelDropzone = {
      autoProcessQueue: false,
      acceptedFiles: ".xlsx,.xls",
      maxFiles: 1, // Membatasi unggahan ke satu file
      init: function() {
        var submitButton = document.querySelector("#uploadButton");
        var myDropzone = this;
        submitButton.addEventListener("click", function() {
          if (myDropzone.getAcceptedFiles().length === 0) {
            Swal.fire({
              title: 'Error!',
              text: 'Silakan unggah file terlebih dahulu.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          } else {
            myDropzone.processQueue(); // Mulai unggah file
          }
        });
        this.on("sending", function(file, xhr, formData) {
          // Tambahkan CSRF token ke form data
          formData.append("_token", "{{ csrf_token() }}");
          $('#uploadModal').modal('hide'); // Tutup modal saat pengiriman dimulai
        });
        this.on("success", function(file, response) {
          if (response.success) {
            Swal.fire({
              title: 'Berhasil!',
              text: response.message,
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(function() {
              location.reload(); // Muat ulang halaman setelah sukses
            });
          } else {
            Swal.fire({
              title: 'Error!',
              text: response.message,
              icon: 'error',
              confirmButtonText: 'OK'
            }).then(function() {
              location.reload(); // Muat ulang halaman setelah error
            });
          }
        });
        this.on("error", function(file, response) {
          var message = response.message ? response.message : 'Terjadi kesalahan saat mengunggah file.';
          Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            confirmButtonText: 'OK'
          });
        });
        this.on("maxfilesexceeded", function(file) {
          this.removeAllFiles();
          this.addFile(file);
        });
      }
    };
  </script>
  @if(session('success'))
  <script>
    Swal.fire({
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      icon: 'success',
      confirmButtonText: 'OK'
    });
  </script>
  @elseif(session('error'))
  <script>
    Swal.fire({
      title: 'Error!',
      text: '{{ session('error') }}',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  </script>
  @endif
  <script>
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function() {
        const itemId = this.getAttribute('rincian_id');
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Anda tidak dapat mengembalikan data ini!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`/admin/view_master_rincian/${itemId}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
            }).then(response => response.json())
              .then(data => {
                if (data.success) {
                  Swal.fire(
                    'Dihapus!',
                    data.message,
                    'success'
                  ).then(() => {
                    location.reload(); // Muat ulang halaman setelah sukses
                  });
                } else {
                  Swal.fire(
                    'Error!',
                    data.message,
                    'error'
                  );
                }
              });
          }
        });
      });
    });
  </script>

  <script>
    document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
      // Ambil data dari tombol yang diklik
      const rincian_id = this.getAttribute('data-rincian_id');
      const uraian_kegiatan = this.getAttribute('data-uraian_kegiatan');
      const uraian_rencana_kinerja = this.getAttribute('data-uraian_rencana_kinerja');
      
      // Isi nilai ke dalam form update
      document.getElementById('update_rincian_id').value = rincian_id;
      document.getElementById('update_uraian_kegiatan').value = uraian_kegiatan;
      document.getElementById('update_uraian_rencana_kinerja').value = uraian_rencana_kinerja;
      
      // Tampilkan modal update
      $('#updateModal').modal('show');
    });
  });

  document.getElementById('updateButton').addEventListener('click', function() {
  const updateData = {
    uraian_kegiatan: document.getElementById('update_uraian_kegiatan').value,
    uraian_rencana_kinerja: document.getElementById('update_uraian_rencana_kinerja').value,
    _token: "{{ csrf_token() }}"
  };

  const rincian_id = document.getElementById('update_rincian_id').value;

  fetch(`/admin/view_master_rincian/${rincian_id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': updateData._token
    },
    body: JSON.stringify(updateData)
    }).then(response => response.json())
      .then(data => {
        $('#updateModal').modal('hide'); // Tutup modal update terlebih dahulu
        setTimeout(() => { // Tunggu sebentar sebelum menampilkan SweetAlert
          if (data.success) {
            Swal.fire({
              title: 'Berhasil!',
              text: data.message,
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              location.reload(); // Muat ulang halaman setelah sukses
            });
          } else {
            Swal.fire({
              title: 'Error!',
              text: data.message,
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        }, 500); // Waktu tunda 500ms untuk memastikan modal telah sepenuhnya ditutup
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          title: 'Error!',
          text: 'Terjadi kesalahan saat mengirim permintaan update.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      });
  });
</script>
  
</body>
</html>
