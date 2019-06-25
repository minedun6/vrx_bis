@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.boxes.management'))

@section('after-styles')
    {!! Charts::assets() !!}
@stop

@section('page-header')
    <h1>
        {{ trans('labels.backend.games.management') }}
        <small>{{ trans('labels.backend.games.active') }}</small>
    </h1>
@endsection

@section('content')

@stop

@section('after-scripts')
@stop
