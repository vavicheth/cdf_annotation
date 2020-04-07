<?php

namespace App\Http\Controllers\Api\V1;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepartmentsRequest;
use App\Http\Requests\Admin\UpdateDepartmentsRequest;
use Yajra\DataTables\DataTables;

class DepartmentsController extends Controller
{
    public function index()
    {
        return Department::all();
    }

    public function show($id)
    {
        return Department::findOrFail($id);
    }

    public function update(UpdateDepartmentsRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->all());
        

        return $department;
    }

    public function store(StoreDepartmentsRequest $request)
    {
        $department = Department::create($request->all());
        

        return $department;
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return '';
    }
}
