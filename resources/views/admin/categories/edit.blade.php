@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.category.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.categories.update", [$category->name]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.category.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.category.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $category->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="icon">{{ trans('cruds.category.fields.icon') }} (example: <i class="fa fa-globe"></i> fa fa-globe )</label>
                <span style="background-color: #ddd;border-radius: 12px;padding: 5px;">
                    <i id="icon-show" class="{{ old('icon', $category->icon) }}"></i>
                </span>
                <input class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" >
                @if($errors->has('icon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('icon') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.icon_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.category.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $project)
                        <option value="{{ $id }}" {{ ($category->project ? $category->project->id : old('project_id')) == $id ? 'selected' : '' }}>{{ $project }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.project_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
@parent
<script>
    $(function () {
        $("#icon").on("input", function() {
            $( "#icon-show" ).removeClass().addClass($("#icon").val());
        });
})

</script>
@endsection
