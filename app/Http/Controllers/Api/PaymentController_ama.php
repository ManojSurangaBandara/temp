<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CYBSPEBBasicService;
//use App\Services\CYBSPEBBasicService;

class PaymentController_old extends Controller
{
    protected $cybersourceService;

    // public function __construct(CYBSPEBBasicService $cybersourceService)
    // {
    //     $this->cybersourceService = $cybersourceService;
    // }


    public function generateForm(Request $request)
    {
       // return response()->json(['req'=>$request->booking_id]);

        $orderID = $request->input('booking_id');
        $purchaseAmt = $request->input('amount');

        return response()->json(['payment_url'=>$request->booking_id]);

        $cybsService = new CYBSPEBBasicService();

        $formtext = "<!DOCTYPE html>
        <html lang='en'>
            <head>
                 <meta charset='UTF-8'>
                 <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                 <title>JSON to HTML</title>
                 </head>
                 <body>";

        $formtext .= $cybsService->getDefaultForm($orderID, $purchaseAmt);

        $formtext .="</body>
        </html>";

        return response($formtext)->header('Content-Type', 'text/html');

        //return response()->json(['form_html' => $formtext]);
    }

    // public function generateForm(Request $request)
    // {
    //     $SECRET_KEY = 'd76d77c78e2146aab64ffcc3923d8f5e9e173a83962f433992538ea923401ae4a69f5ddca9fb442093bc7b4548d64dd13cf9c2ad75c24bc29a6158ee358364a4a02b1459e10240b89d9334cc24d49ed7c5bb94e8ecc14ddca86d2efbb98e57c11eeda61784164af78da9add352f717ce2289e904b714440897408b8e55b483ae';
	// 	$access_key = '13b346d707963e65980967c4170325df';
	// 	$profile_id = '06BC035E-E668-40B5-9B93-28245B76EE4E';
	// 	$url = 'https://testsecureacceptance.cybersource.com/pay';
	// 	$params = array();
	// 	$params["transaction_uuid"] = uniqid();
	// 	$params["access_key"] = $access_key;
	// 	$params["profile_id"] = $profile_id;
	// 	$params["signed_field_names"] = "access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency";
	// 	$params["unsigned_field_names"] = "auth_trans_ref_no,bill_to_forename,bill_to_surname,bill_to_address_line1,bill_to_address_city,bill_to_address_country,bill_to_email";
	// 	$params["signed_date_time"] = gmdate("Y-m-d\TH:i:s\Z");
	// 	$params["locale"] = "en";
	// 	$params["transaction_type"] = "sale";
	// 	$params["reference_number"] = $request->booking_id;
	// 	$params["auth_trans_ref_no"] = $request->booking_id;
	// 	$params["amount"] = $request->amount;
	// 	$params["currency"] = "LKR";
	// 	$params["bill_to_email"] = "null@cybersource.com";
	// 	$params["bill_to_forename"] = "noreal";
	// 	$params["bill_to_surname"] = "name";
	// 	$params["bill_to_address_line1"] = "1295 Charleston Rd";
	// 	$params["bill_to_address_city"] = "Mountain View";
	// 	$params["bill_to_address_country"] = "US";
	// 	$params["bill_to_address_postal_code"] = "94043";
	// 	$params["signature"] = $this->sign($params, $SECRET_KEY);


    //     // $formtext = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
    //     // $formtext .= '<script>$("#payment_confirmation").ready(function(){$("#payment_confirmation").submit();});</script>';
    //     // $formtext .= '<form type="hidden" id="payment_confirmation" action="' . $url . '" method="post"/>';
    //     // foreach ($params as $name => $value) {
    //     //         $formtext .= "<input  type='hidden' id='" . $name . "' name='" . $name . "' value='" . $value . "'/><br/>";
    //     // }

    //     // $formtext .= '</form>';

    //     // $formInputs = '';
    //     // //$formInputs .= '<form type="hidden" id="payment_confirmation" action="' . $url . '" method="post"/>';
    //     // foreach ($params as $name => $value) {
    //     //     $formInputs .= "<input type='hidden' id='$name' name='$name' value='$value'/>";
    //     // }

    // $htmlContent = "<!DOCTYPE html>
    // <html lang='en'>
    // <head>
    //     <meta charset='UTF-8'>
    //     <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    //     <title>JSON to HTML</title>
    //     <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    //     <script>
    //     $(document).ready(function() {
    //         // Your JavaScript code here
    //         // For example, submitting a form
    //         $('#payment_confirmation').submit();
    //     });
    // </script>
    // </head>
    // <body>
    //     <h1>JSON Data Converted to HTML</h1>
    //     <div id='booking_id'>
    //         <p>Booking ID: $request->booking_id</p>
    //     </div>
    //     <form type='hidden' id='payment_confirmation' action='$url' method='post'>";



    //     foreach ($params as $name => $value) {
    //         $htmlContent .= "<input type='text' id='$name' name='$name' value='$value'/>";
    //     }

    //     $htmlContent .="</form>
    // </body>

    // </html>";

    // // Return the HTML content as a response
    // return response($htmlContent)->header('Content-Type', 'text/html');

    //     // return response()->json(['data' => $request->booking_id]);
    //     // // Validate the incoming request
    //     // $request->validate([
    //     //     'booking_id' => 'required|string',
    //     //     'amount' => 'required|numeric',
    //     // ]);

    //     // // Generate the form text using the service class
    //     // $formText = $this->cybersourceService->getDefaultForm($request->booking_id, $request->amount);

    //     // return response()->json(['form_text' => $formText]);
    // }


    // private function sign($params, $secretKey)
	// {
	// 	return $this->signData($this->buildDataToSign($params), $secretKey);
	// }

	// private function signData($data, $secretKey)
	// {
	// 	return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
	// }

	// private function buildDataToSign($params)
	// {
	// 	$signedFieldNames = explode(",", $params["signed_field_names"]);
	// 	foreach ($signedFieldNames as $field) {
	// 		$dataToSign[] = $field . "=" . $params[$field];
	// 	}
	// 	return $this->commaSeparate($dataToSign);
	// }

	// private function commaSeparate($dataToSign)
	// {
	// 	return implode(",", $dataToSign);
	// }


}