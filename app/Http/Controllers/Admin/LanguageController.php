<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Language;
use App\Photo;
use App\ClientFiles;
use App\TranslatorFiles;

class LanguageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $languages = Language::orderBy('id', 'desc')->paginate(10);

        return view('private.admin.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('private.admin.languages.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'name' => ['required','min:2','max:100','not_regex:/([%\$#\*<>]+)/'],
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $this->validate($request,$rules);

        $language = Language::create($request->all());

        if($language)
        {
            if($file = $request->file('image')) {

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.'.$fileextension;

                if($file->move('images', $file_to_store)) {
                    Photo::create([
                        'filename' => $file_to_store,
                        'photoable_id' => $language->id,
                        'photoable_type' => 'App\Language',
                    ]);
                }
            }
            return redirect('/admin/languages')->withStatus('language successfully created.');
        }
        else
        {
            return redirect('/admin/languages')->withStatus('something wrong happened , try again');
        }
    }

    public function show(Language $language)
    {

        $clientfiles = ClientFiles::where('source_language',$language->id)->orderBy('id', 'desc')->paginate(10);

        $translatorfiles = TranslatorFiles::where('source_language',$language->id)->get();

        $languagewords = 0;

        foreach($translatorfiles as $translatorfile)
        {
            $languagewords += $translatorfile->words;
        }

        return view('private.admin.languages.showlanguage', compact('language','clientfiles','translatorfiles','languagewords'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //

        return view('private.admin.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Language $language)
    {
        //

        $rules = [
            'name' => ['required','min:2','max:100','not_regex:/([%\$#\*<>]+)/'],
            'price' => 'required|numeric',
        ];

        $this->validate($request, $rules);

        $language->update($request->all());

        if($file = $request->file('image')) {

            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];

            $this->validate($request,$rules);

            $filename = $file->getClientOriginalName();
            $fileextension = $file->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.'.$fileextension;

            if($file->move('images', $file_to_store)) {
                if($language->photo) {
                    $photo = $language->photo;

                    // remove the old image

                    $filename = $photo->filename;
                    unlink('images/'.$filename);

                    $photo->filename = $file_to_store;
                    $photo->save();
                }else {
                    Photo::create([
                        'filename' => $file_to_store,
                        'photoable_id' => $course->id,
                        'photoable_type' => 'App\Language',
                    ]);
                }
            }
        }
        return redirect('/admin/languages')->withStatus('language successfully updated.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        //
        if($language->photo) {
            $filename = $language->photo->filename;
            unlink('images/'.$filename);
            $language->photo->delete();
        }

        $language->delete();
        return redirect('/admin/languages')->withStatus('language successfully deleted.');
    }
}
