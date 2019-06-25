@if ($notification->type === 'App\Notifications\GameCreatedNotification')
    <li>
        <a href="{{ route('admin.game.edit', $notification['data']['id']) }}">
            <span class="pull-right">
            {!! Form::open(['route' => ['admin.notification.read', $notification->id], 'method' => 'PUT']) !!}
                <button type="submit" class="btn btn-xs default"><i class="icon-check"></i></button>
                {!! Form::close() !!}
            </span>
            <span class="details">
                <span class="label label-sm label-icon label-success">
                    <i class="icon-game-controller"></i>
                </span> Nouveau Jeu Ajouté.
            </span>
        </a>
    </li>
@elseif ($notification->type == 'App\Notifications\BoxCreatedNotification')
    <li>
        <a href="{{ route('admin.box.edit', $notification['data']['id']) }}">
            <span class="details">
            <span class="label label-sm label-icon label-success">
                <i class="icon-eyeglasses"></i>
            </span> Nouvelle Box Ajouté.
        </span>
            <span class="pull-right">
            {!! Form::open(['route' => ['admin.notification.read', $notification->id], 'method' => 'PUT']) !!}
                <button type="submit" class="btn btn-xs default"><i class="icon-check"></i></button>
                {!! Form::close() !!}
            </span>
        </a>

    </li>
@endif