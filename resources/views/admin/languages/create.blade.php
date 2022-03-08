@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.language.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.languages.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.language.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.title_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="iso_code">{{ trans('cruds.language.fields.iso_code') }}</label>
                <input class="form-control {{ $errors->has('iso_code') ? 'is-invalid' : '' }}" type="text" name="iso_code" id="iso_code" value="{{ old('iso_code', '') }}" required>
                @if($errors->has('iso_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('iso_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.iso_code_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="is_primary" >{{ trans('cruds.language.fields.is_primary') }}</label>
                <input class="form-control {{ $errors->has('is_primary') ? 'is-invalid' : '' }}" type="checkbox" name="is_primary" id="is_primary" value="{{ old('is_primary', '') }}">
                @if($errors->has('is_primary'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_primary') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.is_primary_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="active" >{{ trans('cruds.language.fields.active') }}</label>
                <input class="form-control {{ $errors->has('active') ? 'is-invalid' : '' }}" type="checkbox" name="active" id="active" value="{{ old('active', '') }}"
                    checked>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.is_primary_helper') }}</span>
            </div>


            <div class="form-group">
                <label for="text_direction">{{ trans('cruds.language.fields.text_direction') }}</label>
                <select class="form-control select2 {{ $errors->has('text_direction') ? 'is-invalid' : '' }}" name="text_direction" id="text_direction" required>
                    @foreach($text_directions as $id => $text_direction)
                        <option value="{{ $text_direction }}" {{ old('text_direction') == $text_direction ? 'selected' : '' }}>{{ $text_direction }}</option>
                    @endforeach
                </select>
                @if($errors->has('text_direction'))
                    <div class="invalid-feedback">
                        {{ $errors->first('text_direction') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.language.fields.text_direction_helper') }}</span>
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
