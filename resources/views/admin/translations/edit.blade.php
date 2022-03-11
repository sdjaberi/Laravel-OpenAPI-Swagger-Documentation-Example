@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.translation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.translations.update", [$translation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="translation">{{ trans('cruds.translation.fields.translation') }}</label>
                <textarea class="form-control {{ $errors->has('translation') ? 'is-invalid' : '' }}" name="translation" id="translation" >{{ old('translation', $translation->translation) }}</textarea>
                @if($errors->has('translation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('translation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.translation.fields.translation_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="phrase_id">{{ trans('cruds.translation.fields.phrase') }}</label>
                <select class="form-control select2 {{ $errors->has('phrase') ? 'is-invalid' : '' }}" name="phrase_id" id="phrase_id">
                    @foreach($phrases as $id => $phrase)
                        <option value="{{ $id }}" {{ ($translation->phrase ? $translation->phrase->id : old('phrase_id')) == $id ? 'selected' : '' }}>{{ $phrase }}</option>
                    @endforeach
                </select>
                @if($errors->has('phrase_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phrase_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.translation.fields.author_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="language_id">{{ trans('cruds.translation.fields.language') }}</label>
                <select class="form-control select2 {{ $errors->has('language') ? 'is-invalid' : '' }}" name="language_id" id="language_id">
                    @foreach($languages as $id => $language)
                        <option value="{{ $id }}" {{ ($translation->language ? $translation->language->id : old('language_id')) == $id ? 'selected' : '' }}>{{ $language }}</option>
                    @endforeach
                </select>
                @if($errors->has('language_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('language_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.translation.fields.language_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.translation.fields.author') }}</label>
                <select class="form-control select2 {{ $errors->has('author') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($authors as $id => $author)
                        <option value="{{ $id }}" {{ ($translation->author ? $translation->author->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $author }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.translation.fields.author_helper') }}</span>
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
