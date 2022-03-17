@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.general.localizationOverview') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="stripe row-border order-column table table-bordered datatable datatable-Home">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th rowspan="1">Title</th>
                                    @php $projectIds = array(); @endphp

                                    @foreach($categories as $key => $category)
                                    @php $colspan = count($category->project->categories); @endphp

                                        @if (!in_array($category->project_id, $projectIds))
                                        @php array_push($projectIds, $category->project_id);  @endphp

                                            <th colspan=" {{ $colspan }} ">
                                                {{  $category->project->name  }}
                                            </th>
                                        @endif

                                    @endforeach
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.language.title') }}
                                    </th>
                                    @foreach($categories as $key => $category)
                                    <th>
                                        {{ $category->name }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($languages as $key => $language)
                                    <tr>
                                        <td>
                                            {{ $language->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $language->title ?? '' }}

                                            @if (!$language->active)
                                                <i class="fa-fw fas fa-exclamation-triangle" data-toggle="tooltip" title="Deactive Language">

                                                </i>
                                            @endif

                                            @if ($language->is_primary)
                                                <i class="fa-fw fas fa-flag" data-toggle="tooltip" title="Primary Language">

                                                </i>
                                            @endif

                                        </td>

                                        @foreach($categories as $key => $category)
                                        <td class="text-center">
                                            @php

                                                $phrases = $category->phrases;

                                                $categoryLanguages = $category->project->languages;
                                                $categoryLanguagesCount = count($categoryLanguages);

                                                if(count($categoryLanguages->where('id', $language->id)) < 1 || $language->is_primary)
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

                                                    $totalRemainedTranslations = count($phrases) * $categoryLanguagesCount;
                                                    $remainedTranslations = count($phrases);

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

                                            @can('translation_edit')
                                            @php $hasLink = (!$category->project->languages->where('id', $language->id)->isEmpty() && !$language->is_primary);  @endphp
                                            @if($hasLink) <a href="{{ route('admin.categories.translate', [$category->name, $language->title]) }}"> @endif
                                                    <span class="badge badge-lg bg-{{ $badgeClass }}">{{ $tanslationPercentage }}</span>
                                            @if($hasLink) </a> @endif
                                            @endcan

                                        </td>
                                        @endforeach

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


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

        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        $('.datatable-Home').DataTable({
            fixedColumns: {
                left: 2
            },
            select: {
                style: 'single',
                info: false,
                selector: 'td:not(.status)'
            },
            columnDefs: [
            {
                targets: -1,
                className: "dt-body-center status"
            }
            ],
            scrollX: true,
            scrollY: true,
            order: [[0, 'asc']],
            autoWidth: false,
        });
    });

</script>
@endsection
