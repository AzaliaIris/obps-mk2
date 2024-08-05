<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Uraian Kegiatan</th>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th style="min-width: 85px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pencatatan as $item)
            <tr>
                <td>{{ $item->kegiatan }}</td>
                <td>{{ $item->uraian }}</td>
                <td>{{ $item->volume }}</td>
                <td>{{ $item->satuan }}</td>
                <td>{{ $item->waktu_mulai }}</td>
                <td>{{ $item->waktu_selesai }}</td>
                <td>
                <div class="d-inline-block flex">
                    <button class="btn btn-success btn-sm edit-btn" style="display: inline-block;"
                        data-pencatatan_id="{{ $item->pencatatan_id }}"
                        data-kegiatan_id="{{ $item->kegiatan_id }}"
                        data-rincian_id="{{ $item->rincian_id }}"
                        data-volume="{{ $item->volume }}"
                        data-bobot_id="{{ $item->bobot_id }}"
                        data-waktu_mulai="{{ $item->waktu_mulai }}"
                        data-waktu_selesai="{{ $item->waktu_selesai }}">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" style="display: inline-block;"
                        data-pencatatan_id="{{ $item->pencatatan_id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </td>                      
            </tr>
            @endforeach
        </tbody>
    </table>                       
</div>