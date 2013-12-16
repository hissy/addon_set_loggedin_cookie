<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class SetLoggedinCookiePackage extends Package {
   
    protected $pkgHandle = 'set_loggedin_cookie';
    protected $appVersionRequired = '5.6.2';
    protected $pkgVersion = '0.0.1';

    public function getPackageDescription() {
        return t('Set additional cookie when user is logged in, for reverse proxy.');
    }

    public function getPackageName() {
        return t('Set LoggedIn Cookie');
    }
	
	public function on_start() {
		Events::extend('on_before_render', __CLASS__, 'addLoggedInCookie', __FILE__);
	}
	
	public function addLoggedInCookie($view) {
		$u = new User();
		if($u->isLoggedIn()) {
			setcookie('ccmUserIsLoggedIn', true, 0);
		} else {
			setcookie('ccmUserIsLoggedIn', NULL, -1);
			unset($_COOKIE['ccmUserIsLoggedIn']);
		}
	}

}