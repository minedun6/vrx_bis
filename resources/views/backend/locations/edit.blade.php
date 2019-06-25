@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.locations.management') . ' | ' . trans('labels.backend.locations.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.locations.management') }}
        <small>{{ trans('labels.backend.locations.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($location, ['route' => ['admin.location.update', $location], 'class' => 'form-horizontal', 'method' => 'PATCH']) }}

    @include ('backend.locations.includes.partials.form',[
        'button' => 'Edit'
    ])

    {{ Form::close() }}
@stop

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
@stop
