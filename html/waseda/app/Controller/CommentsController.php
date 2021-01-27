<?php

class CommentsController extends AppController{
    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE
    public $uses=["Comment","Board"];
   
    public function add($toId=null){
        if($this->request->is("get")){
            $this->set("toId",$toId);
        }else if($this->request->is('post')){
            if($toId!=$this->request->data["Comment"]["to_board_id"] || $toId==null){
                $this->Flash->error("Error!");//保存成功
                return $this->redirect(["action"=>"view"],$toId);
            }

            if($this->Comment->save($this->request->data)){
                //to update "modified" of board
                $i=0; $nowId=$toId;
                while(1){
                    $newId=$this->Board->findById($toId)["Board"]["to_board_id"];
                    $this->Board->save([ "Board"=>["id"=>$toId] ]); 

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