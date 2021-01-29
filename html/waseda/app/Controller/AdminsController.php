<?php

/*
$ret = $this->query('UPDATE users SET point = point + ? WHERE id = ?', array($point, $user_id)); 直接SQL文書ける。SQL発行回数減らす時に使えそう？saveは便利だけどSQL発行回数が多い http://damepg.hatenablog.com/entry/2012/09/08/134126
*/

class AdminsController extends AppController{

    //auth
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow("index");
    }
    public function isAuthorized($user)
    {        
        return parent::isAuthorized($user);
    }

    public $uses=array("User","Profile","Gpa","Faculty","School","Department","FacultySchool","SchoolDepartment","AvailableDepartmentSelection","UserDepartmentSelection");//model 指定 AvailableDepartmentSelection, User

    //public $scaffold;//localhost/blog/postsでもう管理画面みたいなのが既にできてる。でもこれだとカスタマイズはできないよね〜〜
    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE

    public function index(){
        
    }

    /* See user index */
    public function user(){
        $this->set('users',$this->User->find('all',array('order' => 'user.id asc','recursive'=>'2', "fields"=>"*" , "joins"=>[ ["table"=>"gpas","alias"=>"Gpa","type"=>"left","conditions"=>["User.id=Gpa.id"]], ] )) ); //left join gpa
    }

    /* Edit User Imformation */
    public function userEdit($id=null){ //path is "user_edit"
        if (/*!isset($this->request->data) || */$id==null) { 
            $this->Flash->error('parameter needed');
            return $this->redirect(array('action' => 'index'));  
        }

        //debug($this->request->data);

        if($this->request->is('get')){ /*GET*/
            $this->set('faculties',$this->Faculty->find('all',array('order' => 'Faculty.faculty asc')) );
            
            $data=$this->User->find("first",['order' => 'user.id asc','recursive'=>'2', 'conditions'=>"User.id=".$id , "fields"=>"*" , "joins"=>[ ["table"=>"gpas","alias"=>"Gpa","type"=>"left","conditions"=>["User.id=Gpa.id"]], ] ] );
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
                //debug($this->request->data);
                return;
            }
            
            //error: 
            //if($id==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');


            /*
            //when handle image as input image file
            //I decided to send imageDataURL, so I don't need to do this action.
            if(!empty($this->request->data["Profile"]["image"]["tmp_name"])){ //image set
                //debug($this->request->data["Profile"]);
                $this->request->data["Profile"]["image"]=file_get_contents($this->request->data["Profile"]["image"]["tmp_name"]);
            }else{//画像が未選択の場合元のまま or なし
                $image=$this->User->Profile->findByUserId($id)["Profile"]["image"];
                if(!empty($image)){
                    $this->request->data["Profile"]["image"]=$image;
                }else{
                    $this->request->data["Profile"]["image"]="";
                }
            }*/

            $saved1=$this->User->saveAssociated($this->request->data); //これか下のコメントアウトかどちらか
            $saved2=$this->Gpa->save($this->request->data);

            if (!empty($saved1) && !empty($saved2)) { 
                $this->Flash->success('edit success!');
                return $this->redirect(array('action' => 'userEdit',$id));  
            }else{
                $this->Flash->error('edit Failed');
                return $this->redirect(array('action' => 'index'));  
            }
        } 
    }


    //see Department index
    public function department() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('departments',$this->Department->find('all',array('order' => 'Department.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            //if($this->request->data["Department"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["Department"]["delete"]==true){ //delete
                $delete=$this->Department->delete($this->request->data["Department"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'Department'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'Department'));  
                }
            }else{
                $saved=$this->Department->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'Department'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'Department'));  
                }
            }  
        } 
    }

    //see School index
    public function school() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('schools',$this->School->find('all',array('order' => 'School.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            //if($this->request->data["School"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["School"]["delete"]==true){ //delete
                $delete=$this->School->delete($this->request->data["School"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'school'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'school'));  
                }
            }else{ //save
                $saved=$this->School->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'school'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'school'));  
                }
            }   
        }  
    }

    //see Faculty index
    public function faculty() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('faculties',$this->Faculty->find('all',array('order' => 'Faculty.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            //if($this->request->data["Faculty"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["Faculty"]["delete"]==true){ //delete
                $delete=$this->Faculty->delete($this->request->data["Faculty"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'faculty'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'faculty'));  
                }
            }else{ //save
                $saved=$this->Faculty->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'faculty'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'faculty'));  
                }
            }   
        }  
    }
    
    //see AvailableDepartmentSelection index
    public function availableDepartmentSelection() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('departments',$this->Department->find('all',array('order' => 'Department.department asc')) );
            $this->set('schools',$this->School->find('all',array('order' => 'School.school asc')) );
            $this->set('availableDepartmentSelections',$this->AvailableDepartmentSelection->find('all',array('order' => 'AvailableDepartmentSelection.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            //if($this->request->data["AvailableDepartmentSelection"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["AvailableDepartmentSelection"]["delete"]==true){
                $delete=$this->AvailableDepartmentSelection->delete($this->request->data["AvailableDepartmentSelection"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'availableDepartmentSelection'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'availableDepartmentSelection'));  
                }
            }else{
                $saved=$this->AvailableDepartmentSelection->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'availableDepartmentSelection'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'availableDepartmentSelection'));  
                }
            }
            
        }  
    }


    //see schoolDepartment index
    public function schoolDepartment() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('schools',$this->School->find('all',array('order' => 'School.school asc')) );
            $this->set('departments',$this->Department->find('all',array('order' => 'Department.department asc')) );
            $this->set('schoolDepartments',$this->SchoolDepartment->find('all',array('order' => 'SchoolDepartment.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            //if($this->request->data["SchoolDepartment"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["SchoolDepartment"]["delete"]==true){
                $delete=$this->SchoolDepartment->delete($this->request->data["SchoolDepartment"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'SchoolDepartment'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'schoolDepartment'));  
                }
            }else{
                $saved=$this->SchoolDepartment->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'schoolDepartment'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'schoolDepartment'));  
                }
            }   
        }  
    }

    //see facultySchool index
    public function facultySchool() {
        /* GET */
        if ($this->request->is('get')){
            $this->set('faculties',$this->Faculty->find('all',array('order' => 'Faculty.faculty asc')) );
            $this->set('schools',$this->School->find('all',array('order' => 'School.school asc')) );
            $this->set('facultySchools',$this->FacultySchool->find('all',array('order' => 'FacultySchool.id asc')) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            //if($this->request->data["FacultySchool"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["FacultySchool"]["delete"]==true){
                $delete=$this->FacultySchool->delete($this->request->data["FacultySchool"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'facultySchool'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'facultySchool'));  
                }
            }else{
                $saved=$this->FacultySchool->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'facultySchool'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'facultySchool'));  
                }
            }   
        }  
    }

    //see userDepartmentSelections index
    public function userDepartmentSelection() {
        /* GET */
        if ($this->request->is('get')){
            //$this->set('departments',$this->Department->find('all',array('order' => 'Department.department asc')) );
            $this->set('availableDepartmentSelections',$this->AvailableDepartmentSelection->find('all',array('order' => 'AvailableDepartmentSelection.id asc','recursive'=>1)) );
            $this->set('userDepartmentSelections',$this->UserDepartmentSelection->find('all',array('order' => 'UserDepartmentSelection.id asc','recursive'=>1)) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
            //if($this->request->data["UserDepartmentSelection"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["UserDepartmentSelection"]["delete"]==true){
                $delete=$this->UserDepartmentSelection->delete($this->request->data["UserDepartmentSelection"]["id"]);
                if (!empty($delete)) { 
                    $this->Flash->success('delete success!');
                    return $this->redirect(array('action' => 'userDepartmentSelection'));  
                }else{
                    $this->Flash->error('delete Failed');
                    return $this->redirect(array('action' => 'userDepartmentSelection'));  
                }
            }else{
                $saved=$this->UserDepartmentSelection->save($this->request->data); //これか下のコメントアウトかどちらか
                if (!empty($saved)) { 
                    $this->Flash->success('change success!');
                    return $this->redirect(array('action' => 'userDepartmentSelection'));  
                }else{
                    $this->Flash->error('change Failed');
                    return $this->redirect(array('action' => 'userDepartmentSelection'));  
                }
            }   
        }  
    }

    public function LimitedSchools(){ //for Ajax //need faculty_id
        $this->autoRender=false;
        if ($this->request->is('ajax')){
            $data=json_encode($this->FacultySchool->find('all',array('fields'=>['School.id','School.school'],'conditions'=>['FacultySchool.faculty_id'=>$this->request->query["faculty_id"]],'order' => 'School.school asc','recursive'=>2)) );
            //debug($data);
            return $data;
        }else{
            return $this->Flash->error("error");
        }
    }

    public function LimitedDepartments(){ //for ajax //need school_id
        $this->autoRender=false;
        if ($this->request->is('ajax')){
            $data=json_encode($this->SchoolDepartment->find('all',array('fields'=>['Department.id','Department.department'],'conditions'=>['SchoolDepartment.school_id'=>$this->request->query["school_id"]],'order' => 'Department.department asc','recursive'=>2)) );
            //debug($data);
            return $data;
        }else{
            return $this->Flash->error("error");
        }
    }

}

?>