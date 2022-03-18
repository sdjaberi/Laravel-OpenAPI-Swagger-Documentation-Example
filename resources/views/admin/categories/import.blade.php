@extends('layouts.admin')
@section('content')

<form method="POST" action="{{ route("admin.categories.import", $category->name) }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h2 class="card-title pt-1 font-bold text-center">
                <strong>{{ $category->project->name }} / {{ $category->name }}</strong>
            </h2>
            <ul class="nav justify-content-center mt-4 mb-3">
                <li class="nav-item">
                    <select class="custom-select" id="from" data-title="{{ $from->title }}">
                        <option selected disabled>{{ trans('cruds.general.fileLanguage') }}: {{ $from->title }}</option>
                        <option value="{{ $from->title }}">{{ $from->title }}</option>
                    </select>
                </li>
                <li class="nav-item ml-5">
                    <select class="custom-select" id="categoryName" data-name="{{ $category->name }}">
                        @foreach($categories as $name => $cat)
                            <option value="{{ $name }}" {{ ($category ? $category->name : old('category_name')) == $name ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </li>
            </ul>
        </div>

        <div class="card-body text-center">
            <label for="myfile">Select a file:</label>
            <div class="file-upload-wrapper">
                <input type="file" id="input-file-now" name="myfile" class="file-upload"/>
            </div>
        </div>

        <div class="card-footer text-center">
            <button class="btn btn-lg btn-danger" type="submit">
                {{ trans('cruds.general.importData') }}
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
        let catName = $('#categoryName').data("name");

        $('#categoryName').change(function (value) {
            window.location.href = window.location.origin + `/admin/categories/${$('#categoryName').val()}/import`;
        });

    });

</script>
@endsection
