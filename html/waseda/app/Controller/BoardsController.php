<?php

class BoardsController extends AppController{
    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE

    public $uses=["Board","Comment"];
    
    public function index($id=1){
        $this->redirect(["action"=>"view"]);
    }

    public function view($id=1){
        $this->set('board_base',$this->Board->find("first",["conditions"=>["Board.id"=>$id,], "recursive"=>1, "fields"=>["*"] ]));
        $this->set('boards',$this->Board->find("all",["order"=>"Board.modified desc","conditions"=>["Board.to_board_id"=>$id,], "recursive"=>-1, "fields"=>["*"] ]));
        $this->set("comments",$this->Comment->find("all",["order"=>"Comment.created desc", "conditions"=>["Comment.to_board_id"=>$id], "recursive"=>0, "fields"=>["Comment.*","User.name","User.id"] ]));
    }

    public function add($toId=null){

        if($this->request->is("get")){
            $this->set("toId",$toId);
        }else if($this->request->is('post')){
            if($toId!=$this->request->data["Board"]["to_board_id"] || $toId==null){
                $this->Flash->error("Error!");//保存成功
                return $this->redirect(["action"=>"view"],$toId);
            }

            if($this->Board->save($this->request->data)){
                //to update "modified" of board
                $i=0; $nowId=$toId;
                while(1){
                    $newId=$this->Board->findById($nowId)["Board"]["to_board_id"];
                    $this->Board->save([ "Board"=>["id"=>$nowId] ]); 

                    if($nowId==$newId){ break; }
                    else{ $nowId=$newId; }

                    if($i>30){ $this->Flash->error("Error! infinite loop happen :(");  break; }
                    else{$i++;}
                }
                
                $this->Flash->success("Success!");//保存成功
                return $this->redirect(["controller"=>"boards","action"=>"view",$toId]);
            }else{
                $this->Flash->error("Failed!");//保存失敗
                return $this->redirect(["controller"=>"boards","action"=>"view",$toId]);
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