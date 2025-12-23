<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Services\BookingService;
use App\Repositories\BookingRepository;
use App\Repositories\RoomRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $service,
        protected BookingRepository $repository,
        protected RoomRepository $roomRepository
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Booking::class);

        $filters = $request->only(['status', 'room_id', 'user_id']);

        if (! $request->user()->hasRole('Admin')) {
            $filters['user_id'] = $request->user()->id;
        }

        $bookings = $this->repository->paginate(10, $filters);

        return view('dashboard.booking.index', compact('bookings'));
    }

    public function create()
    {
        $this->authorize('create', Booking::class);

        $rooms = $this->roomRepository->getActive();

        return view('dashboard.booking.create', compact('rooms'));
    }

    public function store(StoreBookingRequest $request)
    {
        $this->authorize('create', Booking::class);

        $data = $request->validated();
        $data['user_id'] = $data['user_id'] ?? $request->user()->id;

        $this->service->create($data);

        return redirect()
            ->route('dashboard.bookings.index')
            ->with('success', 'Booking berhasil dibuat.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        return view('dashboard.booking.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);

        $rooms = $this->roomRepository->getActive();

        return view('dashboard.booking.edit', compact('booking', 'rooms'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $this->service->update($booking, $request->validated());

        return redirect()
            ->route('dashboard.bookings.index')
            ->with('success', 'Booking berhasil diupdate.');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);

        $this->service->delete($booking);

        return redirect()
            ->route('dashboard.bookings.index')
            ->with('success', 'Booking berhasil dihapus.');
    }

    public function approve(Booking $booking)
    {
        $this->authorize('approve', $booking);

        $this->service->approve($booking, Auth::id());

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    public function reject(Booking $booking)
    {
        $this->authorize('reject', $booking);

        $this->service->reject($booking, Auth::id());

        return back()->with('success', 'Booking berhasil ditolak.');
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        $this->service->cancel($booking);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
