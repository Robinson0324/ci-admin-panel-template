<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 9/30/14
 * Time: 2:53 AM
 */

/**
 * Database related configuration
*/

$CI = & get_instance();
//Database settings
define("DB_HOST",$CI->db->hostname);
define("DB_NAME",$CI->db->database);
define("DB_USER",$CI->db->username);
define("DB_PASSWORD",$CI->db->password);
//Custom tables
define("DB_USER_TABLE","member_tb");
//Mailing configure
define("MAIL_HOST", 'smtp.gmail.com');
define("MAIL_PORT", 587);
define("MAIL_SMTP_SECURE", 'tls');
define("MAIL_OWNER_ADDR", "amazontopmaster@gmail.com");
define("MAIL_PASSWORD", "7wQXxJ4s76uY6UU");
define("MAIL_FROM_USER_ADDR", 'support@mail.com');
define("MAIL_FROM_USER_NAME", 'Amazon Service Team');

/***************************
 * Require custom handlers
 **************************/
require_once __DIR__.'/lib/DatatableHandler.php';
require_once __DIR__.'/lib/UploadHandler.php';

require_once __DIR__.'/lib/ResearchHandler.php';
require_once __DIR__.'/lib/InventoryHandler.php';
require_once __DIR__.'/lib/OrdersHandler.php';
require_once __DIR__.'/lib/SettingHandler.php';
require_once __DIR__.'/lib/TransactionsHandler.php';
require_once __DIR__.'/lib/RansomlistHandler.php';
require_once __DIR__.'/lib/JobHandler.php';
require_once __DIR__.'/lib/TutorHandler.php';
require_once __DIR__.'/lib/SubjectHandler.php';
require_once __DIR__.'/lib/BookingHandler.php';
require_once __DIR__.'/lib/ProfileHandler.php';
require_once __DIR__.'/lib/ChattingHandler.php';
function getDatabaseEnv(){

    return array('master' => array('host' => 'fifthlocal.mysql.rds.aliyuncs.com',
        'db'   => 'echujifa_test',
        'id'   => 'the5thmedia_test',
        'pass' => 'the_5th_media_test'),
        'slave' => array('host' => 'fifthlocal.mysql.rds.aliyuncs.com',
            'db'   => 'echujifa_test',
            'id'   => 'the5thmedia_test',
            'pass' => 'the_5th_media_test'),
        'sms'    => array('host' => '',
            'db'   => '',
            'id'   => '',
            'pass' => ''),
        'prefix' => 'tbl_',
        'log_db' => 'echujifa_log_test');
}