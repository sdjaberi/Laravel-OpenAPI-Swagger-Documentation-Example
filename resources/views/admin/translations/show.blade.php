@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.translation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.translations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.translation.fields.id') }}
                        </th>
                        <td>
                            {{ $translation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translation.fields.translation') }}
                        </th>
                        <td>
                            {{ $translation->translation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translation.fields.phrase') }}
                        </th>
                        <td>
                            {{ $translation->phrase->phrase }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translation.fields.language') }}
                        </th>
                        <td>
                            {{ $translation->language->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translation.fields.author') }}
                        </th>
                        <td>
                            {{ $translation->author->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.translations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
