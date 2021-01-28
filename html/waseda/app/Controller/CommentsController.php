<?php

App::uses('AppController', 'Controller');

class CommentsController extends AppController{

    //auth
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE
    public $uses=["Comment","Board"];
   
    public function add($to_board_id=null){
        if($this->request->is("get")){
            $this->set("login_id", $this->Auth->user("id") );
            $this->set("to_board_id", $to_board_id );

        }else if($this->request->is('post')){
            if($to_board_id!=$this->request->data["Comment"]["to_board_id"] || $to_board_id==null){
                $this->Flash->error("Error!");
                return $this->redirect(["action"=>"view"],$to_board_id);
            }

            if($this->request->data["Comment"]["user_id"]!=$this->Auth->user("id")){
                $this->Flash->error("error: invalid user id.");
                return $this->redirect(["action"=>"view"],$to_board_id);
            }

            if($this->Comment->save($this->request->data)){
                //to update "modified" of board
                $i=0; $nowId=$to_board_id;
                while(1){
                    $newId=$this->Board->findById($to_board_id)["Board"]["to_board_id"];
                    $this->Board->save([ "Board"=>["id"=>$to_board_id] ]); 

                    if($nowId==$newId){ break; }
                    else{ $nowId=$newId; }

                    if($i>30){ $this->Flash->error("Error! infinite loop happen :(");  break; }
                    else{$i++;}
                }

                $this->Flash->success("Success!");//保存成功
                return $this->redirect(array("controller"=>"boards","action"=>"view",$this->data["Comment"]["to_board_id"]));
            }else{
                $this->Flash->error("Failed!");//保存失敗
            }
        }
    }

    /*
    public function delete($id=null){
        if($this->request->is("get")){
            throw new MethodNotAllowedException();
        }else if($this->request->is("ajax")){
            if($this->Comment->delete($id) ){
                $this->autoRender=false;
                $this->autoLayout=false;
                $response=array("id"=>$id);
                $this->header("Content-Type: application/json");
                echo json_encode($response);
                exit();
            }
            exit();
        }

        $this->redirect(["controller"=>"posts","action"=>"index"]);
    }*/
}

?>