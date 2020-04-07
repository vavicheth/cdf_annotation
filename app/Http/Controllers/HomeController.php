<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (! Gate::allows('document_access')) {
            return abort(401);
        }
        $user=Auth::user();
        $documents=$user->document;

        return redirect('admin/documents_user');
    }
}
