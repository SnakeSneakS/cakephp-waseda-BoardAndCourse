<?php


class MainsController extends AppController{
    //auth
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("index"); //ログイン不要
    }
    public function isAuthorized($user){
        return true;
        //return parent::isAuthorized($user);
    }

    public function index(){
        
    }
}