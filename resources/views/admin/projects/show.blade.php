@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.project.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.id') }}
                        </th>
                        <td>
                            {{ $project->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.name') }}
                        </th>
                        <td>
                            {{ $project->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.description') }}
                        </th>
                        <td>
                            {{ $project->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.author') }}
                        </th>
                        <td>
                            {{ $project->author->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.languages') }}
                        </th>
                        <td>
                            @foreach($project->languages as $key => $languages)
                                <span class="label label-info">{{ $languages->title."(". $languages->iso_code .")" }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
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
                <a class="nav-link" href="#project_languages" role="tab" data-toggle="tab">
                    <i class="fa-fw fas fa-globe nav-icon">

                    </i>
                    {{ trans('cruds.language.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#project_categories" role="tab" data-toggle="tab">
                    <i class="fa-fw fas fa-list-alt nav-icon">

                    </i>
                    {{ trans('cruds.category.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="project_languages">
                @includeIf('admin.projects.relationships.projectLanguages', ['languages' => $project->languages])
            </div>
            <div class="tab-pane" role="tabpanel" id="project_categories">
                @includeIf('admin.projects.relationships.projectCategories', ['categories' => $project->categories])
            </div>
        </div>
    </div>
</div>



@endsection
