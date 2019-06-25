@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($game, ['route' => ['admin.game.update', $game], 'class' => 'form-horizontal', 'method' => 'PATCH']) }}

        @include ('backend.games.includes.partials.form',[
            'button' => 'Edit'
        ])

    {{ Form::close() }}
@stop

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
@stop
