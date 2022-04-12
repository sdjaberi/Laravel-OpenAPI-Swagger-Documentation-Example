@extends('layouts.admin')
@section('content')
@can('translation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.translations.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.translation.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.translation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Translation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.translation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.phrase.fields.base_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.translation.fields.translation') }}
                        </th>
                        <th>
                            {{ trans('cruds.translation.fields.phrase') }}
                        </th>
                        <th>
                            {{ trans('cruds.translation.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.translation.fields.language') }}
                        </th>
                        <th>
                            {{ trans('cruds.translation.fields.author') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


@endsection
@section('scripts')
@parent
<script>
    $(function () {

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    @can('translation_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.translations.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).attr('id');
                });

                if (ids.length === 0){
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }})
                    .done(function () { location.reload() })
                }
            }
        }

        dtButtons.push(deleteButton)
    @endcan

    // DataTable
    $('.datatable-Translation:not(.ajaxTable)').DataTable({
         buttons: dtButtons,
         processing: true,
         serverSide: true,
         ajax: "{{ route('admin.translations.getTranslations') }}",
         order: [[ 1, 'desc' ]],
         columns: [
            { data: null },
            { data: 'id' },
            { data: 'base_id' },
            { data: 'translation' },
            { data: 'phrase' },
            { data: 'status' },
            { data: 'language' },
            { data: 'author' },
            { data: 'id', orderable: false },
         ],
         rowId: 'id',
         columnDefs: [
            {
                targets: 0,
                select: true,
                className: 'select-checkbox',
                defaultContent: ""
            },
            {
                targets: 8,
                render: function (data) {
                    return '<a class="btn btn-xs btn-primary" href="/admin/translations/' + data + '">{{ trans('global.view') }}</a> ' +
                    '<a class="btn btn-xs btn-info" href="/admin/translations/' + data + '/edit">{{ trans('global.edit') }}</a> ' +
                    '<form action="/admin/translations/' + data + '" method="POST" onsubmit="return confirm(\'{{ trans('global.areYouSure') }}\');" style="display: inline-block;">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                        '<input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">' +
                    '</form>';
                }
            }
        ]
      });
})

</script>
@endsection
