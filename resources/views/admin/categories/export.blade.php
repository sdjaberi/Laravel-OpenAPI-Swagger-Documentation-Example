@extends('layouts.admin')
@section('content')

<form method="POST" action="{{ route("admin.categories.export", [$category->name, $to->title]) }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h2 class="card-title pt-1 font-bold text-center">
                <strong id="category" data-name="{{ $category->name }}">{{ $category->project->name }} / {{ $category->name }}</strong>
            </h2>
            <ul class="nav justify-content-center mt-4 mb-3">
                <li class="nav-item">
                    <select class="custom-select" id="from" data-title="{{ $from->title }}">
                        <option selected disabled>{{ trans('cruds.general.from') }}: {{ $from->title }}</option>
                        <option value="{{ $from->title }}">{{ $from->title }}</option>
                    </select>
                </li>
                <li class="nav-item ml-5">
                    <select class="custom-select" id="to" data-title="{{ $to->title }}">


                        <option selected disabled>{{ trans('cruds.general.to') }}: {{ !isset($to->title) && empty($to->title) ? trans('cruds.general.all') : $to->title }} </option>

                        <option value="">{{ trans('cruds.general.all') }}</option>
                        @foreach($languagesTo as $language)
                            <option value="{{ $language->title }}">{{ $language->title }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="nav-item ml-5">
                    <select class="custom-select" id="categoryName" data-name="{{ $category->name  }}">
                        <option selected disabled>{{ trans('cruds.general.to') }}: {{ $category->name }}</option>
                        @foreach($categories as $name => $cat)
                            <option value="{{ $name }}" {{ ($category ? $category->name : old('category_name')) == $name ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="2">
                            {{ trans('cruds.general.from') }}: {{ $from->title }}
                            <br>
                            {{ trans('cruds.general.to') }}: {{ !isset($to->title) && empty($to->title) ? trans('cruds.general.all') : $to->title }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.phrase.fields.translations') }}
                        </th>
                        <td>
                            {{ count($translations) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phrase.title') }}
                        </th>
                        <td>
                            {{ count($category->phrases) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phrase.fields.phrase_category_id') }}
                        </th>
                        <td>
                            {{ count($phrasesCategories) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center">
            <button class="btn btn-lg btn-danger" type="submit">
                {{ trans('cruds.general.exportData') }}
            </button>
        </div>
    </div>
</form>

@endsection


@section('scripts')
@parent
<script>
    $(function () {

        let langFrom = $('#from').data("title");
        let langTo = $('#to').data("title");
        let catName = $('#categoryName').data("name");

        $('#to').change(function (value) {
            window.location.href = window.location.origin + `/admin/categories/${catName}/export/${$('#to').val()}`;
        });

        $('#categoryName').change(function (value) {
            window.location.href = window.location.origin + `/admin/categories/${$('#categoryName').val()}/export/${langTo}`;
        });

    });

</script>
@endsection
