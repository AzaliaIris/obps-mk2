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
          <div class="title"><strong>Daftar Kegiatan</strong></div>
          <!-- Tombol untuk membuka modal tambah rincian -->
          <button type="button" class="btn btn-info" style="margin-bottom: 5px" data-toggle="modal" data-target="#addModal">Tambah Kegiatan</button>
          <!-- Tombol untuk membuka modal upload file Excel -->
          <button type="button" class="btn btn-success" style="margin-bottom: 5px" data-toggle="modal" data-target="#uploadModal">Import Excel</button>
          {{-- <div class="input-group" style="margin-top: 10px">
            <input type="text" id="search" class="form-control" placeholder="Cari..." value="{{ $search }}">
            <div class="input-group-append">
              <button class="btn btn-primary" id="searchButton" type="button">Cari</button>
            </div>
          </div> --}}
          <div class="table-responsive">
            {{-- <div class="d-flex justify-content-between mb-2" style="margin-top: 10px">
              <!-- Dropdown untuk memilih jumlah item per halaman -->
              <div>
                <form action="{{ route('view_master_kegiatan') }}" method="GET" id="perPageForm">
                  <label for="perPage">Tampilkan data dalam 1 tabel: </label>
                  <select name="perPage" id="perPage" onchange="document.getElementById('perPageForm').submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    <option value="200" {{ $perPage == 200 ? 'selected' : '' }}>200</option>
                    <option value="400" {{ $perPage == 400 ? 'selected' : '' }}>400</option>
                    <option value="800" {{ $perPage == 800 ? 'selected' : '' }}>800</option>
                  </select>
                </form>
              </div>
            </div> --}}
            <table class="table">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Keterangan</th>
                    <th style="min-width:85px">Aksi</th> <!-- Tambahkan kolom aksi -->
                  </tr>
                </thead>
                <tbody>
                  @foreach($kegiatan as $item)
                  <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <div class="d-inline-block flex">
                            <button class="btn btn-success btn-sm edit-btn" style="display: inline-block;" data-kegiatan_id="{{ $item->kegiatan_id }}" data-keterangan="{{ $item->keterangan }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" style="display: inline-block;" kegiatan_id="{{ $item->kegiatan_id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>              
            <!-- Tampilkan link pagination -->
            {{-- {{ $kegiatan->appends(['perPage' => $perPage])->links() }} --}}
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
          <h5 class="modal-title" id="addModalLabel">Tambah Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('add_kegiatan') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="kode">Kode</label>
              <input type="text" class="form-control" id="kode" name="kode" required>
            </div>
            <div class="form-group">
              <label for="klp">Kelompok</label>
              <input type="text" class="form-control" id="klp" name="klp" required>
            </div>
            <div class="form-group">
              <label for="fung">Fungsi</label>
              <input type="text" class="form-control" id="fung" name="fung" required>
            </div>
            <div class="form-group">
              <label for="sub">Subs</label>
              <input type="text" class="form-control" id="sub" name="sub" required>
            </div>
            <div class="form-group">
              <label for="no">Nomor</label>
              <input type="text" class="form-control" id="no" name="no" required>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control" id="keterangan" name="keterangan" required>
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
          <form action="{{ route('upload_excel_kegiatan') }}" method="POST" class="dropzone" id="excelDropzone" enctype="multipart/form-data">
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
          <h5 class="modal-title" id="updateModalLabel">Update Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="updateForm">
            @csrf
            <input type="hidden" id="update_kegiatan_id" name="kegiatan_id">
            <div class="form-group">
              <label for="update_keterangan">Keterangan</label>
              <input type="text" class="form-control" id="update_keterangan" name="keterangan" required>
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
  {{-- <script>
    document.getElementById('searchButton').addEventListener('click', function() {
      let search = document.getElementById('search').value;
      let perPage = document.getElementById('perPage').value;
      let url = new URL(window.location.href);
      url.searchParams.set('search', search);
      url.searchParams.set('perPage', perPage);
      url.searchParams.set('page', 1);  // Set page to 1
      window.location.href = url.href;
    });

    document.getElementById('perPage').addEventListener('change', function() {
      let search = document.getElementById('search').value;
      let perPage = this.value;
      let url = new URL(window.location.href);
      url.searchParams.set('search', search);
      url.searchParams.set('perPage', perPage);
      window.location.href = url.href;
    });
  </script> --}}
  <script>
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function() {
        const itemId = this.getAttribute('kegiatan_id');
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
            fetch(`/admin/view_master_kegiatan/${itemId}`, {
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
    const kegiatan_id = this.getAttribute('data-kegiatan_id');
    const keterangan = this.getAttribute('data-keterangan');
    
    // Isi nilai ke dalam form update
    document.getElementById('update_kegiatan_id').value = kegiatan_id;
    document.getElementById('update_keterangan').value = keterangan;
    
    // Tampilkan modal update
    $('#updateModal').modal('show');
  });
});

document.getElementById('updateButton').addEventListener('click', function() {
  const updateData = {
    keterangan: document.getElementById('update_keterangan').value,
    _token: "{{ csrf_token() }}"
  };

  const kegiatan_id = document.getElementById('update_kegiatan_id').value;

  fetch(`/admin/view_master_kegiatan/${kegiatan_id}`, {
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
