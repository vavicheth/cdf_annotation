@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.documents.title')</h3>

    <div class="panel panel-primary">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>លេខលិខិត</th>
                            <td field-key='letter_code'>{{ $document->letter_code }}</td>
                        </tr>
                        <tr>
                            <th>លេខកូដចូល</th>
                            <td field-key='code_in'>{{ $document->code_in }}</td>
                        </tr>
                        <tr>
                            <th>លេខកូដឯកសារ</th>
                            <td field-key='document_code'>{{ $document->document_code }}</td>
                        </tr>
                        <tr>
                            <th>មកពី</th>
                            <td field-key='oranization'>{{ $document->oranization }}</td>
                        </tr>
                        <tr>
                            <th>អ្នកមានយោបល់</th>
                            <td field-key='users'>
                                @foreach($document->user as $user)
                                    {{$user->name_kh}},
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.documents.fields.description')</th>
                            <td field-key='description'>{!! $document->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.documents.fields.submit')</th>
                            <td field-key='submit'>{{ Form::checkbox("submit", 1, $document->submit == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.documents.fields.user-created')</th>
                            <td field-key='user_created'>{{ $document->user_created->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.documents.fields.user-updated')</th>
                            <td field-key='user_updated'>{{ $document->user_updated->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>ឯកសារ</th>
                            <td field-key='files'>
                                @foreach($document->getMedia('file') as $media)
                                    <p class="form-group">
                                        <a href="{{asset('storage').'/' .$media->id.'/'.$media->file_name}}" target="_blank">{{ $media->name }} ({{ $media->size }} B)</a>
                                        @can('edit_pdf')
                                            <a href="{{ route('admin.documents.view_pdf',[$document->id,$media->id]) }}" target="_blank" class="btn btn-xs btn-primary">Approve on file</a>
                                        @endcan
                                    </p>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

        <div class="row">
            <div class="col-md-12">
                <!-- DIRECT CHAT -->
                <div class="box box-success direct-chat direct-chat-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">យោបល់</h3>
                    </div>
                    <!-- /.box-header -->

                            @foreach($comments as $comment)
                                <!-- Message. Default to the left -->
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-left">{{$comment->user->department->name_kh .'៖ '. $comment->user->title->name_kh .' '.$comment->user->name_kh}}</span>
                                        <span class="direct-chat-timestamp pull-right">{{$comment->updated_at ->format('d-M-Y  H:i:s')}}</span>

                                        </button>
                                    </div>
                                    <!-- /.direct-chat-info -->
                                    <img class="direct-chat-img" src="{{ asset('media'.'/' . $comment->user->photo)}}" alt="image">
                                    <!-- /.direct-chat-img -->
                                    <div class="direct-chat-text">
                                        {{$comment->comment}}
                                    </div>

                                    @if($user_login->role->id == '1' || ($comment->user_id == $user_login->id && $comment->submit == '0'))
                                        <button type="button" class="btn btn-box-tool pull-right" data-toggle="modal" data-target="#submit{{$comment->id}}"><i class="fa fa-check"></i>
                                        <button type="button" class="btn btn-box-tool pull-right" data-toggle="modal" data-target="#deldoc{{$comment->id}}"><i class="fa fa-times"></i>
                                        <button type="button" class="btn btn-box-tool pull-right" data-toggle="modal" data-target="#edit{{$comment->id}}"><i class="fa fa-pencil"></i>
                                    @endif

                                    <!-- /.direct-chat-text -->
                                </div>
                                <!-- /.direct-chat-msg -->

                                    <!-- Modal Edit-->
                                    <div class="modal fade" id="edit{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">កែប្រែយោបល់</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::model($comment,['method'=>'PATCH','route'=>['admin.comments.update',$comment->id],'files'=>true]) !!}
                                                <div class="modal-body">
                                                    <input hidden name="user_id" value="{{$comment->user_id}}" >
                                                    <input hidden name="document_id" value="{{$document->id}}" >

                                                    <div class="form-group">
                                                        <textarea name="comment" class="form-control" id="mt{{$comment->id}}" required> {{$comment->comment}} </textarea>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">រក្សាទុក </button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal Delete-->
                                    <div class="modal fade" id="deldoc{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Comment</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure delete this Document?
                                                    You won't be able to revert this!
                                                </div>
                                                <div class="modal-footer">

                                                    {!! Form::open(['method'=>'DELETE','route'=>['admin.comments.destroy',$comment->id]]) !!}
                                                    @csrf
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <input hidden name="doc" value="{{$document->id}}" >
                                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal Submit-->
                                    <div class="modal fade" id="submit{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">បញ្ចប់ការបញ្ចេញយោបល់</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure Submit this comment? &nbsp;
                                                    You won't be able to edit or delete this comment!
                                                </div>
                                                <div class="modal-footer">

                                                    {!! Form::model($comment,['method'=>'PATCH','route'=>['admin.comments.submit',$comment->id],'files'=>true,'class'=>'form-horizontal']) !!}
                                                    @csrf
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                            @endforeach

                    <div class="box-footer">
                        @if($user_login->role->id == '1' || $comments->where('user_id',$user_login->id)->count() < 1)
                            {!! Form::open(['method' => 'POST', 'route' => ['admin.comments.store'], 'files' => true,]) !!}
                            <div class="input-group">

                                <div>
                                    <textarea class="textarea" name="comment" placeholder="យោបល់" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>


                                {!! Form::hidden('document_id', $document->id, ['class' => 'form-control']) !!}
                                {!! Form::hidden('user_id', '0', ['class' => 'form-control']) !!}
{{--                                {!! Form::text('comment', old('comment'), ['class' => 'form-control', 'placeholder' => 'Type Message ...','required' => '']) !!}--}}
                                <span class="input-group-btn">
                                    {!! Form::submit('Send', ['class' => 'btn btn-success btn-flat']) !!}
                                </span>
                            </div>
                            {!! Form::close() !!}
                        @endif
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!--/.direct-chat -->
            </div>
            <!-- /.col -->
        </div>


            <p>&nbsp;</p>

            <a href="{{ route('admin.documents.index_user') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>

            @if($user_login->role->id <> 3)
                <a href="{{url('admin/documents/print/'.$document->id)}}"  target="_blank">
                    <button class="btn btn-info mt-3 pull-right"  id="btnprint"><i class="fa fa-print"></i> Print</button>
                </a>
            @endif
        </div>
    </div>
@stop


