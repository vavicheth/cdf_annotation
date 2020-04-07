@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.comments.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.comments.store'], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('document_id', trans('quickadmin.comments.fields.document').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('document_id', $documents, old('document_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('document_id'))
                        <p class="help-block">
                            {{ $errors->first('document_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('user_id', trans('quickadmin.comments.fields.user').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('user_id', $users, old('user_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('user_id'))
                        <p class="help-block">
                            {{ $errors->first('user_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('comment', trans('quickadmin.comments.fields.comment').'', ['class' => 'control-label']) !!}
                    {!! Form::text('comment', old('comment'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('comment'))
                        <p class="help-block">
                            {{ $errors->first('comment') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('comment_file', trans('quickadmin.comments.fields.comment-file').'', ['class' => 'control-label']) !!}
                    {!! Form::file('comment_file[]', [
                        'multiple',
                        'class' => 'form-control file-upload',
                        'data-url' => route('admin.media.upload'),
                        'data-bucket' => 'comment_file',
                        'data-filekey' => 'comment_file',
                        ]) !!}
                    <p class="help-block"></p>
                    <div class="photo-block">
                        <div class="progress-bar form-group">&nbsp;</div>
                        <div class="files-list"></div>
                    </div>
                    @if($errors->has('comment_file'))
                        <p class="help-block">
                            {{ $errors->first('comment_file') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('submit', trans('quickadmin.comments.fields.submit').'', ['class' => 'control-label']) !!}
                    {!! Form::hidden('submit', 0) !!}
                    {!! Form::checkbox('submit', 1, old('submit', false), []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('submit'))
                        <p class="help-block">
                            {{ $errors->first('submit') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('user_created_id', trans('quickadmin.comments.fields.user-created').'', ['class' => 'control-label']) !!}
                    {!! Form::select('user_created_id', $user_createds, old('user_created_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('user_created_id'))
                        <p class="help-block">
                            {{ $errors->first('user_created_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('user_updated_id', trans('quickadmin.comments.fields.user-updated').'', ['class' => 'control-label']) !!}
                    {!! Form::select('user_updated_id', $user_updateds, old('user_updated_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('user_updated_id'))
                        <p class="help-block">
                            {{ $errors->first('user_updated_id') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent

    <script src="{{ asset('quickadmin/plugins/fileUpload/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('quickadmin/plugins/fileUpload/js/jquery.fileupload.js') }}"></script>
    <script>
        $(function () {
            $('.file-upload').each(function () {
                var $this = $(this);
                var $parent = $(this).parent();

                $(this).fileupload({
                    dataType: 'json',
                    formData: {
                        model_name: 'Comment',
                        bucket: $this.data('bucket'),
                        file_key: $this.data('filekey'),
                        _token: '{{ csrf_token() }}'
                    },
                    add: function (e, data) {
                        data.submit();
                    },
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            var $line = $($('<p/>', {class: "form-group"}).html(file.name + ' (' + file.size + ' bytes)').appendTo($parent.find('.files-list')));
                            $line.append('<a href="#" class="btn btn-xs btn-danger remove-file">Remove</a>');
                            $line.append('<input type="hidden" name="' + $this.data('bucket') + '_id[]" value="' + file.id + '"/>');
                            if ($parent.find('.' + $this.data('bucket') + '-ids').val() != '') {
                                $parent.find('.' + $this.data('bucket') + '-ids').val($parent.find('.' + $this.data('bucket') + '-ids').val() + ',');
                            }
                            $parent.find('.' + $this.data('bucket') + '-ids').val($parent.find('.' + $this.data('bucket') + '-ids').val() + file.id);
                        });
                        $parent.find('.progress-bar').hide().css(
                            'width',
                            '0%'
                        );
                    }
                }).on('fileuploadprogressall', function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $parent.find('.progress-bar').show().css(
                        'width',
                        progress + '%'
                    );
                });
            });
            $(document).on('click', '.remove-file', function () {
                var $parent = $(this).parent();
                $parent.remove();
                return false;
            });
        });
    </script>
@stop