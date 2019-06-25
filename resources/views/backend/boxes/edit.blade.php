@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('page-header')
    <h1>
        Gestion des Boxes
    </h1>
@endsection

@section('content')
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">Ajout d'une Nouvelle Box</div>

            <div class="actions">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="portlet-body form">
            {!! Form::model($box, ['route' => ['admin.box.update', $box], 'method' => 'PATCH']) !!}
            @include ('backend.boxes.partials.form')
            {!! Form::close() !!}
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts')

@stop
