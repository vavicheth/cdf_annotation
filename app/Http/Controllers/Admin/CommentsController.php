<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCommentsRequest;
use App\Http\Requests\Admin\UpdateCommentsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class CommentsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Comment.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('comment_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('comment_delete')) {
                return abort(401);
            }
            $comments = Comment::onlyTrashed()->get();
        } else {
            $comments = Comment::all();
        }

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating new Comment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('comment_create')) {
            return abort(401);
        }

        $documents = \App\Document::get()->pluck('letter_code', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.comments.create', compact('documents', 'users', 'user_createds', 'user_updateds'));
    }

    /**
     * Store a newly created Comment in storage.
     *
     * @param  \App\Http\Requests\StoreCommentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentsRequest $request)
    {
        if (! Gate::allows('comment_create')) {
            return abort(401);
        }

        //Show approved when DG comment
        if (auth()->id() == 28)
        {
            $document=Document::findOrFail($request->document_id);
            $document->update(['submit' => '2']);
        }


        $request->request->add(['user_created_id' => Auth::user()->id]);
        $request->request->add(['user_id' => Auth::user()->id]);
        $request = $this->saveFiles($request);
        $comment = Comment::create($request->all());




        foreach ($request->input('comment_file_id', []) as $index => $id) {
            $model          = config('medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $comment->id;
            $file->save();
        }


        return redirect()->back();
    }


    /**
     * Show the form for editing Comment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('comment_edit')) {
            return abort(401);
        }

        $documents = \App\Document::get()->pluck('letter_code', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $comment = Comment::findOrFail($id);

        return view('admin.comments.edit', compact('comment', 'documents', 'users', 'user_createds', 'user_updateds'));
    }

    /**
     * Update Comment in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentsRequest $request, $id)
    {
        if (! Gate::allows('comment_edit')) {
            return abort(401);
        }
        $request->request->add(['user_updated_id' => Auth::user()->id]);
        $request = $this->saveFiles($request);
        $comment = Comment::findOrFail($id);
        $comment->update($request->all());


        $media = [];
        foreach ($request->input('comment_file_id', []) as $index => $id) {
            $model          = config('medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $comment->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $comment->updateMedia($media, 'comment_file');


        return redirect()->back();
    }


    /**
     * Display Comment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('comment_view')) {
            return abort(401);
        }
        $comment = Comment::findOrFail($id);

        return view('admin.comments.show', compact('comment'));
    }


    /**
     * Remove Comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('comment_delete')) {
            return abort(401);
        }
        $comment = Comment::findOrFail($id);
        $comment->deletePreservingMedia();

        return redirect()->back();
    }

    /**
     * Delete all selected Comment at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('comment_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Comment::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore Comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('comment_delete')) {
            return abort(401);
        }
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return redirect()->route('admin.comments.index');
    }

    /**
     * Permanently delete Comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('comment_delete')) {
            return abort(401);
        }
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->forceDelete();

        return redirect()->route('admin.comments.index');
    }


    public function updateStatus(Request $request, $id)
    {
        $request->request->add(['submit' => '1']);
        $comment=Comment::findOrFail($id);
        $comment->update($request->all());

        return redirect()->back();
    }

}
