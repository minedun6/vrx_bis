<?php

namespace App\Http\Controllers\Backend\Location;

use App\DataTables\LocationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Location\ManageLocationRequest;
use App\Http\Requests\Backend\Location\StoreLocationRequest;
use App\Http\Requests\Backend\Location\UpdateLocationRequest;
use App\Models\Location\Location;
use App\Repositories\Backend\Location\LocationRepository;


class LocationController extends Controller
{
    /**
     * @var LocationRepository
     */
    protected $locations;

    /**
     * LocationController constructor.
     * @param $locations
     */
    public function __construct(LocationRepository $locations)
    {
        $this->locations = $locations;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageLocationRequest $request, LocationDataTable $dataTable)
    {
        return $dataTable->render('backend.locations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ManageLocationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(ManageLocationRequest $request)
    {
        return view('backend.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLocationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {
        $this->locations->create(['data' => $request->all()]);
        return redirect()
            ->route('admin.location.index')
            ->withFlashSuccess(trans('alerts.backend.locations.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Location $location
     * @param ManageLocationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location, ManageLocationRequest $request)
    {
        return view('backend.locations.edit')
            ->withLocation($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Location $location
     * @param UpdateLocationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Location $location, UpdateLocationRequest $request)
    {
        $this->locations->update($location, ['data' => $request->all()]);

        return redirect()
            ->route('admin.location.index')
            ->withFlashSuccess(trans('alerts.backend.locations.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @param  ManageLocationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, ManageLocationRequest $request)
    {
        $this->locations->delete($location);

        return redirect()
            ->route('admin.location.index')
            ->withFlashSuccess(trans('alerts.backend.locations.deleted'));
    }



}
