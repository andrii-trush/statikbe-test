<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Booking;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VisitorsStatisticAction
{
    /**
     * Return data for Apexchart
     */
    public function handle(CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        /** @var Collection $data */
        $dbData = Booking::query()->select('booking_date')
            ->addSelect(DB::raw('sum(visitor_count) as visitor_count'))
            ->where('booking_date', '>=', $startDate->toDateString())
            ->where('booking_date', '<=', $endDate->toDateString())
            ->orderBy('booking_date')
            ->groupBy('booking_date')
            ->pluck('visitor_count', 'booking_date');

        $data = collect();

        // For days without visitors set "0"
        do {
            $data->push([
                'date' => $startDate->toDateString(),
                'visitor_count' => $dbData->get($startDate->toDateString(), 0),
            ]);
            $startDate->addDay();
        } while ($startDate->lessThanOrEqualTo($endDate));

        return [
            'series' => [[
                'name' => 'Visitors',
                'data' => $data->pluck('visitor_count')->toArray(),
            ]],
            'options' => [
                'xaxis' => [
                    'categories' => $data->pluck('date')->toArray(),
                ],
            ],
        ];
    }
}
