<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Booking;
use Illuminate\Support\Str;

class BookingObserver
{
    public function created(Booking $booking): void
    {
        do {
            $ref = Str::upper(Str::random(8));
        } while (Booking::whereBookingRef($ref)->exists());

        $booking->booking_ref = $ref;
        $booking->saveQuietly();
    }
}
