<!-- BEGIN NOTIFICATION DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-extended dropdown-notification dropdown-light" id="header_notification_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
       data-close-others="true">
        <i class="icon-bell"></i>
        <span class="badge badge-success"> {{ $logged_in_user->unreadNotifications->count() }} </span>
    </a>
    <ul class="dropdown-menu">
        <li class="external">
            <h3>
                <span>{{ trans_choice('strings.backend.general.you_have.notifications', $logged_in_user->unreadNotifications->count() , ['number' => $logged_in_user->unreadNotifications->count() ]) }}</span>
            </h3>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller"
                style="height: 100px;" data-handle-color="#637283">
                @foreach($logged_in_user->unreadNotifications as $unreadNotification)
                    @include ('backend.includes.notifications.notification-single', [
                        'notification' => $unreadNotification
                    ])
                @endforeach
            </ul>
        </li>
    </ul>
</li>
<!-- END NOTIFICATION DROPDOWN -->