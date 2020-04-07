<?php

namespace App\Http\Controllers\Api\V1;

use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePositionsRequest;
use App\Http\Requests\Admin\UpdatePositionsRequest;
use Yajra\DataTables\DataTables;

class PositionsController extends Controller
{
    public function index()
    {
        return Position::all();
    }

    public function show($id)
    {
        return Position::findOrFail($id);
    }

    public function update(UpdatePositionsRequest $request, $id)
    {
        $position = Position::findOrFail($id);
        $position->update($request->all());
        

        return $position;
    }

    public function store(StorePositionsRequest $request)
    {
        $position = Position::create($request->all());
        

        return $position;
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
        return '';
    }
}
