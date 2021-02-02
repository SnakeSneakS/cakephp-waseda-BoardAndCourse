<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController{

    //auth
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("login","logout","index","add","view"); //ログイン不要
    }
    //beforeFilterのAuth->allow以外で、isAuthorizedを突破した者のみアクセス許可
    public function isAuthorized($user){
        //debug($user);
        if($this->request->is("post")){
            //ban fields
            if($this->banFields($this->request->data,$user)){ return false; }

            //don't allow if [user is login] //to allow non-login user, must declare $this->Auth->allow & declare $this->isAuthorize in each [action function]
            if( in_array($this->action, ["add","login"]) ){
                if($user===null || $user["role"]==="admin") return true;
                else return false;
            }
            
            //allow to its owner
            if( in_array($this->action, ["edit"]) ){
                //only admin user can set [role]
                if(isset($this->request->data["User"]["role"]) && $user["role"]!=="admin"){ return false; }

                if($this->request->data["User"]["id"]===$user["id"] && $this->request->data["Profile"]["user_id"]===$user["id"]) return true;
            }

        }else if($this->request->is("get")){
            //don't allow if [user is login] //to allow non-login user, must declare $this->Auth->allow & declare $this->isAuthorize in each [action function]
            if( in_array($this->action, ["add","login"]) ){
                if( $user===null || $user["role"]==="admin") return true;
                else return false;
            }

            //allow to all [login-user]
            if( in_array($this->action, ["LimitedSchools","LimitedDepartments"]) ){
                return true;
            }

            //allow to its owner
            if( in_array($this->action, ["edit"]) ){
                $user_id=$this->request->params["pass"][0]?$this->request->params["pass"][0]:null; //0番目のパラメータ引数
                if($user_id===$user["id"]){
                    return true;
                }
            }

        }
        
        return parent::isAuthorized(($user)); 
    }

    public $uses=array("User","Faculty","FacultySchool","SchoolDepartment");//model 指定 AvailableDepartmentSelection, User

    public $helpers = array('Html','Form');

    public function login(){
        //ログインしている者は許さない
        if( !$this->isAuthorized($this->Auth->user()) ){
            $this->Flash->error("あなたは既にログインしています");
            return $this->redirect(["action"=>"index"]);
        }

        if ($this->request->is('post')) {
            if($this->Auth->login()) {
                $this->Flash->success("ログイン成功");
                return $this->redirect($this->Auth->redirectUrl() );
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
        $this->set("login_id",$this->Auth->user("id")?$this->Auth->user("id"):null); 
    }

    public function add(){
        //ログインしている者は許さない
        if( !$this->isAuthorized($this->Auth->user()) ){
            $this->Flash->error("あなたは既にユーザアカウントを持っています");
            return $this->redirect(["action"=>"index"]);
        }

        if($this->request->is("post")){
            $this->User->create();
            if($this->User->save($this->request->data)){
                return $this->redirect(["action"=>"login"]);
            }else{
                $this->Flash->error("The user cloudn't be saved, try again.");
            }
        }
    }

    public function view($id=null){
        if($this->request->is('get')){ /*GET*/
            
            if($id==null){       
                $this->Flash->error("parameter needed");
                return $this->redirect(["action"=>"index"]);
            }

            $data=$this->User->find("first",["conditions"=>["User.id"=>$id],"recursive"=>2,"fields"=>["User.id","User.username","Profile.enter_year","Profile.comment","Profile.image","Profile.faculty_id","Profile.school_id","Profile.department_id"]]);
            if($data){
                $this->Flash->success('Load data success!');
                $this->set("user",$data);
                if($id==$this->Auth->user("id")){ $this->set("isAuthor",true); }
            }else{
                throw new NotFoundException(__('User Not Found'));
            }
        }
    }

    /* Edit User Imformation */
    public function edit($id=null){ //path is "user_edit"

        if ($id==null) { 
            $this->Flash->error('error: argument was not set...');
            return $this->redirect(["action"=>"index"]);  
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
                return;
            }

            //profile enter year //debug($this->request->data);
            

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
                //debug($this->request->data);
                return $this->redirect(array('action' => 'view',$id));  
            }
        } 
    }

    //see schoolDepartment index
    /*
    public function schoolDepartment() {
        
        // GET 
        if ($this->request->is('get')){
            $this->set('schools',$this->School->find('all',array('order' => 'School.school asc')) );
            $this->set('departments',$this->Department->find('all',array('order' => 'Department.department asc')) );
            $this->set('schoolDepartments',$this->SchoolDepartment->find('all',array('order' => 'SchoolDepartment.id asc')) );
        }
        // POST
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
    }*/

    //see facultySchool index
    /*
    public function facultySchool() {
        // GET 
        if ($this->request->is('get')){
            $this->set('faculties',$this->Faculty->find('all',array('order' => 'Faculty.faculty asc')) );
            $this->set('schools',$this->School->find('all',array('order' => 'School.school asc')) );
            $this->set('facultySchools',$this->FacultySchool->find('all',array('order' => 'FacultySchool.id asc')) );
        }
        // POST 
        
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
    }*/

    //see userDepartmentSelections index
    /*
    public function userDepartmentSelection() {
        // GET 
        if ($this->request->is('get')){
            //$this->set('departments',$this->Department->find('all',array('order' => 'Department.department asc')) );
            $this->set('availableDepartmentSelections',$this->AvailableDepartmentSelection->find('all',array('order' => 'AvailableDepartmentSelection.id asc','recursive'=>1)) );
            $this->set('userDepartmentSelections',$this->UserDepartmentSelection->find('all',array('order' => 'UserDepartmentSelection.id asc','recursive'=>1)) );
        }
        // POST 
        else if ($this->request->is('post')) { 
            //if($this->request->data["UserDepartmentSelection"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
            if($this->request->data["UserDepartmentSelection"]["delete"]==true){
                if($this->request->data["UserDepartmentSelection"]["user_id"]===$this->Auth->user("id")){
                    $delete=$this->UserDepartmentSelection->delete($this->request->data["UserDepartmentSelection"]["id"]);
                    if (!empty($delete)) { 
                        $this->Flash->success('delete success!');
                        return $this->redirect(array('action' => 'userDepartmentSelection'));  
                    }else{
                        $this->Flash->error('delete Failed');
                        return $this->redirect(array('action' => 'userDepartmentSelection'));  
                    }
                }else{
                    $this->Flash->error('delete Failed: access error!');
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
    }*/

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