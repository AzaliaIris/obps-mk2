<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        .nav-tabs .nav-link.active {
            background-color: #4861ff;
            color: #ffffff;
        }
        .nav-tabs .nav-link {
            color: #000000;
            background-color: #ffffff;
            border: 1px solid #dee2e6; /* Optional: to match the border style of the active tab */
        }
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
            <div class="title"><strong>Daftar Kegiatan yang Dilakukan</strong></div>
            <!-- Tombol untuk membuka modal tambah rincian -->
            <button type="button" class="btn btn-info" style="margin-bottom: 20px" data-toggle="modal" data-target="#addModal">Ajukan Kegiatan</button>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#today" data-toggle="tab">Today</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#upcoming" data-toggle="tab">Soon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#done" data-toggle="tab">Past</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="today">
                    @include('admin.partials.pengajuan_kegiatan', ['pencatatan' => $pencatatanHariIni])
                </div>
                <div class="tab-pane" id="upcoming">
                    @include('admin.partials.pengajuan_kegiatan', ['pencatatan' => $pencatatanAkanDatang])
                </div>
                <div class="tab-pane" id="done">
                    @include('admin.partials.pengajuan_kegiatan', ['pencatatan' => $pencatatanTelahDilakukan])
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal untuk pengajuan kegiatan -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Pengajuan Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ajukan_kegiatan') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kegiatan">Kegiatan</label>
                        <input class="form-control" id="kegiatan" name="kegiatan" list="kegiatanList" autocomplete="on" required>
                        <datalist id="kegiatanList">
                            @foreach($kegiatan as $item)
                            <option value="{{ $item->keterangan }}" data-id="{{ $item->kegiatan_id }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="uraian">Uraian Kegiatan</label>
                        <input class="form-control" id="uraian" name="uraian" list="uraianList" autocomplete="on" required>
                        <datalist id="uraianList">
                            @foreach($uraian as $item)
                            <option value="{{ $item->uraian_kegiatan }}" data-id="{{ $item->rincian_id }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="volume">Volume</label>
                        <input type="text" class="form-control" id="volume" name="volume" required>
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input class="form-control" id="satuan" name="satuan" list="satuanList" autocomplete="on" required>
                        <datalist id="satuanList">
                            @foreach($satuan as $item)
                            <option value="{{ $item->satuan }}" data-id="{{ $item->bobot_id }}"></option>
                            @endforeach
                        </datalist>
                    </div>                
                    <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="datetime-local" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <input type="datetime-local" class="form-control" id="waktu_selesai" name="waktu_selesai" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->addHour()->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal untuk update kegiatan -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Pengajuan Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="update_pencatatan_id" name="pencatatan_id">
                    <div class="form-group">
                        <label for="update_kegiatan">Kegiatan</label>
                        <select class="form-control select2" id="update_kegiatan" name="kegiatan_id" required>
                            <option value="">Pilih Kegiatan</option>
                            @foreach($kegiatan as $item)
                            <option value="{{ $item->kegiatan_id }}">{{ $item->keterangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="update_uraian">Uraian Kegiatan</label>
                        <select class="form-control select2" id="update_uraian" name="rincian_id" required>
                            <option value="">Pilih Uraian Kegiatan</option>
                            @foreach($uraian as $item)
                            <option value="{{ $item->rincian_id }}">{{ $item->uraian_kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="update_volume">Volume</label>
                        <input type="text" class="form-control" id="update_volume" name="volume" required>
                    </div>
                    <div class="form-group">
                        <label for="update_satuan">Satuan</label>
                        <select class="form-control select2" id="update_satuan" name="bobot_id" required>
                            <option value="">Pilih Satuan</option>
                            @foreach($satuan as $item)
                            <option value="{{ $item->bobot_id }}">{{ $item->satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="update_waktu_mulai">Waktu Mulai</label>
                        <input type="datetime-local" class="form-control" id="update_waktu_mulai" name="waktu_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="update_waktu_selesai">Waktu Selesai</label>
                        <input type="datetime-local" class="form-control" id="update_waktu_selesai" name="waktu_selesai" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="updateButton">Update</button>
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
        const deletePencatatanRoute = "{{ route('delete_pencatatan', ':pencatatan_id') }}";
        const updatePencatatanRoute = "{{ route('update_pencatatan', ':pencatatan_id') }}";
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
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const pencatatan_id = this.getAttribute('data-pencatatan_id');
            const kegiatan_id = this.getAttribute('data-kegiatan_id');
            const rincian_id = this.getAttribute('data-rincian_id');
            const volume = this.getAttribute('data-volume');
            const satuan = this.getAttribute('data-bobot_id');
            const waktu_mulai = this.getAttribute('data-waktu_mulai');
            const waktu_selesai = this.getAttribute('data-waktu_selesai');
    
            // Isi nilai ke dalam form update
            document.getElementById('update_pencatatan_id').value = pencatatan_id;
            document.getElementById('update_kegiatan').value = kegiatan_id;
            document.getElementById('update_uraian').value = rincian_id;
            document.getElementById('update_volume').value = volume;
            document.getElementById('update_satuan').value = satuan;
            document.getElementById('update_waktu_mulai').value = waktu_mulai;
            document.getElementById('update_waktu_selesai').value = waktu_selesai;
    
            // Tampilkan modal update
            $('#updateModal').modal('show');
        });
    });
    
    document.getElementById('updateButton').addEventListener('click', function() {
        const updateData = {
            kegiatan_id: document.getElementById('update_kegiatan').value,
            rincian_id: document.getElementById('update_uraian').value,
            volume: document.getElementById('update_volume').value,
            bobot_id: document.getElementById('update_satuan').value,
            waktu_mulai: document.getElementById('update_waktu_mulai').value,
            waktu_selesai: document.getElementById('update_waktu_selesai').value,
            _token: "{{ csrf_token() }}"
        };
    
        const pencatatan_id = document.getElementById('update_pencatatan_id').value;
        const urls = updatePencatatanRoute.replace(':pencatatan_id', pencatatan_id);
        fetch(urls, {
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
    
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const pencatatan_id = this.getAttribute('data-pencatatan_id');
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
                    const url = deletePencatatanRoute.replace(':pencatatan_id', pencatatan_id);
                    fetch( url, {
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
</body>
</html>
