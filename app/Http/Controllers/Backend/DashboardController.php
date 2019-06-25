<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Utilities\ChartUtility;
use App\Http\Controllers\Controller;
use App\Models\Activity\Activity;
use App\Repositories\Backend\Box\BoxRepository;
use App\Repositories\Backend\Game\GameRepository;
use Carbon\Carbon;
use Charts;
use DB;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{

    protected $games;

    protected $boxes;

    /**
     * DashboardController constructor.
     * @param GameRepository $games
     * @param BoxRepository $boxes
     */
    public function __construct(GameRepository $games, BoxRepository $boxes)
    {
        $this->games = $games;
        $this->boxes = $boxes;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $chart = $this->getChart();

        return view('backend.dashboard', [
            'chart' => $chart,
            'boxes' => $this->boxes->getAll(),
            'topGames' => $this->games->topPlayedGames(),
            'statuses' => $this->boxes->groupByStatus(),
            'activities' => $this->getLatestActivities(true)
        ]);
    }

    /**
     * @return mixed
     */
    protected function getChart()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        $twoMonthsAgo = Carbon::now()->subMonths(2);

        $data = $this->games->gameHistoryQuery()->where(DB::raw('MONTH(played_at)'), $currentMonth->format('m'))
            ->where(DB::raw('YEAR(played_at)'), $currentMonth->year)
            ->where('is_payed', 1)->get();
        $secondData = $this->games->gameHistoryQuery()->where(DB::raw('MONTH(played_at)'), $lastMonth->format('m'))
            ->where(DB::raw('YEAR(played_at)'), $lastMonth->year)
            ->where('is_payed', 1)->get();
        $thirdData = $this->games->gameHistoryQuery()->where(DB::raw('MONTH(played_at)'), $twoMonthsAgo->format('m'))
            ->where(DB::raw('YEAR(played_at)'), $twoMonthsAgo->year)
            ->where('is_payed', 1)->get();

        $firstSubSet = ChartUtility::groupByDay($data, $currentMonth->format('m'), $currentMonth->year);
        $secondSubSet = ChartUtility::groupByDay($secondData, $lastMonth->format('m'), $lastMonth->year);
        $thirdSubSet = ChartUtility::groupByDay($thirdData, $twoMonthsAgo->format('m'), $twoMonthsAgo->year);

        $chart = Charts::multi('bar', 'highcharts')
            ->elementLabel("")// add config('app.currency') if needed
            ->title('Revenue en ' . config('app.currency'))
            ->labels($firstSubSet[0])
            ->dataset($currentMonth->format('m') . ' - ' . $currentMonth->year, $firstSubSet[1])
            ->dataset($lastMonth->format('m') . ' - ' . $lastMonth->year, $secondSubSet[1])
            ->dataset($twoMonthsAgo->format('m') . ' - ' . $twoMonthsAgo->year, $thirdSubSet[1])
            ->credits(false)
            ->responsive(true);

        return $chart;
    }

    protected function getLatestActivities($all = false, $number = 20)
    {
        if ($all == true) {
            return Activity::latest()->get();
        } else {
            return Activity::latest()->take($number)->get();
        }
    }

}
