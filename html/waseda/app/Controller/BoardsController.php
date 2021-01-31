<?php

App::uses('AppController', 'Controller');

class BoardsController extends AppController{

    //auth
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("index","view");
    }
    public function isAuthorized($user)
    {        
        if($this->request->is("post")){ //POST
            //add board - [all login user]
            if( in_array($this->action, ["add"]) ){
                return true;
            }
            
        }else if($this->request->is("get")){ //GET
            //add board - [all login user]
            if( in_array($this->action, ["add"]) ){
                return true;
            }
        }
        return parent::isAuthorized($user);
    }


    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE

    public $uses=["Board","Comment","BoardUser",];
    
    public function index(){
        $this->redirect(["action"=>"view"]);
    }

    public function view($id=1){
        if($this->request->is("get")){
            $base_board=$this->Board->find("first",["conditions"=>["Board.id"=>$id,], "recursive"=>1, "fields"=>["Board.*","ToBoard.*","User.id","User.username","User.role"] ]);
            if($base_board){
                $this->set("login_id",$this->Auth->user("id")?$this->Auth->user("id"):null);
                $this->set("board_base",$base_board);
                $this->set("boards",$this->Board->find("all",["order"=>"Board.modified desc","conditions"=>["Board.to_board_id"=>$id,], "recursive"=>-1, "fields"=>["Board.*"] ]));
                $this->set("comments",$this->Comment->find("all",["order"=>"Comment.created desc", "conditions"=>["Comment.to_board_id"=>$id], "recursive"=>1, "fields"=>["Comment.*","User.username","User.id","User.role"] ]));
                $this->set("board_user",$this->BoardUser->find("first",["conditions"=>["BoardUser.board_id"=>$id,"BoardUser.user_id"=>$this->Auth->user("id")?$this->Auth->user("id"):null,], "recursive"=>-1, ] ));
            }else{
                $this->Flash->error("invalid board");
                return $this->redirect(["action"=>"view",1]);
            }
        }
    }

    public function add($to_board_id=null){
        if($this->request->is("get")){
            $this->set("login_id",$this->Auth->user("id") ); 
            $this->set("to_board_id",$to_board_id ); 
             
        }else if($this->request->is('post')){

            if($to_board_id!=$this->request->data["Board"]["to_board_id"] || $to_board_id==null){
                $this->Flash->error("Error: invalid board id!");
                return $this->redirect(["action"=>"view"],$to_board_id);
            }

            if($this->request->data["Board"]["user_id"] != $this->Auth->user("id")){
                $this->Flash->error("Error: invalid user id!");
                return $this->redirect(["action"=>"view"],$to_board_id);
            }

            if($this->Board->save($this->request->data)){
                //to update "modified" of board
                $i=0; $nowId=$to_board_id;
                while(1){
                    $newId=$this->Board->findById($nowId)["Board"]["to_board_id"];
                    $this->Board->save([ "Board"=>["id"=>$nowId] ]); 

                    if($nowId==$newId){ break; }
                    else{ $nowId=$newId; }

                    if($i>30){ $this->Flash->error("Error! infinite loop happen :(");  break; }
                    else{$i++;}
                }
                
                $this->Flash->success("Success!");//保存成功
                return $this->redirect(["controller"=>"boards","action"=>"view",$to_board_id]);
            }else{
                $this->Flash->error("Failed!");//保存失敗
                return $this->redirect(["controller"=>"boards","action"=>"view",$to_board_id]);
            }
        }
        //$this->set('post',$this->Post->find('all'));
    }

    /*
    public function edit($id=null){
        $this->Post->id=$id;
        $this->set("categories",$this->Category->find("list",["fields"=>["id","name"]]));


        if($this->request->is("get")){
            $this->set("categories",$this->Category->find("list"));
            $this->request->data=$this->Post->read(); //formの各inputの値にsetする
        }else{
            if($this->Post->save($this->request->data)){
                $this->Session->setFlash("success!");
                $this->redirect(["action"=>"index"]);
            }else{
                $this->Session->setFlash("failed!");
            }
        }
    }

    public function delete($id=null){
        if($this->request->is("get")){
            throw new MethodNotAllowedException();
        }else if($this->request->is("ajax")){
            if($this->Post->delete($id) ){
                $this->autoRender=false;
                $this->autoLayout=false;
                $response=array("id"=>$id);
                $this->header("Content-Type: application/json");
                echo json_encode($response);
                //$this->redirect(["action"=>"index"]);
            }
            exit();
        }

        $this->redirect(["action"=>"index"]);
    }
    */
}

?>