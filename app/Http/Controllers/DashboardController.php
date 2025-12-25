<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('Admin');

        // Staff: hanya tampilkan booking mereka sendiri
        if (!$isAdmin) {
            $userBookings = Booking::with(['room'])
                ->forUser($user->id)
                ->latest()
                ->limit(10)
                ->get();

            return view('dashboard', [
                'isAdmin'         => false,
                'userBookings'    => $userBookings,
                'totalMyBookings' => Booking::forUser($user->id)->count(),
            ]);
        }

        // Admin: tampilkan statistik lengkap
        $totalRooms = Room::count();
        $totalUsers = User::count();
        $totalBookings = Booking::count();

        // Ambil data booking 7 hari terakhir berdasarkan status (approved/pending)
        $start = now()->subDays(6)->startOfDay();
        $end = now()->endOfDay();

        $rows = Booking::query()
            ->selectRaw('DATE(created_at) as day, status, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('status', [Booking::STATUS_APPROVED, Booking::STATUS_PENDING])
            ->groupBy('day', 'status')
            ->get();

        $countsByDay = [];
        foreach ($rows as $row) {
            $day = (string) $row->day;
            $status = (string) $row->status;
            $countsByDay[$day][$status] = (int) $row->total;
        }

        $chartLabels = [];
        $confirmedData = [];
        $pendingData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayKey = $date->toDateString();

            $chartLabels[] = $date->format('M d');
            $confirmedData[] = $countsByDay[$dayKey][Booking::STATUS_APPROVED] ?? 0;
            $pendingData[] = $countsByDay[$dayKey][Booking::STATUS_PENDING] ?? 0;
        }

        return view('dashboard', [
            'isAdmin'       => true,
            'totalRooms'    => $totalRooms,
            'totalUsers'    => $totalUsers,
            'totalBookings' => $totalBookings,
            'chartLabels'   => $chartLabels,
            'confirmedData' => $confirmedData,
            'pendingData'   => $pendingData,
        ]);
    }
}
