@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.general.localizationOverview') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Home">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.language.title') }}
                                    </th>
                                    @foreach($categories as $key => $category)
                                    <th>
                                        {{ $category->project->name }}
                                        <br>
                                        {{ $category->name }}
                                        @if ($category->icon)
                                        <i class="fa-fw {{ $category->icon }} nav-icon">

                                        </i>
                                        @endif
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($languages->sortBy('id') as $key => $language)
                                    <tr>
                                        <td>
                                            {{ $language->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $language->title ?? '' }}
                                        </td>

                                        @foreach($categories as $key => $category)
                                        <td class="text-center">
                                            @php

                                                $phrases = $category->phrases;

                                                $categoryLanguages = $category->project->languages;
                                                $categoryLanguagesCount = count($categoryLanguages);

                                                if(count($categoryLanguages->where('id', $language->id)) < 1)
                                                {
                                                    $tanslationPercentage = "---";
                                                    $badgeClass = "Secondary";
                                                }
                                                else
                                                {
                                                    $translationsCount = 0;

                                                    foreach ($phrases as $key => $phrase) {
                                                        $categoryTranslations = $phrase->translations->where('language_id', $language->id);
                                                        if(count($categoryTranslations) > 0)
                                                        {
                                                            $translationsids = $translations->pluck('id')->toArray();
                                                            $categoryTranslationsids = $categoryTranslations->pluck('id')->toArray();
                                                            $translationsCount += count(array_intersect($translationsids, $categoryTranslationsids));

                                                        }
                                                    }

                                                    $remainedTranslations = count($phrases) * $categoryLanguagesCount;

                                                    $tanslationPercentage = $remainedTranslations != 0 ?  $translationsCount / $remainedTranslations * 100 : 100;

                                                    $tanslationPercentage = round($tanslationPercentage);

                                                    $badgeClass = "info";
                                                    switch ($tanslationPercentage) {
                                                        case 0:
                                                            $badgeClass = "danger";
                                                            break;
                                                        case 100:
                                                            $badgeClass = "success";
                                                            break;
                                                    }

                                                    $tanslationPercentage = $tanslationPercentage. "%";

                                                }

                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">{{ $tanslationPercentage }}</span>

                                        </td>
                                        @endforeach

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        $('.datatable-Home:not(.ajaxTable)').DataTable();
    });

</script>
@endsection
