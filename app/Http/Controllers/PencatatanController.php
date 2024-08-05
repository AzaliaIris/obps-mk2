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

class PencatatanController extends Controller
{

    public function ajukan_kegiatan(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required|exists:master_kegiatan,kegiatan_id',
            'rincian_id' => 'required|exists:master_rincian,rincian_id',
            'volume' => 'required|numeric',
            'bobot_id' => 'required|exists:bobot,bobot_id', // Ensure bobot_id is validated
            'waktu_mulai' => 'required|date_format:Y-m-d\TH:i',
            'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after:waktu_mulai',
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $waktu_mulai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_mulai);
        $waktu_selesai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_selesai);
        $jam = $waktu_mulai->diffInMinutes($waktu_selesai) / 60;

        // Retrieve the nilai_bobot from the bobot table
        $bobot = Bobot::find($request->bobot_id);
        $nilai_bobot = $bobot->nilai;
        $total = $request->volume * $jam * $nilai_bobot;

        MasterPencatatan::create([
            'user_id' => auth()->user()->id,
            'kegiatan_id' => $request->kegiatan_id,
            'rincian_id' => $request->rincian_id,
            'bobot_id' => $request->bobot_id, // Include bobot_id here
            'volume' => $request->volume,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'jam' => $jam,
            'total' => $total,
        ]);
        

        return redirect()->route('view_pengajuan_kegiatan')->with('success', 'Kegiatan berhasil diajukan.');
    }

    public function ajukan_kegiatan_user(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required|exists:master_kegiatan,kegiatan_id',
            'rincian_id' => 'required|exists:master_rincian,rincian_id',
            'volume' => 'required|numeric',
            'bobot_id' => 'required|exists:bobot,bobot_id', // Ensure bobot_id is validated
            'waktu_mulai' => 'required|date_format:Y-m-d\TH:i',
            'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after:waktu_mulai',
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $waktu_mulai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_mulai);
        $waktu_selesai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_selesai);
        $jam = $waktu_mulai->diffInMinutes($waktu_selesai) / 60;

        // Retrieve the nilai_bobot from the bobot table
        $bobot = Bobot::find($request->bobot_id);
        $nilai_bobot = $bobot->nilai;
        $total = $request->volume * $jam * $nilai_bobot;

        MasterPencatatan::create([
            'user_id' => auth()->user()->id,
            'kegiatan_id' => $request->kegiatan_id,
            'rincian_id' => $request->rincian_id,
            'bobot_id' => $request->bobot_id, // Include bobot_id here
            'volume' => $request->volume,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'jam' => $jam,
            'total' => $total,
        ]);
        

        return redirect()->route('view_pengajuan_kegiatan_user')->with('success', 'Kegiatan berhasil diajukan.');
    }

    public function delete_pencatatan($pencatatan_id)
    {
        try {
            $pencatatan = MasterPencatatan::findOrFail($pencatatan_id);
            $pencatatan->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error saat menghapus kegiatan: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }

    public function delete_pencatatan_user($pencatatan_id)
    {
        try {
            $pencatatan = MasterPencatatan::findOrFail($pencatatan_id);
            $pencatatan->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error saat menghapus kegiatan: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }


    public function update_pencatatan(Request $request, $pencatatan_id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required|exists:master_kegiatan,kegiatan_id',
            'rincian_id' => 'required|exists:master_rincian,rincian_id',
            'volume' => 'required|numeric',
            'bobot_id' => 'required|exists:bobot,bobot_id', // Ensure bobot_id is validated
            'waktu_mulai' => 'required|date_format:Y-m-d\TH:i',
            'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after:waktu_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Input tidak valid.']);
        }

        try {
            $pencatatan = MasterPencatatan::where('pencatatan_id', $pencatatan_id)->firstOrFail();

            $waktu_mulai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_mulai);
            $waktu_selesai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_selesai);
            $jam = $waktu_mulai->diffInMinutes($waktu_selesai) / 60;

            // Retrieve the nilai_bobot from the bobot table
            $bobot = Bobot::find($request->bobot_id);
            $nilai_bobot = $bobot->nilai;
            $total = $request->volume * $jam * $nilai_bobot;

            // Update data
            $pencatatan->update([
                'user_id' => auth()->user()->id,
                'kegiatan_id' => $request->kegiatan_id,
                'rincian_id' => $request->rincian_id,
                'bobot_id' => $request->bobot_id, // Include bobot_id here
                'volume' => $request->volume,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'jam' => $jam,
                'total' => $total,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            \Log::error('Error saat memperbarui pencatatan: ' . $e->getMessage(), [
                'kode' => $kode,
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function update_pencatatan_user(Request $request, $pencatatan_id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required|exists:master_kegiatan,kegiatan_id',
            'rincian_id' => 'required|exists:master_rincian,rincian_id',
            'volume' => 'required|numeric',
            'bobot_id' => 'required|exists:bobot,bobot_id', // Ensure bobot_id is validated
            'waktu_mulai' => 'required|date_format:Y-m-d\TH:i',
            'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after:waktu_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Input tidak valid.']);
        }

        try {
            $pencatatan = MasterPencatatan::where('pencatatan_id', $pencatatan_id)->firstOrFail();

            $waktu_mulai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_mulai);
            $waktu_selesai = Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_selesai);
            $jam = $waktu_mulai->diffInMinutes($waktu_selesai) / 60;

            // Retrieve the nilai_bobot from the bobot table
            $bobot = Bobot::find($request->bobot_id);
            $nilai_bobot = $bobot->nilai;
            $total = $request->volume * $jam * $nilai_bobot;

            // Update data
            $pencatatan->update([
                'user_id' => auth()->user()->id,
                'kegiatan_id' => $request->kegiatan_id,
                'rincian_id' => $request->rincian_id,
                'bobot_id' => $request->bobot_id, // Include bobot_id here
                'volume' => $request->volume,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'jam' => $jam,
                'total' => $total,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            \Log::error('Error saat memperbarui pencatatan: ' . $e->getMessage(), [
                'kode' => $kode,
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    // public function search_master_kegiatan(Request $request)
    // {
    //     $search = $request->get('q');
    //     $kegiatan = MasterKegiatan::where('keterangan', 'LIKE', "%{$search}%")->get();
    //     return response()->json($kegiatan);
    // }

    // public function search_master_rincian(Request $request)
    // {
    //     $search = $request->get('q');
    //     $uraian = MasterRincian::where('uraian_kegiatan', 'LIKE', "%{$search}%")->get();
    //     return response()->json($uraian);
    // }

    // public function search_bobot(Request $request)
    // {
    //     $search = $request->get('q');
    //     $kegiatan = Bobot::where('satuan', 'LIKE', "%{$search}%")->get();
    //     return response()->json($satuan);
    // }
    
}
