<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;

use App\ClientFiles;
use App\TranslatorFiles;

class UploadController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('approved');
        $this->middleware('auth:translator');
    }


    public function uploadGet(ClientFiles $clientfile)
    {

        return view('private.translator.upload',compact('clientfile'));

    }


    public function upload(UploadRequest $request,ClientFiles $clientfile)
    {


        $user = auth()->user();

        $user_id = $clientfile->user_id;

        $source_language = $clientfile->source_language;

        $target_language = $clientfile->target_language;

        $translator_id = $user->id;


        if($request->validated())
        {
            $text = $request->input('text');


            $words = $request->input('words');


            $file_to_store = time() . "_" . $user->first_name. "_" . ".pdf";


            $translatorfile = TranslatorFiles::create([
                'filename' => $file_to_store ,
                'user_id' => $user_id ,
                'source_language' => $source_language ,
                'target_language' => $target_language ,
                'translator_id' => $translator_id ,
                'words' => $words
            ]);



            if($translatorfile)
            {
                unlink('client_file_uploads/'.$clientfile->filename);
                $clientfile->delete();

                $config = [
                    'mode' => '+aCJK',
                    // "allowCJKoverflow" => true,
                    "autoScriptToLang" => true,
                    // "allow_charset_conversion" => false,
                    "autoLangToFont" => true,
                ];
                $mpdf=new \Mpdf\Mpdf($config);
                $mpdf->WriteHTML($text);
                $mpdf->Output('translator_file_uploads/'.$file_to_store,'F');
                return redirect('/translator/clientfiles')->withStatus('file successfully uploaded.');
            }
            else
            {
                return redirect('/translator/clientfiles')->withStatus('something wrong happened,try again');
            }
        }


    }

    public function uploadedit(TranslatorFiles $translatorfile)
    {

        return view('private.translator.uploadedit',compact('translatorfile'));

    }

    public function uploadupdate(UploadRequest $request,TranslatorFiles $translatorfile)
    {

        $user = auth()->user();

        $user_id = $translatorfile->user_id;

        $source_language = $translatorfile->source_language;

        $target_language = $translatorfile->target_language;

        $translator_id = $user->id;



        if($request->validated())
        {
            $text = $request->input('text');


            $words = $request->input('words');


            $file_to_store = time() . "_" . $user->first_name. "_" . ".pdf";


            $newtranslatorfile = TranslatorFiles::create(['filename' => $file_to_store , 'user_id' => $user_id , 'source_language' => $source_language,'target_language' => $target_language, 'translator_id' => $translator_id ,'words' => $words]);


            $translatorfile->delete();

            $config = [
                'mode' => '+aCJK',
                // "allowCJKoverflow" => true,
                "autoScriptToLang" => true,
                // "allow_charset_conversion" => false,
                "autoLangToFont" => true,
            ];
            $mpdf=new \Mpdf\Mpdf($config);
            $mpdf->WriteHTML($text);
            $mpdf->Output('translator_file_uploads/'.$file_to_store,'F');


            if($newtranslatorfile)
            {
                unlink('translator_file_uploads/'.$translatorfile->filename);
                $translatorfile->delete();

                $config = [
                    'mode' => '+aCJK',
                    // "allowCJKoverflow" => true,
                    "autoScriptToLang" => true,
                    // "allow_charset_conversion" => false,
                    "autoLangToFont" => true,
                ];
                $mpdf=new \Mpdf\Mpdf($config);
                $mpdf->WriteHTML($text);
                $mpdf->Output('translator_file_uploads/'.$file_to_store,'F');
                return redirect('/translator/translatorfiles')->withStatus('file successfully updated.');
            }
            else
            {
                return redirect('/translator/translatorfiles')->withStatus('something wrong happened,try again');
            }
        }

    }

}
