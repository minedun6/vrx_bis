<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.backend.locations.create') }}</h3>
        <div class="box-tools pull-right">
            @include('backend.locations.includes.partials.location-header-buttons')
        </div><!--box-tools pull-right-->
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="form-group">
            {{ Form::label('name', trans('validation.attributes.backend.locations.name'), ['class' => 'col-lg-2 control-label']) }}

            <div class="col-lg-10">
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.locations.name')]) }}
            </div><!--col-lg-10-->
        </div><!--form control-->
        <div class="form-group">
            {{ Form::label('city', trans('validation.attributes.backend.locations.city'), ['class' => 'col-lg-2 control-label']) }}

            <div class="col-lg-10">
                {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.locations.city')]) }}
            </div><!--col-lg-10-->
        </div><!--form control-->

    </div><!-- /.box-body -->
</div><!--box-->

<div class="box box-info">
    <div class="box-body">
        <div class="pull-left">
            {{ link_to_route('admin.game.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
        </div><!--pull-left-->

        <div class="pull-right">
            {{ Form::submit($button, ['class' => 'btn btn-success btn-xs']) }}
        </div><!--pull-right-->

        <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!--box-->
