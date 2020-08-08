<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ClientFiles;
use App\TranslatorFiles;

class ClientController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myfiles()
    {
        $user = auth()->user();

        $translatorfiles = TranslatorFiles::where('user_id',$user->id)->orderBy('id', 'desc')->paginate(10);

        return view('private.client.myfiles',compact('translatorfiles'));
    }

    public function download($id)
    {
        $translatorfile = TranslatorFiles::where('id',$id)->first();
        return response()->download('translator_file_uploads/'.$translatorfile->filename);

    }
}
