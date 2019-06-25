<?php

namespace App\Repositories\Backend\Location;

use App\Exceptions\GeneralException;
use App\Models\Location\Location;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LocationRepository extends Repository
{
    /**
     * Associated Repository Model
     */
    const MODEL = Location::class;

    public function getForDataTable($trashed = false)
    {
        $dataTableQuery = $this->query()
            ->select([
                'locations.id',
                'locations.name',
                'locations.city',
                'locations.created_at',
                'locations.updated_at',
            ]);

        if ($trashed == "true") {
            return $dataTableQuery->onlyTrashed();
        }

        // active() is a scope on the UserScope trait
        return $dataTableQuery;
    }

    public function getAll()
    {
        return $this->query()->get();
    }

    /**
     * @param $input
     */
    public function create($input)
    {
        $data = $input['data'];

        $location = $this->createLocationStub($data);

        DB::transaction(function () use ($location, $data) {
            if (parent::save($location)) {

                //Todo event(new LocationCreated($location));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @param Model $location
     * @param array $input
     * @return bool|void
     * @throws GeneralException
     */
    public function update(Model $location, array $input)
    {
        $data = $input['data'];

        //$this->checkLocationById($location);

        DB::transaction(function () use ($location, $data) {
            if (parent::update($location, $data)) {
                parent::save($location);
                //Todo event(new LocationUpdated($location));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * @param Model $location
     * @return bool
     * @throws GeneralException
     */
    public function delete(Model $location)
    {
        if (parent::delete($location)) {
            //Todo event(new LocationDeleted($location));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
    }

    /**
     * @param $input
     * @param $location
     * @throws GeneralException
     */
    protected function checkLocationById($location, $input)
    {
        //Figure out if location is not the same
        if ($location->id != $input['id']) {
            //Check to see if location exists
            if ($this->query()->where('id', '=', $input['id'])->first()) {
                throw new GeneralException(trans('exceptions.backend.access.users.email_error'));
            }
        }
    }

    protected function createLocationStub($input)
    {
        $location = self::MODEL;
        $location = new $location;
        $location->name = $input['name'];
        $location->city = $input['city'];
        return $location;
    }

}