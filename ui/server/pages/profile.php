<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:23 PM
 *
 * Inventory management
 */



switch($action){
    case 'save_profile':
        require_once __DIR__."/../config.php";

        $profile_handler = new ProfileHandler($user_data);
        $profile_handler->save_profile($data);
        break;
    case 'update_avatar':
        require_once __DIR__."/../config.php";

        $profile_handler = new ProfileHandler($user_data);
        $profile_handler->update_avatar($data);
        break;
    case 'change_password':
        require_once __DIR__."/../user_manage.php";
        $usermanager = new UserManagement();
        $usermanager->change_password($data , $user_data);
        break;
    case 'request_budget':
        require_once __DIR__."/../config.php";

        $profile_handler = new ProfileHandler($user_data);
        $profile_handler->request_budget($data);
        break;
}