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

                                    @foreach($categories as $category1)
                                    @php $colspan = count($category1->project->categories); @endphp

                                        @if (!in_array($category1->project_id, $projectIds))
                                        @php array_push($projectIds, $category1->project_id);  @endphp

                                            <th colspan=" {{ $colspan }} ">
                                                {{  $category1->project->name  }}
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
                                    @foreach($categories as $category2)
                                    <th>
                                        {{ $category2->name }}
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

                                        @foreach($categories as $category3)
                                        <td class="text-center">
                                            @php
                                                $categoryLanguages = $category3->project->languages;
                                                $categoryLanguagesCount = count($categoryLanguages);

                                                if(count($categoryLanguages->where('id', $language->id)) < 1 || $language->is_primary)
                                                {
                                                    $tanslationPercentage = "---";
                                                    $badgeClass = "Secondary";
                                                }
                                                else
                                                {
                                                    ini_set('memory_limit', '1024M');

                                                    $categoryPhrasesCount = $phrases->where('category_name', $category3->name)->count();

                                                    $translationsCount = $translations
                                                        ->where('category_name', $category3->name)
                                                        ->where('language_id', $language->id)
                                                        ->count();

                                                    $tanslationPercentage = $categoryPhrasesCount != 0 ?  $translationsCount / $categoryPhrasesCount * 100 : 100;

                                                    $tanslationPercentage = min(round($tanslationPercentage, 1), 100) ;

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

                                            @php $hasLink = (!$category3->project->languages->where('id', $language->id)->isEmpty() && !$language->is_primary); @endphp

                                            @if($hasLink) <a href="{{ route('admin.categories.translate', [$category3->name, $language->title]) }}"> @endif
                                                <span class="badge badge-xlg bg-{{ $badgeClass }}">{{ $tanslationPercentage }}</span>
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
