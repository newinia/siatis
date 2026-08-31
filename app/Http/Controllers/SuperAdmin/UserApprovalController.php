<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    /**
     * Menampilkan request admin + daftar admin
     */
    public function index()
    {
        // Akun yang masih menunggu persetujuan
        $requestAdmins = User::where('status', 'pending')
            ->where('role', '!=', 'super_admin')
            ->orderBy('created_at', 'asc')
            ->get();

        // Admin yang sudah disetujui
        $admins = User::where('status', 'approved')
            ->where('role', '!=', 'super_admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('super-admin.users', compact(
            'requestAdmins',
            'admins'
        ));
    }


    /**
     * Setujui akun admin
     */
    public function approve(User $user)
    {
        $user->update([
            'status' => 'approved',
        ]);

        return back()->with(
            'success',
            'Akun ' . $user->name . ' berhasil disetujui.'
        );
    }


    /**
     * Tolak / hapus request admin
     */
    public function reject(User $user)
    {
        $user->delete();

        return back()->with(
            'success',
            'Request akun ' . $user->name . ' berhasil ditolak.'
        );
    }


    /**
     * Kembalikan akun menjadi pending
     */
    public function pending(User $user)
    {
        $user->update([
            'status' => 'pending',
        ]);

        return back()->with(
            'success',
            'Akun ' . $user->name . ' dikembalikan menjadi pending.'
        );
    }


    /**
     * Ubah role admin
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => [
                'required',
                'in:medis,instruktur',
            ],
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with(
            'success',
            'Role admin berhasil diperbarui.'
        );
    }


    /**
     * Hapus akun admin
     */
    public function destroy(User $user)
    {
        // Jangan izinkan Super Admin dihapus dari halaman ini
        if ($user->role === 'super_admin') {
            return back()->with(
                'error',
                'Akun Super Admin tidak dapat dihapus.'
            );
        }

        $user->delete();

        return back()->with(
            'success',
            'Akun ' . $user->name . ' berhasil dihapus.'
        );
    }
}
