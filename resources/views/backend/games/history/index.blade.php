@extends ('backend.layouts.app')

@section ('title', app_name() . ' | Historique des Jeux Lancés')

@section('page-header')
    <h1>
        Historique des jeux lancés
    </h1>
@endsection

@section('after-styles')
    <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')
    @include ('backend.games.history.filter')
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">Historique</div>

            <div class="actions">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="portlet-body">
            {!! $dataTable->table() !!}
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts')
    <script src="{{ asset('assets/global/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/moment/locales/fr.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/backend/init.js') }}"></script>

    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function () {
            var startDate;
            var endDate;
            $('#filter_worker').on('change', function (e) {
                $('#dataTableBuilder').DataTable().draw();
            });

            $('#filter_box').on('change', function (e) {
                $('#dataTableBuilder').DataTable().draw();
            });

            $('#filter_game').on('change', function (e) {
                $('#dataTableBuilder').DataTable().draw();
            });

            $('#filter_played_at').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                $('#dataTableBuilder').DataTable().draw();
            });

            $('#filter_played_at').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
                $('#dataTableBuilder').DataTable().draw();
            });

            $('#dataTableBuilder').on('preXhr.dt', function (e, settings, data) {
                data.filter_worker = $('#filter_worker').val();
                data.filter_box = $('#filter_box').val();
                data.filter_game = $('#filter_game').val();
                data.filter_played_at = $('#filter_played_at').val();
            });
        });
    </script>
@stop
