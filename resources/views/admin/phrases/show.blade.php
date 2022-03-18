@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.phrase.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.phrases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.phrase.fields.id') }}
                        </th>
                        <td>
                            {{ $phrase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phrase.fields.base_id') }}
                        </th>
                        <td>
                            {{ $phrase->base_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phrase.fields.phrase') }}
                        </th>
                        <td>
                            {{ $phrase->phrase }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.title_singular') }} => {{ trans('cruds.phrase.fields.category_name') }}
                        </th>
                        <td>
                            {{ $phrase->category->project->name ?? '' }} => {{ $phrase->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phrase.fields.phrase_category_id') }}
                        </th>
                        <td>
                            {{ $phrase->phraseCategory->name ?? '' }} => {{ json_encode($phrase->phraseCategory->filename) ?? '' }}
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.phrases.index') }}">
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
                <a class="nav-link" href="#phrase_translations" role="tab" data-toggle="tab">
                    <i class="fa-fw fa fa-exchange nav-icon">

                    </i>
                    {{ trans('cruds.translation.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="phrase_translations">
                @includeIf('admin.phrases.relationships.phraseTranslations', ['translations' => $phrase->translations])
            </div>
        </div>
    </div>
</div>



@endsection
