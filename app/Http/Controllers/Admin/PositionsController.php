<?php

namespace App\Http\Controllers\Admin;

use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePositionsRequest;
use App\Http\Requests\Admin\UpdatePositionsRequest;
use Yajra\DataTables\DataTables;

class PositionsController extends Controller
{
    /**
     * Display a listing of Position.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('position_access')) {
            return abort(401);
        }


        
        if (request()->ajax()) {
            $query = Position::query();
            $template = 'actionsTemplate';
            if(request('show_deleted') == 1) {
                
        if (! Gate::allows('position_delete')) {
            return abort(401);
        }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'positions.id',
                'positions.name',
                'positions.name_kh',
                'positions.description',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey  = 'position_';
                $routeKey = 'admin.positions';

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

            $table->rawColumns(['actions','massDelete']);

            return $table->make(true);
        }

        return view('admin.positions.index');
    }

    /**
     * Show the form for creating new Position.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('position_create')) {
            return abort(401);
        }
        return view('admin.positions.create');
    }

    /**
     * Store a newly created Position in storage.
     *
     * @param  \App\Http\Requests\StorePositionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePositionsRequest $request)
    {
        if (! Gate::allows('position_create')) {
            return abort(401);
        }
        $position = Position::create($request->all());



        return redirect()->route('admin.positions.index');
    }


    /**
     * Show the form for editing Position.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('position_edit')) {
            return abort(401);
        }
        $position = Position::findOrFail($id);

        return view('admin.positions.edit', compact('position'));
    }

    /**
     * Update Position in storage.
     *
     * @param  \App\Http\Requests\UpdatePositionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePositionsRequest $request, $id)
    {
        if (! Gate::allows('position_edit')) {
            return abort(401);
        }
        $position = Position::findOrFail($id);
        $position->update($request->all());



        return redirect()->route('admin.positions.index');
    }


    /**
     * Display Position.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('position_view')) {
            return abort(401);
        }
        $users = \App\User::where('position_id', $id)->get();

        $position = Position::findOrFail($id);

        return view('admin.positions.show', compact('position', 'users'));
    }


    /**
     * Remove Position from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('position_delete')) {
            return abort(401);
        }
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect()->route('admin.positions.index');
    }

    /**
     * Delete all selected Position at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('position_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Position::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Position from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('position_delete')) {
            return abort(401);
        }
        $position = Position::onlyTrashed()->findOrFail($id);
        $position->restore();

        return redirect()->route('admin.positions.index');
    }

    /**
     * Permanently delete Position from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('position_delete')) {
            return abort(401);
        }
        $position = Position::onlyTrashed()->findOrFail($id);
        $position->forceDelete();

        return redirect()->route('admin.positions.index');
    }
}
