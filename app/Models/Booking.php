<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\BookingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(BookingObserver::class)]
class Booking extends Model
{
    protected $fillable = [
        'booking_ref',
        'booking_date',
        'booking_start_at',
        'booking_end_at',
        'visitor_count',
    ];

    public function casts(): array
    {
        return [
            'booking_ref' => 'string',
            'booking_date' => 'date:d/m/Y',
            'booking_start_at' => 'datetime:H:i',
            'booking_end_at' => 'datetime:H:i',
        ];
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(BookingVisitor::class);
    }
}
