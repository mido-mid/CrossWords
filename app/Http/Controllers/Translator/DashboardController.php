<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ClientFiles;
use App\Translator;
use App\TranslatorFiles;
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

        $files = ClientFiles::where('translator_id',null)->where(function ($q) {
            $user = auth()->user();
            $q->where('target_language', $user->language_id)->orWhere('source_language', $user->language_id);
        })->orderBy('id', 'desc')->paginate(10);
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


        return redirect('/translator/clientfiles')->withStatus('well done ,'.$clientfile->filename.' file has been cleared from your tasks');
    }

    public function clientfiles()
    {
        $user = auth()->user();

        $clientfiles = ClientFiles::where('translator_id',$user->id)->orderBy('id', 'desc')->paginate(10);

        $translator = Translator::where('id',$user->id)->pluck('language_id');


        $language = Language::where('id',$translator[0])->first();


        return view('private.translator.myfiles',compact('clientfiles','language'));
    }

    public function translatorfiles()
    {
        $user = auth()->user();

        $translatorfiles = TranslatorFiles::where('translator_id',$user->id)->orderBy('id', 'desc')->paginate(10);

        $translator = Translator::where('id',$user->id)->pluck('language_id');


        $language = Language::where('id',$translator[0])->first();


        return view('private.translator.translatorfiles',compact('translatorfiles','language'));
    }

    public function downloadclient(ClientFiles $clientfile)
    {

        return response()->download('client_file_uploads/'.$clientfile->filename);

    }

    public function downloadtranslator($id)
    {
        $translatorfile = TranslatorFiles::where('id',$id)->first();
        return response()->download('translator_file_uploads/'.$translatorfile->filename);
    }
}
