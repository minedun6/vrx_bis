<?php

namespace App\Http\Controllers\Backend\Box;

use App\DataTables\BoxDataTable;
use App\Helpers\Utilities\ChartUtility;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Box\ManageBoxRequest;
use App\Http\Requests\Backend\Box\StoreBoxRequest;
use App\Http\Requests\Backend\Box\UpdateBoxRequest;
use App\Models\Box\Box;
use App\Models\Box\Status;
use App\Models\Game\GameHistoric;
use App\Repositories\Backend\Box\BoxRepository;
use App\Repositories\Backend\Game\GameRepository;
use App\Repositories\Backend\Location\LocationRepository;
use App\Repositories\Backend\Worker\WorkerRepository;
use Carbon\Carbon;
use Charts;
use DB;
use Illuminate\Http\Request;

class BoxController extends Controller
{

    protected $workers;

    protected $locations;

    protected $boxes;

    protected $games;

    /**
     * BoxController constructor.
     * @param WorkerRepository $workers
     * @param LocationRepository $locations
     * @param BoxRepository $boxes
     * @param GameRepository $games
     */
    public function __construct(WorkerRepository $workers,
                                LocationRepository $locations,
                                BoxRepository $boxes, GameRepository $games)
    {
        $this->workers = $workers;
        $this->locations = $locations;
        $this->boxes = $boxes;
        $this->games = $games;
    }

    /**
     * @param ManageBoxRequest $request
     * @param BoxDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ManageBoxRequest $request, BoxDataTable $dataTable)
    {
        return $dataTable->render('backend.boxes.index');
    }

    /**
     * @param ManageBoxRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ManageBoxRequest $request)
    {
        return view('backend.boxes.create')
            ->withUnassigned($this->workers->unassigned()->pluck('name', 'id')->toArray())
            ->withLocations($this->locations->getAll()->pluck('name', 'id')->toArray())
            ->withStats(Status::pluck('label', 'id'));
    }

    /**
     * @param StoreBoxRequest|Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->boxes->create($request->all());
        return redirect()
            ->route('admin.box.index')
            ->withFlashSuccess('Box created');
    }

    /**
     * @param ManageBoxRequest $request
     * @param Box $box
     * @return mixed
     */
    public function edit(ManageBoxRequest $request, Box $box)
    {
        return view('backend.boxes.edit')
            ->withBox($box)
            ->withStats(Status::pluck('label', 'id'))
            ->withUnassigned($this->workers->getAll()->pluck('name', 'id')->toArray())
            ->withLocations($this->locations->getAll()->pluck('name', 'id')->toArray())
            ->withStatuses($box->statuses);
    }

    public function update(UpdateBoxRequest $request, Box $box)
    {
        $this->boxes->update($box, ['data' => $request->all()]);
        return redirect()
            ->route('admin.box.index')
            ->withFlashSuccess('Box updated');
    }

    public function show(ManageBoxRequest $request, Box $box)
    {
        $chart = $this->getChart($box);

        return view('backend.boxes.show')
            ->with('box', $box)
            ->with('boxMoney', $this->getBoxRelatedData($box))
            ->with('topGames', $this->games->topPlayedGames($box))
            ->with('chart', $chart);
    }

    protected function getDataGroupedByDay($box, $month, $year, $fancy = false)
    {
        $query = GameHistoric::where(DB::raw('extract(MONTH from played_at)'), $month)
            ->where(DB::raw('extract(YEAR from played_at)'), $year)
            ->where('box_id', $box->id)
            ->where('is_payed', 1)
            ->get();
        return ChartUtility::groupByDay($query, $month, $year);
    }

    protected function getBoxRelatedData(Box $box)
    {
        $all = collect();

        $boxMoney = GameHistoric::join('games', 'historics.game_id', '=', 'games.id')
            ->join('boxes', 'historics.box_id', '=', 'boxes.id')
            ->where('historics.box_id', $box->id)
            ->where('historics.is_payed', 1)
            ->select(DB::raw('SUM(price) as day_price'), 'historics.played_at')
            ->orderBy('historics.played_at')
            ->groupBy('historics.played_at')
            ->get();

        $boxMoney->map(function ($item, $key) use ($all) {
            $all->put(
                Carbon::parse($item->played_at)->format('d F, Y'),
                generatedMoney($item->day_price)
            );
        });

        return $boxMoney;
    }

    function generatedMoney($money)
    {
        return money_format('%.2n', $money);
    }

    /**
     * @param Box $box
     * @return mixed
     */
    public function getChart(Box $box)
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        $twoMonthAgo = Carbon::now()->subMonths(2);

        $data = $this->getDataGroupedByDay($box, $currentMonth->format('m'), $currentMonth->format('Y'));
        $secondData = $this->getDataGroupedByDay($box, $lastMonth->format('m'), $lastMonth->format('Y'));
        $thirdData = $this->getDataGroupedByDay($box, $twoMonthAgo->format('m'), $twoMonthAgo->format('Y'));

        $chart = Charts::multi('bar', 'highcharts')
            ->elementLabel(config('app.currency'))
            ->title('Revenue généré en ' . config('app.currency'))
            ->labels($data[0])
            ->dataset($currentMonth->format('m') . ' - ' . $currentMonth->year, array_values($data[1]))
            ->dataset($lastMonth->format('m') . ' - ' . $lastMonth->year, array_values($secondData[1]))
            ->dataset($twoMonthAgo->format('m') . ' - ' . $twoMonthAgo->year, array_values($thirdData[1]))
            ->credits(false)
            ->responsive(true);
        return $chart;
    }

}
