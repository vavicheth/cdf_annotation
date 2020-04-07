<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class UsersController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user_access')) {
            return abort(401);
        }


                $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        
        $titles = \App\Title::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $positions = \App\Position::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments = \App\Department::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.users.create', compact('titles', 'positions', 'departments', 'roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $user = User::create($request->all());



        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        
        $titles = \App\Title::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $positions = \App\Position::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments = \App\Department::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user', 'titles', 'positions', 'departments', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $user = User::findOrFail($id);
        $user->update($request->all());



        return redirect()->route('admin.users.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }
        
        $titles = \App\Title::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $positions = \App\Position::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments = \App\Department::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$user_actions = \App\UserAction::where('user_id', $id)->get();$comments = \App\Comment::where('user_id', $id)->get();$departments = \App\Department::where('user_created_id', $id)->get();$departments = \App\Department::where('user_updated_id', $id)->get();$comments = \App\Comment::where('user_created_id', $id)->get();$documents = \App\Document::where('user_created_id', $id)->get();$comments = \App\Comment::where('user_updated_id', $id)->get();$documents = \App\Document::where('user_updated_id', $id)->get();

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user', 'user_actions', 'comments', 'departments', 'departments', 'comments', 'documents', 'comments', 'documents'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
