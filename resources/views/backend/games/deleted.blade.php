@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.games.management') . ' | ' . trans('labels.backend.games.deleted'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@stop

@section('page-header')
    <h1>
        {{ trans('labels.backend.games.management') }}
        <small>{{ trans('labels.backend.games.deleted') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.games.deleted') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.games.includes.partials.game-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="games-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.games.table.id') }}</th>
                        <th>{{ trans('labels.backend.games.table.code') }}</th>
                        <th>{{ trans('labels.backend.games.table.name') }}</th>
                        <th>{{ trans('labels.backend.games.table.bought_at') }}</th>
                        <th>{{ trans('labels.backend.games.table.duration') }}</th>
                        <th>{{ trans('labels.backend.games.table.created_at') }}</th>
                        <th>{{ trans('labels.backend.games.table.updated_at') }}</th>
                        <th>{{ trans('labels.backend.games.table.actions') }}</th>
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
            $('#games-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.game.get") }}',
                    type: 'get',
                    data: {trashed: true}
                },
                columns: [
                    {data: 'id', name: 'games.id'},
                    {data: 'code', name: 'games.code'},
                    {data: 'name', name: 'games.name', render: $.fn.dataTable.render.text()},
                    {data: 'bought_at', name: 'games.bought_at', render: $.fn.dataTable.render.text()},
                    {data: 'duration', name: 'games.duration'},
                    {data: 'created_at', name: 'games.created_at'},
                    {data: 'updated_at', name: 'games.updated_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500
            });

            $("body").on("click", "a[name='delete_game_perm']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "{{ trans('strings.backend.games.delete_game_confirm') }}",
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

            $("body").on("click", "a[name='restore_game']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "{{ trans('strings.backend.games.restore_game_confirm') }}",
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
