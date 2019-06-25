@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.workers.management') . ' | ' . trans('labels.backend.workers.deleted'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@stop

@section('page-header')
    <h1>
        {{ trans('labels.backend.workers.management') }}
        <small>{{ trans('labels.backend.workers.deleted') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.workers.deleted') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.workers.includes.partials.worker-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="workers-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.workers.table.id') }}</th>
                        <th>{{ trans('labels.backend.workers.table.code') }}</th>
                        <th>{{ trans('labels.backend.workers.table.name') }}</th>
                        <th>{{ trans('labels.backend.workers.table.email') }}</th>
                        <th>{{ trans('labels.backend.workers.table.phone1') }}</th>
                        <th>{{ trans('labels.backend.workers.table.started_at') }}</th>
                        <th>{{ trans('labels.backend.workers.table.created') }}</th>
                        <th>{{ trans('labels.backend.workers.table.last_updated') }}</th>
                        <th>{{ trans('labels.backend.workers.table.actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts')
    {{ Html::script("js/backend/plugin/datatables/jquery.dataTables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables.bootstrap.min.js") }}

    <script>
        $(function() {
            $('#workers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.worker.get") }}',
                    type: 'get',
                    data: { trashed: true }
                },
                columns: [
                    {data: 'id', name: 'workers.id'},
                    {data: 'code', name: 'workers.code'},
                    {data: 'name', name: 'workers.name', render: $.fn.dataTable.render.text()},
                    {data: 'email', name: 'workers.email', render: $.fn.dataTable.render.text()},
                    {data: 'phone1', name: 'workers.phone1'},
                    {data: 'started_at', name: 'workers.started_at'},
                    {data: 'created_at', name: 'workers.created_at'},
                    {data: 'updated_at', name: 'workers.updated_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500
            });

            $("body").on("click", "a[name='delete_worker_perm']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "{{ trans('strings.backend.workers.delete_worker_confirm') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('strings.backend.general.continue') }}",
                    cancelButtonText: "{{ trans('buttons.general.cancel') }}",
                    closeOnConfirm: false
                }, function(isConfirmed){
                    if (isConfirmed){
                        window.location.href = linkURL;
                    }
                });
            });

            $("body").on("click", "a[name='restore_worker']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "{{ trans('strings.backend.workers.restore_worker_confirm') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('strings.backend.general.continue') }}",
                    cancelButtonText: "{{ trans('buttons.general.cancel') }}",
                    closeOnConfirm: false
                }, function(isConfirmed){
                    if (isConfirmed){
                        window.location.href = linkURL;
                    }
                });
            });
        });
    </script>
@stop
