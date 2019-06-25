<div class="form-group">
    <label>Code de la Box </label>
    <div class="input-icon right">
        <i class="fa fa-binoculars"></i>
        {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'BOX123']) }}
    </div>
</div>

<div class="form-group">
    <label>Adresse de la Box </label>
    {{ Form::select(
            'location_id',
            $locations,
            null,
            ['class' => 'form-control select2', 'data-placeholder' => 'Select location' ])
        }}
</div>

<div class="form-group">
    <label>Status de la Box </label>
    {{ Form::select(
            'box_status',
            $stats,
            null,
            ['class' => 'form-control select2', 'data-placeholder' => 'Select location' ])
        }}
</div>

<div class="form-group">
    <label>Prix pour 1 Personne </label>
    {{ Form::number('price1', null, ['min' => 1, 'max' => 100, 'class' => 'form-control']) }}
</div>

<div class="form-group">
    <label>Prix pour 2 Personnes </label>
    {{ Form::number('price2', null, ['min' => 1, 'max' => 100, 'class' => 'form-control']) }}
</div>

<div class="form-group">
    <label>Prix pour 3 Personnes </label>
    {{ Form::number('price3', null, ['min' => 1, 'max' => 100, 'class' => 'form-control']) }}
</div>