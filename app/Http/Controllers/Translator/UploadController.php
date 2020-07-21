<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ClientFiles;
use App\TranslatorFiles;


class Doc2Txt
{
	private $filename;

	public function __construct($filePath) {
		$this->filename = $filePath;
	}

	private function read_doc()	{
		$fileHandle = fopen($this->filename, "r");
		$line = @fread($fileHandle, filesize($this->filename));
		$lines = explode(chr(0x0D),$line);
		$outtext = "";
		foreach($lines as $thisline)
		  {
			$pos = strpos($thisline, chr(0x00));
			if (($pos !== FALSE)||(strlen($thisline)==0))
			  {
			  } else {
				$outtext .= $thisline." ";
			  }
		  }
		 $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
		return $outtext;
	}

	private function read_docx(){

		$striped_content = '';
		$content = '';

		$zip = zip_open($this->filename);

		if (!$zip || is_numeric($zip)) return false;

		while ($zip_entry = zip_read($zip)) {

			if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

			if (zip_entry_name($zip_entry) != "word/document.xml") continue;

			$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

			zip_entry_close($zip_entry);
		}// end while

		zip_close($zip);

		$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
		$content = str_replace('</w:r></w:p>', "\r\n", $content);
		$striped_content = strip_tags($content);

		return $striped_content;
	}

	public function convertToText() {

		if(isset($this->filename) && !file_exists($this->filename)) {
			return "File Not exists";
		}

		$fileArray = pathinfo($this->filename);
		$file_ext  = $fileArray['extension'];
		if($file_ext == "doc" || $file_ext == "docx")
		{
			if($file_ext == "doc") {
				return $this->read_doc();
			} else {
				return $this->read_docx();
			}
		} else {
			return "Invalid File Type";
		}
	}
}


class UploadController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('approved');
        $this->middleware('auth:translator');
    }

    public function upload(Request $request,ClientFiles $clientfile)
    {


        $user = auth()->user();

        $user_id = $clientfile->user_id;

        $language_id = $clientfile->language_id;

        $translator_id = $user->id;


        $rules = [
            'filename' => 'required|file|max:10000|mimes:pdf,doc,docx,txt',
        ];


        if($this->validate($request,$rules))
        {
            $filename = $request->file('filename');


            $words = $request->input('words');


            $file_to_store = time() . "_" . $user->first_name. "_" . "." . $filename->getClientOriginalExtension();

            /*

            $filename->move('file_uploads', $file_to_store);


                if($filename->getClientOriginalExtension() == 'pdf')
                {

                    $parser = new \Smalot\PdfParser\Parser();
                    $pdf = $parser->parseFile('file_uploads/'.$file_to_store);

                    $text = $pdf->getText();


                }
                elseif($filename->getClientOriginalExtension() == 'doc'|| $filename->getClientOriginalExtension() == 'docx')
                {
                    $docObj = new Doc2Txt('file_uploads/'.$file_to_store);

                    $text = $docObj->convertToText();

                }

                else
                {
                    $text = file_get_contents('file_uploads/'.$file_to_store);
                }


				$words = str_word_count($text);*/


            $translatorfile = TranslatorFiles::create(['filename' => $file_to_store , 'user_id' => $user_id , 'language_id' => $language_id , 'translator_id' => $translator_id ,'words' => $words]);


            $clientfile->delete();


            if($translatorfile)
            {
                return redirect('/translator/myfiles')->withStatus('file successfully uploaded.');
            }
            else
            {
                return redirect('/translator/myfiles')->withStatus('something wrong happened,try again');
            }
        }




    }
}