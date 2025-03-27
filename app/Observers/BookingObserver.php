<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Booking;
use Illuminate\Support\Str;

class BookingObserver
{
    /**
     * After booking was created - need to assign unique booking number
     */
    public function created(Booking $booking): void
    {
        do {

            // TODO: make length as config variable
            $ref = Str::upper(Str::random(8));
        } while (Booking::whereBookingRef($ref)->exists());

        $booking->booking_ref = $ref;
        $booking->saveQuietly();
    }
}
