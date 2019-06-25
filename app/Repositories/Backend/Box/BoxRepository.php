<?php

namespace App\Repositories\Backend\Box;


use App\Exceptions\GeneralException;
use App\Models\Box\Box;
use App\Models\Box\Status;
use App\Repositories\Backend\Location\LocationRepository;
use App\Repositories\Backend\Worker\WorkerRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BoxRepository extends Repository
{
    const MODEL = Box::class;

    /**
     * @var LocationRepository
     */
    protected $location;

    /**
     * @var WorkerRepository
     */
    protected $worker;

    /**
     * BoxRepository constructor.
     * @param LocationRepository $location
     * @param WorkerRepository $worker
     */
    public function __construct(LocationRepository $location,
                                WorkerRepository $worker)
    {

        $this->location = $location;
        $this->worker = $worker;
    }

    /**
     * @param bool $trashed
     * @return $this
     */
    public function getForDataTable($trashed = false)
    {

    }

    /**
     * @param $input
     */
    public function create($input)
    {
        $box = $this->createBoxStub($input);

        DB::transaction(function () use ($box, $input) {
            if (parent::save($box)) {
                $box->statuses()->save(Status::find($input['box_status']));
                //Todo event(new BoxCreated($box));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });

    }

    /**
     * @param Model $box
     * @param array $input
     * @return bool|void
     */
    public function update(Model $box, array $input)
    {
        $data = $input['data'];
        DB::transaction(function () use ($box, $data) {
            if (parent::update($box, $data)) {
                parent::save($box);
                if ($box->getLatestStatus()->id != $data['box_status']) {
                    $box->statuses()->save(Status::find($data['box_status']));
                }
                //Todo event(new BoxUpdated($box));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * @param $input
     * @return mixed
     */
    protected function createBoxStub($input)
    {
        $box = self::MODEL;
        $box = new $box;
        $box->code = $input['code'];
        $box->location_id = $input['location_id'] ?? null;
        $box->price1 = $input['price1'] ?? null;
        $box->price2 = $input['price2'] ?? null;
        $box->price3 = $input['price3'] ?? null;
        $box->box_status = $input['box_status'] ?? null;
        return $box;
    }

    /**
     * @return mixed
     */
    public function groupByStatus()
    {
        $counts = Status::leftJoin('boxes', 'statuses.id', '=', 'boxes.box_status')
            // group by tags.id in order to count number of rows in join and to get each tag only once
            ->groupBy('statuses.id')
            // get only columns from tags table along with aggregate COUNT column
            ->select(['statuses.*', DB::raw('count(distinct(boxes.code)) as cnt')])
            ->get();
        return $counts;
    }

    public function query()
    {
        return parent::query();
    }


}