<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\VisitorsStatisticAction;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingVisitor;
use App\Rules\MaxVisitorsPerTimeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class BookingController extends Controller
{
    public function index(
        VisitorsStatisticAction $visitorsStatistic,
    ): \Inertia\Response {
        return Inertia::render('Booking/Index', []);
    }

    public function store(BookingRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Additional validation to check if there's free space for the requested time slot
        $request->validate([
            'time_slot' => new MaxVisitorsPerTimeslot($request),
        ]);

        $booking = null;
        try {
            DB::transaction(function () use ($request, &$booking) {
                $validated = $request->validated();
                $timeslots = explode('-', $validated['time_slot']);
                $booking = Booking::create([
                    'booking_date' => $validated['booking_date'],
                    'booking_start_at' => $timeslots[0],
                    'booking_end_at' => $timeslots[1],
                    'visitor_count' => \count($validated['visitors']),
                ]);
                $visitors = [];
                foreach ($validated['visitors'] as $visitor) {
                    $visitors[] = new BookingVisitor($visitor);
                }
                $booking->visitors()->saveMany($visitors);
            });
        } catch (Throwable $e) {
            // TODO: return UI exception
            throw $e;
        }

        return to_route('booking.success')->with('bookingId', $booking->id);
    }

    public function show(Booking $booking): \Inertia\Response
    {
        $booking->load('visitors');

        return Inertia::render('Booking/Show', compact('booking'));
    }

    public function success(Booking $booking, Request $request)
    {
        $bookingId = $request->session()->get('bookingId');

        if (empty($bookingId)) {
            return to_route('index');
        }

        return Inertia::render('Booking/Success', []);
    }
}
