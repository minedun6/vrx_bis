@section('after-styles')
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection


<div class="form-body">
    @include ('backend.boxes.partials.form-components')
</div>
<div class="form-actions right">
    <button type="submit" class="btn blue" data-disable-with="<i class='fa fa-refresh fa-spin fa-fw'></i> Sauvegarde...">
        <span class="fa fa-save"></span> Sauvegarder
    </button>
    <button type="reset" value="Reset" class="btn default">Annuler</button>
</div>

@section('after-scripts')
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@endsection