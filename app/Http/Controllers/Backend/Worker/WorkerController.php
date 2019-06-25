<?php

namespace App\Http\Controllers\Backend\Worker;

use App\DataTables\WorkerDataTable;
use App\Http\Requests\Backend\Worker\ManageWorkerRequest;
use App\Http\Requests\Backend\Worker\StoreWorkerRequest;
use App\Http\Requests\Backend\Worker\UpdateWorkerRequest;
use App\Models\Worker\Worker;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\Backend\Box\BoxRepository;
use App\Repositories\Backend\Worker\WorkerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkerController extends Controller
{

    /**
     * @var
     */
    protected $workers;

    protected $roles;

    protected $boxes;

    /**
     * @param RoleRepository $roles
     * @param WorkerRepository $workers
     * @param BoxRepository $boxes
     * @internal param RoleRepository $role
     */
    function __construct(RoleRepository $roles, WorkerRepository $workers, BoxRepository $boxes)
    {
        $this->roles = $roles;
        $this->workers = $workers;
        $this->boxes = $boxes;
    }


    /**
     * Display a listing of the resource.
     *
     * @param ManageWorkerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ManageWorkerRequest $request, WorkerDataTable $dataTable)
    {
        return $dataTable->render('backend.workers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ManageWorkerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(ManageWorkerRequest $request)
    {
        return view('backend.workers.create')
            ->with('roles', $this->roles->getAll())
            ->with('boxes', $this->boxes->getAll()->pluck('code', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkerRequest $request)
    {
        $request['status'] = 1;
        $request['confirmed'] = 1;
        $request['confirmation_email'] = 1;

        $this->workers->create([
            'data' => $request->except(['assignees_roles', 'code', 'phone1', 'phone2', 'phone3', 'started_at']),
            'roles' => $request->only('assignees_roles'),
            'worker' => $request->only('code', 'phone1', 'phone2', 'phone3', 'started_at', 'default_box')
        ]);
        return redirect()
            ->route('admin.worker.index')
            ->withFlashSuccess('<i class="icon-note"></i> Le Supérviseur a été créée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Worker $worker)
    {
        return view('backend.workers.show', ['worker' => $worker]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Worker $worker
     * @param ManageWorkerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Worker $worker, ManageWorkerRequest $request)
    {
        return view('backend.workers.edit')
            ->with('worker', $worker)
            ->withUserRoles($worker->user->roles->pluck('id')->all())
            ->withRoles($this->roles->getAll())
            ->with('boxes', $this->boxes->getAll()->pluck('code', 'id'));;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Worker $worker
     * @param UpdateWorkerRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Worker $worker, UpdateWorkerRequest $request)
    {
        $this->workers->update($worker, [
            'data' => $request->except(['assignees_roles', 'code', 'phone1', 'phone2', 'phone3', 'started_at', 'password']),
            'roles' => $request->only('assignees_roles'),
            'worker' => $request->only('code', 'phone1', 'phone2', 'phone3', 'started_at', 'default_box')
        ]);

        return redirect()
            ->route('admin.worker.index')
            ->withFlashSuccess('The worker was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Worker $worker
     * @param ManageWorkerRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Worker $worker, ManageWorkerRequest $request)
    {
        $this->workers->delete($worker);
        return redirect()
            ->route('admin.worker.index')
            ->withFlashSuccess(trans('alerts.backend.workers.deleted'));
    }
}
