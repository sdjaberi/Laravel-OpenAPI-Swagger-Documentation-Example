@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.language.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.languages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.id') }}
                        </th>
                        <td>
                            {{ $language->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.title') }}
                        </th>
                        <td>
                            {{ $language->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.iso_code') }}
                        </th>
                        <td>
                            {{ $language->iso_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.local_name') }}
                        </th>
                        <td>
                            {{ $language->local_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.is_primary') }}
                        </th>
                        <td>
                            {{ $language->is_primary ? 'Yes' : 'No' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.active') }}
                        </th>
                        <td>
                            {{ $language->active ? 'Yes' : 'No' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.language.fields.text_direction') }}
                        </th>
                        <td>
                            {{ $language->text_direction }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.languages.index') }}">
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
                <a class="nav-link" href="#language_projects" role="tab" data-toggle="tab">
                    <i class="fa-fw fas fa-tasks nav-icon">

                    </i>
                    {{ trans('cruds.project.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#language_users" role="tab" data-toggle="tab">
                    <i class="fa-fw fas fa-user nav-icon">

                    </i>
                    {{ trans('cruds.user.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="language_projects">
                @includeIf('admin.languages.relationships.languageProjects', ['projects' => $language->projects])
            </div>
            <div class="tab-pane" role="tabpanel" id="language_users">
                @includeIf('admin.languages.relationships.languageUsers', ['users' => $language->users])
            </div>
        </div>
    </div>
</div>



@endsection
