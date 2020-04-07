<?php

namespace App\Http\Controllers\Api\V1;

use App\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDocumentsRequest;
use App\Http\Requests\Admin\UpdateDocumentsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class DocumentsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Document::all();
    }

    public function show($id)
    {
        return Document::findOrFail($id);
    }

    public function update(UpdateDocumentsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $document = Document::findOrFail($id);
        $document->update($request->all());
        

        return $document;
    }

    public function store(StoreDocumentsRequest $request)
    {
        $request = $this->saveFiles($request);
        $document = Document::create($request->all());
        

        return $document;
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return '';
    }
}
