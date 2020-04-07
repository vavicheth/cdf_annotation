@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.comments.title')</h3>
    @can('comment_create')
    <p>
        <a href="{{ route('admin.comments.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('comment_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.comments.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.comments.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($comments) > 0 ? 'datatable' : '' }} @can('comment_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('comment_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.comments.fields.document')</th>
                        <th>@lang('quickadmin.comments.fields.user')</th>
                        <th>@lang('quickadmin.comments.fields.comment')</th>
                        <th>@lang('quickadmin.comments.fields.comment-file')</th>
                        <th>@lang('quickadmin.comments.fields.submit')</th>
                        <th>@lang('quickadmin.comments.fields.user-created')</th>
                        <th>@lang('quickadmin.comments.fields.user-updated')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($comments) > 0)
                        @foreach ($comments as $comment)
                            <tr data-entry-id="{{ $comment->id }}">
                                @can('comment_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='document'>{{ $comment->document->letter_code ?? '' }}</td>
                                <td field-key='user'>{{ $comment->user->name ?? '' }}</td>
                                <td field-key='comment'>{{ $comment->comment }}</td>
                                <td field-key='comment_file'> @foreach($comment->getMedia('comment_file') as $media)
                                <p class="form-group">
                                    <a href="{{ $media->getUrl() }}" target="_blank">{{ $media->name }} ({{ $media->size }} KB)</a>
                                </p>
                            @endforeach</td>
                                <td field-key='submit'>{{ Form::checkbox("submit", 1, $comment->submit == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='user_created'>{{ $comment->user_created->name ?? '' }}</td>
                                <td field-key='user_updated'>{{ $comment->user_updated->name ?? '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('comment_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.comments.restore', $comment->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('comment_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.comments.perma_del', $comment->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('comment_view')
                                    <a href="{{ route('admin.comments.show',[$comment->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('comment_edit')
                                    <a href="{{ route('admin.comments.edit',[$comment->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('comment_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.comments.destroy', $comment->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('comment_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.comments.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection