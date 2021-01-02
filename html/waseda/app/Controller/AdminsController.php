<?php

/*
$ret = $this->query('UPDATE users SET point = point + ? WHERE id = ?', array($point, $user_id)); 直接SQL文書ける。SQL発行回数減らす時に使えそう？saveは便利だけどSQL発行回数が多い http://damepg.hatenablog.com/entry/2012/09/08/134126
*/

class AdminsController extends AppController{

    public $uses=array("User","Course","Department","CourseSelection");//model 指定 CourseSelection, User

    //public $scaffold;//localhost/blog/postsでもう管理画面みたいなのが既にできてる。でもこれだとカスタマイズはできないよね〜〜
    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE

    public function index(){
        
    }

    /* See user index */
    public function user(){
        $this->set('users',$this->User->find('all',array('order' => 'user.id asc','recursive'=>'2')) );//recursiveによって誰だけ深くまでfindするか決める
    }

    /* Edit User Imformation */
    public function userEdit($id=null){ //path is "user_edit"
        if (/*!isset($this->request->data) || */$id==null) { 
            $this->Flash->error('error: argument was not set...');
            return $this->redirect(array('action' => 'index'));  
        }

        //$this->request->data["Grade"]["user_id"]=$id;
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

            if(!empty($this->request->data["Grade"]["image"]["tmp_name"])){ //image set
                debug($this->request->data["Grade"]);
                $this->request->data["Grade"]["image"]=file_get_contents($this->request->data["Grade"]["image"]["tmp_name"]);
            }else{//画像が未選択の場合元のまま or なし
                $image=$this->User->Grade->findByUserId($id)["Grade"]["image"];
                if(!empty($image)){
                    $this->request->data["Grade"]["image"]=$image;
                }else{
                    $this->request->data["Grade"]["image"]="";
                }
            }
            $saved=$this->User->saveAssociated($this->request->data); //これか下のコメントアウトかどちらか
            /*$user=$this->User->save($this->request->data);
            if(!empty($user)){
                if($this->User->Grade->save($this->request->data)){
                    $this->Flash->success('edit grade success!');
                }else{
                    $this->Flash->error('edit grade failed!');
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


    //see course index
    public function course() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('courses',$this->Course->find('all',array('order' => 'course.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            if($this->request->data["Course"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["Course"]["delete"]==true){ //delete
                $delete=$this->Course->delete($this->request->data["Course"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'course'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'course'));  
                }
            }else{
                $saved=$this->Course->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'course'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'course'));  
                }
            }  
        } 
    }

    //see department index
    public function department() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('departments',$this->Department->find('all',array('order' => 'department.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            if($this->request->data["Department"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["Department"]["delete"]==true){ //delete
                $delete=$this->Department->delete($this->request->data["Department"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'department'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'department'));  
                }
            }else{ //save
                $saved=$this->Department->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'department'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'department'));  
                }
            }   
        }  
    }
    
    //see courseSelection index
    public function courseSelection() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('courses',$this->Course->find('all',array('order' => 'Course.course asc')) );
            $this->set('departments',$this->Department->find('all',array('order' => 'Department.department asc')) );
            $this->set('courseSelections',$this->CourseSelection->find('all',array('order' => 'CourseSelection.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            if($this->request->data["CourseSelection"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["CourseSelection"]["delete"]==true){
                $delete=$this->CourseSelection->delete($this->request->data["CourseSelection"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'courseSelection'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'courseSelection'));  
                }
            }else{
                $saved=$this->courseSelection->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'courseSelection'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'courseSelection'));  
                }
            }
            
        }  
    }

}

?>