@extends('layouts.admin')
@section('content')
@can('phrase_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.phrases.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.phrase.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.phrase.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Phrase">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.phrase.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.phrase.fields.base_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.phrase.fields.phrase') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.title_singular') }} => {{ trans('cruds.phrase.fields.category_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.phrase.fields.phrase_category_id') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($phrases as $key => $phrase)
                        <tr data-entry-id="{{ $phrase->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $phrase->id ?? '' }}
                            </td>
                            <td>
                                {{ $phrase->base_id ?? '' }}
                            </td>
                            <td>
                                {{ $phrase->phrase ?? '' }}
                            </td>
                            <td>
                                {{ $phrase->category->project->name ?? '' }} => {{ $phrase->category->name ?? '' }}
                            </td>
                            <td>
                                {{ $phrase->phraseCategory->name ?? '' }}
                            </td>
                            <td>
                                @can('phrase_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.phrases.show', $phrase->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('phrase_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.phrases.edit', $phrase->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('phrase_delete')
                                    <form action="{{ route('admin.phrases.destroy', $phrase->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
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
@can('phrase_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.phrases.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
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

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Phrase:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
