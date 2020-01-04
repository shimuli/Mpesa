<?php
// Used to confirm a transction and transctions to database
require 'config.php';
		header("Content_Type:application/json");

		$response = '{
			"ResultCode" : 0,
			"ResultDesc" : "Confirmation Received Successfully "

		}';

		//DATA

		//response from M-Pesa Stream
		$mpesaResponse = file_get_contents('php://input');

		//Log the response

		$logfile = "M_PESAConfirmationResponse.txt";//Transction info in plain text incase database does not save it

		$jsonMpesaResponse = json_decode($mpesaResponse, true);
		$transaction = array(

		':transctionType'=> $jsonMpesaResponse['TransactionType'], 
		':transctionID' => $jsonMpesaResponse['TransID'], 
		':transctionTime' => $jsonMpesaResponse['TransTime'], 
		':transctionAmount' => $jsonMpesaResponse['TransAmount'], 
		':ShortCode' => $jsonMpesaResponse['BusinessShortCode'], 
		':BillRefNo' => $jsonMpesaResponse['BillRefNumber'], 
		':InvoiceNo' => $jsonMpesaResponse['InvoiceNumber'], 
		':schoolAccountBal' => $jsonMpesaResponse['OrgAccountBalance'], 
		':thirdpartyTransId' => $jsonMpesaResponse['ThirdPartyTransID'], 
		':MSISDN' => $jsonMpesaResponse['MSISDN'], 
		':FirstName' => $jsonMpesaResponse['FirstName'], 
		':MiddleName' => $jsonMpesaResponse['MiddleName'], 
		':LastName' => $jsonMpesaResponse['LastName']
		);


		//Write to file
		$log = fopen($logfile, "a");

		fwrite($log, $mpesaResponse);
		fclose($log);

		echo $response;

		insert_response($jsonMpesaResponse);


?>