@section('after-styles')
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
@endsection

<div class="form-body">
    <div class="form-group">
        <label>Code du Jeu </label>
        <div class="input-icon right">
            <i class="fa fa-binoculars"></i>
            {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'G12345']) }}
        </div>
    </div>
    <div class="form-group">
        <label>Nom du Jeu </label>
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Resident Evil']) }}
    </div>
    <div class="form-group">
        <label>Date Achat du Jeu </label>
        {{ Form::text('bought_at', null, ['class' => 'form-control form-control-inline date-picker', 'placeholder' => '25/03/2015']) }}
    </div>
    <div class="form-group">
        <label>Durée du Jeu </label>
        {{ Form::text('duration', null, ['class' => 'form-control', 'placeholder' => '19:20:00']) }}
    </div>
</div>
<div class="form-actions right">
    <button type="submit" class="btn blue" data-disable-with="<i class='fa fa-refresh fa-spin fa-fw'></i> Sauvegarde...">
        <span class="fa fa-save"></span> Sauvegarder
    </button>
    <button type="reset" value="Reset" class="btn default">Annuler</button>
</div>

@section('after-scripts')
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js') }}"
            charset="UTF-8"></script>
    <script src="{{ asset('js/backend/init.js') }}"></script>
@endsection