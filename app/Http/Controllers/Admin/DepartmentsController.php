<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepartmentsRequest;
use App\Http\Requests\Admin\UpdateDepartmentsRequest;
use Yajra\DataTables\DataTables;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of Department.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('department_access')) {
            return abort(401);
        }


        
        if (request()->ajax()) {
            $query = Department::query();
            $query->with("user_created");
            $query->with("user_updated");
            $template = 'actionsTemplate';
            if(request('show_deleted') == 1) {
                
        if (! Gate::allows('department_delete')) {
            return abort(401);
        }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'departments.id',
                'departments.name',
                'departments.name_kh',
                'departments.description',
                'departments.user_created_id',
                'departments.user_updated_id',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey  = 'department_';
                $routeKey = 'admin.departments';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('name_kh', function ($row) {
                return $row->name_kh ? $row->name_kh : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('user_created.name', function ($row) {
                return $row->user_created ? $row->user_created->name : '';
            });
            $table->editColumn('user_updated.name', function ($row) {
                return $row->user_updated ? $row->user_updated->name : '';
            });

            $table->rawColumns(['actions','massDelete']);

            return $table->make(true);
        }

        return view('admin.departments.index');
    }

    /**
     * Show the form for creating new Department.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('department_create')) {
            return abort(401);
        }
        
        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.departments.create', compact('user_createds', 'user_updateds'));
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param  \App\Http\Requests\StoreDepartmentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentsRequest $request)
    {
        if (! Gate::allows('department_create')) {
            return abort(401);
        }
        $department = Department::create($request->all());



        return redirect()->route('admin.departments.index');
    }


    /**
     * Show the form for editing Department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('department_edit')) {
            return abort(401);
        }
        
        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $department = Department::findOrFail($id);

        return view('admin.departments.edit', compact('department', 'user_createds', 'user_updateds'));
    }

    /**
     * Update Department in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentsRequest $request, $id)
    {
        if (! Gate::allows('department_edit')) {
            return abort(401);
        }
        $department = Department::findOrFail($id);
        $department->update($request->all());



        return redirect()->route('admin.departments.index');
    }


    /**
     * Display Department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('department_view')) {
            return abort(401);
        }
        
        $user_createds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $user_updateds = \App\User::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$users = \App\User::where('department_id', $id)->get();

        $department = Department::findOrFail($id);

        return view('admin.departments.show', compact('department', 'users'));
    }


    /**
     * Remove Department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('department_delete')) {
            return abort(401);
        }
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('admin.departments.index');
    }

    /**
     * Delete all selected Department at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('department_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Department::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('department_delete')) {
            return abort(401);
        }
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->restore();

        return redirect()->route('admin.departments.index');
    }

    /**
     * Permanently delete Department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('department_delete')) {
            return abort(401);
        }
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->forceDelete();

        return redirect()->route('admin.departments.index');
    }
}
