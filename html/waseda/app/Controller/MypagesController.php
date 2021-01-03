<?php

class MypagesController extends AppController{

    public $uses=array("User");//model 指定 CourseSelection, User

    //public $scaffold;//localhost/blog/postsでもう管理画面みたいなのが既にできてる。でもこれだとカスタマイズはできないよね〜〜
    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE

    public function index(){
        /*$params = array(
            'order' => 'modified desc',//ORDER BY 'modified' DESC
            'limit' => 2 //何件検索するか
            //他にもいろいろなパラメータあり https://api.cakephp.org/2.10/class-Model.html#_find
        );*/
        $this->set('users',$this->User->find('all',array('order' => 'user.id asc','recursive'=>'2')) );//recursiveによって誰だけ深くまでfindするか決める
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data/*["User"]*/)) { //table名とformの名前が等しい時はdata後の["${name}"]を省略できる?
                $this->Flash->success('The user has been saved');
                return $this->redirect(array('action' => 'index'));
            }else{
                //debug($this->User->validationErrors);
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
            
        }
    }

    public function edit($id=null){
        if (/*!isset($this->request->data) || */$id==null) { 
            $this->Flash->error('error: argument was not set...');
            return $this->redirect(array('action' => 'index'));  
        }

        //$this->request->data["Profile"]["user_id"]=$id;
        //debug($this->request->data);

        if($this->request->is('get')){ /*GET*/
            $data=$this->User->findById($id);
            if($data){
                $this->Flash->success('Load data success!');
                $this->set('user',$data); //$this->User->find('first',array("conditions"=>array("User.id"=>$id)) でも良い 
            }else{
                $this->Flash->error('load Failed');
                return $this->redirect(array('action' => 'index')); 
            }
        }else if ($this->request->is('post')) { /*POST*/
            //urlとdataが違う時、エラーを出して操作中止
            if($this->request->data["User"]["id"]!=$id){
                $this->Flash->error('error: $i ≠ data>User>id');
                debug($this->request->data);
                return;
            }
            
            //error: 
            if($id==0){
                $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
                //$this->Flash->error('error: '.$this->request->data["User"]["id"].' = '.$id);
                //$this->Flash->error('error: '.$this->request->data["User"]["id"]!=$id);
                return;   
            }

            if(!empty($this->request->data["Profile"]["image"]["tmp_name"])){ //image set
                debug($this->request->data["Profile"]);
                $this->request->data["Profile"]["image"]=file_get_contents($this->request->data["Profile"]["image"]["tmp_name"]);
            }else{//画像が未選択の場合元のまま or なし
                $image=$this->User->Profile->findByUserId($id)["Profile"]["image"];
                if(!empty($image)){
                    $this->request->data["Profile"]["image"]=$image;
                }else{
                    $this->request->data["Profile"]["image"]="";
                }
            }
            $saved=$this->User->saveAssociated($this->request->data); //これか下のコメントアウトかどちらか
            /*$user=$this->User->save($this->request->data);
            if(!empty($user)){
                if($this->User->Profile->save($this->request->data)){
                    $this->Flash->success('edit Profile success!');
                }else{
                    $this->Flash->error('edit Profile failed!');
                }
            }*/

            if (!empty($saved)) { 
                $this->Flash->success('edit success!');
                //return $this->redirect(array('action' => 'edit',$id));  
            }else{
                $this->Flash->error('edit Failed');
                return $this->redirect(array('action' => 'index'));  
            }
        } 
    }

}

?>