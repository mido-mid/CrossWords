<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ClientFiles;
use App\Translator;
use App\Language;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:translator');
    }


    public function homepage()
    {
        return view('private.translator.home');
    }

    
    public function index()
    {

        $user = auth()->user();
        $files = ClientFiles::where('translator_id',null)->where('language_id',$user->language_id)->orderBy('id', 'desc')->paginate(10);
        return view('private.translator.dashboard',compact('files'));
    }

    public function assign(Request $request,ClientFiles $clientfile)
    {   

        $user = auth()->user();

        $clientfile->update(['translator_id' => $user->id]);


        return redirect('/translator')->withStatus('well done ,'.$clientfile->filename.' file has been assigned to you');
    }

    public function cancelassign(Request $request,ClientFiles $clientfile)
    {   

        $user = auth()->user();

        $clientfile->update(['translator_id' => null]);


        return redirect('/translator/myfiles')->withStatus('well done ,'.$clientfile->filename.' file has been cleared from your tasks');
    }

    public function myfiles()
    {
        $user = auth()->user();

        $translatorfiles = ClientFiles::where('translator_id',$user->id)->orderBy('id', 'desc')->paginate(10);

        $languagefile = ClientFiles::where('translator_id',$user->id)->pluck('language_id');


        $language = Language::where('id',$languagefile[0])->first();


        return view('private.translator.myfiles',compact('translatorfiles','language'));
    }

    public function download(ClientFiles $clientfile)
    {   

        return response()->download('file_uploads/'.$clientfile->filename);

    }
}
