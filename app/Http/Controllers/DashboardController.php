<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('Admin');

        // Admin: tampilkan statistik lengkap
        if ($isAdmin) {
            // 1. Ambil semua total count dalam SATU query (Atomic Count)
            $stats = DB::table(DB::raw('(SELECT count(*) FROM rooms) as rooms'))
                ->selectRaw('(SELECT count(*) FROM users) as users')
                ->selectRaw('(SELECT count(*) FROM bookings) as bookings')
                ->first();

            // 2. Ambil data booking 7 hari terakhir berdasarkan status
            $period = CarbonPeriod::create(now()->subDays(6), now());
            $chartLabels = [];
            $confirmedData = [];
            $pendingData = [];

            foreach ($period as $date) {
                $formattedDate = $date->format('Y-m-d');
                $chartLabels[] = $date->format('M d');

                $confirmed = Booking::whereDate('created_at', $formattedDate)
                    ->where('status', 'confirmed')
                    ->count();

                $pending = Booking::whereDate('created_at', $formattedDate)
                    ->where('status', 'pending')
                    ->count();

                $confirmedData[] = $confirmed;
                $pendingData[] = $pending;
            }

            return view('dashboard', [
                'isAdmin'        => true,
                'totalRooms'     => $stats->rooms ?? 0,
                'totalUsers'     => $stats->users ?? 0,
                'totalBookings'  => $stats->bookings ?? 0,
                'chartLabels'    => $chartLabels,
                'confirmedData'  => $confirmedData,
                'pendingData'    => $pendingData
            ]);
        }

        // Staff: hanya tampilkan booking mereka sendiri
        $userBookings = Booking::with(['room'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', [
            'isAdmin'       => false,
            'userBookings'  => $userBookings,
            'totalMyBookings' => Booking::where('user_id', $user->id)->count()
        ]);
    }
}
