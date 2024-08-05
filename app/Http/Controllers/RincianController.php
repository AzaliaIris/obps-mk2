<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterRincian;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MasterRincianImport;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RincianController extends Controller
{

    public function upload_excel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // Impor data dari file Excel ke dalam sebuah collection sementara untuk validasi
            $rows = Excel::toArray(new MasterRincianImport, $request->file('file'));
            $data = $rows[0]; // Mengambil array data dari sheet pertama

            // Validasi data
            foreach ($data as $row) {
                $validator = Validator::make($row, [
                    'kode' => 'required|string',
                    'keg' => 'required|string',
                    'rk' => 'required|string',
                    'iki' => 'required|string',
                    'uraian_kegiatan' => 'required|string',
                    'uraian_rencana_kinerja' => 'required|string',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
            }

            // // Jika semua data valid, truncate tabel dan impor data ke dalam tabel
            // DB::table('master_rincian')->delete(); // Hapus semua data dari tabel
            // Excel::import(new MasterRincianImport, $request->file('file'));

            // Jika semua data valid, update atau insert data ke dalam tabel
            foreach ($data as $row) {
                DB::table('master_rincian')->updateOrInsert(
                    ['kode' => $row['kode']],
                    [
                        'keg' => $row['keg'],
                        'rk' => $row['rk'],
                        'iki' => $row['iki'],
                        'uraian_kegiatan' => $row['uraian_kegiatan'],
                        'uraian_rencana_kinerja' => $row['uraian_rencana_kinerja'],
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'Data berhasil diunggah!']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'File yang diunggah tidak sesuai dengan template.']);
        } catch (\Exception $e) {
            \Log::error('Error saat mengupload: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah file.']);
        }
    }

    public function add_rincian(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|unique:master_rincian,kode', // Kode harus unik
            'keg' => 'required|string',
            'rk' => 'required|string',
            'iki' => 'required|string',
            'uraian_kegiatan' => 'required|string',
            'uraian_rencana_kinerja' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database
        MasterRincian::create([
            'kode' => $request->kode,
            'keg' => $request->keg,
            'rk' => $request->rk,
            'iki' => $request->iki,
            'uraian_kegiatan' => $request->uraian_kegiatan,
            'uraian_rencana_kinerja' => $request->uraian_rencana_kinerja,
        ]);

        return redirect()->route('view_master_rincian')->with('success', 'Rincian kegiatan berhasil ditambahkan.');
    }

    public function delete_rincian($kode)
    {
        try {
            $rincian = MasterRincian::findOrFail($kode);
            $rincian->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            // Catat error ke log Laravel
            \Log::error('Error saat menghapus rincian: ' . $e->getMessage(), [
                'kode' => $kode,
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }

    public function update_rincian(Request $request, $rincian_id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'uraian_kegiatan' => 'required|string',
            'uraian_rencana_kinerja' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Input tidak valid.']);
        }

        try {
            $rincian = MasterRincian::where('rincian_id', $rincian_id)->firstOrFail();

            // Update data
            $rincian->update([
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'uraian_rencana_kinerja' => $request->uraian_rencana_kinerja,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            \Log::error('Error saat memperbarui rincian: ' . $e->getMessage(), [
                'kode' => $kode,
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    
}


