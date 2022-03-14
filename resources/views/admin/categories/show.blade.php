@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.category.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.name') }}
                        </th>
                        <td>
                            {{ $category->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.description') }}
                        </th>
                        <td>
                            {{ $category->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.icon') }}
                        </th>
                        <td>
                            @if ($category->icon)
                                <i class="fa-fw {{ $category->icon }} nav-icon">

                                </i>
                                {{ $category->icon }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.project') }}
                        </th>
                        <td>
                            {{ $category->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.phrases') }}
                        </th>
                        <td>
                            {{ count($category->phrases) ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.categories.index') }}">
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
                <a class="nav-link" href="#category_phrases" role="tab" data-toggle="tab">
                    <i class="fa-fw fa fa-quote-left nav-icon">

                    </i>
                    {{ trans('cruds.phrase.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#category_users" role="tab" data-toggle="tab">
                    <i class="fa-fw fas fa-user nav-icon">

                    </i>
                    {{ trans('cruds.user.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="category_phrases">
                @includeIf('admin.categories.relationships.categoryPhrases', ['phrases' => $category->phrases])
            </div>
            <div class="tab-pane" role="tabpanel" id="category_users">
                @includeIf('admin.categories.relationships.categoryUsers', ['users' => $category->users])
            </div>
        </div>
    </div>
</div>




@endsection
