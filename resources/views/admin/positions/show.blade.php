@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.positions.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.positions.fields.name')</th>
                            <td field-key='name'>{{ $position->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.positions.fields.name-kh')</th>
                            <td field-key='name_kh'>{{ $position->name_kh }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.positions.fields.description')</th>
                            <td field-key='description'>{{ $position->description }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="users">
<table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.users.fields.title')</th>
                        <th>@lang('quickadmin.users.fields.name')</th>
                        <th>@lang('quickadmin.users.fields.name-kh')</th>
                        <th>@lang('quickadmin.users.fields.email')</th>
                        <th>@lang('quickadmin.users.fields.gender')</th>
                        <th>@lang('quickadmin.users.fields.dob')</th>
                        <th>@lang('quickadmin.users.fields.phone')</th>
                        <th>@lang('quickadmin.users.fields.staff-code')</th>
                        <th>@lang('quickadmin.users.fields.position')</th>
                        <th>@lang('quickadmin.users.fields.department')</th>
                        <th>@lang('quickadmin.users.fields.role')</th>
                                                <th>&nbsp;</th>

        </tr>
    </thead>

    <tbody>
        @if (count($users) > 0)
            @foreach ($users as $user)
                <tr data-entry-id="{{ $user->id }}">
                    <td field-key='title'>{{ $user->title->name_kh ?? '' }}</td>
                                <td field-key='name'>{{ $user->name }}</td>
                                <td field-key='name_kh'>{{ $user->name_kh }}</td>
                                <td field-key='email'>{{ $user->email }}</td>
                                <td field-key='gender'>{{ $user->gender }}</td>
                                <td field-key='dob'>{{ $user->dob }}</td>
                                <td field-key='phone'>{{ $user->phone }}</td>
                                <td field-key='staff_code'>{{ $user->staff_code }}</td>
                                <td field-key='position'>{{ $user->position->name_kh ?? '' }}</td>
                                <td field-key='department'>{{ $user->department->name_kh ?? '' }}</td>
                                <td field-key='role'>{{ $user->role->title ?? '' }}</td>
                                                                <td>
                                    @can('user_view')
                                    <a href="{{ route('admin.users.show',[$user->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('user_edit')
                                    <a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('user_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.users.destroy', $user->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="19">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.positions.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


