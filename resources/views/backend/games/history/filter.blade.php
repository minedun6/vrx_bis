<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            Recherche Avancée
        </div>
        <div class="actions"></div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-5 col-sm-6">
                <div class="form-group">
                    <label for="filter_worker">Supérviseur</label>

                    <select name="filter_worker" id="filter_worker" class="form-control select2"
                            data-placeholder="Séléctionnez un Supérviseur ...">
                        <option value=""></option>
                        @foreach($workers as $worker)
                            <option value="{{ $worker->id }}">{{ $worker->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter_box">Box</label>

                    <select name="filter_box" id="filter_box" class="form-control select2"
                            data-placeholder="Séléctionnez une Box ...">
                        <option value=""></option>
                        @foreach($boxes as $box)
                            <option value="{{ $box->id }}">{{ $box->code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-1 col-sm-6">
                <div class="form-group">
                    <label for="filter_game">Jeu</label>

                    <select name="filter_game" id="filter_game" class="form-control select2"
                            data-placeholder="Séléctionnez un Jeu ...">
                        <option value=""></option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter_played_at">Lancé entre</label>
                    <div id="filter_played_at" data-display-range="0" class="form-control pull-right tooltips btn default">
                        <i class="icon-calendar"></i>&nbsp;
                        <span class="thin uppercase"></span>&nbsp;
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@section('after-scripts')
    <script src="{{ asset('assets/global/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/moment/locales/fr.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
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
