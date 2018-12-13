<?php

require_once 'CallerService.php';

/*** Get required parameters from the web form for the request ***/

$paymentType =urlencode( $_POST['paymentType']);
$firstName =urlencode( $_POST['fname']);
$lastName =urlencode( $_POST['lname']);
$creditCardType =urlencode( $_POST['creditCardType']);
$creditCardNumber = urlencode($_POST['creditCardNumber']);
$expDateMonth =urlencode( $_POST['expDateMonth']);

//Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode( $_POST['expDateYear']);
$cvv2Number = urlencode($_POST['cvv2Number']);
$amount = urlencode($_POST['ftotal']);
$currencyCode="USD";

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */

$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";

/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("doDirectPayment",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
*/

$ack = strtoupper($resArray["ACK"]);

if($ack!="SUCCESS")  {
    $_SESSION['reshash']=$resArray;
	$location = "confirmation.php?flag=2";
		 header("Location: $location");
   }
if($ack=="SUCCESS")  {
	$_SESSION['reshash']="SUCCESS";
	$location = "thankyou.php?stage=3";
		 header("Location: $location");

}   
?>