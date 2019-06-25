@extends ('backend.layouts.app')

@section ('title', 'Gestion des Boxes')

@section('page-header')
    <h1>
        Gestion des Supérviseurs
    </h1>
@endsection

@section('content')
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">Supérviseurs</div>

            <div class="actions">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="portlet-body">
            {!! $dataTable->table() !!}
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts')
    {!! $dataTable->scripts() !!}
@stop
