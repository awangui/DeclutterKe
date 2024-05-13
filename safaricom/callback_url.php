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

// Get M-Pesa callback data
$mpesaResponse = file_get_contents('php://input');
$json = json_decode($mpesaResponse, true);

// Insert into mpesa_transaction table using prepared statement
$query = "INSERT INTO mpesa_request_details (transaction_type, trans_id, trans_time, trans_amount, business_short_code, bill_ref_number, MSISDN, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "sssssssss", $json['TransactionType'], $json['TransID'], $json['TransTime'], $json['TransAmount'], $json['BusinessShortCode'], $json['BillRefNumber'], $json['MSISDN'], $json['FirstName'], $json['LastName']);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo $response;
} else {
    echo "Error: " . mysqli_error($con);
}
?>
