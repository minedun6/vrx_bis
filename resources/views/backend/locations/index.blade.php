@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('page-header')
    <h1>
        Gestion des Adresses
    </h1>
@endsection

@section('content')
    <div class="portlet light portlet-datatable">
        <div class="portlet-title">
            <div class="caption">Adresses</div>

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
