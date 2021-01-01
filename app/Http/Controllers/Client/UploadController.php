<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
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


    public function payment(UploadRequest $request)
    {
        $user = auth()->user();

        if($request->validated())
        {

            $text = $request->input('text');
            $user_id = $user->id;
            $sourcelanguage = $request->input('source_language');
            $targetlanguage = $request->input('target_language');
            $words = $request->input('words');


            $file_to_store = time() . "_" . $user->first_name. "_" . ".pdf";

            $config = [
                'mode' => '+aCJK',
                // "allowCJKoverflow" => true,
                "autoScriptToLang" => true,
                // "allow_charset_conversion" => false,
                "autoLangToFont" => true,
            ];
            $mpdf=new \Mpdf\Mpdf($config);
            $mpdf->WriteHTML($text);
            $mpdf->Output('client_file_uploads/'.$file_to_store,'F');


            $languageprice = Language::where('id',$sourcelanguage)->first()->price;

            $price = $words * $languageprice;

             $request->session()->put([

                'filename' => $file_to_store,
                'user_id' => $user_id,
                'target_language' => $targetlanguage,
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
            return redirect('uploadfile')->withStatus('try again');
        }
    }


    public function status(Request $request)
    {

        if(empty($request->input('PayerID'))||empty($request->input('token')))
        {
            return redirect('uploadfile')->withStatus('payment failed');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId,$this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        $data = $request->session()->all();
        ClientFiles::create(['filename' => $data['filename'] , 'user_id' => $data['user_id'] , 'target_language' => $data['target_language'] , 'source_language' => $data['source_language'] ,'words' => $data['words'] , 'total_price' => $data['total_price'] ]);
        return redirect('uploadfile')->withStatus('thank you payment completed');
        $result = $payment->execute($execution,$this->apiContext);

        $data = $request->session()->all();

        if($result->getState() == 'approved')
        {
            ClientFiles::create(['filename' => $data['filename'] , 'user_id' => $data['user_id'] , 'target_language' => $data['target_language'] , 'source_language' => $data['source_language'] ,'words' => $data['words'] , 'total_price' => $data['total_price'] ]);
            return redirect('uploadfile')->withStatus('thank you payment completed');
        }

        unlink('client_file_uploads/'.$data['filename']);

        return redirect('uploadfile')->withStatus('your payment process failed');
    }

    public function cancel($filetostore)
    {
        unlink('client_file_uploads/'.$filetostore);
        return redirect('uploadfile')->withStatus('your payment process was cancelled');
    }


}
