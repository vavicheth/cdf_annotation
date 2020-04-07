@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.comments.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.comments.fields.document')</th>
                            <td field-key='document'>{{ $comment->document->letter_code ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.comments.fields.user')</th>
                            <td field-key='user'>{{ $comment->user->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.comments.fields.comment')</th>
                            <td field-key='comment'>{{ $comment->comment }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.comments.fields.comment-file')</th>
                            <td field-key='comment_file's> @foreach($comment->getMedia('comment_file') as $media)
                                <p class="form-group">
                                    <a href="{{ $media->getUrl() }}" target="_blank">{{ $media->name }} ({{ $media->size }} KB)</a>
                                </p>
                            @endforeach</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.comments.fields.submit')</th>
                            <td field-key='submit'>{{ Form::checkbox("submit", 1, $comment->submit == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.comments.fields.user-created')</th>
                            <td field-key='user_created'>{{ $comment->user_created->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.comments.fields.user-updated')</th>
                            <td field-key='user_updated'>{{ $comment->user_updated->name ?? '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.comments.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


