<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home text-red"></i>
        <p>Home</p>
    </a>
</li>

{{-- <li class="nav-item">
    <a href="{{route('persons.index')}}" class="nav-link
    {{ request()->routeIs('persons*')?'active':'' }}">
    <i class="nav-icon fas fa-user-group text-green"></i>
            <p>Person Mgt</p>
    </a>
</li> --}}

<li class="nav-item">
    <a href="{{route('bungalows.index')}}" class="nav-link
    {{ request()->routeIs('bungalows*')?'active':'' }}">
    <i class="nav-icon fas fa-hotel text-green"></i>
            <p>Bungalow Mgt</p>
    </a>
</li>



<li class="nav-item {{ request()->routeIs('reports*')?'menu-open':'' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file text-pink"></i>
        <p>
            Report Management
            <i class="right fas fa-angle-left text-pink"></i>
        </p>
    </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('reports.person_profile')}}" class="nav-link
                {{ request()->routeIs('reports.person_profile')?'active':'' }}">
                    <i class="far fa-circle nav-icon text-pink"></i>
                    <p>Person Profile</p>
                </a>
            </li>
        </ul>
   
</li>

{{-- @can('card-issuance-status-list','ethnicity-list') --}}
    <li class="nav-item {{ request()->routeIs('directorates*','ranks*','regiments*',
    'units*')?'menu-open':'' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs text-blue"></i>
            <p>
                Master Data
                <i class="right fas fa-angle-left text-blue"></i>
            </p>
        </a>        

        {{-- @can('user-type-list') --}}
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('directorates.index')}}" class="nav-link
                    {{ request()->routeIs('directorates*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Directorates</p>
                    </a>
                </li>
            </ul>
        {{-- @endcan --}}

        {{-- @can('user-type-list') --}}
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('regiments.index')}}" class="nav-link
                {{ request()->routeIs('regiments*')?'active':'' }}">
                    <i class="far fa-circle nav-icon text-blue"></i>
                    <p>Regiments</p>
                </a>
            </li>
        </ul>
    {{-- @endcan --}}

    {{-- @can('user-type-list') --}}
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('units.index')}}" class="nav-link
            {{ request()->routeIs('units*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Units</p>
            </a>
        </li>
    </ul>
    {{-- @endcan --}}

    {{-- @can('user-type-list') --}}
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('ranks.index')}}" class="nav-link
            {{ request()->routeIs('ranks*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Ranks</p>
            </a>
        </li>
    </ul>
    {{-- @endcan --}}

    </li>
    {{-- @endcan --}}

@can('role-list','user-list','permission-category-list','permission-list')
    <li class="nav-item {{ request()->routeIs('users*', 'roles*','permissioncategories*','permissions*')?'menu-open':'' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt text-purple"></i>
            <p>
                System Management
                <i class="right fas fa-angle-left text-purple"></i>
            </p>
        </a>        

        @can('permission-category-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('permissioncategories.index')}}" class="nav-link
                    {{ request()->routeIs('permissioncategories.create','permissioncategories.edit','permissioncategories.index')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-purple"></i>
                        <p>Permission Category</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('permission-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('permissions.index')}}" class="nav-link
                    {{ request()->routeIs('permissions.create','permissions.edit','permissions.index')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-purple"></i>
                        <p>Permission</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('role-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link
                    {{ request()->routeIs('roles.create','roles.edit','roles.index')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-purple"></i>
                        <p>User Roles</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('user-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link
                    {{ request()->routeIs('users.index','users.edit')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-purple"></i>
                        <p>User</p>
                    </a>
                </li>
            </ul>
        @endcan

    </li>
@endcan

<li class="nav-item">
    <a href="{{ route('change.index') }}" class="nav-link {{ Request::is('change.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-key text-orange"></i>
        <p>Change Password</p>
    </a>
</li>
