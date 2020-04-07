@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.users.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.users.fields.title')</th>
                            <td field-key='title'>{{ $user->title->name_kh ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.name')</th>
                            <td field-key='name'>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.name-kh')</th>
                            <td field-key='name_kh'>{{ $user->name_kh }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.email')</th>
                            <td field-key='email'>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.gender')</th>
                            <td field-key='gender'>{{ $user->gender }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.dob')</th>
                            <td field-key='dob'>{{ $user->dob }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.phone')</th>
                            <td field-key='phone'>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.staff-code')</th>
                            <td field-key='staff_code'>{{ $user->staff_code }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.position')</th>
                            <td field-key='position'>{{ $user->position->name_kh ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.department')</th>
                            <td field-key='department'>{{ $user->department->name_kh ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.role')</th>
                            <td field-key='role'>{{ $user->role->title ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.users.fields.photo')</th>
                            <td field-key='photo'>@if($user->photo)<a href="{{ asset('media').'/' . $user->photo }}" target="_blank"><img src="{{  asset('media').'/thumb/' . $user->photo}}"/></a>@endif</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#user_actions" aria-controls="user_actions" role="tab" data-toggle="tab">User actions</a></li>
<li role="presentation" class=""><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
<li role="presentation" class=""><a href="#departments" aria-controls="departments" role="tab" data-toggle="tab">Departments</a></li>
<li role="presentation" class=""><a href="#departments" aria-controls="departments" role="tab" data-toggle="tab">Departments</a></li>
<li role="presentation" class=""><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
<li role="presentation" class=""><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a></li>
<li role="presentation" class=""><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
<li role="presentation" class=""><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="user_actions">
<table class="table table-bordered table-striped {{ count($user_actions) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.user-actions.created_at')</th>
                        <th>@lang('quickadmin.user-actions.fields.user')</th>
                        <th>@lang('quickadmin.user-actions.fields.action')</th>
                        <th>@lang('quickadmin.user-actions.fields.action-model')</th>
                        <th>@lang('quickadmin.user-actions.fields.action-id')</th>
                        
        </tr>
    </thead>

    <tbody>
        @if (count($user_actions) > 0)
            @foreach ($user_actions as $user_action)
                <tr data-entry-id="{{ $user_action->id }}">
                    <td>{{ $user_action->created_at ?? '' }}</td>
                                <td field-key='user'>{{ $user_action->user->name ?? '' }}</td>
                                <td field-key='action'>{{ $user_action->action }}</td>
                                <td field-key='action_model'>{{ $user_action->action_model }}</td>
                                <td field-key='action_id'>{{ $user_action->action_id }}</td>
                                
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="comments">
<table class="table table-bordered table-striped {{ count($comments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.comments.fields.document')</th>
                        <th>@lang('quickadmin.comments.fields.user')</th>
                        <th>@lang('quickadmin.comments.fields.comment')</th>
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
                    <td field-key='document'>{{ $comment->document->letter_code ?? '' }}</td>
                                <td field-key='user'>{{ $comment->user->name ?? '' }}</td>
                                <td field-key='comment'>{{ $comment->comment }}</td>
                                <td field-key='comment_file'>@if($comment->comment_file)<a href="{{ asset(env('UPLOAD_PATH').'/' . $comment->comment_file) }}" target="_blank">Download file</a>@endif</td>
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
<div role="tabpanel" class="tab-pane " id="departments">
<table class="table table-bordered table-striped {{ count($departments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.departments.fields.name')</th>
                        <th>@lang('quickadmin.departments.fields.name-kh')</th>
                        <th>@lang('quickadmin.departments.fields.description')</th>
                        <th>@lang('quickadmin.departments.fields.user-created')</th>
                        <th>@lang('quickadmin.departments.fields.user-updated')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($departments) > 0)
            @foreach ($departments as $department)
                <tr data-entry-id="{{ $department->id }}">
                    <td field-key='name'>{{ $department->name }}</td>
                                <td field-key='name_kh'>{{ $department->name_kh }}</td>
                                <td field-key='description'>{{ $department->description }}</td>
                                <td field-key='user_created'>{{ $department->user_created->name ?? '' }}</td>
                                <td field-key='user_updated'>{{ $department->user_updated->name ?? '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('department_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.departments.restore', $department->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('department_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.departments.perma_del', $department->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('department_view')
                                    <a href="{{ route('admin.departments.show',[$department->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('department_edit')
                                    <a href="{{ route('admin.departments.edit',[$department->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('department_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.departments.destroy', $department->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="departments">
<table class="table table-bordered table-striped {{ count($departments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.departments.fields.name')</th>
                        <th>@lang('quickadmin.departments.fields.name-kh')</th>
                        <th>@lang('quickadmin.departments.fields.description')</th>
                        <th>@lang('quickadmin.departments.fields.user-created')</th>
                        <th>@lang('quickadmin.departments.fields.user-updated')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($departments) > 0)
            @foreach ($departments as $department)
                <tr data-entry-id="{{ $department->id }}">
                    <td field-key='name'>{{ $department->name }}</td>
                                <td field-key='name_kh'>{{ $department->name_kh }}</td>
                                <td field-key='description'>{{ $department->description }}</td>
                                <td field-key='user_created'>{{ $department->user_created->name ?? '' }}</td>
                                <td field-key='user_updated'>{{ $department->user_updated->name ?? '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('department_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.departments.restore', $department->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('department_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.departments.perma_del', $department->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('department_view')
                                    <a href="{{ route('admin.departments.show',[$department->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('department_edit')
                                    <a href="{{ route('admin.departments.edit',[$department->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('department_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.departments.destroy', $department->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="comments">
<table class="table table-bordered table-striped {{ count($comments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.comments.fields.document')</th>
                        <th>@lang('quickadmin.comments.fields.user')</th>
                        <th>@lang('quickadmin.comments.fields.comment')</th>
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
                    <td field-key='document'>{{ $comment->document->letter_code ?? '' }}</td>
                                <td field-key='user'>{{ $comment->user->name ?? '' }}</td>
                                <td field-key='comment'>{{ $comment->comment }}</td>
                                <td field-key='comment_file'>@if($comment->comment_file)<a href="{{ asset(env('UPLOAD_PATH').'/' . $comment->comment_file) }}" target="_blank">Download file</a>@endif</td>
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
<div role="tabpanel" class="tab-pane " id="documents">
<table class="table table-bordered table-striped {{ count($documents) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.documents.fields.letter-code')</th>
                        <th>@lang('quickadmin.documents.fields.code-in')</th>
                        <th>@lang('quickadmin.documents.fields.document-code')</th>
                        <th>@lang('quickadmin.documents.fields.oranization')</th>
                        <th>@lang('quickadmin.documents.fields.description')</th>
                        <th>@lang('quickadmin.documents.fields.submit')</th>
                        <th>@lang('quickadmin.documents.fields.user-created')</th>
                        <th>@lang('quickadmin.documents.fields.user-updated')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($documents) > 0)
            @foreach ($documents as $document)
                <tr data-entry-id="{{ $document->id }}">
                    <td field-key='letter_code'>{{ $document->letter_code }}</td>
                                <td field-key='code_in'>{{ $document->code_in }}</td>
                                <td field-key='document_code'>{{ $document->document_code }}</td>
                                <td field-key='oranization'>{{ $document->oranization }}</td>
                                <td field-key='description'>{!! $document->description !!}</td>
                                <td field-key='submit'>{{ Form::checkbox("submit", 1, $document->submit == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='user_created'>{{ $document->user_created->name ?? '' }}</td>
                                <td field-key='user_updated'>{{ $document->user_updated->name ?? '' }}</td>
                                <td field-key='file'>@if($document->file)<a href="{{ asset(env('UPLOAD_PATH').'/' . $document->file) }}" target="_blank">Download file</a>@endif</td>
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
<div role="tabpanel" class="tab-pane " id="comments">
<table class="table table-bordered table-striped {{ count($comments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.comments.fields.document')</th>
                        <th>@lang('quickadmin.comments.fields.user')</th>
                        <th>@lang('quickadmin.comments.fields.comment')</th>
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
                    <td field-key='document'>{{ $comment->document->letter_code ?? '' }}</td>
                                <td field-key='user'>{{ $comment->user->name ?? '' }}</td>
                                <td field-key='comment'>{{ $comment->comment }}</td>
                                <td field-key='comment_file'>@if($comment->comment_file)<a href="{{ asset(env('UPLOAD_PATH').'/' . $comment->comment_file) }}" target="_blank">Download file</a>@endif</td>
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
<div role="tabpanel" class="tab-pane " id="documents">
<table class="table table-bordered table-striped {{ count($documents) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.documents.fields.letter-code')</th>
                        <th>@lang('quickadmin.documents.fields.code-in')</th>
                        <th>@lang('quickadmin.documents.fields.document-code')</th>
                        <th>@lang('quickadmin.documents.fields.oranization')</th>
                        <th>@lang('quickadmin.documents.fields.description')</th>
                        <th>@lang('quickadmin.documents.fields.submit')</th>
                        <th>@lang('quickadmin.documents.fields.user-created')</th>
                        <th>@lang('quickadmin.documents.fields.user-updated')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($documents) > 0)
            @foreach ($documents as $document)
                <tr data-entry-id="{{ $document->id }}">
                    <td field-key='letter_code'>{{ $document->letter_code }}</td>
                                <td field-key='code_in'>{{ $document->code_in }}</td>
                                <td field-key='document_code'>{{ $document->document_code }}</td>
                                <td field-key='oranization'>{{ $document->oranization }}</td>
                                <td field-key='description'>{!! $document->description !!}</td>
                                <td field-key='submit'>{{ Form::checkbox("submit", 1, $document->submit == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='user_created'>{{ $document->user_created->name ?? '' }}</td>
                                <td field-key='user_updated'>{{ $document->user_updated->name ?? '' }}</td>
                                <td field-key='file'>@if($document->file)<a href="{{ asset(env('UPLOAD_PATH').'/' . $document->file) }}" target="_blank">Download file</a>@endif</td>
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

            <p>&nbsp;</p>

            <a href="{{ route('admin.users.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.date').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });
            
        });
    </script>
            
@stop
