<div class="form-group">
    <div class="input-icon right">
        <label>Code du Supérviseur </label>
        {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'WORKER1234']) }}
    </div>
</div>

<div class="form-group">
    <label>Nom du Supérviseur </label>
    {{ Form::text('name', $worker->user->name ?? null, ['class' => 'form-control', 'placeholder' => 'John Doe']) }}
</div>

<div class="form-group">
    <label>Adresse Email du Supérviseur </label>
    {{ Form::text('email', $worker->user->email ?? null, ['class' => 'form-control', 'placeholder' => 'john@doe.com']) }}
</div>

<div class="form-group">
    <label>Num Téléphone #1 </label>
    {{ Form::text('phone1', null, ['class' => 'form-control', 'placeholder' => '70100100']) }}
</div>

<div class="form-group">
    <label>Num Téléphone #2 </label>
    {{ Form::text('phone2', null, ['class' => 'form-control', 'placeholder' => '70100100']) }}
</div>

<div class="form-group">
    <label>Num Téléphone #3 </label>
    {{ Form::text('phone3', null, ['class' => 'form-control', 'placeholder' => '70100100']) }}
</div>

<div class="form-group">
    <label for="">Box par défault</label>
    {{ Form::select(
        'default_box',
        $boxes,
        null,
        ['class' => 'form-control select2', 'data-placeholder' => 'Select the default Status of the box'])
    }}
</div>

<div class="form-group">
    <label for="">Date de commencement</label>
    {{ Form::text('started_at', null, ['class' => 'form-control form-control-inline date-picker']) }}
</div>

@if (!isset($worker))
    <div class="form-group">
        <label for="">Mot de Passe</label>
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        <label for="">Condirmation Mot de Passe</label>
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>
@endif