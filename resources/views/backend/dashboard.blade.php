@extends('backend.layouts.app')

@section('after-styles')
    {!! Charts::assets() !!}
@endsection

@section('page-header')
    <h1>
        {{ trans('strings.backend.dashboard.title') }}
    </h1>
@endsection

@section('content')

    <div class="row widget-row">
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">Boxes en Total</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-default icon-eyeglasses"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="{{ $boxes->count() }}">{{ $boxes->count() }}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->
        </div>
        @foreach($statuses as $status)
            <div class="col-md-3">
                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                    <h4 class="widget-thumb-heading">Boxes {{ $status->label }}</h4>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon {{ $status->colors() }} icon-eyeglasses"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle"></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup"
                                  data-value="{{ $status->cnt }}">{{ $status->cnt }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">Chiffres d'affaires générés sur les 3 derniers mois</div>
                </div>
                <div class="box-body">
                    {!! $chart->render() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        Top 10 des Jeux les plus joués
                    </div>
                </div>
                <div class="portlet-body scroller" style="height: 400px;">
                    <ul class="list-group">
                        @foreach($topGames as $topGame)
                            <li class="list-group-item">
                                {{ link_to_route('admin.game.show', $topGame->code .' - '. $topGame->name, [$topGame->id] ) }}
                                <span class="pull-right">
                                        <span class="badge bg-green">{{ $topGame->boxes_count }}</span>
                                    </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-globe font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Activités</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" class="active" data-toggle="tab"> System </a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab"> Activities </a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <!--BEGIN TABS-->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    <li>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <td>Time</td>
                                                <td>Description</td>
                                                <td>User</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($activities as $activity)
                                                    <tr>
                                                        <td>{{ $activity->created_at->diffForHumans() }}</td>
                                                        <td>{{ $activity->generateDescription() }}</td>
                                                        <td>{{ $activity->causer->name ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection