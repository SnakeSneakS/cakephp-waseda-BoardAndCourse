<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController{

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','login');
    }

    public $uses=array("User","Faculty","FacultySchool","SchoolDepartment");//model 指定 AvailableDepartmentSelection, User

    public $helpers = array('Html','Form');

    public function login(){
        if($this->request->is("get")){
            if($this->Auth->login()) {
                $this->Flash->success("ログイン済み");
                return $this->redirect($this->Auth->redirectUrl());
            }
        }else if ($this->request->is('post')) {
            if($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }else {
                return $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }

    public function logout(){
        $this->Flash->success("ログアウトしました");
        return $this->redirect($this->Auth->logout());
    }

    public function index(){
        /*if($this->Auth->login()){
            $this->Flash->error("ログイン済みです");
            return $this->redirect(["action"=>"view"]);
        }*/
    }

    public function add(){
        if($this->Auth->login()){
            $this->Flash->success("ログイン済み");
            return $this->Auth->redirectUrl();
        }

        if($this->request->is("post")){
            $this->User->create();
            if($this->User->save($this->request->data)){
                return $this->redirect(["action"=>"view",$this->User->id]);
            }else{
                $this->Flash->error("The user cloudn't be saved, try again.");
            }
            
        }
    }

    public function view($id=null){
        if($this->request->is('get')){ /*GET*/
            if($id==null){
                $this->Flash->error("user id can't be null");
                return;
            }

            $data=$this->User->find("first",["conditions"=>["User.id"=>$id],"recursive"=>2,"fields"=>["User.id","User.username","Profile.enter_year","Profile.comment","Profile.image","Profile.faculty_id","Profile.school_id","Profile.department_id"]]);
            if($data){
                $this->Flash->success('Load data success!');
                $this->set('user',$data); //$this->User->find('first',array("conditions"=>array("User.id"=>$id)) でも良い 
            }else{
                $this->Flash->error('load Failed');
                return $this->redirect(array('action' => 'index')); 
                //throw new NotFoundException(__('Invalid user'));
            }
        }
    }

    /* Edit User Imformation */
    public function edit($id=-1){ //path is "user_edit"
        if ($id==null) { 
            $this->Flash->error('error: argument was not set...');
            return $this->redirect(array('action' => 'index'));  
        }

        if($this->request->is('get')){ /*GET*/
            $data=$this->User->find("first",["conditions"=>["User.id"=>$id],"recursive"=>2]);
            $this->set("faculties",$this->Faculty->find("all"));

            if($data){
                $this->Flash->success('Load data success!');
                $this->set('user',$data); //$this->User->find('first',array("conditions"=>array("User.id"=>$id)) でも良い 
            }else{
                $this->Flash->error('user not cound');
                return $this->redirect(['action' => 'view',$id]); 
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

            $saved=$this->User->saveAssociated($this->request->data); //これか下のコメントアウトかどちらか
            /*
            //another way
            $user=$this->User->save($this->request->data);
            if(!empty($user)){
                if($this->User->Profile->save($this->request->data)){
                    $this->Flash->success('edit Profile success!');
                }else{
                    $this->Flash->error('edit Profile failed!');
                }
            }*/

            if (!empty($saved)) { 
                $this->Flash->success('edit success!');
                return $this->redirect(array('action' => 'view',$id));  
            }else{
                $this->Flash->error('edit Failed');
                return $this->redirect(array('action' => 'index'));  
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