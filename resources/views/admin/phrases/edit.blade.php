@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.phrase.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.phrases.update", [$phrase->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="base_id">{{ trans('cruds.phrase.fields.base_id') }}</label>
                <input class="form-control {{ $errors->has('base_id') ? 'is-invalid' : '' }}" type="number" name="base_id" id="base_id" value="{{ old('name', $phrase->base_id) }}">
                @if($errors->has('base_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('base_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phrase.fields.base_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phrase">{{ trans('cruds.phrase.fields.phrase') }}</label>
                <textarea class="form-control {{ $errors->has('phrase') ? 'is-invalid' : '' }}" name="phrase" id="phrase" required>{{ old('description', $phrase->phrase) }}</textarea>
                @if($errors->has('phrase'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phrase') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phrase.fields.phrase_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="category_name">{{ trans('cruds.phrase.fields.category_name') }}</label>
                <select class="form-control select2 {{ $errors->has('category_name') ? 'is-invalid' : '' }}" name="category_name" id="category_name" required>
                    @foreach($categories as $name => $category)
                        <option value="{{ $name }}" {{ ($phrase->category ? $phrase->category->name : old('category_name')) == $name ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('category_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phrase.fields.category_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phrase_category_id">{{ trans('cruds.phrase.fields.phrase_category_id') }}</label>
                <select class="form-control select2 {{ $errors->has('phrase_category_id') ? 'is-invalid' : '' }}" name="phrase_category_id" id="phrase_category_id">
                    @foreach($phraseCategories as $id => $phraseCategory)
                        <option value="{{ $id }}" {{ ($phrase->phraseCategory ? $phrase->phraseCategory->id : old('phrase_category_id')) == $id ? 'selected' : '' }}>{{ $phraseCategory }}</option>
                    @endforeach
                </select>
                @if($errors->has('phrase_category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phrase_category_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phrase.fields.phrase_category_id_helper') }}</span>
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
