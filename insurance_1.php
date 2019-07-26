 <?php 
 
 include_once 'sendtxt.php';
 
 
require_once 'DbOperation.php';
require_once 'Firebase.php';
require_once 'Push.php'; 

//$db = new DbOperation();
  

function confirmB2cPayment($array) {
      $DB_HOST = '192.168.1.243:3306';
    $DB_HOST_NAME = 'root';
    $DB_HOST_PASS = 'mysql';
    $DB_NAME = 'mifostenant-uip';

    $con = mysqli_connect($DB_HOST, $DB_HOST_NAME, $DB_HOST_PASS, $DB_NAME);
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

// $file = fopen('callback.json', 'a');

// fwrite($file, (json_encode($array)));


    
    $resultDesc = $array["resultDesc"];

    $resultCode = $array['resultCode'];

    $originatorConversationID = $array['originatorConversationID'];

    $transactionID = $array['transactionID'];

    $initiatorAccountCurrentBalance = $array['initiatorAccountCurrentBalance'];
    
    $debitAccountCurrentBalance = $array['debitAccountCurrentBalance'];

    $transCompletedTime = $array['transCompletedTime'];
    $debitPartyCharges = $array['debitPartyCharges'];
    $receiverPartyPublicName = $array['receiverPartyPublicName'];
     $_SESSION['phone'] = trim(substr($receiverPartyPublicName, 0,12));
     
////businessShortCode,timestamp,transactionType,amount,phoneNumber,callBackURL

    $sql = "SELECT * from b2c_uiprequest  where OriginatorConversationID ='$originatorConversationID' ";
    


    $result1 = mysqli_query($con, $sql);
    $fp = fopen('t.json', 'w');
fwrite($fp,json_encode($result1));
fclose($fp);

    if (!$result1) {
        echo "Error: " . $sql . "<br>" . $con->error;
         $fp = fopen('t.json', 'a');
fwrite($fp,"Error: " . $sql . "<br>" . $con->error);
fclose($fp);

        // "New record created successfully";
    }
   if($result1) {
//
    while ($row = mysqli_fetch_array($result1)) {

   

        if ($row['request_id']) {
      
      
            echo $date = date("YmdHis");

              $sqlupdate = "UPDATE  b2c_uiprequest SET resultDesc='$resultDesc', resultCode='$resultCode',transactionID='$transactionID',"
                    . " initiatorAccountCurrentBalance='$initiatorAccountCurrentBalance',debitAccountCurrentBalance='$debitAccountCurrentBalance',transCompletedTime='$transCompletedTime', debitPartyCharges='$debitPartyCharges',"
                    . "confirm_date='$date',receiverPartyPublicName='$receiverPartyPublicName',TransactionReceipt='".$array['TransactionReceipt']."' WHERE request_id='" . $row["request_id"] . "' ";
              $resultupdate = mysqli_query($con, $sqlupdate);
            $file = fopen('t.json', 'a');

fwrite($file,  $sqlupdate);
if (!$resultupdate) {
        echo "Error: " . $sql . "<br>" . $con->error;
         $fp = fopen('t.json', 'w');
fwrite($fp,"Error: " . $sql . "<br>" . $con->error);
fclose($fp);

        // "New record created successfully";
    }
        }
    }
   }

          
            if(isset($array['TransactionReceipt'])){
                 $sql = "SELECT * from b2c_uiprequest c where OriginatorConversationID ='$originatorConversationID' ";

    $result1 = mysqli_query($con, $sql);

    if (!$result1) {
        echo "Error: " . $sql . "<br>" . $con->error;

        // "New record created successfully";
    }
   if($result1) {
//
    while ($row = mysqli_fetch_array($result1)) {
         $_SESSION['loanId'] = $row['loanid'];

        //  print_r($row);

        if ($row['request_id']) {
                 
      
            $date = date("YmdHis");

             $sqll4 = "UPDATE  b2c_uiprequest SET TransactionReceipt='".$array['TransactionReceipt']."' WHERE request_id='" . $row['request_id'] . "' ";
            
            $file = fopen('t.json', 'a');

fwrite($file,  $sqll4);
 $result11 = mysqli_query($con, $sqll4);

            
      if($result11){
      
  $loanId = $row['loanid'];
    
   $DB_HOST = '192.168.1.243:3306';
    $DB_HOST_NAME = 'root';
    $DB_HOST_PASS = 'mysql';
    $DB_NAME = 'mifostenant-uipmobile';

    $connx = mysqli_connect($DB_HOST, $DB_HOST_NAME, $DB_HOST_PASS, $DB_NAME);
    if (!$connx) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $sq8 = "SELECT * from m_loan where id='$loanId'";

    $result9 = mysqli_query($connx, $sq8);


   while ($row = mysqli_fetch_array($result9)) {
    
  $details = Array();
        $details['transactionAmount'] = number_format($row['principal_amount'],0);
        $details['actualDisbursementDate'] = date("d F Y");
        $details['paymentTypeId'] = 4;
        $details['locale'] = "en";
        $details['dateFormat'] = "dd MMMM yyyy";
        $url2 = "https://192.168.1.243:8444/uip/api/v1/loans/$loanId?tenantIdentifier=uipmobile&command=disburse";

        $res = json_decode(get_details_to_mifos($url2, $details,"8444"), TRUE);
         
            $file = fopen('t.json', 'a');

fwrite($file,  json_encode($res).$url2);
        if(isset($res['loanId'])){
			
					//exit();
			
            $file = fopen('t.json', 'a');

fwrite($file,  json_encode($res));
          //sendTxt(13, $res['loanId']);
        session_destroy();
        }
                
      }
      }

            
            if (!$result1) {
                echo "Error: " . $sql . "<br>" . $con->error;

            } 
         
        }
    }
}
}
}


function confirmPayment($array) {

 $DB_HOST = '192.168.1.243:3306';
    $DB_HOST_NAME = 'root';
    $DB_HOST_PASS = 'mysql';
    $DB_NAME = 'mifostenant-uipmobile';

    $connx = mysqli_connect($DB_HOST, $DB_HOST_NAME, $DB_HOST_PASS, $DB_NAME);
    if (!$connx) {
        die("Connection failed: " . mysqli_connect_error());
    }


    //global $conn;

    $resultDesc = $array["resultDesc"];

    $resultCode = $array['resultCode'];

    $merchantRequestID = $array['merchantRequestID'];

    $checkoutRequestID = $array['checkoutRequestID'];

    $mpesaReceiptNumber = $array['mpesaReceiptNumber'];

    $phoneNumber = $array['phoneNumber'];

    $_SESSION['phone'] = $phoneNumber;

    $db = new DbOperation();
  	//creating a new push
		$push = null;
   
   	$push = new Push(
					"Uip Credit",
					"Paid Successifully",
					null
				);
	//getting the push from push object
		$mPushNotification = $push->getPush(); 

		//getting the token from database object 
		$devicetoken = $db->getTokenByEmail($checkoutRequestID);

   $filee = fopen('devicetoken.json', 'a');
   fwrite($filee,$checkoutRequestID);

		//creating firebase class object 
		$firebase = new Firebase(); 

		//sending push notification and displaying result 
		echo $firebase->send($devicetoken, $mPushNotification);

////businessShortCode,timestamp,transactionType,amount,phoneNumber,callBackURL

    $sql = "SELECT id,account_reference,partya,transaction_desc,amount from stk_push_requests where checkout_requestid like '%$checkoutRequestID%'";


    $result = mysqli_query($connx, $sql);

    if (!$result) {
        echo "Error: " . $sql . "<br>" .$connx->error;

        // "New record created successfully";
    }


//    //print_r($result);
//
    while ($row = mysqli_fetch_array($result)) {

        //  print_r($row);

        if ($row["id"]) {

            $transactiondesc = $row['transaction_desc'];

            $accountReference = $row['account_reference'];
            $receipt = $mpesaReceiptNumber;

            $date = date("YmdHis");

            $amount = $row['amount'];

            $sqll = "UPDATE  stk_push_requests SET result_desc='$resultDesc', result_code='$resultCode',mpesa_receipt_number= '$mpesaReceiptNumber',confirm_date='$date' WHERE id='" . $row["id"] . "' ";
//
//            // echo $sqll;
//

//$fileq= fopen('queryy.json', 'a');

//fwrite($fileq,$sqll);
            $result = mysqli_query($connx, $sqll);
// 
            if (!$result) {
                echo "Error: " . $sql . "<br>" .  $connx->error;

//        // "New record created successfully";
            } else {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://localhost:443/shortcode/updatesms.php");
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($ch);
                curl_close($ch);
            }
        }
    }
}
function get_details_to_mifos($url, $details,$port) {
   

    // $out = array_values($details);
    //echo $details;
     $js = json_encode($details);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        //curl_setopt ($curl, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem"),
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false),
        //CURLOPT_CAINFO=> dirname(__FILE__)."/cacert.pem",

        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_PORT => $port,
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $js,
        CURLOPT_HTTPHEADER => array(
            "authorization: Basic YWRtaW46cGFzc3dvcmQ=",
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: 82f71847-a076-7a85-a4d7-ed6745be0190"
        ),
    ));

 echo $response = curl_exec($curl);

    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {

        echo "cURL Error #:" . $err;
    } else {

        return $response;
    }
}


   
  
    