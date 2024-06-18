<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\WopalModel;
use App\Models\PackagesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function dashboardDataSuperAdmin()
    {
        $userCount = User::count();
        $woCount = WopalModel::count();
        $bookingCount = BookingModel::count();
        $packageCount = PackagesModel::count();
        $visitorCount = Cache::remember('visitor_count', 60, function () {
            return DB::table('visitors')->count();
        });

        return response()->json([
            'woCount' => $woCount,
            'bookingCount' => $bookingCount,
            'packageCount' => $packageCount,
            'visitorCount' => $visitorCount,
            'userCount' =>  $userCount,
        ]);
    }

    public function dashboardDataAdmin()
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }
    
        $userId = $user->id;
    
        // Ambil data paket berdasarkan user id
        $pakets = PackagesModel::with('wopal')
            ->whereHas('wopal', function($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->get();
    
        $jumlahPakets = $pakets->count();
    
        // Ambil data booking berdasarkan user id
        $bookings = BookingModel::with(['package', 'user'])
            ->whereHas('package', function ($query) use ($userId) {
                $query->whereHas('wopal', function ($q) use ($userId) {
                    $q->where('id_user', $userId);
                });
            })->get();
    
        $events = [];
        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking->user->name,
                'paket' => $booking->package->nama_paket,
                'start' => $booking->tgl_nk,  // Menggunakan 'tgl_nk' sebagai tanggal mulai
                'end' => $booking->tgl_nk,    // Menggunakan 'tgl_nk' sebagai tanggal selesai
                // Anda bisa menambahkan properti lain jika diperlukan
            ];
        }
    
        // Mengambil jumlah pengunjung dari cache
        $visitorCount = Cache::remember('visitor_count', 60, function () {
            return DB::table('visitors')->count();
        });
    
        return response()->json([
            'visitorCount' => $visitorCount,
            'jumlahPakets' => $jumlahPakets,
            'events' => $events,  // Menyertakan events dalam respons JSON
            'jumlahBookings' => count($events), // Jumlah bookings
        ]);
    }

    
    
    

}
