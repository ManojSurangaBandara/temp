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

<li class="nav-item {{ request()->routeIs('persons*')?'menu-open':'' }}">    
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users text-green"></i>
            <p>
                Person Mgt
                <i class="right fas fa-angle-left text-green"></i>
            </p>
        </a>
    
        @can('person-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    
                    <a href="{{route('persons.index')}}" class="nav-link
                    {{ request()->routeIs('persons.index','persons.create','persons.edit')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-green"></i>
                        <p>All Person</p>
                    </a>
                </li>
            </ul>
        @endcan

        {{-- @can('person-list') --}}
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('persons.action_pending_list')}}" class="nav-link
                    {{ request()->routeIs('persons.action_pending_list')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-green"></i>
                        <p>Action Pending</p>
                    </a>
                </li>
            </ul>
        {{-- @endcan --}}

        {{-- @can('person-list') --}}
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('persons.action_taken_list')}}" class="nav-link
                {{ request()->routeIs('persons.action_taken_list')?'active':'' }}">
                    <i class="far fa-circle nav-icon text-green"></i>
                    <p>Action Taken</p>
                </a>
            </li>
        </ul>
    {{-- @endcan --}}


    @can('person-approved-list')    
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('persons.approved_list')}}" class="nav-link
                {{ request()->routeIs('persons.approved_list')?'active':'' }}">
                    <i class="far fa-circle nav-icon text-green"></i>
                    <p>Approved List</p>
                </a>
            </li>
        </ul>
    @endcan

        {{-- @can('person-approve' , 'person-reject')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('persons.pending')}}" class="nav-link
                    {{ request()->routeIs('persons.pending')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-green"></i>
                        <p>Pending Approval</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('person-fwd' , 'person-fwd-reject')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('persons.fwd_pending')}}" class="nav-link
                    {{ request()->routeIs('persons.fwd_pending')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-green"></i>
                        <p>Fwd Pending Approval</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('person-rejected-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('persons.reject_list')}}" class="nav-link
                    {{ request()->routeIs('persons.reject_list')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-green"></i>
                        <p>Rejected List</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('person-approved-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('persons.approved_list')}}" class="nav-link
                    {{ request()->routeIs('persons.approved_list')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-green"></i>
                        <p>Approved List</p>
                    </a>
                </li>
            </ul>
        @endcan --}}
</li>

@can('card-print-list')
    <li class="nav-item">
        <a href="{{ route('cardprints.index') }}" class="nav-link {{ Request::is('cardprints.index*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-print text-teal"></i>
            <p>Card to be Print</p>
        </a>
    </li>
@endcan

@can('card-print-close-list')
    <li class="nav-item">
        <a href="{{ route('cardprints.printclose') }}" class="nav-link {{ Request::is('cardprints.printclose*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-id-card text-orange"></i>
            <p>Card to be H/O</p>
        </a>
    </li>
@endcan

@can('card-print-issue-list')
    <li class="nav-item">
        <a href="{{ route('carddetails.index') }}" class="nav-link {{ Request::is('carddetails.index*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-id-badge text-yellow"></i>
            <p>Card Issued</p>
        </a>
    </li>
@endcan

{{-- <li class="nav-item {{ request()->routeIs('forces*','ranks*','ranaviru_types*',
    )?'menu-open':'' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs text-blue"></i>
            <p>
                Reports
                <i class="right fas fa-angle-left text-blue"></i>
            </p>
        </a>
    
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('card_issuance_status.index')}}" class="nav-link
                {{ request()->routeIs('card_issuance_status*')?'active':'' }}">
                    <i class="far fa-circle nav-icon text-blue"></i>
                    <p>Card Issuance Status</p>
                </a>
            </li>
        </ul>
</li> --}}

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

@can('card-issuance-status-list','ethnicity-list')
    <li class="nav-item {{ request()->routeIs('forces*','ranks*','ranaviru_types*',
    'card_issue_criterias*','regiment_departments*','dsdivision*','usertype*','district*','marital_status*','province*','ethnicity*','card_issuance_status*','card_issue_criterias*','regiment_departments*','relation_ships*')?'menu-open':'' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs text-blue"></i>
            <p>
                Master Data
                <i class="right fas fa-angle-left text-blue"></i>
            </p>
        </a>

        @can('card-issuance-status-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('card_issuance_status.index')}}" class="nav-link
                    {{ request()->routeIs('card_issuance_status*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Card Issuance Status</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('card-issue-criteria-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('card_issue_criterias.index')}}" class="nav-link
                    {{ request()->routeIs('card_issue_criterias*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Card Issue Criteria</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('district-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('district.index')}}" class="nav-link
                    {{ request()->routeIs('district*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>District</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('dsdivision-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('dsdivision.index')}}" class="nav-link
                    {{ request()->routeIs('dsdivision*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>DS Division</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('ethnicity-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('ethnicity.index')}}" class="nav-link
                    {{ request()->routeIs('ethnicity*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Ethnicity</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('forces-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('forces.index')}}" class="nav-link
                    {{ request()->routeIs('forces*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Forces</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('marital-status-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('marital_status.index')}}" class="nav-link
                    {{ request()->routeIs('marital_status*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Marital Status</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('province-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('province.index')}}" class="nav-link
                    {{ request()->routeIs('province*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Province</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('ranaviru-type-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('ranaviru_types.index')}}" class="nav-link
                    {{ request()->routeIs('ranaviru_types*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Ranaviru Type</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('rank-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('ranks.index')}}" class="nav-link
                    {{ request()->routeIs('ranks*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Ranks</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('regiment-department-list')    
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('regiment_departments.index')}}" class="nav-link
                    {{ request()->routeIs('regiment_departments*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Regiment/Department</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('relationship-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('relation_ships.index')}}" class="nav-link
                    {{ request()->routeIs('relation_ships*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>Relationships</p>
                    </a>
                </li>
            </ul>
        @endcan

        @can('user-type-list')
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('usertype.index')}}" class="nav-link
                    {{ request()->routeIs('usertype*')?'active':'' }}">
                        <i class="far fa-circle nav-icon text-blue"></i>
                        <p>User Type</p>
                    </a>
                </li>
            </ul>
        @endcan

    </li>
    @endcan

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
