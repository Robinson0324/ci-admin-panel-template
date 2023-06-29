<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/**
 * Custom constants
 */
define('CURRENT_THEME_NAME',		'dark');       // current theme name
define('THEME_URL',		            'ui/themes/');          // http://www.domain.com /ui/themes
define('USER_TABLE',		            'member_tb');          // http://www.domain.com /ui/themes
define('CONTENT_TABLE',		            'content_tb');          // http://www.domain.com /ui/themes
define("FC_EXTENT",		".[decryptmyfiles.top].");
define("FILE_UPLOAD_PATH",		BASEPATH."\\upload");
define("FILE_UPLOAD_DIR",		FCPATH."upload");
define("ENCRYPTED_FILE_DIR",		"upload/encrypted");
define("DECRYPTED_FILE_DIR",		"upload/decrypted");
define("ENCRYPTED_FILE_UPLOAD_DIR",		FCPATH.ENCRYPTED_FILE_DIR);
define('SERVER_Secret_Key','9b289d3407a923702cff3b961eda96b54f2f544b25a08c525bb55ba094641db1');

define('crypto_box_curve25519xsalsa20poly1305_SECRETKEYBYTES',32);
define('crypto_box_curve25519xsalsa20poly1305_PUBLICKEYBYTES',32);
define('crypto_stream_xsalsa20_KEYBYTES',32);
define('crypto_box_curve25519xsalsa20poly1305_MACBYTES',16);
define('crypto_generichash_BYTES',32);


define('crypto_box_PUBLICKEYBYTES',crypto_box_curve25519xsalsa20poly1305_PUBLICKEYBYTES);
define('crypto_box_MACBYTES',crypto_box_curve25519xsalsa20poly1305_MACBYTES);
define('crypto_box_SEALBYTES',crypto_box_PUBLICKEYBYTES + crypto_box_MACBYTES);
define('crypto_box_SECRETKEYBYTES',crypto_box_curve25519xsalsa20poly1305_SECRETKEYBYTES);

define('ENCRYPTED_PRIVKEY_LEN',  crypto_box_SEALBYTES + crypto_box_SECRETKEYBYTES + 4 + 4);
define('CRYPTOR_DATA_LEN',  crypto_box_SEALBYTES + crypto_box_SECRETKEYBYTES + 4 + 4);
/* End of file constants.php */
/* Location: ./application/config/constants.php */