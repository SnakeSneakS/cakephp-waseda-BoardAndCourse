<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    // sanitize all html characters 
    // referred to https://www.marineroad.com/staff-blog/3836.html
    // basiccaly sanitize everything. When you add $sanitize=false, don't sanitize
    public function set($var, $val = null, $sanitize = true) {
        if ($sanitize) {
            $val = $this->__sanitize($val);
        }
        return parent::set($var, $val);
    }

    private function __sanitize($dat) {
        if(is_array($dat)){
            foreach ($dat as $cnt => $val) {
                $dat[$cnt] = $this->__sanitize($val);
            }
            return $dat;
        }else{
            return htmlspecialchars($dat,ENT_QUOTES,"UTF-8");
        }
    }


    //Auth
    public $components = array(
        "Flash",
        "Auth" => array(
            "authError"=>"アクセス権限を持っていません。",
            "loginRedirect" => array(
                "controller" => "users",
                "action" => "index"
            ),
            "logoutRedirect" => array(
                "controller" => "mains",
                "action" => "index",
                "home"
            ),
            "authenticate" => array(
                "Form" => array(
                    "fields"=>array(
                        "User"=>"username",
                        "User"=>"password", 
                    ),
                    "passwordHasher" => "Blowfish"
                )
                //"Basic","Digest" https://book.cakephp.org/2/ja/core-libraries/components/authentication.html
            ),
            "authorize" => array("Controller"),
        )
    );
    
    public function beforeFilter() {
        //$this->Auth->allow("index");
    }

    public function isAuthorized($user){
        //debug($user);
        //If you assign "admin" role, you must re-login to update $user
        return isset($user["role"]) && $user["role"]==="admin";
    }
}
