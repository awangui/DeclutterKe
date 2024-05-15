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
  
  // $mpesaResponse = file_get_contents('php://input');
  
  $mpesaResponse = '{
    "TransactionType": "Pay Bill",
    "TransID":"RKTQDM7W6S",
    "TransTime":"20191122063845",
    "TransAmount":"10",
    "BusinessShortCode": "600638",
    "BillRefNumber":"invoice008",
    "InvoiceNumber":"",
    "OrgAccountBalance":"",
    "ThirdPartyTransID": "",
    "MSISDN":"25470****149",
    "FirstName":"John",
    "MiddleName":"",
    "LastName":"Doe"
  }';
 
  $json = json_decode($mpesaResponse);    
  // Insert into mpesa_transaction table
  $query = "INSERT INTO mpesa_request_details(transaction_type,trans_id,trans_time,trans_amount,business_short_code,bill_ref_number,MSISDN,first_name,last_name) VALUES ('$json->TransactionType', '$json->TransID',  '$json->TransTime', '$json->TransAmount',  '$json->BusinessShortCode', '$json->BillRefNumber', '$json->MSISDN','$json->FirstName', '$json->LastName')";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo $response;
  } else {
      echo "Error: " . mysqli_error($con);
  }