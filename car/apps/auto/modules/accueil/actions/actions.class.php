<?php

/**
 * accueil actions.
 *
 * @package    car
 * @subpackage accueil
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accueilActions extends sfActions
{
        /**
        * Executes index action
        *
        * @param sfRequest $request A request object
        */
        public function executeIndex(sfWebRequest $request)
        {
            /***
             * ADDED BY ZER TO SET COUNTRY FROM ADDR IP
             */            
            $this->pays = Country::getCoutryByIpGeoLoca();            
            //$this->pays = Country::getCoutryByIp();
            $this->getUser()->setAttribute(Constantes::SESSION_PAYS_ID, $this->pays);
            /***
             * END SET COUNTRY
             */
        }

        public function executeLogin(sfWebRequest $request) {
                $user = CarAuto::getUser ( $request->getParameter ( 'login' ), $request->getParameter ( 'password' ) );

                if ($user != NULL) {
                        $this->getUser ()->setAttribute ( Constantes::SESSION_USER_CONNECTED, $user );
                        $this->getUser ()->setAttribute ( 'user_id', $user->getId (), 'sfGuardSecurityUser' );
                        $this->getUser ()->setAuthenticated ( true );
                        $this->getUser ()->clearCredentials ();
                        $this->getUser ()->addCredentials ( $user->getAllPermissionNames () );
                        $user->setLastLogin ( date ( 'Y-m-d h:i:s' ) );
                        $user->save ();
                        if($request->getParameter("remember_me")=="1")
                              $remember = TRUE;
                        // remember?
                        if ($remember)
                        {
                          $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);

                          // remove old keys
                          Doctrine::getTable('sfGuardRememberKey')->createQuery()
                            ->delete()
                            ->where('created_at < ?', date('Y-m-d H:i:s', time() - $expiration_age))
                            ->execute();

                          // remove other keys from this user
                          Doctrine::getTable('sfGuardRememberKey')->createQuery()
                            ->delete()
                            ->where('user_id = ?', $user->getId())
                            ->execute();

                          // generate new keys
                          $key = CarAuto::generateRandomKey();

                          // save key
                          $rk = new sfGuardRememberKey();
                          $rk->setRememberKey($key);
                          $rk->setsfGuardUser($user);
                          $rk->setIpAddress($_SERVER['REMOTE_ADDR']);
                          $rk->save($con);

                          // make key as a cookie
                          $remember_cookie = sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember');
                          sfContext::getInstance()->getResponse()->setCookie($remember_cookie, $key, time() + $expiration_age);
                          sfContext::getInstance ()->getResponse ()->setCookie ( Constantes::COOKIE_REMEMBER_CHECKED, 'true', time () + $expiration_age );
                        }else{
                            $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);
                            sfContext::getInstance ()->getResponse ()->setCookie ( Constantes::COOKIE_REMEMBER_CHECKED, '', time () - $expiration_age );
                        }
                }
                //$this->redirect ( $this->getUser ()->getAttribute ( Constantes::LASTMODULENAME ) . '/' . $this->getUser ()->getAttribute ( Constantes::LASTACTIONNAME ) );
                $this->redirect ($request->getReferer());
        }

        public function executeLogout(sfWebRequest $request) {

                //$this->getAttributeHolder()->removeNamespace('sfGuardSecurityUser');                
                
                $this->getUser ()->setAttribute ( 'user_id', NULL, 'sfGuardSecurityUser' );
                $this->getUser ()->clearCredentials ();
                $this->getUser ()->setAuthenticated ( false );
                $expiration_age = sfConfig::get ( 'app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600 );
                $remember_cookie = sfConfig::get ( 'app_sf_guard_plugin_remember_cookie_name', 'sfRemember' );
                sfContext::getInstance ()->getResponse ()->setCookie ( $remember_cookie, '', time () - $expiration_age );

                $signout_url = sfConfig::get ( 'app_sf_guard_plugin_success_signout_url', $request->getReferer () );

                $this->redirect ( '@homepage' );

        }
}
