<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MasterPencatatan;
use App\Models\MasterKegiatan;
use App\Models\MasterRincian;
use App\Models\Team;
use App\Models\team_user;
use App\Models\Bobot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminindex()
    {
        $currentDateTime = Carbon::now()->setTimezone('Asia/Jakarta');
        
        $users = User::all();
        $totalUsers = $users->count();
        $orangTersedia = 0;
        $orangBekerja = 0;

        foreach ($users as $user) {
            $isWorking = MasterPencatatan::where('user_id', $user->id)
                ->where('waktu_mulai', '<=', $currentDateTime)
                ->where('waktu_selesai', '>=', $currentDateTime)
                ->exists();

            if ($isWorking) {
                $orangBekerja++;
            } else {
                $orangTersedia++;
            }
        }

        $totalPekerjaanBulanIni = MasterPencatatan::whereMonth('waktu_selesai', $currentDateTime->month)
            ->whereYear('waktu_selesai', $currentDateTime->year)
            ->count();

        // Menghitung jumlah maksimum pekerjaan dalam satu bulan
        $maxPekerjaanBulanIni = MasterPencatatan::selectRaw('COUNT(*) as total')
        ->where(function($query) use ($currentDateTime) {
            $query->whereMonth('waktu_mulai', $currentDateTime->month)
                ->whereYear('waktu_mulai', $currentDateTime->year)
                ->orWhereMonth('waktu_selesai', $currentDateTime->month)
                ->whereYear('waktu_selesai', $currentDateTime->year);
        })
        ->groupBy(DB::raw('YEAR(waktu_selesai), MONTH(waktu_selesai)'))
        ->orderBy('total', 'desc')
        ->first()
        ->total ?? 1; // Default to 1 to avoid division by zero

        $pekerjaanHariIni = MasterPencatatan::where('waktu_mulai', '<=', $currentDateTime)
            ->where('waktu_selesai', '>=', $currentDateTime)
            ->join('master_kegiatan', 'master_pencatatan.kegiatan_id', '=', 'master_kegiatan.kegiatan_id')
            ->join('master_rincian', 'master_pencatatan.rincian_id', '=', 'master_rincian.rincian_id')
            ->select('master_kegiatan.keterangan', 'master_rincian.uraian_kegiatan')
            ->get();

        $kontribusiBulanIni = MasterPencatatan::select('user_id', DB::raw('SUM(total) as total'))
            ->whereMonth('waktu_selesai', $currentDateTime->month)
            ->whereYear('waktu_selesai', $currentDateTime->year)
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                $user = User::find($item->user_id);
                return [
                    'name' => $user->name,
                    'total' => $item->total
                ];
            });

            // Menghitung persentase pekerjaan bulan ini
    $persentasePekerjaanBulanIni = ($totalPekerjaanBulanIni / $maxPekerjaanBulanIni) * 100;

        return view('admin.index', compact('orangTersedia', 'orangBekerja', 'persentasePekerjaanBulanIni','totalPekerjaanBulanIni', 'pekerjaanHariIni', 'kontribusiBulanIni', 'totalUsers'));
    }


    public function view_master_kegiatan(Request $request)
    {
        $kegiatan = MasterKegiatan::all();

        return view('admin.master_kegiatan', compact('kegiatan'));
    }

    public function view_master_rincian(Request $request)
    {
        $rincian = MasterRincian::all();

        return view('admin.master_rincian', compact('rincian'));
    }

    public function view_pengajuan_kegiatan(Request $request)
    {
        $userId = auth()->user()->id;
        $now = \Carbon\Carbon::now();

        // Ambil data pencatatan berdasarkan kategori waktu
        $pencatatanHariIni = MasterPencatatan::join('master_kegiatan', 'master_pencatatan.kegiatan_id', '=', 'master_kegiatan.kegiatan_id')
            ->join('master_rincian', 'master_pencatatan.rincian_id', '=', 'master_rincian.rincian_id')
            ->join('bobot', 'master_pencatatan.bobot_id','=','bobot.bobot_id')
            ->select('master_pencatatan.*', 'master_kegiatan.keterangan as kegiatan', 'master_rincian.uraian_kegiatan as uraian', 'bobot.satuan as satuan')
            ->where('master_pencatatan.user_id', $userId)
            ->whereDate('master_pencatatan.waktu_mulai', '<=', $now)
            ->whereDate('master_pencatatan.waktu_selesai', '>=', $now)
            ->get();

        $pencatatanAkanDatang = MasterPencatatan::join('master_kegiatan', 'master_pencatatan.kegiatan_id', '=', 'master_kegiatan.kegiatan_id')
            ->join('master_rincian', 'master_pencatatan.rincian_id', '=', 'master_rincian.rincian_id')
            ->join('bobot', 'master_pencatatan.bobot_id','=','bobot.bobot_id')
            ->select('master_pencatatan.*', 'master_kegiatan.keterangan as kegiatan', 'master_rincian.uraian_kegiatan as uraian', 'bobot.satuan as satuan')
            ->where('master_pencatatan.user_id', $userId)
            ->whereDate('master_pencatatan.waktu_mulai', '>', $now)
            ->get();

        $pencatatanTelahDilakukan = MasterPencatatan::join('master_kegiatan', 'master_pencatatan.kegiatan_id', '=', 'master_kegiatan.kegiatan_id')
            ->join('master_rincian', 'master_pencatatan.rincian_id', '=', 'master_rincian.rincian_id')
            ->join('bobot', 'master_pencatatan.bobot_id','=','bobot.bobot_id')
            ->select('master_pencatatan.*', 'master_kegiatan.keterangan as kegiatan', 'master_rincian.uraian_kegiatan as uraian', 'bobot.satuan as satuan')
            ->where('master_pencatatan.user_id', $userId)
            ->whereDate('master_pencatatan.waktu_selesai', '<', $now)
            ->get();

        $kegiatan = MasterKegiatan::all();
        $uraian = MasterRincian::all();
        $satuan = Bobot::all();

        return view('admin.pengajuan_kegiatan', compact('pencatatanHariIni', 'pencatatanAkanDatang', 'pencatatanTelahDilakukan', 'kegiatan', 'uraian', 'satuan'));
    }

    public function view_monitor_user(Request $request)
    {
        $filter_jabatan = $request->input('filter_jabatan');
        $filter_role = $request->input('filter_role');
        $filter_kontribusi = $request->input('filter_kontribusi');

        $users = User::select('id', 'name', 'usertype', 'jabatan')
            ->when($filter_jabatan, function($query, $jabatan) {
                return $query->where('jabatan', $jabatan);
            })
            ->when($filter_role, function($query, $role) {
                return $query->where('usertype', $role);
            })
            ->get();

        $currentDateTime = Carbon::now()->setTimezone('Asia/Jakarta');
        $pengguna = $users->map(function ($user) use ($currentDateTime, $filter_kontribusi) {
            $pencatatanQuery = MasterPencatatan::where('user_id', $user->id);
            
            if ($filter_kontribusi === 'bulan_ini') {
                $pencatatanQuery->whereMonth('waktu_selesai', $currentDateTime->month)
                                ->whereYear('waktu_selesai', $currentDateTime->year);
            // } elseif ($filter_kontribusi === 'minggu_ini') {
            //     $startOfWeek = $currentDateTime->copy()->startOfWeek();
            //     $pencatatanQuery->where('waktu_selesai', '>=', $startOfWeek)
            //           ->where('waktu_selesai', '<=', $currentDateTime);
            } elseif ($filter_kontribusi === 'tahun_ini') {
                $pencatatanQuery->whereYear('waktu_selesai', $currentDateTime->year);
            }

            $total = number_format($pencatatanQuery->sum('total'), 2);

            return (object) [
                'id' => $user->id,
                'name' => $user->name,
                'usertype' => $user->usertype,
                'jabatan' => $user->jabatan,
                'total' => $total
            ];
        });

        $jabatanOptions = User::select('jabatan')->distinct()->get()->pluck('jabatan');

        return view('admin.monitor_user', compact('pengguna', 'jabatanOptions'));
    }

    public function view_monitor_kegiatan(Request $request)
    {
        $filter_team = $request->input('filter_team');
        $filter_position = $request->input('filter_position');
        $filter_ketersediaan = $request->input('filter_ketersediaan');

        // Ambil semua pengguna dengan informasi dari tabel pivot 'team_user' dan tabel 'teams'
        $users = User::select('users.id', 'users.name', 'team_user.team_user_id as team_user_id', 'team_user.position', 'team_user.team_id', 'teams.teamname')
            ->join('team_user', 'users.id', '=', 'team_user.user_id')
            ->join('teams', 'team_user.team_id', '=', 'teams.team_id');

        // Filter berdasarkan tim
        if ($filter_team) {
            $users->where('team_user.team_id', $filter_team);
        }

        // Filter berdasarkan posisi
        if ($filter_position) {
            $users->where('team_user.position', $filter_position);
        }

        $users = $users->get();

        $currentDateTime = Carbon::now()->setTimezone('Asia/Jakarta');

        $tim = $users->map(function ($user) use ($currentDateTime) {
            // Ambil semua catatan pencatatan dari pengguna
            $pencatatanRecords = MasterPencatatan::where('user_id', $user->id)
                ->join('master_rincian', 'master_pencatatan.rincian_id', '=', 'master_rincian.rincian_id')
                ->select('master_rincian.uraian_kegiatan', 'master_pencatatan.waktu_mulai', 'master_pencatatan.waktu_selesai')
                ->get();

            // Tentukan ketersediaan
            $isWorking = $pencatatanRecords->some(function ($record) use ($currentDateTime) {
                return $record->waktu_mulai <= $currentDateTime && $record->waktu_selesai >= $currentDateTime;
            });

            if ($isWorking) {
                // Jika sedang bekerja, ambil semua uraian_kegiatan dalam rentang waktu yang berlaku
                $uraianKegiatan = $pencatatanRecords->filter(function ($record) use ($currentDateTime) {
                    return $record->waktu_mulai <= $currentDateTime && $record->waktu_selesai >= $currentDateTime;
                })->pluck('uraian_kegiatan')->unique()->values();

                $uraianKegiatan = $uraianKegiatan->map(function ($item, $index) {
                    return ($index + 1) . '. ' . $item;
                })->implode("\n");
            } else {
                // Jika tidak sedang bekerja, ambil uraian_kegiatan yang akan datang
                $upcomingRecords = $pencatatanRecords->filter(function ($record) use ($currentDateTime) {
                    return $record->waktu_mulai > $currentDateTime;
                });

                if ($upcomingRecords->isEmpty()) {
                    $uraianKegiatan = 'Tidak ada kegiatan';
                } else {
                    // Ambil kegiatan yang paling dekat dengan waktu sekarang
                    $closestRecord = $upcomingRecords->sortBy('waktu_mulai')->first();
                    $uraianKegiatan = $closestRecord ? $closestRecord->uraian_kegiatan : 'Tidak ada kegiatan';
                }
            }

            return (object) [
                'team_user_id' => $user->team_user_id,
                'name' => $user->name,
                'teamname' => $user->teamname,
                'team_id' => $user->team_id,
                'position' => $user->position,
                'ketersediaan' => $isWorking ? 'Sedang Bekerja' : 'Belum Bekerja',
                'uraian_kegiatan' => $uraianKegiatan
            ];
        });

        // Filter berdasarkan ketersediaan
        if ($filter_ketersediaan) {
            $tim = $tim->filter(function ($item) use ($filter_ketersediaan) {
                return $item->ketersediaan == $filter_ketersediaan;
            });
        }

        $users = User::all();
        $teams = Team::all();

        return view('admin.monitor_kegiatan', compact('tim', 'users', 'teams'));
    }

}
