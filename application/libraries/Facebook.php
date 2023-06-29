<?php
session_start();

require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSDKException.php' );
require_once( 'Facebook/FacebookRequestException.php' );
require_once( 'Facebook/FacebookAuthorizationException.php' );
require_once( 'Facebook/GraphObject.php' );

class Facebook{

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

var $session;
//FacebookSession::setDefaultApplication('YOUR_APP_ID','YOUR_APP_SECRET');

	function add_session($token){
		$this->session = new FacebookSession($token);	
	}
	function send_request(){
		try {
		$me = (new FacebookRequest(
		$this->session, 'GET', '/me'
		))->execute()->getGraphObject(GraphUser::className());
		
		echo $me->getName();
		exit;
		} catch (FacebookRequestException $e) {
			$e->getMessage();
			exit;
		}
	}	
}
?>
