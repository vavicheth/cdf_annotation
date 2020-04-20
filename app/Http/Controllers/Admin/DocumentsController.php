<?php

namespace App\Http\Controllers\Admin;

use App\Document;
use App\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDocumentsRequest;
use App\Http\Requests\Admin\UpdateDocumentsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use Yajra\DataTables\DataTables;

class DocumentsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Document.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('document_access')) {
            return abort(401);
        }

        $documents = Document::orderBy('created_at', 'DESC');

        if (request('show_deleted') == 1) {
            if (!Gate::allows('document_delete')) {
                return abort(401);
            }
            $documents = $documents->onlyTrashed()->get();
        } elseif (request('show_all') == 1) {
            $documents = $documents->get();
        } elseif (request('show_done') == 1) {
            $documents = $documents->whereSubmit(1)->get();
        } else {
            $documents = $documents->where('submit', '<>', 1)->get();
        }

        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating new Document.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('document_create')) {
            return abort(401);
        }

        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $users = User::orderBy('name', 'asc')->pluck('name', 'id')->all();

        return view('admin.documents.create', compact('users', 'user_createds', 'user_updateds'));
    }

    /**
     * Store a newly created Document in storage.
     *
     * @param \App\Http\Requests\StoreDocumentsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentsRequest $request)
    {
        if (!Gate::allows('document_create')) {
            return abort(401);
        }

        $request->request->add(['user_created_id' => Auth::user()->id]);

        $request = $this->saveFiles($request);
        $document = Document::create($request->all());


        foreach ($request->input('file_id', []) as $index => $id) {
            $model = config('medialibrary.media_model');
            $file = $model::find($id);
            $file->model_id = $document->id;
            $file->save();
        }

        $document->user()->attach($request->users);

        return redirect()->route('admin.documents.index');
    }


    /**
     * Show the form for editing Document.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('document_edit')) {
            return abort(401);
        }

        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $document = Document::findOrFail($id);
        $users = User::orderBy('name', 'asc')->get();

        return view('admin.documents.edit', compact('document', 'users', 'user_createds', 'user_updateds'));
    }

    /**
     * Update Document in storage.
     *
     * @param \App\Http\Requests\UpdateDocumentsRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentsRequest $request, $id)
    {
        if (!Gate::allows('document_edit')) {
            return abort(401);
        }

        $request->request->add(['user_updated_id' => Auth::user()->id]);
        $request = $this->saveFiles($request);
        $document = Document::findOrFail($id);
        $document->update($request->all());

        // Submit document and submit all comments in document for can not edit
        if ($request->get('submit') == 1) {
            $document->comments()->update(['submit' => '1']);
        }

        $media = [];
        foreach ($request->input('file_id', []) as $index => $id) {
            $model = config('medialibrary.media_model');
            $file = $model::find($id);
            $file->model_id = $document->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $document->updateMedia($media, 'file');
        $document->user()->sync($request->users);


        return redirect()->route('admin.documents.index');
    }


    /**
     * Display Document.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('document_view')) {
            return abort(401);
        }

        $comments = \App\Comment::where('document_id', $id)->get();
        $document = Document::findOrFail($id);
        $user_login = Auth::user();

        return view('admin.documents.show', compact('document', 'comments', 'user_login'));
    }


    /**
     * Remove Document from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('document_delete')) {
            return abort(401);
        }
        $document = Document::findOrFail($id);
        $document->deletePreservingMedia();

        return redirect()->route('admin.documents.index');
    }

    /**
     * Delete all selected Document at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('document_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Document::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore Document from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('document_delete')) {
            return abort(401);
        }
        $document = Document::onlyTrashed()->findOrFail($id);
        $document->restore();

        return redirect()->route('admin.documents.index');
    }

    /**
     * Permanently delete Document from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('document_delete')) {
            return abort(401);
        }
        $document = Document::onlyTrashed()->findOrFail($id);
        $document->forceDelete();

        return redirect()->route('admin.documents.index');
    }

    public function index_user()
    {
        if (!Gate::allows('document_access')) {
            return abort(401);
        }
        $user = Auth::user();
        $documents = $user->document()->orderBy('created_at', 'DESC');

        if (request('show_deleted') == 1) {
            if (!Gate::allows('document_delete')) {
                return abort(401);
            }
            $documents = $documents->onlyTrashed()->get();
        } elseif (request('show_all') == 1) {
            $documents = $documents->get();
        } elseif (request('show_done') == 1) {
            $documents = $documents->whereSubmit(1)->get();
        } else {
            $documents = $documents->where('submit', '<>', 1)->get();
        }

        return view('admin.documents.index_user', compact('documents'));
    }


    public function print($id)
    {
//        $documents=Document::findOrFail($id);
//        $users=User::orderBy('name','asc')->pluck('name','id')->all();
//        $docphotos=DocPhoto::where('documents_id', '=', $id)->get();
//        $comments=Comment::where('documents_id', '=', $documents->id)->get();
//
//        return view('admin.documents.print',compact('documents','users','docphotos','comments'));

        if (!Gate::allows('document_view')) {
            return abort(401);
        }

        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $comments = \App\Comment::where('document_id', $id)->get();

        $document = Document::findOrFail($id);
        $user_login = Auth::user();

        return view('admin.documents.print', compact('document', 'comments', 'user_login'));
    }

    public function view_pdf($document_id, $media_id)
    {
        if (!Gate::allows('edit_pdf')) {
            return abort(401);
        }
        $document = Document::findOrFail($document_id);
        $media = Media::findOrFail($media_id);
        $file_name = asset('storage') . '/' . $media->id . '/' . $media->file_name;

        return view('admin.documents.view_pdf', compact('document', 'media', 'file_name'));
    }

    public function save_pdf(Request $request)
    {
        if (!Gate::allows('edit_pdf')) {
            return abort(401);
        }

//        return response($request->all());

        if ($request->has('pdf')) {
            $base64img = str_replace('data:application/pdf;base64,', '', $request['pdf']);
            $data = base64_decode($base64img);
//
//            Storage::put($request->media_id.'/'.$request->media_file, $data);


            Storage::disk("public")->put($request->media_id.'/'.$request->media_file, $data);


//            $base64_image = $request->input('pdf'); // your base64 encoded
//            @list($type, $file_data) = explode(';', $base64_image);
//            @list(, $file_data) = explode(',', $file_data);
//            $imageName=$request->media_id.'/'.$request->media_file;
//            Storage::disk('public')->put($imageName, base64_decode($file_data));


//            $file = $request->media_id.'/'.$request->media_file;
//            file_put_contents($file, $data);

//            Storage::put($request->media_id.'/'.$request->media_file, (string) file_get_contents($data), 'public');

            //Show approved when DG comment
            if (auth()->id() == 28) {
                $document = Document::findOrFail($request->document_id);
                $document->update(['submit' => '2']);
            }

            return response('Successful binary save to file!');
        }


        /**
         * For Blob object
         */

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');
            Storage::put($request->media_id . '/' . $request->media_file, (string)file_get_contents($file), 'public');

            //Show approved when DG comment
            if (auth()->id() == 28) {
                $document = Document::findOrFail($request->document_id);
                $document->update(['submit' => '2']);
            }

            return response('Successful blog save to file!');
        }




        return response('File can not edit!');
    }


}
