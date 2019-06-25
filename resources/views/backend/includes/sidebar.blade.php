<ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="nav-item start {{ Active::pattern('admin/dashboard') }}">
        <a href="{{ route('admin.dashboard') }}" class="nav-link nav-toggle">
            <i class="icon-home"></i>
            <span class="title">{{ trans('menus.backend.sidebar.dashboard') }}</span>
        </a>
    </li>

    @permission('manage-boxes')
    <li class="nav-item  {{ Active::pattern('admin/box*') }}">
        <a href="{{ route('admin.box.index') }}" class="nav-link nav-toggle">
            <i class="icon-eyeglasses"></i>
            <span class="title">Gestion des Boxes</span>
        </a>
    </li>
    @endauth

    @permission('manage-workers')
    <li class="nav-item  {{ Active::pattern('admin/worker*') }}">
        <a href="{{ route('admin.worker.index') }}" class="nav-link nav-toggle">
            <i class="icon-user"></i>
            <span class="title">Gestion des Supérviseurs</span>
        </a>
    </li>
    @endauth

    @permission('manage-games')
    <li class="nav-item  {{ Active::pattern('admin/game*') }}">
        <a href="{{ route('admin.game.index') }}" class="nav-link nav-toggle">
            <i class="icon-game-controller"></i>
            <span class="title">Gestion des Jeux</span>
        </a>
    </li>
    @endauth

    @permission('manage-locations')
    <li class="nav-item  {{ Active::pattern('admin/location*') }}">
        <a href="{{ route('admin.location.index') }}" class="nav-link nav-toggle">
            <i class="icon-map"></i>
            <span class="title">Gestion des Adresses</span>
        </a>
    </li>
    @endauth

    @permission('view-game-history')
    <li class="nav-item  {{ Active::pattern('admin/gaming/history*') }}">
        <a href="{{ route('admin.gaming.history') }}" class="nav-link nav-toggle">
            <i class="icon-book-open"></i>
            <span class="title">Historique de Jeu</span>
        </a>
    </li>
    @endauth

    @permissions(['manage-users', 'manage-roles'])
    <li class="heading">
        <h3 class="uppercase">
            Access
        </h3>
    </li>
    <li class="nav-item ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-users"></i>
            <span class="title">{{ trans('menus.backend.access.title') }}</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            @permission('manage-users')
            <li class="nav-item  {{ Active::pattern('admin/access/user*') }}">
                <a href="{{ route('admin.access.user.index') }}" class="nav-link ">
                    <i class="icon-user"></i>
                    <span class="title">{{ trans('labels.backend.access.users.management') }}</span>
                </a>
            </li>
            <li class="nav-item  {{ Active::pattern('admin/access/role*') }}">
                <a href="{{ route('admin.access.role.index') }}" class="nav-link ">
                    <i class="icon-notebook"></i>
                    <span class="title">{{ trans('labels.backend.access.roles.management') }}</span>
                </a>
            </li>
            @endauth
        </ul>
    </li>
    @endauth
</ul>