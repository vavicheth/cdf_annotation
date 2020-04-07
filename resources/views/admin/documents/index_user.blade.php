@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.documents.title')</h3>
    @can('document_create')
        <p>
            <a href="{{ route('admin.documents.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    <p>
    <ul class="list-inline">
        <li><a href="{{ route('admin.documents.index_user') }}" style="{{ request('show_done') == 1 || request('show_all') == 1 || request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Active</a></li> |
        <li><a href="{{ route('admin.documents.index_user') }}?show_done=1" style="{{ request('show_done') == 1 ? 'font-weight: 700' : '' }}">Closed</a></li> |
        <li><a href="{{ route('admin.documents.index_user') }}?show_all=1"  style="{{ request('show_all') == 1 ? 'font-weight: 700':'' }}">@lang('quickadmin.qa_all')</a></li>
        @can('document_delete')
            | <li><a href="{{ route('admin.documents.index_user') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        @endcan

    </ul>
    </p>



    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table id="doctable" class="table table-bordered table-striped {{ count($documents) > 0 ? 'datatable' : '' }} @can('document_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                <tr>
                    @can('document_delete')
                        @if ( request('show_deleted') != 1 )<th width="3%" style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                    @endcan

                    <th width="10%" style="padding: 1px !important; text-align: center" >លេខលិខិត</th>
                    <th width="10%" style="padding: 1px !important; text-align: center" >លេខចូល</th>
                    <th width="5%" style="padding: 1px !important; text-align: center" >លេខឯកសារ</th>
                    <th width="15%" style="padding: 1px !important; text-align: center" >មកពី</th>
                    <th width="15%" style="padding: 1px !important; text-align: center" >កម្មវត្ថុ</th>
                    <th width="5%" style="padding: 1px !important; text-align: center" >ស្ថានភាព</th>

                    <th width="5%" style="padding: 1px !important; text-align: center" >កាលបរិច្ឆេទ</th>
                    <th width="10%" style="padding: 1px !important; text-align: center" >ឯកសាររយោង</th>
                    @if( request('show_deleted') == 1 )
                        <th width="10%" style="padding: 1px !important; text-align: center" >&nbsp;</th>
                    @else
                        <th width="10%" style="padding: 1px !important; text-align: center" >&nbsp;</th>
                    @endif
                </tr>
                </thead>

                <tbody>
                @if (count($documents) > 0)
                    @foreach ($documents as $document)
                        <tr data-entry-id="{{ $document->id }}">
                            @can('document_delete')
                                @if ( request('show_deleted') != 1 )<td></td>@endif
                            @endcan

                            <td field-key='letter_code'>{{ $document->letter_code }}</td>
                            <td field-key='code_in'>{{ $document->code_in }}</td>
                            <td field-key='document_code'>{{ $document->document_code }}</td>
                            <td field-key='oranization'>{{ str_limit($document->oranization,25) }}</td>
                            <td field-key='description'>{!! str_limit($document->description,25) !!}</td>
                            <td field-key='submit'>
                                @if($document->submit == 1)
                                    <small class="label label-danger">Closed</small>
                                @elseif($document->submit == 2)
                                    <small class="label label-info">Approved</small>
                                @else
                                    <small class="label label-success">Active</small>
                                @endif
                            </td>
                            <td field-key='user_updated'>{{ $document->created_at }}</td>
                            <td field-key='file'> @foreach($document->getMedia('file') as $media)
                                    <p class="form-group">
                                        <a href="{{asset('storage').'/' .$media->id.'/'.$media->file_name}}" target="_blank">{{ $media->name }} ({{ $media->size }} KB)</a>
                                    </p>
                                @endforeach</td>
                            @if( request('show_deleted') == 1 )
                                <td>
                                    @can('document_delete')
                                        {!! Form::open(array(
        'style' => 'display: inline-block;',
        'method' => 'POST',
        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
        'route' => ['admin.documents.restore', $document->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                    @can('document_delete')
                                        {!! Form::open(array(
        'style' => 'display: inline-block;',
        'method' => 'DELETE',
        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
        'route' => ['admin.documents.perma_del', $document->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            @else
                                <td>
                                    @can('document_view')
                                        <a href="{{ route('admin.documents.show',[$document->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('document_edit')
                                        <a href="{{ route('admin.documents.edit',[$document->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('document_delete')
                                        {!! Form::open(array(
                                                                                'style' => 'display: inline-block;',
                                                                                'method' => 'DELETE',
                                                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                                                'route' => ['admin.documents.destroy', $document->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="14">@lang('quickadmin.qa_no_entries_in_table')</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('document_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.documents.mass_destroy') }}'; @endif
        @endcan






    </script>
@endsection
