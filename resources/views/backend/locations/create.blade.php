@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.locations.management') . ' | ' . trans('labels.backend.locations.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.locations.management') }}
        <small>{{ trans('labels.backend.locations.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.location.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

    @include ('backend.locations.includes.partials.form',[
        'button' => 'Create'
    ])

    {{ Form::close() }}
@stop

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
@stop
