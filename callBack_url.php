 
<?php
//This code can be used in android stkpush as callbackurl
    $db_server = "localhost";
    $db_username = ""; // Datebase username
    $db_password = "";  // database password if any
    $db_database = "";  //db name
   
    $con=mysqli_connect($db_server,$db_username,$db_password,$db_database); 
    $data = json_decode(file_get_contents('php://input'));
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else{
        echo "Connection was successful";
    }
    
  //sending callback response to database fromstk push
    $columns = ["transctionAmount","mpesa_receipt_number","transaction_date","phone_number"]; //your db entries name
    $values = array();
    foreach ($data->Body->stkCallback->CallbackMetadata->Item as $item) {
        if ($item->Name !== "Balance") {
            $values[]=$item->Value;
        }
    }
    $col="";
    $val="";
    for ($i=0; $i <count($columns) ; $i++) { 
        $col.=$columns[$i];
        $val.="'".$values[$i]."'";
        if ($i !==(count($columns)-1)) {
            $col.=",";
            $val.=",";
        }
    }
    $transact="INSERT INTO yourtable name(".$col.")VALUES(".$val.")";
        $exec = mysqli_query($con,$transact);
        if($exec){
            echo "Transaction saved";
        }else{
            //incase transction is not successful
            echo "There was an error " . mysqli_error($con);
            $callBackResponse = file_get_contents('php://input');
            $callbackData=json_decode($callBackResponse);
            $logFile = "failed.txt";
            $log = fopen($logFile, "a");
            fwrite($log, $callBackResponse);
            fclose($log);
        }
        mysqli_close($con);	
      
?>
