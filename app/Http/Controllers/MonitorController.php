<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\team_user;
use App\Models\MasterPencatatan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function filter_kontribusi(Request $request)
    {
        $filter = $request->input('filter');
        $users = User::select('id', 'name', 'usertype', 'jabatan')->get();
        $currentDateTime = Carbon::now()->setTimezone('Asia/Jakarta');

        $pengguna = $users->map(function ($user) use ($filter, $currentDateTime) {
            $pencatatanRecords = MasterPencatatan::where('user_id', $user->id)->get();

            switch ($filter) {
                case 'minggu':
                    $startDate = $currentDateTime->startOfWeek();
                    break;
                case 'bulan':
                    $startDate = $currentDateTime->startOfMonth();
                    break;
                case 'tahun':
                    $startDate = $currentDateTime->startOfYear();
                    break;
                default:
                    $startDate = null;
                    break;
            }

            if ($startDate) {
                $pencatatanRecords = $pencatatanRecords->where('waktu_mulai', '>=', $startDate);
            }

            $total = number_format($pencatatanRecords->sum('total'), 2);

            return (object) [
                'id' => $user->id,
                'name' => $user->name,
                'usertype' => $user->usertype,
                'jabatan' => $user->jabatan,
                'total' => $total
            ];
        });

        return view('admin.partials.pengguna_table', compact('pengguna'))->render();
    }

    
    public function delete_user($id)
    {
        try {
            $pengguna = User::findOrFail($id);
            $pengguna->delete();

            return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error saat menghapus user: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus user.']);
        }
    }

    public function update_user(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'usertype' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            //'tim' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid input.']);
        }

        try {
            $user = User::findOrFail($id);
            $user->update($request->only(['name', 'usertype', 'jabatan']));

            return response()->json(['success' => true, 'message' => 'User updated successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the user.']);
        }
    }

    public function alokasi_tim(Request $request)
    {
        // Validasi data input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'team_id' => 'required|exists:teams,team_id',
            'position' => 'required|in:Ketua,Anggota',
        ]);

        // Cek apakah user sudah ada di tim tersebut
        $existingAllocation = team_user::where('user_id', $request->user_id)
                                      ->where('team_id', $request->team_id)
                                      ->first();

        if ($existingAllocation) {
            return redirect()->back()->with('error', 'User sudah dialokasikan ke tim ini.');
        }

        // Buat alokasi baru
        team_user::create([
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
            'position' => $request->position,
        ]);

        return redirect()->back()->with('success', 'User berhasil dialokasikan ke tim.');
    }

    public function delete_tim($team_user_id)
    {
        try {
            $pengguna = team_user::findOrFail($team_user_id);
            $pengguna->delete();

            return response()->json(['success' => true, 'message' => 'Alokasi Pengguna berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error saat menghapus alokasi: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus alokasi.']);
        }
    }

    public function update_tim(Request $request, $team_user_id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|exists:teams,team_id',
            'position' => 'required|in:Ketua,Anggota',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid input.']);
        }

        try {
            $user = team_user::findOrFail($team_user_id);  // Pastikan menggunakan model yang benar
            $user->update($request->only(['team_id', 'position']));

            return response()->json(['success' => true, 'message' => 'Alokasi Tim updated successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error updating tim: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the tim.']);
        }
    }

}