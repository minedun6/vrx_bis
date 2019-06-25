@extends ('backend.layouts.app')

@section ('title', 'Supérviseur : ' . $worker->user->name )

@section('after-styles')
    {!! Charts::assets('highcharts') !!}
@stop

@section('page-header')
    <h1>
        Supérviseur : {{ $worker->code }}
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img alt="User profile picture" class="profile-user-img img-responsive img-circle"
                         src="{{ $worker->user->picture }}"
                        style="margin-left: 35%">
                    <h3 class="profile-username text-center">
                        {{ $worker->user->name }}
                    </h3>
                    <p class="text-muted text-center">
                        Travaille depuis {{ $worker->started_at }}
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <b>
                                Boxes
                            </b>
                            <a class="pull-right">
                                <span class="counter">{{ $worker->boxes->unique()->count() }}</span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>
                                Jeux Lancés
                            </b>
                            <a class="pull-right">
                                <span class="counter">{{ $worker->games->count() }}</span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>
                                Jeux Lancés Payants
                            </b>
                            <a class="pull-right">
                                <span class="counter">{{ $worker->games()->where('is_payed', 1)->count() }}</span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>
                                Argent Généré
                            </b>
                            <a class="pull-right">
                                {!!  $worker->generatedMoney() !!}
                            </a>
                        </li>
                    </ul>
                    </img>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Dernières Affectations</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body {{ count($worker->boxes->unique()) > 5 ? 'scroller' : '' }}">
                    @foreach( $worker->boxes->unique() as $box )
                        <strong><i class="fa fa-binoculars margin-r-5"></i> Box : {{ $box->code }}</strong>

                        <p class="text-muted">
                            {{ isset($box->location) ? $box->location->name : 'Non spécifié' }}
                        </p>
                        @if (!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@stop

@section('after-scripts')
@stop
