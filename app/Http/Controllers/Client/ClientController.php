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

        $clientfiles = ClientFiles::where('user_id',$user->id)->orderBy('id', 'desc')->paginate(10);
        $translatorfiles = TranslatorFiles::where('user_id',$user->id)->orderBy('id', 'desc')->paginate(10);

        return view('private.client.myfiles',compact('clientfiles','translatorfiles'));
    }

    public function download(TranslatorFiles $clientfile)
    {   

        return response()->download('file_uploads/'.$clientfile->filename);

    }
}
