<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Translator;
use App\User;
use App\TranslatorFiles;
use App\ClientFiles;
use App\Language;

class AdminController extends Controller
{
    //

    public function __construct() {
        $this->middleware('admin');
        $this->middleware('auth');
    }

    public function index()
    {

        $translators = Translator::orderBy('id', 'desc')->paginate(10);

        return view('private.admin.dashboard', compact('translators'));
    }

    public function approve(Request $request , Translator $translator)
    {
        $translator->update(['approved' => $request->approve]);

        return redirect('/admin');
    }


    public function showtranslator(Translator $translator)
    {
        return view('private.admin.showtranslator', compact('translator'));
    }


}
