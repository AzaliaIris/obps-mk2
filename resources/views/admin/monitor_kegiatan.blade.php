<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        #filterForm {
            display: none; /* Sembunyikan form filter secara default */
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
                <div class="title"><strong>Daftar Kegiatan berdasarkan Team</strong></div>
                
                <!-- Tombol untuk menampilkan/menyembunyikan form filter -->
                <button id="toggleFilterBtn" type="button" class="btn btn-danger mb-3">Filter</button>
                
                <!-- Form Filter -->
                <form id="filterForm" action="{{ route('view_monitor_kegiatan') }}" method="GET" class="mb-3">
                    <div class="form-group">
                        <label for="filter_team" class="mr-2">Tim</label>
                        <select name="filter_team" id="filter_team" class="form-control mr-3">
                            <option value="">Pilih Tim</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->team_id }}" {{ request('filter_team') == $team->team_id ? 'selected' : '' }}>{{ $team->teamname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter_position" class="mr-2">Posisi</label>
                        <select name="filter_position" id="filter_position" class="form-control mr-3">
                            <option value="">Pilih Posisi</option>
                            <option value="Ketua" {{ request('filter_position') == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="Anggota" {{ request('filter_position') == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter_ketersediaan" class="mr-2">Ketersediaan</label>
                        <select name="filter_ketersediaan" id="filter_ketersediaan" class="form-control mr-3">
                            <option value="">Pilih Ketersediaan</option>
                            <option value="Sedang Bekerja" {{ request('filter_ketersediaan') == 'Sedang Bekerja' ? 'selected' : '' }}>Sedang Bekerja</option>
                            <option value="Belum Bekerja" {{ request('filter_ketersediaan') == 'Belum Bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </form>

                <!-- Tombol untuk membuka modal tambah user -->
                <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#alokasiTimModal">Alokasi Tim</button>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tim</th>
                            <th>Posisi</th>
                            <th>Ketersediaan</th>
                            <th>Uraian Kegiatan</th>
                            <th style="min-width: 85px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tim as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->teamname }}</td>
                            <td>{{ $item->position }}</td>
                            <td>{{ $item->ketersediaan }}</td>
                            <td>{!! nl2br(e($item->uraian_kegiatan)) !!}</td>
                            <td>
                                <div class="d-inline-block flex">
                                    <button class="btn btn-success btn-sm edit-btn" style="display: inline-block;"
                                        data-team_user_id="{{ $item->team_user_id }}"
                                        data-team_id="{{ $item->team_id }}" 
                                        data-position="{{ $item->position }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-btn" style="display: inline-block;" 
                                        data-team_user_id="{{ $item->team_user_id }}">
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

    <!-- Modal untuk mengalokasikan user ke tim -->
    <div class="modal fade" id="alokasiTimModal" tabindex="-1" role="dialog" aria-labelledby="alokasiTimModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alokasiTimModalLabel">Alokasikan User ke Tim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('alokasi_tim') }}" method="POST">
                        @csrf
                        <!-- User -->
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Tim -->
                        <div class="form-group">
                            <label for="team_id">Tim</label>
                            <select class="form-control" id="team_id" name="team_id" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->team_id }}">{{ $team->teamname }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Posisi -->
                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <select class="form-control" id="position" name="position" required>
                                <option value="Ketua">Ketua</option>
                                <option value="Anggota">Anggota</option>
                            </select>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Alokasikan</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk update mengalokasikan user ke tim -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="alokasiTimModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Alokasi Tim User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="update_team_user_id" name="team_user_id">
                        <!-- Tim -->
                        <div class="form-group">
                            <label for="update_teamname">Tim</label>
                            <select class="form-control" id="update_teamname" name="team_id" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->team_id }}">{{ $team->teamname }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Posisi -->
                        <div class="form-group">
                            <label for="update_position">Posisi</label>
                            <select class="form-control" id="update_position" name="position" required>
                                <option value="Ketua">Ketua</option>
                                <option value="Anggota">Anggota</option>
                            </select>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Alokasikan</button>
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
        const deleteTimRoute = "{{ route('delete_tim', ':team_user_id') }}";
        const updateTimRoute = "{{ route('update_tim', ':team_user_id') }}";
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
        // Fungsi untuk menampilkan atau menyembunyikan form filter
        document.getElementById('toggleFilterBtn').addEventListener('click', function() {
            var filterForm = document.getElementById('filterForm');
            if (filterForm.style.display === 'none' || filterForm.style.display === '') {
                filterForm.style.display = 'block';
            } else {
                filterForm.style.display = 'none';
            }
        });
    
        // // Mengirimkan form saat ada perubahan pada dropdown
        // document.getElementById('filter_team').addEventListener('change', function() {
        //     document.getElementById('filterForm').submit();
        // });
        // document.getElementById('filter_position').addEventListener('change', function() {
        //     document.getElementById('filterForm').submit();
        // });
        // document.getElementById('filter_ketersediaan').addEventListener('change', function() {
        //     document.getElementById('filterForm').submit();
        // });
    </script>
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const team_user_id = this.getAttribute('data-team_user_id');
                const team_id = this.getAttribute('data-team_id');
                const position = this.getAttribute('data-position');
    
                // Fill form with data
                document.getElementById('update_team_user_id').value = team_user_id;
                document.getElementById('update_teamname').value = team_id;  // Ubah id sesuai dengan nama field team_id
                document.getElementById('update_position').value = position;
                
                // Show update modal
                $('#updateModal').modal('show');
            });
        });
    
        document.getElementById('updateForm').addEventListener('submit', function(event) {
            event.preventDefault();
    
            const updateData = {
                team_id: document.getElementById('update_teamname').value,  // Pastikan ini sesuai dengan nama field di backend
                position: document.getElementById('update_position').value,
                _token: "{{ csrf_token() }}"
            };
    
            const team_user_id = document.getElementById('update_team_user_id').value;
            const url = updateTimRoute.replace(':team_user_id', team_user_id);
            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': updateData._token
                },
                body: JSON.stringify(updateData)
            }).then(response => response.json())
            .then(data => {
                $('#updateModal').modal('hide');
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            }).catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while updating.', 'error');
            });
        });
    
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const deleteTimRoute = "{{ route('delete_tim', ':team_user_id') }}";
            const team_user_id = this.getAttribute('data-team_user_id');
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
                    const url = deleteTimRoute.replace(':team_user_id', team_user_id);
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
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
                    }).catch(error => {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
