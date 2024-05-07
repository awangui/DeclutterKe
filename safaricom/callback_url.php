<?php
require_once '../connection.php';
header("Content-Type: application/json");

$response = '{
         "ResultCode": 0, 
         "ResultDesc": "Confirmation Received Successfully"
     }';
$errorResponse = '{
      "ResultCode": "C2B00011",
   "ResultDesc": "Rejected"
  }';

// DATA
$mpesaResponse = file_get_contents('php://input');

$json = json_decode($mpesaResponse);

$mid = $json->Body->stkCallback->MerchantRequestID;
$cid = $json->Body->stkCallback->CheckoutRequestID;
$amount = $json->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$rn = $json->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$td = $json->Body->stkCallback->CallbackMetadata->Item[2]->Value;
$pn = $json->Body->stkCallback->CallbackMetadata->Item[3]->Value;



$query = "INSERT INTO mpesa_transactions (MerchantRequestID, CheckoutRequestID, Amount, MpesaReceiptNumber, TransactionDate, PhoneNumber) VALUES ( '$mid', '$cid','$amount', '$rn', '$td', '$pn')";

$result = mysqli_query($con, $query);
if ($result) {
  echo $response;
} else {
  echo "Error: " . mysqli_error($con);
}
