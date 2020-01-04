<?php
// This database config is used to save the c2b transcations
function insert_response($jsonMpesaResponse){
    try{
        $con = new PDO("mysql:dbhost=localhost;dbname=Your_db_name",'your db username','db password');
        if (!$con) {
            echo "Connection failed";
        }else{
            echo "Connection was successful";
    
        }

    }
    catch(PDOException $e){
        die("Error Connection".$e->getMessage());
    }

    try{
    $insert = $con->prepare("INSERT INTO `your table name`(`transctionType`, `transctionID`, `transctionTime`, `transctionAmount`, `ShortCode`, `BillRefNo`,
    `InvoiceNo`, `schoolAccountBal`, `thirdpartyTransId`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`)
    VALUES  (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, 
    :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)");
        
    $insert->execute((array)($jsonMpesaResponse));
        $Transaction = fopen('Transaction.txt', 'a');
        fwrite($Transaction, json_encode($jsonMpesaResponse));
        fclose($Transaction);
    }
    catch(PDOException $e){
        $errorLog = fopen('error.txt', 'a');

        fwrite($errorLog, $e->getMessage());

        fclose($errorLog);

        $logFailedTransaction = fopen('failedTransaction.txt', 'a');
        fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
        fclose($logFailedTransaction);
    }

}

    


?>