<?php
session_start();
////mobile verification
$site_root = "http://www.testwebsite.com/";
include("includes/database.mvc.php");
$db = new Database();		
//Please Enter Your Details
 $user="xxxxxxxxx"; //your username
 $password="yyyyyyy"; //your password
 $action=$_REQUEST['action'];
 $registerperson=$_REQUEST['registerperson'];
 $mobilenumber=$_REQUEST['mobileno']; //enter Mobile numbers comma seperated
 //$mobilenumber="919xxxxxxxxx";
 //$message = "test messgae"; //enter Your Message 
 $senderid="CSO-NGO"; //Your senderid
 $messagetype="N"; //Type Of Your Message
 $DReports="Y"; //Delivery Reports
 $url="http://www.smscountry.com/SMSCwebservice.asp";


if($action=="update")
{
    $random = rand(001, 999); 
                //$random_alphabet=rand(a, z);
                
                
                for ($i = 0; $i < 3; $i++)
                	{
                		// the use of 65 and 90 - ascii for alphabets
                		$num = rand(65, 90);
                		$verification_code .= chr($num);
                	}
                $verify_code=$verification_code.$random;
                $msg="Your Account Verification Code for XXX:".$verify_code;
                 $message = urlencode($msg);

$ch = curl_init(); 
 if (!$ch){die("Couldn't initialize a cURL handle");}
 $ret = curl_setopt($ch, CURLOPT_URL,$url);
 curl_setopt ($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 curl_setopt ($ch, CURLOPT_POSTFIELDS, 
"User=$user&passwd=$password&mobilenumber=$mobilenumber&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports&jobno=&status&doneTime=&messagepart=$message");
 $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");



 $curlresponse = curl_exec($ch); // execute
 if (empty($ret)) {
    // some kind of an error happened
    die(curl_error($ch));
    curl_close($ch); // close cURL handler
 } else {
    $info = curl_getinfo($ch);
    curl_close($ch); // close cURL handler
    //echo "<br>";
   //echo "Message Sent Succesfully" ;
   
 }
 $jobid=$curlresponse; 
  $deliver_url="http://www.smscountry.com/SMSCwebservice_SMS_GetDR.asp";
 
 $ch = curl_init(); 
 if (!$ch){die("Couldn't initialize a cURL handle");}
 $ret = curl_setopt($ch, CURLOPT_URL,$deliver_url);
 curl_setopt ($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 curl_setopt ($ch, CURLOPT_POSTFIELDS,"SMS_JOB_NO=$jobid&User=$user&passwd=$password");
 $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");



 $curlresponse = curl_exec($ch); // execute   

    $data=explode("-",$curlresponse);
    if($data[1]=='3' || $data[1]=='9'){
        $response="Verification Code Sent to Your Mobile ";
    }
    else if($data[1]=='11'){
        $response="Invalid Mobile Number";
    }
    else if($data[1]=='10'){
        $response="Your Mobile Registered in DND service.Please Try Again with some other mobile number";
    }
    else{
        $response="Message Not Sent. Try again with some other Mobile number";
    }
    
    $response="Message sent to Your mobile. If you not getting message please check your mobile is registered in DND or not.";
    $responsearray['response']=$response;
    $responsearray['verifycode']=$verify_code;
    $responsearray=json_encode($responsearray);
    echo $responsearray;
}


?>