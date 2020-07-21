<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZipArchive;
use App\User;
use App\Language;
use App\ClientFiles;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;

/*
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
}*/


class DocCounter {

    // Class Variables
    private $file;
    private $filetype;

    // Set file
    public function setFile($filename)
    {
        $this->file = $filename;
        $this->filetype = pathinfo($this->file, PATHINFO_EXTENSION);
    }

    // Get file
    public function getFile()
    {
        return $this->file;
    }

    // Get file information object
    public function getInfo()
    {
        // Function variables
        $ft = $this->filetype;

        // Let's construct our info response object
        $obj = new \stdClass();
        $obj->format = $ft;
        $obj->wordCount = null;

        // Let's set our function calls based on filetype
        switch($ft)
        {
            case "doc":
                $doc = $this->read_doc_file();
                $obj->wordCount = $this->str_word_count_utf8($doc);
                break;
            case "docx":
                $obj->wordCount = $this->str_word_count_utf8($this->docx2text());
                break;
            case "pdf":
                $obj->wordCount = $this->str_word_count_utf8($this->pdf2text());
                break;
            case "txt":
                $textContents = file_get_contents($this->file);
                $obj->wordCount = $this->str_word_count_utf8($textContents);
                break;
            default:
                $obj->wordCount = "unsupported file format";
        }

        return $obj;
    }

    // Convert: Word.doc to Text String
    function read_doc_file() {

        $path = getcwd();
        $f = $path."/".$this->file;
         if(file_exists($f))
        {
            if(($fh = fopen($f, 'r')) !== false )
            {
               $headers = fread($fh, 0xA00);

               // 1 = (ord(n)*1) ; Document has from 0 to 255 characters
               $n1 = ( ord($headers[0x21C]) - 1 );

               // 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
               $n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 );

               // 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
               $n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 );

               // 1 = (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
               $n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 );

               // Total length of text in the document
               $textLength = ($n1 + $n2 + $n3 + $n4);

               $extracted_plaintext = fread($fh, $textLength);
                $extracted_plaintext = mb_convert_encoding($extracted_plaintext,'UTF-8');
               // simple print character stream without new lines
               //echo $extracted_plaintext;

               // if you want to see your paragraphs in a new line, do this
               return nl2br($extracted_plaintext);
               // need more spacing after each paragraph use another nl2br
            }
        }
    }
    // Jonny 5's simple word splitter
    function str_word_count_utf8($str) {
        return count(preg_split('~[^\p{L}\p{N}\']+~u',$str));
    }
    // Convert: Word.docx to Text String
    function docx2text()
    {
        return $this->readZippedXML($this->file, "word/document.xml");
    }

    function readZippedXML($archiveFile, $dataFile)
    {
        // Create new ZIP archive
        $zip = new ZipArchive();

        // set absolute path
        $path = getcwd();
        $f = $path."/".$archiveFile;

        // Open received archive file
        if (true === $zip->open($f)) {
            // If done, search for the data file in the archive
            if (($index = $zip->locateName($dataFile)) !== false) {
                // If found, read it to the string
                $data = $zip->getFromIndex($index);
                // Close archive file
                $zip->close();
                // Load XML from a string
                // Skip errors and warnings
                $xml = new \DOMDocument();
                $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);

                $xmldata = $xml->saveXML();
                // Newline Replacement
                $xmldata = str_replace("</w:p>", "\r\n", $xmldata);
                // Return data without XML formatting tags
                return strip_tags($xmldata);
            }
            $zip->close();
        }

        // In case of failure return empty string
        return "";
    }

    // Convert: Word.doc to Text String
    function read_doc()
    {
        $path = getcwd();
        $f = $path."/".$this->file;
        $fileHandle = fopen($f, "r");
        $line = @fread($fileHandle, filesize($this->file));
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

    // Convert: Adobe.pdf to Text String
    function pdf2text()
    {
        //absolute path for file
        $path = getcwd();
        $f = 'file_uploads/'.$file_to_store;

        if (file_exists($f)) {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($f);
            $text = $pdf->getText();
            return $text;
        }

        return null;
    }



}


/*

class RD_Text_Extraction
{

    protected static function pdf_to_text( $path_to_file ) {

        if ( class_exists( '\\Smalot\\PdfParser\\Parser') ) {

            $parser   = new \Smalot\PdfParser\Parser();
            $pdf      = $parser->parseFile( $path_to_file );
            $response = $pdf->getText();

        } else {

            throw new \Exception('The library used to parse PDFs was not found.' );
        }

        return $response;

    }


    protected static function doc_to_text( $path_to_file )
    {
        $fileHandle = fopen($path_to_file, 'r');
        $line       = @fread($fileHandle, filesize($path_to_file));
        $lines      = explode(chr(0x0D), $line);
        $response   = '';

        foreach ($lines as $current_line) {

            $pos = strpos($current_line, chr(0x00));

            if ( ($pos !== FALSE) || (strlen($current_line) == 0) ) {

            } else {
                $response .= $current_line . ' ';
            }
        }

        $response = preg_replace('/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/', '', $response);

        return $response;
    }


    protected static function docx_to_text( $path_to_file )
    {
        $response = '';
        $zip      = zip_open($path_to_file);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE)
                continue;

            if (zip_entry_name($zip_entry) != 'word/document.xml')
                continue;

            $response .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }

        zip_close($zip);

        $response = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $response);
        $response = str_replace('</w:r></w:p>', "\r\n", $response);
        $response = strip_tags($response);

        return $response;
    }


    protected static function xlsx_to_text( $path_to_file )
    {
        $xml_filename = 'xl/sharedStrings.xml'; //content file name
        $zip_handle   = new ZipArchive();
        $response     = '';

        if (true === $zip_handle->open($path_to_file)) {

            if (($xml_index = $zip_handle->locateName($xml_filename)) !== false) {

                $doc = new DOMDocument();

                $xml_data   = $zip_handle->getFromIndex($xml_index);
                $doc->loadXML($xml_data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                $response   = strip_tags($doc->saveXML());

            }

            $zip_handle->close();

        }

        return $response;
    }


    protected static function pptx_to_text( $path_to_file )
    {
        $zip_handle = new ZipArchive();
        $response   = '';

        if (true === $zip_handle->open($path_to_file)) {

            $slide_number = 1; //loop through slide files
            $doc = new DOMDocument();

            while (($xml_index = $zip_handle->locateName('ppt/slides/slide' . $slide_number . '.xml')) !== false) {

                $xml_data   = $zip_handle->getFromIndex($xml_index);

                $doc->loadXML($xml_data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                $response  .= strip_tags($doc->saveXML());

                $slide_number++;

            }

            $zip_handle->close();

        }

        return $response;
    }


    public static function get_valid_file_types()
    {
        return [
            'doc',
            'docx',
            'pptx',
            'xlsx',
            'pdf'
        ];
    }


    public static function convert_to_text( $path_to_file )
    {
        if (isset($path_to_file) && file_exists($path_to_file)) {

            $valid_extensions = self::get_valid_file_types();

            $file_info = pathinfo($path_to_file);
            $file_ext  = strtolower($file_info['extension']);

            if (in_array( $file_ext, $valid_extensions )) {

                $method   = $file_ext . '_to_text';
                $response = self::$method( $path_to_file );

            } else {

                throw new \Exception('Invalid file type provided. Valid file types are doc, docx, xlsx or pptx.');

            }

        } else {

            throw new \Exception('Invalid file provided. The file does not exist.');

        }

        return $response;
    }

}*/




class UploadController extends Controller
{
    //


    private $apiContext;
    private $clientId;
    private $secret;

    public function __construct()
    {
        if(config('paypal.settings.mode') == 'live')
        {
            $this->clientId = config('paypal.live_client_id');
            $this->secret = config('paypal.live_secret');
        }

        else
        {
            $this->clientId = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');
        }

        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->clientId,$this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }


    public function index()
    {
        return view('private.client.upload');
    }


    public function payment(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'text' => 'required|string',
            'source_language' => 'required|string',
            'language_id' => 'required|integer',
        ];


        if($this->validate($request,$rules))
        {

            $text = $request->input('text');
            $user_id = $user->id;
            $sourcelanguage = $request->input('source_language');
            $targetlanguage = $request->input('language_id');
            $words = $request->input('words');

            $file_to_store = time() . "_" . $user->first_name. "_" . ".pdf";


/*
                if($filename->getClientOriginalExtension() == 'pdf')
                {

                    $parser = new \Smalot\PdfParser\Parser();
                    $pdf = $parser->parseFile('file_uploads/'.$file_to_store);

                    $text = $pdf->getText();

                    $words = count(preg_split('~[^\p{L}\p{N}\']+~u',$text));


                }/*
                elseif($filename->getClientOriginalExtension() == 'doc'|| $filename->getClientOriginalExtension() == 'docx')
                {
                    /*
                    $docObj = new Doc2Txt('file_uploads/'.$file_to_store);

                    $text = $docObj->convertToText();

                    $doc = new DocCounter();
                    $doc->setFile('file_uploads/'.$file_to_store);

                    $words = $doc->getInfo()->wordCount;

                }*/

            /*

                else
                {
                    $text = file_get_contents('file_uploads/'.$file_to_store);

                    $words = count(preg_split('~[^\p{L}\p{N}\']+~u',$text));
                }*/

            /*

        $uploadedText = '';


        $phpword = \PhpOffice\PhpWord\IOFactory::load('file_uploads/'.$file_to_store);

        $sections = $phpword->getSections();

        foreach ($sections as $section) {
            $elements = $section->getElements();
            foreach ($elements as $element) {
                if (get_class($element) === 'PhpOffice\PhpWord\Element\Text') {
                    $uploadedText .= $element->getText();
                    $uploadedText .= ' ';
                } else if (get_class($element) === 'PhpOffice\PhpWord\Element\TextRun') {
                    $textRunElements = $element->getElements();
                    foreach ($textRunElements as $textRunElement) {
                        $uploadedText .= $textRunElement->getText();
                        $uploadedText .= ' ';
                    }
                } else if (get_class($element) === 'PhpOffice\PhpWord\Element\TextBreak') {
                    $uploadedText .= ' ';
                } else {
                    throw new Exception('Unknown class type ' . get_class($e));
                }
            }
        }

        $uploadedText = str_replace('&nbsp;',"", $uploadedText);
        $uploadedText = str_replace('•',"",$uploadedText);
        $uploadedText = preg_split('/\s+/', $uploadedText);

        $words = count($uploadedText);

        $dest = 'file_uploads/'.$file_to_store;*/



            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($text);
            $mpdf->Output('file_uploads/'.$file_to_store,'F');


            $languageprice = Language::where('id',$targetlanguage)->first()->price;

            $price = $words * $languageprice;



             $request->session()->put([

                'filename' => $file_to_store,
                'user_id' => $user_id,
                'language_id' => $targetlanguage,
                'source_language' => $sourcelanguage,
                'words' => $words,
                'total_price' => $price


            ]);




            $payer = new Payer();

                $payer->setPaymentMethod("paypal");

                $file = new Item();

                $file->setName($file_to_store)->setCurrency('USD')->setQuantity(1)->setPrice($price);


                $itemlist = new ItemList();

                $itemlist->setItems([$file]);



                $amount = new Amount();

                $amount->setCurrency('USD')->setTotal($price);


                $transaction = new Transaction();

                $transaction->setAmount($amount)->setItemList($itemlist)->setDescription('payment description');


                $redirecturls = new RedirectUrls();

                $redirecturls->setReturnUrl('http://localhost/crosswords/public/paymentstatus')->setCancelUrl('http://localhost/crosswords/public/paymentcancel/'.$file_to_store);


                $payment = new Payment();
                $payment->setIntent("sale")
                    ->setPayer($payer)
                    ->setRedirectUrls($redirecturls)
                    ->setTransactions(array($transaction));


                $request = clone $payment;


            try {
                $payment->create($this->apiContext);
            } catch (\PayPal\Exception\PPConnectionException $ex) {

                die($ex);
            }


            $paymentLink = $payment->getApprovalLink();


            return redirect($paymentLink);
        }

        else
        {
            return redirect('uploadfile')->withStatus('check the type of file uploaded.');
        }
    }


    public function status(Request $request)
    {

        if(empty($request->input('PayerID'))||empty($request->input('token')))
        {
            die('payment failed');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId,$this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution,$this->apiContext);

        $data = $request->session()->all();

        if($result->getState() == 'approved')
        {

            ClientFiles::create(['filename' => $data['filename'] , 'user_id' => $data['user_id'] , 'language_id' => $data['language_id'] , 'source_language' => $data['source_language'] ,'words' => $data['words'] , 'total_price' => $data['total_price'] ]);
            return redirect('uploadfile')->withStatus('thank you payment completed');
        }

        unlink('file_uploads/'.$data['filename']);

        echo 'payment failed';
        die($result);
    }

    public function cancel($filetostore)
    {
        unlink('file_uploads/'.$filetostore);
        return redirect('uploadfile')->withStatus('your payment process was cancelled');
    }


}
