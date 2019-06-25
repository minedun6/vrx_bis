<?php
namespace App\Repositories\Backend\Worker;

use App\Exceptions\GeneralException;
use App\Models\Access\Role\Role;
use App\Models\Worker\Worker;
use App\Repositories\Backend\Access\User\UserRepository;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkerRepository extends Repository
{

    /**
     * Associated Repository Model
     */
    const MODEL = Worker::class;

    protected $user;

    /**
     * WorkerRepository constructor.
     * @param $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function getForDataTable($trashed = false)
    {

    }

    public function create($input)
    {
        $worker = $input['worker'];
        $input['roles']['assignees_roles'] = [4];
        DB::transaction(function () use ($input, $worker) {
            $user = $this->user->create($input);
            $worker = $this->createWorkerStub($worker);
            if (parent::save($worker)) {
                $user->worker()->save($worker);
                //Todo event(new WorkerCreated($worker));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function update(Model $worker, array $input)
    {
        $updatedWorker = $input['worker'];
        $input['roles']['assignees_roles'] = [4];

        DB::transaction(function () use ($worker, $updatedWorker, $input) {
            $this->user->update($worker->user, $input);
            if (parent::update($worker, $updatedWorker)) {
                // Todo event(new UpdatedWorker($worker))
                return true;
            }
            throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * @param Model $worker
     * @return bool
     * @throws GeneralException
     */
    public function delete(Model $worker)
    {
        if (parent::delete($worker)) {
            //Todo event(new WorkerDeleted($worker));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
    }

    protected function checkWorkerByEmail($input, $worker)
    {
        //Figure out if email is not the same
        if ($worker->email != $input['email']) {
            //Check to see if email exists
            if ($this->query()->where('email', '=', $input['email'])->first()) {
                throw new GeneralException(trans('exceptions.backend.access.users.email_error'));
            }
        }
    }

    /**
     * @param Model $worker
     * @return bool|null|void
     * @throws GeneralException
     */
    public function forceDelete(Model $worker)
    {
        if (is_null($worker->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.delete_first'));
        }

        DB::transaction(function () use ($worker) {
            if (parent::forceDelete($worker)) {
                //Todo event(new WorkerPermanentlyDeleted($game));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param Model $worker
     * @return bool
     * @throws GeneralException
     */
    public function restore(Model $worker)
    {
        if (is_null($worker->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_restore'));
        }

        if (parent::restore(($worker))) {
            //Todo event(new WorkerRestored($worker));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.restore_error'));
    }

    public function unassigned()
    {
        return Worker::unassigned();
    }

    /**
     * @param  $input
     * @return mixed
     */
    protected function createWorkerStub($input)
    {
        $worker = self::MODEL;
        $worker = new $worker;
        $worker->code = $input['code'];
        $worker->phone1 = $input['phone1'] ?? null;
        $worker->phone2 = $input['phone2'] ?? null;
        $worker->phone3 = $input['phone3'] ?? null;
        $worker->default_box = $input['default_box'] ?? null;
        $worker->started_at = $input['started_at'] ?? null;
        return $worker;
    }

    public function query()
    {
        return parent::query();
    }


}