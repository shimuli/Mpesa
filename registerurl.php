 <?php
 /*This is the C2B reg url which mpesa uses to to send transction info after a complete transction.
 This code does not have a test option,itmay exist in the daraja portalbut it wont work because this code is sent to mpesa using the
 url= 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl.
 You need to have live credentils and a registered paybill number for this to work.
 */

    $headers = ['Content-Type:application/json; charset=utf8'];
    $consumerKey = ''; // your live consumer key
    $consumerSecret = ''; // Your live secret key

     //access token code ends here
     $urls = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'; // this a live access_token url
     $curl = curl_init($urls);
     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
     curl_setopt($curl, CURLOPT_HEADER, FALSE);
     curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
     $result = curl_exec($curl);
     $status = curl_getinfo($curl , CURLINFO_HTTP_CODE);
     $result = json_decode($result);
     $access_token = $result->access_token;    
     echo $access_token;
     curl_close($curl);
    
   
     $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl'; // live reg url
  
     $curl = curl_init();
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); 
  
  
     $curl_post_data = array(
     
       'ShortCode' => '', //your registered paybill number
       'ResponseType' => 'Confirmed',
       'ConfirmationURL' => '', // confirmation url domain,must be in a  remote server, host the one provided in this repo and use it here 
       'ValidationURL' => ''  // validation url domain, must be in a remote server, host the one provided in this repo and use it here 
     );
  
     $data_string = json_encode($curl_post_data);
  
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($curl, CURLOPT_POST, true);
     curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
     $curl_response = curl_exec($curl);
     print_r($curl_response);
  
     echo $curl_response;
    
  ?>