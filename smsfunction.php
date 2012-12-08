<?php


function SendSms($message,$mobilenumber)
{
    

//Please Enter Your Details
 $user="xxxxxxxxx"; //your username
 $password="yyyyyyyyy"; //your password
 $mobilenumber=$mobilenumber; //enter Mobile numbers comma seperated
 //$mobilenumber="919xxxxxxxxx";
 //$message = "test messgae"; //enter Your Message 
 $senderid="AT-XMPY"; //Your senderid
 $messagetype="N"; //Type Of Your Message
 $DReports="Y"; //Delivery Reports
 $url="http://www.smscountry.com/SMSCwebservice.asp";
$message=urlencode($message);

if($mobilenumber!="")
{


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
 
}
}

?>
