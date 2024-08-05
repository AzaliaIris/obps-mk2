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
            <div class="title"><strong>Daftar Kontribusi User</strong></div>
            <!-- Tombol untuk menampilkan/menyembunyikan form filter -->
            <button id="toggleFilterBtn" type="button" class="btn btn-danger mb-3">Filter</button>
                
            <!-- Form Filter -->
            <form id="filterForm" action="{{ route('view_monitor_user') }}" method="GET" class="mb-3">
                <div class="form-group">
                    <label for="filter_jabatan">Filter Jabatan</label>
                    <select class="form-control" id="filter_jabatan" name="filter_jabatan">
                        <option value="">Pilih Jabatan</option>
                        @foreach($jabatanOptions as $jabatan)
                            <option value="{{ $jabatan }}">{{ $jabatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter_role">Filter Role</label>
                    <select class="form-control" id="filter_role" name="filter_role">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter_kontribusi">Filter Kontribusi</label>
                    <select class="form-control" id="filter_kontribusi" name="filter_kontribusi">
                        <option value="">Pilih Kontribusi</option>
                        <option value="bulan_ini">Bulan Ini</option>
                        {{-- <option value="minggu_ini">Minggu Ini</option> --}}
                        <option value="tahun_ini">Tahun Ini</option>
                        <option value="total">Total</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            </form>
            <!-- Tombol untuk membuka modal tambah user -->
            {{-- <button type="button" class="btn btn-info" style="margin-bottom: 5px" data-toggle="modal" data-target="#addUserModal">Tambah User</button> --}}
            <button type="button" class="btn btn-info mb-3"style="margin-bottom: 5px" data-toggle="modal" data-target="#addUserModal">Tambah User</button>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Jabatan</th>
                            <th id="kontribusi-header">Total Kontribusi</th>
                            <th style="min-width: 85px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pengguna-table-body">
                        @foreach($pengguna as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->usertype }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td class="kontribusi-value">{{ $item->total }}</td>
                            <td>
                            <div class="d-inline-block flex">
                                <button class="btn btn-success btn-sm edit-btn" style="display: inline-block;"
                                    data-id="{{ $item->id }}"
                                    data-name="{{$item->name}}"
                                    data-usertype="{{ $item->usertype }}"
                                    data-jabatan="{{ $item->jabatan }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" style="display: inline-block;" 
                                data-id="{{ $item->id }}">
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

    <!-- Modal untuk menambahkan user -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <!-- Usertype -->
                        <div class="form-group">
                            <label for="usertype">Usertype</label>
                            <select class="form-control" id="usertype" name="usertype" required>
                                <option value="admin">Admin</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <!-- Jabatan -->
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for updating user -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="update_user_id" name="user_id">
                        <div class="form-group">
                            <label for="update_name">Name</label>
                            <input type="text" class="form-control" id="update_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="update_usertype">Usertype</label>
                            {{-- <input type="text" class="form-control" id="update_usertype" name="usertype" required> --}}
                            <select class="form-control" id="update_usertype" name="usertype" required>
                                <option value="admin">Admin</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="update_jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="update_jabatan" name="jabatan" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="update_tim">Tim</label>
                            <input type="text" class="form-control" id="update_tim" name="tim" required>
                        </div> --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
        const deleteUserRoute = "{{ route('delete_user', ':id') }}";
        const updateUserRoute = "{{ route('update_user', ':id') }}";
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
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const usertype = this.getAttribute('data-usertype');
            const jabatan = this.getAttribute('data-jabatan');
            //const tim = this.getAttribute('data-tim');

            // Fill form with data
            document.getElementById('update_user_id').value = id;
            document.getElementById('update_name').value = name;
            document.getElementById('update_usertype').value = usertype;
            document.getElementById('update_jabatan').value = jabatan;
            //document.getElementById('update_tim').value = tim;
            
            // Show update modal
            $('#updateModal').modal('show');
        });
    });

    document.getElementById('updateForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const updateData = {
            name: document.getElementById('update_name').value,
            usertype: document.getElementById('update_usertype').value,
            jabatan: document.getElementById('update_jabatan').value,
            //tim: document.getElementById('update_tim').value,
            _token: "{{ csrf_token() }}"
        };

        const user_id = document.getElementById('update_user_id').value;
        const url = updateUserRoute.replace(':id', user_id);
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
            const deleteUserRoute = "{{ route('delete_user', ':id') }}";
            const id = this.getAttribute('data-id');
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
                    const url = deleteUserRoute.replace(':id', id);
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
