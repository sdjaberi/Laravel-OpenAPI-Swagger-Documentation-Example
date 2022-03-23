<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>

            @php
            $LogedInUserProjects = Auth::user()->categories->map(function ($item) {
                    return $item->project;
                })
                ->unique('id');
            @endphp
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-check nav-icon">

                    </i>
                    {{ trans('cruds.general.overview') }}
                </a>
                <ul class="nav-dropdown-items">
                    @foreach($LogedInUserProjects as $project)
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link  nav-dropdown-toggle" href="#">
                            {{ $project->name }}
                        </a>
                        <ul class="nav-dropdown-items">
                            @foreach(Auth::user()->categories->where('project_id', $project->id) as $category)
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.translate', $category->name) }}" class="nav-link {{ (request()->is('admin/categories') || request()->is('admin/categories/'.$category->name.'/translate/*')) ? 'active' : '' }}">
                                        <i class="fa-fw {{$category->icon}} nav-icon">

                                        </i>
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </li>

            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('project_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-th-list nav-icon">

                        </i>
                        {{ trans('cruds.projectManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('project_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.projects.index") }}" class="nav-link {{ request()->is('admin/projects') || request()->is('admin/projects/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-tasks nav-icon">

                                    </i>
                                    {{ trans('cruds.project.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('category_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.categories.index") }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-list-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.category.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan


            @can('translation_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-language nav-icon">

                        </i>
                        {{ trans('cruds.translationManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('phrase_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.phrases.index") }}" class="nav-link {{ request()->is('admin/phrases') || request()->is('admin/phrases/*') ? 'active' : '' }}">
                                    <i class="fa-fw fa fa-quote-left nav-icon">

                                    </i>
                                    {{ trans('cruds.phrase.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('translation_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.translations.index") }}" class="nav-link {{ request()->is('admin/translations') || request()->is('admin/translations/*') ? 'active' : '' }}">
                                    <i class="fa-fw fa fa-exchange nav-icon">

                                    </i>
                                    {{ trans('cruds.translation.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('language_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.languages.index") }}" class="nav-link {{ request()->is('admin/languages') || request()->is('admin/languages/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-globe nav-icon">

                                    </i>
                                    {{ trans('cruds.language.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
