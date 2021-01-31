<?php

App::uses('AppController', 'Controller');

class BoardUsersController extends AppController{

    //auth
    public function beforeFilter() {
        parent::beforeFilter();
    }
    public function isAuthorized($user)
    {        
        if($this->request->is("post")){ //POST
            if( in_array($this->action, ["add",]) ){
                if($this->request->data["BoardUser"]["user_id"]===$user["id"]){
                    return true;
                } 
            } 
            if( in_array($this->action, ["delete",]) ){
                if( $this->request->data["BoardUser"]["user_id"]===$user["id"] ){
                    return true;
                } 
            } 
        }else if($this->request->is("get")){ //POST
            if( in_array($this->action, ["user",]) ){ 
                $user_id=(int)$this->request->params["pass"]?$this->request->params["pass"][0]:null; //0番目のパラメータ引数
                if($user_id===$user["id"]){
                    return true;
                } 
            } 
            if( in_array($this->action, ["board",]) ){
                return true;
            } 
        }
        return parent::isAuthorized($user);
    }


    public $helpers = array("Html","Form");//htmlと入力formをこれから扱うZE
    public $uses=["BoardUser","Board","User" ];
   
    public function add(){
        if($this->request->is('post')){
            if($this->BoardUser->save($this->request->data)){
                $this->Flash->success("Success!");//保存成功
                return $this->redirect(["controller"=>"Boards","action"=>"view",$this->request->data["BoardUser"]["board_id"]]);
            }else{
                $this->Flash->error("Failed!");//保存失敗
            }
        }
    }

    public function board($id=null){
        if($this->request->is("get")){
            $this->set("board", $this->Board->find("first",["conditions"=>["Board.id"=>$id ], "recursive"=>1, "fields"=>["Board.*","User.id","User.username"] ]));
            $this->set("users", $this->BoardUser->find("all",["conditions"=>["BoardUser.board_id"=>$id], "fields"=>["User.id","User.username"]]) );
        }
    }

    public function user($id=null){
        if($this->request->is("get")){
            $this->set("user", $this->User->find("first",["conditions"=>["User.id"=>$id,], "fields"=>["User.id","User.username"], "recursive"=>"-1" ] ));
            $this->set("boards", $this->BoardUser->find("all",["order"=>"Board.modified desc","conditions"=>["BoardUser.user_id"=>$id], "fields"=>["Board.*"]]) );
        }
    }

    public function delete(){
        if($this->request->is('post')){
            $delete_id=$this->BoardUser->find("first",["conditions"=>["user_id"=>$this->request->data["BoardUser"]["user_id"], "board_id"=>$this->request->data["BoardUser"]["board_id"],],"fields"=>["BoardUser.id"], "recursive"=>-1 ])["BoardUser"]["id"];
            if($this->BoardUser->delete($delete_id)){
                $this->Flash->success("Success!");//保存成功
                return $this->redirect(["controller"=>"Boards","action"=>"view",$this->request->data["BoardUser"]["board_id"]]);
            }else{
                $this->Flash->error("Failed!");//保存失敗
                return $this->redirect(["controller"=>"Boards","action"=>"view",$this->request->data["BoardUser"]["board_id"]]);
            }
        }
    }

}

?>