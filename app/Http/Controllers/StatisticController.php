<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\VisitorsStatisticAction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class StatisticController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        VisitorsStatisticAction $visitorsStatistic)
    {
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : now()->endOfMonth();

        return Inertia::render('Statistic', [
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            ...$visitorsStatistic->handle($startDate, $endDate),
        ]);

    }
}
