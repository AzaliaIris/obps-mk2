<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPencatatan;
use App\Models\MasterKegiatan;
use App\Models\MasterRincian;
use App\Models\Bobot;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function view_pengajuan_kegiatan(Request $request)
    {
        $perPage = $request->get('perPage', 10); // Ambil jumlah item per halaman dari request atau default ke 10
        $search = $request->get('search', '');

        $userId = auth()->user()->id;

        $pencatatan = MasterPencatatan::join('master_kegiatan', 'master_pencatatan.kegiatan_id', '=', 'master_kegiatan.kegiatan_id')
                                ->join('master_rincian', 'master_pencatatan.rincian_id', '=', 'master_rincian.rincian_id')
                                ->join('bobot', 'master_pencatatan.bobot_id','=','bobot.bobot_id')
                                ->select('master_pencatatan.*', 'master_kegiatan.keterangan as kegiatan', 'master_rincian.uraian_kegiatan as uraian',
                                'bobot.satuan as satuan')
                                ->where('master_pencatatan.user_id', $userId)
                                ->get();
                                // ->where(function($query) use ($search) {
                                //     $query->where('master_kegiatan.keterangan', 'LIKE', "%{$search}%")
                                //           ->orWhere('master_rincian.uraian_kegiatan', 'LIKE', "%{$search}%");
                                // })
                                // ->paginate($perPage);

        $kegiatan = MasterKegiatan::all();
        $uraian = MasterRincian::all();
        $satuan = Bobot::all();

        // return view('admin.pengajuan_kegiatan', compact('pencatatan', 'search', 'perPage', 'kegiatan', 'uraian','satuan'));
        return view('user.index', compact('pencatatan', 'kegiatan', 'uraian','satuan'));
    }
}
