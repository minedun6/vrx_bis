@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('page-header')
    <h1>
        Gestion des Supérviseurs
    </h1>
@endsection

@section('content')
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">Editer Supérviseur </div>

            <div class="actions">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="portlet-body form">
            {!! Form::model($worker, ['route' => ['admin.worker.update', $worker], 'role' => 'form', 'method' => 'PATCH']) !!}
            @include ('backend.workers.includes.partials.form')
            {!! Form::close() !!}
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts')

@stop
