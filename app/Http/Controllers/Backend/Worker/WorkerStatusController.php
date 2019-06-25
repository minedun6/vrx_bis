<?php

namespace App\Http\Controllers\Backend\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Worker\ManageWorkerRequest;
use App\Models\Worker\Worker;
use App\Repositories\Backend\Worker\WorkerRepository;

class WorkerStatusController extends Controller
{
    protected $workers;

    /**
     * WorkerStatusController constructor.
     * @param $workers
     */
    public function __construct(WorkerRepository $workers)
    {
        $this->workers = $workers;
    }

    /**
     * @param ManageWorkerRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDeleted(ManageWorkerRequest $request)
    {
        return view('backend.workers.deleted');
    }

    /**
     * @param Worker $deletedGame
     * @param ManageWorkerRequest $request
     * @return
     */
    public function delete(Worker $deletedGame, ManageWorkerRequest $request)
    {
        $this->workers->forceDelete($deletedGame);

        return redirect()
            ->route('admin.worker.index')
            ->withFlashSuccess(trans('alerts.backend.workers.deleted_permanently'));
    }


    /**
     * Need to bind the 'deletedWorker' inside the routeServiceProvider to grab the model with trashedData
     *
     * @param Worker $deletedWorker
     * @param ManageWorkerRequest $request
     * @return
     */
    public function restore(Worker $deletedWorker, ManageWorkerRequest $request)
    {
        $this->workers->restore($deletedWorker);

        return redirect()
            ->route('admin.worker.index')
            ->withFlashSuccess(trans('alerts.backend.workers.restored'));
    }


}
