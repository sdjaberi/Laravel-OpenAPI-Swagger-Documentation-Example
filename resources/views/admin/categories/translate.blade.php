@extends('layouts.admin')
@section('content')

@php
    ini_set('memory_limit','512M');
@endphp

<div class="card">
    <div class="card-header">
        <h2 class="card-title pt-1 font-bold text-center">
            <strong id="categoryName" data-name="{{ $category->name }}">{{ $category->project->name }} / {{ $category->name }}</strong>
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
                    <option selected disabled>{{ trans('cruds.general.to') }}: {{ $to->title }}</option>
                    @foreach($languagesTo as $language)
                        <option value="{{ $language->title }}">{{ $language->title }}</option>
                    @endforeach
                </select>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <table id="CategoryTable" class="table table-bordered table-striped table-hover datatable datatable-Category">
            <thead>
            <tr>
                <th class="th-sm">{{ trans('cruds.phrase.fields.base_id') }}
                </th>
                <th class="th-sm">{{ $from->title }}
                </th>
                <th class="th-sm">{{ $to->title }}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($phrases as $phrase)
                <tr>
                    <td style="width: 7%">{{ $phrase->base_id }}</td>
                    <td style="width: 43%">{{ $phrase->phrase }}</td>

                    <td id="td-{{ $phrase->id }} {{ $to->text_direction === 'rtl' ? 'text-right': 'text-left' }}" style="{{ $to->text_direction === 'rtl' ? 'direction: rtl': '' }}>
                        @if($translation = $translations->where('phrase_id', $phrase->id)->first())
                            <div class="form-group">
                                <textarea class="form-control update-translation {{ $to->text_direction === 'rtl' ? 'text-right': 'text-left' }}"
                                          {{ $to->text_direction === 'rtl' ? 'dir=rtl': '' }}
                                          data-id="{{ $translation->id }}"
                                          data-user="{{ $user->id }}"
                                          data-phrase="{{ $phrase->id }}"
                                          data-category="{{ $category->name }}"
                                          data-language="{{ $to->id }}"
                                          data-value="{{ $translation->translation }}"
                                          >{{ $translation->translation }}</textarea>
                            </div>
                        @else
                            <div class="form-group">
                                <textarea class="form-control store-translation {{ $to->text_direction === 'rtl' ? 'text-right': 'text-left' }}"
                                          {{ $to->text_direction === 'rtl' ? 'dir=rtl': '' }}
                                          data-user="{{ $user->id }}"
                                          data-phrase="{{ $phrase->id }}"
                                          data-category="{{ $category->name }}"
                                          data-language="{{ $to->id }}"
                                          ></textarea>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection


@section('scripts')
@parent
<script>
    $(function () {
        $('.datatable-Category:not(.ajaxTable)').DataTable({
            fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
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
            scrollX:        true,
            scrollCollapse: true,
            orderCellsTop: true,
            order: [[0, 'asc']],
            colReorder: {
            realtime: false,
            },
            autoWidth: false,
        });


        let langFrom = $('#from').data("title");
        let langTo = $('#to').data("title");
        let catName = $('#categoryName').data("name");

        $('#to').change(function (value) {
            window.location.href = window.location.origin + `/admin/categories/${catName}/translate/${$('#to').val()}`;
        });

        class Translation {
        _id
        _userId;
        _phraseId;
        _languageId;
        _translation;

        constructor(id = null, userId, phraseId, languageId, translation) {
            this._id = id;
            this._userId = userId;
            this._phraseId = phraseId;
            this._languageId = languageId;
            this._translation = translation;
        }

        get id() {
            return this._id;
        }

        set id(value) {
            this._id = value;
        }

        get userId() {
            return this._userId;
        }

        set userId(value) {
            this._userid = value;
        }

        get phraseId() {
            return this._phraseId;
        }

        set phraseId(value) {
            this._phraseId = value;
        }

        get languageId() {
            return this._languageId;
        }

        set languageId(value) {
            this._languageId = value;
        }

        get translation() {
            return this._translation;
        }

        set translation(value) {
            this._translation = value;
        }
    }

    //FocusIn
    $(document).on('focusin', '.update-translation', function () {
        let element = this;
        element.setAttribute('style', 'border: 2px solid yellow');
    });

    // STORE
    $(document).on('focusout', '.store-translation', function () {
        let element = this;
        let userId = this.dataset.user;
        let phraseId = this.dataset.phrase;
        let languageId = this.dataset.language;
        let translation_txt = this.value;

        let translation = new Translation(null, userId, phraseId, languageId, translation_txt);

        if(translation._translation.trim().length > 0) {
            $.ajax({
                url: "/admin/translations/ajaxStore",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data: {
                    "user_id": translation._userId,
                    "phrase_id": translation._phraseId,
                    "language_id": translation._languageId,
                    "translation": translation._translation
                },
                success: function (response) {
                    element.setAttribute('data-id', response.data.id);
                    element.setAttribute('data-value', response.data.translation);

                    element.className = "form-control update-translation animated pulse";
                    element.setAttribute('style', 'border: 1px solid #00C851');
                },
                error: function (error) {
                    alert("store-translation error " + error);

                }
            });
        }
        else
            element.removeAttribute('style');
    });

    // UPDATE
    $(document).on('focusout', '.update-translation', function () {

        let element = this;
        let id = this.dataset.id;
        let userId = this.dataset.user;
        let phraseId = this.dataset.phrase;
        let languageId = this.dataset.language;
        let translation_txt = this.value;
        let translation_txt_old = this.dataset.value;

        let translation = new Translation(id, userId, phraseId, languageId, translation_txt);

        if($(this).val().trim() != translation_txt_old) {
            $.ajax({
                url: "/admin/translations/ajaxUpdate/" + translation._id ,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "PUT",
                data: {
                    "id": translation._id,
                    "user_id": translation._userId,
                    "phrase_id": translation._phraseId,
                    "language_id": translation._languageId,
                    "translation": translation._translation
                },
                success: function (response) {
                    element.setAttribute('data-id', response.data.id);
                    element.setAttribute('data-value', response.data.translation);

                    $('.update-translation, .store-translation').removeClass('disabled');
                    element.className = "form-control update-translation animated pulse";
                    element.removeAttribute('style');
                    element.setAttribute('style', 'border: 1px solid #00C851');

                },
                error: function (error) {
                    alert("update-translation error " + error);
                }
            });
        }
        else
            element.removeAttribute('style');
    });


    });

</script>
@endsection
