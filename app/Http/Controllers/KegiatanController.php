<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKegiatan;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MasterKegiatanImport;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    public function upload_excel_kegiatan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // Impor data dari file Excel ke dalam sebuah collection sementara untuk validasi
            $rows = Excel::toArray(new MasterKegiatanImport, $request->file('file'));
            $data = $rows[0]; // Mengambil array data dari sheet pertama

            // Validasi data
            foreach ($data as $row) {
                $validator = Validator::make($row, [
                    'kode' => 'required|string',
                    'klp' => 'required|string',
                    'fung' => 'required|string',
                    'sub' => 'required|string',
                    'no' => 'required|string',
                    'keterangan' => 'required|string',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
            }

            // // Jika semua data valid, truncate tabel dan impor data ke dalam tabel
            // DB::table('master_kegiatan')->delete(); // Hapus semua data dari tabel
            // Excel::import(new MasterKegiatanImport, $request->file('file'));

            // Jika semua data valid, update atau insert data ke dalam tabel
            foreach ($data as $row) {
                DB::table('master_kegiatan')->updateOrInsert(
                    ['kode' => $row['kode']],
                    [
                        'klp' => $row['klp'],
                        'fung' => $row['fung'],
                        'sub' => $row['sub'],
                        'no' => $row['no'],
                        'keterangan' => $row['keterangan'],
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'Data berhasil diunggah!']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'File yang diunggah tidak sesuai dengan template.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah file.']);
        }
    }

    public function add_kegiatan(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|unique:master_kegiatan,kode', // Kode harus unik
            'klp' => 'required|string',
            'fung' => 'required|string',
            'sub' => 'required|string',
            'no' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database
        MasterKegiatan::create([
            'kode' => $request->kode,
            'klp' => $request->klp,
            'fung' => $request->fung,
            'sub' => $request->sub,
            'no' => $request->no,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('view_master_kegiatan')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function delete_kegiatan($kegiatan_id)
    {
        try {
            $kegiatan = MasterKegiatan::findOrFail($kegiatan_id);
            $kegiatan->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            // Catat error ke log Laravel
            \Log::error('Error saat menghapus kegiatan: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }

    public function update_kegiatan(Request $request, $kegiatan_id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Input tidak valid.']);
        }

        try {
            $kegiatan = MasterKegiatan::where('kegiatan_id', $kegiatan_id)->firstOrFail();

            // Update data
            $kegiatan->update([
                'keterangan' => $request->keterangan,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            \Log::error('Error saat memperbarui keterangan: ' . $e->getMessage(), [
                'kode' => $kode,
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    
}


