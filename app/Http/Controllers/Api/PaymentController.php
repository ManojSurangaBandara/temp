<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\BookingPayment;
use App\Http\Controllers\Controller;
use App\Services\CYBSPEBBasicService;
//use App\Services\CYBSPEBBasicService;

class PaymentController extends Controller
{
    protected $cybersourceService;

    public function __construct(CYBSPEBBasicService $cybersourceService)
    {
        $this->cybersourceService = $cybersourceService;
    }

    public function generateForm(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'booking_id' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // Generate the form text using the service class
        $formText = $this->cybersourceService->getDefaultForm($request->booking_id, $request->amount);

        // Pass the form text to the view
        return view('payment.form', ['formText' => $formText]);
    }

    public function getpayment_responce(Request $request)
    {
        $postData = $request->all();

        $jsonString = json_encode($postData);

        $jsonArray = json_decode($jsonString, true);

        // return response()->json(['reason_code' => $jsonArray['reason_code'],
        //                          'reference_number'=>$jsonArray['req_reference_number'],
        //                          'auth_trans_ref_no'=>$jsonArray['auth_trans_ref_no'],
        //                          'amount'=>$jsonArray['req_amount'],
        //                          'decision'=>$jsonArray['decision'],
        //                          'message' => $jsonArray['message'],
        //                          'transaction_id' => $jsonArray['transaction_id']], 200);

        $reason_code = $jsonArray['reason_code'];
        try {
            $bookingPayment = BookingPayment::create([
                'reason_code' => $jsonArray['reason_code'],
                'reference_number' => $jsonArray['req_reference_number'],
                'auth_trans_ref_no' => $jsonArray['auth_trans_ref_no'],
                'amount' => $jsonArray['req_amount'],
                'decision' => $jsonArray['decision'],
                'message' => $jsonArray['message'],
                'transaction_id' => $jsonArray['transaction_id'],
                'booking_id' => $jsonArray['auth_trans_ref_no']
            ]);

            if ($reason_code == 100) {
                $whereConditions = ['id' => $jsonArray['auth_trans_ref_no']];

                $updateData = ['level' => 3];

                $booking_update = Booking::where($whereConditions)->update($updateData);

                $booking = Booking::where('id', '=', $jsonArray['auth_trans_ref_no'])->first();

                $formtext = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

                <title>Payment</title>

                <!-- Bootstrap cdn 3.3.7 -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

                <!-- Custom font montseraat -->
                <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">

                <!-- font-awesome -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                <!-- Custom style invoice1.css -->
                <link rel="stylesheet" type="text/css" href="https://net.army.lk/rrs/payment/invoice/invoice1.css">

                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

            </head>
            <body>

	<section class="back">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="invoice-wrapper">
						<div class="invoice-top">
							<div class="row">
								<div class="col-sm-6">
									<div class="invoice-top-left">
										<h2 class="client-company-name">Directorate of RE&Q</h2>
										<h6 class="client-address">Sri Lanka Army Headquaters <br>Sri Jayawardenapura <br></h6>
										<h4>Transaction ID</h4>
										<h5>' . $jsonArray['transaction_id'] . '</h5>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="invoice-top-right">
										<h2 class="our-company-name">' . $booking->svc_no . '</h2>
										<h6 class="our-address">' . $booking->name . ' <br>' . $booking->regiment . ' <br></h6>
										<h5>' . $jsonArray['signed_date_time'] . '</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="invoice-bottom">
							<div class="row">
								<div class="col-xs-12">
									<h2 class="title" style="color: green;"><i class="fa fa-cc-mastercard" aria-hidden="true"></i>Payment Accept</h2>
								</div>
								<div class="clearfix"></div>

								<div class="col-sm-3 col-md-3">
									<div class="invoice-bottom-left">
										<h5>Booking ID</h5>
										<h4>B:' . $booking->id . '</h4>
									</div>
								</div>
								<div class="col-md-offset-1 col-md-8 col-sm-9">
									<div class="invoice-bottom-right">
										<table class="table">
											<thead>
												<tr>
													<th>Ser</th>
													<th>Description</th>
													<th>Price (Rs.)</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>Holiday Bunglow Booking</td>
													<td>' . number_format($booking->paid_amount, 2) . '</td>
												</tr>

												<tr style="height: 40px;"></tr>
											</tbody>
											<thead>
												<tr>
													<th>Total</th>
													<th></th>
													<th>' . number_format($booking->paid_amount, 2) . '</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="bottom-bar"></div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <button class="btn btn-primary print-btn"><i class="fa fa-print" aria-hidden="true"></i> Print </button>
            </div>
        </div>
    </div>


	<!-- jquery slim version 3.2.1 minified -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script>
        $(document).ready(function() {
            $(".print-btn").on("click", function() {
                window.print();
            });
        });
    </script>

</body>

</html>';

                return response($formtext)->header('Content-Type', 'text/html');
            } else {

                $booking = Booking::where('id', '=', $jsonArray['auth_trans_ref_no'])->first();

                $formtext = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Payment</title>

	<!-- Bootstrap cdn 3.3.7 -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Custom font montseraat -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">

	<!-- font-awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Custom style invoice1.css -->
	<link rel="stylesheet" type="text/css" href="https://net.army.lk/rrs/payment/invoice/invoice1.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

</head>
<body>

	<section class="back">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="invoice-wrapper">
						<div class="invoice-top">
							<div class="row">
								<div class="col-sm-6">
									<div class="invoice-top-left">
										<h2 class="client-company-name">Directorate of RE&Q</h2>
										<h6 class="client-address">Sri Lanka Army Headquaters <br>Sri Jayawardenapura <br></h6>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="invoice-top-right">
										<h2 class="our-company-name">' . $booking->svc_no . '</h2>
										<h6 class="our-address">' . $booking->name . ' <br>' . $booking->regiment . '</h6>
										<h5>' . $jsonArray['signed_date_time'] . '</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="invoice-bottom">
							<div class="row">
								<div class="col-xs-12">
									<h2 class="title" style="color: red;"><i class="fa fa-cc-mastercard" aria-hidden="true"></i> Payment Decline</h2>
								</div>
								<div class="clearfix"></div>

								<div class="col-sm-3 col-md-3">
									<div class="invoice-bottom-left">
										<h5>Booking ID</h5>
										<h4>B:'.$booking->id.'</h4>
									</div>
								</div>

								<div class="clearfix"></div>
							</div>
							<div class="bottom-bar"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- jquery slim version 3.2.1 minified -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>';

                return response($formtext)->header('Content-Type', 'text/html');

                //return response()->json(['url' => $booking->svc_no]);


            }
        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function generateIPGCall(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'booking_id' => 'required|string',
            'amount' => 'required|numeric',
            'forename' => 'required|string',
            'surname' => 'required|string',
            'address_line1' => 'required|string'
        ]);

        // Construct the URL with parameters
        $url = "https://net.army.lk/rrs/payment/Call_IPG.php?" .
            "booking_id=" . $request->booking_id .
            "&amount=" . $request->amount .
            "&forename=" . $request->forename .
            "&surname=" . $request->surname .
            "&address_line1=" . $request->address_line1;

        return response()->json(['url' => $url]);

        //return response()->json(['url' => "https://net.army.lk/rrs/payment/Call_IPG.php?booking_id=2&amount=20.00&forename=O/69566&surname=DAN Jayaweera&address_line1=SLSC"], 200);
    }
}
