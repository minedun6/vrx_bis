@section('after-styles')
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
@endsection

<div class="form-body">
    @include ('backend.workers.includes.partials.form-components')
</div>

<div class="form-actions right">
    <button type="submit" class="btn blue" data-disable-with="<i class='fa fa-refresh fa-spin fa-fw'></i> Sauvegarde...">
        <span class="fa fa-save"></span> Sauvegarder
    </button>
    <button type="reset" value="Reset" class="btn default">Annuler</button>
</div>

@section('after-scripts')
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js') }}"
            charset="UTF-8"></script>
    <script src="{{ asset('js/backend/init.js') }}"></script>
@endsection