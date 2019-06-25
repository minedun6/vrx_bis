@extends ('backend.layouts.app')

@section ('title', 'Affichage détails Box')

@section('after-styles')
    {!! Charts::assets() !!}
@stop

@section('page-header')
    <h1>
        Affichage Détails Box
    </h1>
@endsection

@section('content')
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <div class="icon-bar-chart"></div>
                Box : {{ $box->code }}
            </div>
        </div>
        <div class="portlet-body">
            {!! $chart->render() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-globe font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Statistiques relatfives à la Box</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" class="active" data-toggle="tab"> Status </a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab"> Supérviseurs </a>
                        </li>
                        <li>
                            <a href="#tab_1_3" data-toggle="tab"> Jeux Lancés </a>
                        </li>
                        <li>
                            <a href="#tab_1_4" data-toggle="tab"> Revenue Généré </a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="scroller" style="height: 340px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    @foreach($box->statuses as $k => $status)
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm {{ $status->colors() }}">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> {{ $status->label }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    @if( !is_null( $status ) && !is_null( $box->statuses->get($k) ) && !is_null( $box->statuses->get($k + 1) ) )
                                                        {{ $box->statuses->get($k)->pivot->created_at->diffInDays($box->statuses->get($k + 1)->pivot->created_at) }}
                                                        jours
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_2">
                            <div class="scroller" style="height: 340px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    @foreach( $box->workers->unique() as $k => $worker )
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> {{ $worker->user->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_3">
                            <div class="scroller" style="height: 340px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    @foreach( $box->games as $k => $game )
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> {{ $game->code }} {{ $game->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="col2">--}}
                                            {{--<div class="date">--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_4">
                            <div class="scroller" style="height: 340px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    @foreach( $boxMoney as $k => $dayMoney )
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-money"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            {{ $dayMoney->played_at->format('m-d-Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    <span class="badge bg-green">
                                                        {{ number_format($dayMoney->day_price, 2, '.', ' ') . ' ' . config('app.currency') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
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
                <div class="portlet-body scroller" style="height: 350px;">
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

@stop

@section('after-scripts')
@stop