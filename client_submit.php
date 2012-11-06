<?php



/*
Early (online, not EcoCash) merchant client library for p2p transfers.

Class implementation removed for simplicity

Don't mind the odd variable names ;) <HAcK>

Instructions

Import the sql into your db whose details you must provide below

You have to implement one function, handle_successful_transfer

which is called after a successful transfer notification from
our server has been successfuly received and comiitted to the
database.

The library passes to the function an associative array with
details of the transfer as well as a connection object to
your database in case you need to use it.

As with all payments option, what you do from hereon is entirely
your responsibility

The sample API access keys below transfer notifs to our online account
You can use these as a quick test to see them reflect on our website.
Of course the EcoCash funds remain with you.

Tempering with the library, especially responses sent back by It
to our servers results in permanent termination of your account
with us.

ABOUT THE ASSOCIATIVE ARRAY PASSED TO handle_successful_transfer

It has these keys:

"admi" => Android Device Message ID, row id in the submissions table on your device
"amount"=> Amount transferred
"sender"=> The name of the sender, phone number only available in the merchant version
"approval_code"=> EcoCash Transaction approval code
"new_balance"=> The new balance on your EcoCash account
"time_sms_got_in"=> The time that the SMS was received (should be)

*/


//DATABASE: this format allows you to toggle nicely between your localhost, and online

$user = $_SERVER['SERVER_NAME'] == "localhost" ? "root" : "web75-bulksmsapp";

$pass = $_SERVER['SERVER_NAME'] == "localhost" ? "" : "bulksmsapp";

$db = $_SERVER['SERVER_NAME'] == "localhost" ? "khuluma" : "web75-bulksmsapp";

$public_key = "takunda"; //the public key we give to you

$secret_key = "11545CHIPANGURA1991"; //the secret key we give to you

define('LOG_EVENTS', TRUE); //requires log table in the db
define ('DENY_ALL', FALSE);
//function to handle submissions

function handle_successful_transfer($submission, $conn){
	/*
	Decrease stock, add shipping, send email of thanks.
	You decide.
	*/
	return;
}


/*
===============================================================================
	DO NOT EDIT BELOW THIS LINE
===============================================================================
*/

$conn = mysql_connect("localhost", $user, $pass);
mysql_select_db($db, $conn);
log_dema($_SERVER['QUERY_STRING'], $conn);

if (DENY_ALL == TRUE){
	echo "maintenance";
	exit();	
}


$rid = "";
$admi = "";
$amount = "";
$sender = "";
$approval_code = "";
$new_balance = "";
$time_sms_got_in = "";
$merchant_key  ="";
$digest = "";

$missing_field = false;

if (isset($_GET['admi'])){
	$admi  = trim($_GET['admi']);
	if (strlen($admi) < 1){ $missing_field = true; }
	}
else{
	$missing_field = true;
	}	
	
if (isset($_GET['amount'])){
	$amount  = trim($_GET['amount']);
	if (strlen($amount) < 1){ $missing_field = true; }
	}
else{
	$missing_field = true;
	}	
	
if (isset($_GET['sender'])){
	$sender  = trim($_GET['sender']);
	if (strlen($sender) < 1){ $missing_field = true; }
	}
else{
	$missing_field = true;
	}	
	
if (isset($_GET['approval_code'])){
	$approval_code  = trim($_GET['approval_code']);
	if (strlen($approval_code) < 1){ $missing_field = true; }
	}	
else{
	$missing_field = true;
	}	
	
if (isset($_GET['new_balance'])){
	$new_balance  = trim($_GET['new_balance']);
	if (strlen($new_balance) < 1){ $missing_field = true; }
	}	
else{
	$missing_field = true;
	}	
	
if (isset($_GET['time_sms_got_in'])){
	$time_sms_got_in  = trim($_GET['time_sms_got_in']);
	if (strlen($time_sms_got_in) < 1){ $missing_field = true; }
	}	
else{
	$missing_field = true;
	}	

if (isset($_GET['merchant_key'])){
	$merchant_key  = trim($_GET['merchant_key']);
	if (strlen($merchant_key) < 1){ $missing_field = true; }
	}	
else{
	$missing_field = true;
	}	
	
if (isset($_GET['digest'])){
	$digest  = trim($_GET['digest']);
	if (strlen($digest) < 1){ $missing_field = true; }
	}	
else{
	$missing_field = true;
	}		
	
if ($missing_field == true){
		$out = array("message"=>"missing_fields", "status"=>"0");
		echo json_encode($out);
		exit();
	}	

/*
============================================================================================
API AUTHENTICATION
admi=2&amount=1.00&approval_code=121105.1452.C00011&new_balance=14.82&sender=JOHN+KURAI&time_sms_got_in=2012-11-05+12%3A53%3A01&merchant_key=takunda&digest=e8b683729c9169059921b1388c47e60bc016f432cd02830943f5d2845d1de40b

*/	
		
if ($public_key != $merchant_key){
	$out = array("message"=>"auth_fail", "status"=>"0");
	echo json_encode($out);
	exit();
	}
	
//check hash

$hash_part = $admi.$amount.$approval_code.$new_balance.$sender.$time_sms_got_in.$secret_key;

$hash_part = hash("sha256", $hash_part);

if ($hash_part != $digest){
	$out = array("message"=>"auth_fail", "status"=>"0");
	echo json_encode($out);
	exit();
	}

//===========================================================================================


$apprv_checkq = "SELECT * FROM submissions WHERE approval_code = '".mysql_real_escape_string($approval_code, $conn)."' LIMIT 1";

$apprvq_res = mysql_query($apprv_checkq, $conn) or die(mysql_error());

if (mysql_num_rows($apprvq_res) > 0){
	$out = array("message"=>"exists", "status"=>"1");
		echo json_encode($out);
		exit();
	}

//If we get up to here, it means we can persist it

$admi = mysql_real_escape_string($admi, $conn);
$amount = mysql_real_escape_string($amount, $conn);
$sender = mysql_real_escape_string($sender, $conn);
$approval_code = mysql_real_escape_string($approval_code, $conn);
$new_balance = mysql_real_escape_string($new_balance, $conn);
$time_sms_got_in = mysql_real_escape_string($time_sms_got_in, $conn);

$add_submission_q = "INSERT INTO submissions (admi, amount, sender, approval_code, new_balance, time_sms_got_in) VALUES ('".$admi."', '".$amount."', '".$sender."', '".$approval_code."', '".$new_balance."', '".$time_sms_got_in."')";

mysql_query($add_submission_q, $conn);

//create transfer/submission associative array
$submission = array("admi" => $admi, "amount"=>$amount, "sender"=>$sender, "approval_code"=>$approval_code, "new_balance"=>$new_balance, "time_sms_got_in"=>$time_sms_got_in);

handle_successful_transfer($submission, $conn);

$out = array("message"=>"submitted", "status"=>"1");
echo json_encode($out);

//in the future, we'd check the number's prefs and add to pending if they said we only top up their number. ryt now binu does it
	
function log_dema($req, $conn){
	if (LOG_EVENTS ==true){
		mysql_query("INSERT INTO loga(yaya) VALUES('".mysql_real_escape_string(json_encode($req), $conn)."')", $conn);
	}
	return;	
	
}
?>