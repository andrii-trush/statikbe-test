<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Booking;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

use function explode;

class MaxVisitorsPerTimeslot implements ValidationRule
{
    public function __construct(
        protected Request $request,
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $visitors = $this->request->get('visitors', []);

        $timeSlots = explode('-', $this->request->get('time_slot'));
        $currentLoad = Booking::query()
            ->whereBookingDate($this->request->get('booking_date'))
            ->whereBookingStartAt($timeSlots[0] . ':00')
            ->whereBookingEndAt($timeSlots[1] . ':00')
            ->sum('visitor_count');

        if (($currentLoad + \count($visitors)) > 200) {
            $fail('Max visitors per time slot is reached');
        }

    }
}
