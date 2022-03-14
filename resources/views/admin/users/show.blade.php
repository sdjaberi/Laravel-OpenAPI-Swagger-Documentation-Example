@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="badge badge-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.categories') }}
                        </th>
                        <td>
                            @foreach($user->categories as $key => $category)
                                <span class="badge badge-success">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.languages') }}
                        </th>
                        <td>
                            @foreach($user->languages as $key => $language)
                                <span class="badge badge-warning">{{ $language->title }} ({{ $language->iso_code }})</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.userTranslations') }}
                        </th>
                        <td>
                            {{ count($user->userTranslations) ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#author_projects" role="tab" data-toggle="tab">
                    <i class="fa-fw fas fa-tasks nav-icon">

                    </i>
                    {{ trans('cruds.project.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user_languages" role="tab" data-toggle="tab">
                    <i class="fa-fw fa fa-quote-left nav-icon">

                    </i>
                    {{ trans('cruds.language.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user_categories" role="tab" data-toggle="tab">
                    <i class="fa-fw fas fa-list-alt nav-icon">

                    </i>
                    {{ trans('cruds.category.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="author_projects">
                @includeIf('admin.users.relationships.authorProjects', ['projects' => $user->authorProjects])
            </div>
            <div class="tab-pane" role="tabpanel" id="user_languages">
                @includeIf('admin.users.relationships.userLanguages', ['languages' => $user->languages])
            </div>
            <div class="tab-pane" role="tabpanel" id="user_categories">
                @includeIf('admin.users.relationships.userCategories', ['categories' => $user->categories])
            </div>
        </div>
    </div>
</div>

@endsection
