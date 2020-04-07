<?php

namespace App\Http\Controllers\Api\V1;

use App\Title;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTitlesRequest;
use App\Http\Requests\Admin\UpdateTitlesRequest;
use Yajra\DataTables\DataTables;

class TitlesController extends Controller
{
    public function index()
    {
        return Title::all();
    }

    public function show($id)
    {
        return Title::findOrFail($id);
    }

    public function update(UpdateTitlesRequest $request, $id)
    {
        $title = Title::findOrFail($id);
        $title->update($request->all());
        

        return $title;
    }

    public function store(StoreTitlesRequest $request)
    {
        $title = Title::create($request->all());
        

        return $title;
    }

    public function destroy($id)
    {
        $title = Title::findOrFail($id);
        $title->delete();
        return '';
    }
}
