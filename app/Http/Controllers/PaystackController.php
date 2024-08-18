<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{
    //
    // public function redirectToGateway()
    // {
    //     try{
    //         return Paystack::getAuthorizationUrl()->redirectNow();
    //     }catch(\Exception $e) {
    //         return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
    //     }
    // }

    // public function handleGatewayCallback()
    // {
    //     $paymentDetails = Paystack::getPaymentData();

    //     dd($paymentDetails);
    //     // Now you have the payment details,
    //     // you can store the authorization_code in your db to allow for recurrent subscriptions
    //     // you can then redirect or do whatever you want
    // }
    //  public function make_payment()
    // {
    //     $formData = [
    //         'email' => request('email'),
    //         'amount' => request('amount') * 100,
    //         'callback_url' => route('pay.callback')
    //     ];
    //     $pay = json_decode($this->initiate_payment($formData));
    //     if ($pay) {
    //         if ($pay->status) {
    //             return redirect($pay->data->authorization_url);
    //         } else {
    //             return back()->withError($pay->message);
    //         }
    //     } else {
    //         return back()->withError("Something went wrong");
    //     }
    // }

    // public function payment_callback()
    // {
    //     $response = json_decode($this->verify_payment(request('reference')));
    //     if ($response) {
    //         if ($response->status) {
    //             $data = $response->data;
    //             return view('pay.callback_page')->with(compact(['data']));
    //         } else {
    //             return back()->withError($response->message);
    //         }
    //     } else {
    //         return back()->withError("Something went wrong");
    //     }
    // }

    // public function initiate_payment($formData)
    // {
    //     $url = "https://api.paystack.co/transaction/initialize";

    //     $fields_string = http_build_query($formData);
    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         "Authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
    //         "Cache-Control: no-cache",
    //     ));

    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $result = curl_exec($ch);
    //     curl_close($ch);

    //     return $result;
    // }

    // public function verify_payment($reference)
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
    //             "Cache-Control: no-cache",
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     curl_close($curl);

    //     return  $response;
    // }



    public function make_payment()
    {
        $formData = [
            'email' => request('email'),
            'amount' => 0.1 * 100,
            'callback_url' => route('pay.callback'),
            'currency' => 'GHS',
            "metadata" => [
                "cancel_action" =>  route('pay.callback'),
                "custom_fields" => [
                    [
                        "display_name" => "Laptop",
                        "variable_name" => "laptop",
                        "value" => "Laptop"
                    ],
                    [
                        "display_name" => "Quantity",
                        "variable_name" => "quantity",
                        "value" => "1"
                    ]
                ]
            ]
        ];

        $pay = json_decode($this->initiate_payment($formData));


        if ($pay->status) {
            return redirect($pay->data->authorization_url);
        } else {
            return back()->withErrors($pay->message);
        }
    }



    public function payment_callback()
    {
        $response = json_decode($this->verify_payment(request('reference')));


        if ($response->status) {
            $data = $response->data;

            $message = $data->status;
            if ($message === 'success') {
                $obj = new Payment;
                $obj->payment_id = $data->reference;
                $obj->product_name = $data->metadata->custom_fields[0]->value;
                $obj->quantity = $data->metadata->custom_fields[0]->value;
                $obj->amount = $data->amount / 100;
                $obj->currency = $data->currency;
                $obj->payment_status = "Completed";
                $obj->payment_method = $data->channel;;
                $obj->save();
                return view('pay.payment-success')->with(compact('data'));
            } else {
                return back()->with('error', 'Unable to process payment');
            }
        } else {
            return back()->withErrors($response->message);
        }
    }



    public function initiate_payment($formData)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);


        $response = $client->post('https://api.paystack.co/transaction/initialize', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
            ],
            'json' => $formData,
        ]);

        return $response->getBody()->getContents();
    }



    public function verify_payment($reference)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);


        $response = $client->get("https://api.paystack.co/transaction/verify/$reference", [
            'headers' => [
                'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Cache-Control' => 'no-cache',
            ],
        ]);

        return $response->getBody()->getContents();
    }
}
