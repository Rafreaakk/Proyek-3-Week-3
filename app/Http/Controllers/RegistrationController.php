<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RegistrationController extends Controller
{
    public function store(Request $request, $activityId)
    {
        $request->validate([
            'participant_name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        $activity = Activity::findOrFail($activityId);

        //Pendaftaran hanya untuk activity published (Ongoing)
        if ($activity->status !== 'Ongoing') {
            return back()->with('error', 'Kegiatan belum dipublikasikan atau sudah selesai.');
        }

        // Pendaftaran ditolak jika start_at sudah lewat (asumsi kolom activity_date)
        if (now()->startOfDay()->greaterThan($activity->activity_date)) {
            return back()->with('error', 'Pendaftaran ditutup, kegiatan sudah lewat.');
        }

        //Email tidak boleh ganda (Validasi Aplikasi)
        if ($activity->registrations()->where('email', $request->email)->exists()) {
            return back()->with('error', 'Email ini sudah terdaftar pada kegiatan ini.');
        }

        //Kapasitas penuh (asumsi ada kolom capacity)

        $batasKapasitas = $activity->capacity ?? 500; // 
        if ($activity->registered_count >= $batasKapasitas) {
            return back()->with('error', 'Kapasitas kegiatan sudah penuh.');
        }

        // Transaction
        try {
            DB::transaction(function () use ($activity, $request) {
                // 1. Insert pendaftar
                $activity->registrations()->create([
                    'participant_name' => $request->participant_name,
                    'email' => $request->email,
                ]);
                
                // 2. Update kuota
                $activity->increment('registered_count');
            });

            return back()->with('success', 'Pendaftaran berhasil!');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
