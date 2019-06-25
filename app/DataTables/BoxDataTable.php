<?php

namespace App\DataTables;

use App\Models\Box\Box;
use App\Models\Box\BoxStatus;
use App\Repositories\Backend\Location\LocationRepository;
use App\Repositories\Backend\Worker\WorkerRepository;
use Illuminate\Contracts\View\Factory;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Services\DataTable;
use DB;

class BoxDataTable extends DataTable
{

    protected $location, $worker;


    /**
     * BoxDataTable constructor.
     * @param Datatables $datatables
     * @param Factory $viewFactory
     * @param LocationRepository $location
     * @param WorkerRepository $worker
     */
    public function __construct(Datatables $datatables, Factory $viewFactory, LocationRepository $location, WorkerRepository $worker)
    {
        parent::__construct($datatables, $viewFactory);

        $this->location = $location;
        $this->worker = $worker;
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->queryBuilder($this->query())
            ->addColumn('actions', function ($box) {
                return $this->getShowButtonAttribute($box) .
                    $this->getEditButtonAttribute($box);
            })
            ->editColumn('label', function ($box) {
                return '<span class="label ' . $this->colors($box->box_status) . '">' . $box->label . '</span>';
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = DB::table('boxes')
            ->leftJoin('locations', 'locations.id', '=', 'boxes.location_id')
            ->leftJoin('statuses', 'statuses.id', '=', 'boxes.box_status')
            ->select(
                'boxes.code',
                'box_status',
                'locations.name',
                'statuses.label',
                'boxes.price1',
                'boxes.price2',
                'boxes.price3',
                'boxes.id'
            );

        return $this->applyScopes($query);
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return
            $this->builder()
                ->columns($this->getColumns())
                ->parameters([
                    'dom' => "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                    'buttons' => [
                        ['extend' => 'print', 'className' => 'btn xs default'],
                        ['extend' => 'excel', 'className' => 'btn xs default'],
                        ['extend' => 'pdf', 'className' => 'btn xs default'],
                    ],
                    'language' => config('datatables.language_trans')
                ])->setTableAttribute(['class' => 'table dataTable no-footer table-bordered table-condensed']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'code' => ['title' => 'Code Box'],
            'name' => ['title' => 'Adresse Box'],
            'label' => ['title' => 'Status en cours'],
            'price1' => ['title' => 'Price (1P) - TND'],
            'price2' => ['title' => 'Price (2P) - TND'],
            'price3' => ['title' => 'Price (3P) - TND'],
            'actions' => ['searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'boxes_' . time();
    }

    public function getShowButtonAttribute($box)
    {
        return '<a href="' . route('admin.box.show', $box->id) . '" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.view') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute($box)
    {
        return '<a href="' . route('admin.box.edit', $box->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a>';
    }

    protected function colors($id)
    {
        switch ($id) {
            case 1:
                return "label-success";
                break;
            case 2:
                return "label-warning";
                break;
            case 3:
                return "label-danger";
                break;
            default:
                break;
        }
    }

}
