<?php


class DepartmentSelectionsController extends AppController{

    //auth
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("index","result");
    }

    public function isAuthorized($user)
    {        
        //debug ($user);

        //authentication check

        if($this->request->is("post")){ //POST
            //ban fields
            if($this->banFields($this->request->data,$user)){ return false; }

            //user
            if( in_array($this->action, ["selection_add",]) ){
                if (
                    //user_id check
                    $this->request->data["UserDepartmentSelection"]["user_id"]===$user["id"] 
                    //id check
                    && (
                        $this->request->data["UserDepartmentSelection"]["id"]==null 
                        || $this->UserDepartmentSelection->findById($this->request->data["UserDepartmentSelection"]["id"])["UserDepartmentSelection"]["user_id"] == $user["id"]
                    )
                ) return true; 
                /*
                //モデルで以下の制限をかけよう
                (     
                    //next_department_id check
                    //now_department_id check
                    && $this->request->data["UserDepartmentSelection"]["now_department_id"]===$this->User->findById($user["id"],["fields"=>"Profile.department_id"])["Profile"]["department_id"]
                );
                */
            }
            //user selection delete
            if( in_array($this->action, ["selection_delete_all"]) ){
                if ($this->request->data["UserDepartmentSelection"]["user_id"]===$user["id"]) return true; 
            }
            //gpa
            if( in_array($this->action, ["edit_gpa"]) ){
                if( $this->request->data["Gpa"]["id"]===$user["id"]) return true;
            }

        }else if($this->request->is("get")){ //GET
            if( in_array($this->action, ["user_view","user_add","edit_gpa"]) ){
                $user_id=(int)$this->request->params["pass"]?$this->request->params["pass"][0]:null; //0番目のパラメータ引数
                if($user_id===$user["id"]){
                    return true;
                }
            }
        }
        
        return parent::isAuthorized($user);
    }



    public $uses=array("User","Gpa","Department","FacultySchool","SchoolDepartment","AvailableDepartmentSelection","UserDepartmentSelection");

    public function index(){
        //auth
        $this->set("login_id",$this->Auth->user("id")?$this->Auth->user("id"):null); 
    }

    public function user_add($id=null) {

        //auth
        if($id==null){
            $this->Flash->error("parameter needed");
            return $this->redirect(["action"=>"index"]);
        }

        /* GET */
        if ($this->request->is('get')){
            $user=$this->User->find("first",['recursive'=>'1','conditions'=>["User.id"=>$id] , "fields"=>["User.id","User.username",/*"Gpa.*",*/"Profile.department_id"] /*, "joins"=>[ ["table"=>"gpas","alias"=>"Gpa","type"=>"left","conditions"=>["User.id=Gpa.id"]], ]*/ ] );
            $this->set('user',$user);
            $this->set('gpa',$this->Gpa->find("first",['conditions'=>["Gpa.id"=>$id] ,  ]) );
            $this->set('userDepartment',$this->Department->find('first',['conditions'=>["Department.id"=>!empty($user["Profile"]["department_id"])?$user["Profile"]["department_id"]:-1,] ]) );
            $this->set('availableDepartmentSelections',$this->AvailableDepartmentSelection->find('all',['order' => 'AvailableDepartmentSelection.id asc','recursive'=>1,'conditions'=>["AvailableDepartmentSelection.now_department_id"=>!empty($user["Profile"]["department_id"])?$user["Profile"]["department_id"]:-1]  ] ) );

            $deleted=$this->UserDepartmentSelection->deleteAll(["UserDepartmentSelection.user_id"=>$id, "NOT"=>["UserDepartmentSelection.now_department_id"=>$user["Profile"]["department_id"]] ] );
            $this->set('userDepartmentSelections',$this->UserDepartmentSelection->find('all',array('order' => 'UserDepartmentSelection.id asc','recursive'=>1,'conditions'=>"UserDepartmentSelection.user_id=".$id,'fields'=>["UserDepartmentSelection.*","NowDepartment.*","NextDepartment.*","User.id","User.username"])) );
        }
    }

    public function selection_add($id=null) {
        /* POST */
        if ($this->request->is("post")) { 
            //if($this->request->data["UserDepartmentSelection"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            if($this->request->data["UserDepartmentSelection"]["user_id"]!=$id) return $this->Flash->error('not match $id');
            
            $saved=$this->UserDepartmentSelection->save($this->request->data); 
            if (!empty($saved)) { 
                $this->Flash->success('change success!');
                return $this->redirect(array('action' => 'user_add',$id));  
            }else{
                $this->Flash->error('change Failed');
                return $this->redirect(array('action' => 'user_add',$id));  
            }
            
        }  
    }

    public function selection_delete_all($id=null) {
        /* POST */
        if ($this->request->is("post")) { 
            if($this->request->data["UserDepartmentSelection"]["user_id"]!=$id) return $this->Flash->error('not match $id');
            
            $deleted=$this->UserDepartmentSelection->deleteAll(["UserDepartmentSelection.user_id"=>$this->request->data["UserDepartmentSelection"]["user_id"]]); 
            if (!empty($deleted)) { 
                $this->Flash->success('delete success!');
                return $this->redirect(array('action' => 'user_add',$id));  
            }else{
                $this->Flash->error('change Failed');
                return $this->redirect(array('action' => 'user_add',$id));  
            }
            
        }  
    }

    public function user_view($id=null) {

        if($id==null){
            $this->Flash->error("parameter needed");
            return $this->redirect(["action"=>"index"]);
        }

        /* GET */
        if ($this->request->is('get')){
            $user=$this->User->find("first",['recursive'=>'1','conditions'=>["User.id"=>$id] , "fields"=>["User.id","User.username",/*"Gpa.*",*/"Profile.department_id"] /*, "joins"=>[ ["table"=>"gpas","alias"=>"Gpa","type"=>"left","conditions"=>["User.id=Gpa.id"]], ]*/ ] );
            $this->set('user',$user);
            $this->set('gpa',$this->Gpa->find("first",['conditions'=>["Gpa.id"=>$id] ,  ]) );
            $this->set('userDepartment',$this->Department->find('first',['conditions'=>["Department.id"=>!empty($user["Profile"]["department_id"])?$user["Profile"]["department_id"]:-1,] ]) );
            
            $deleted=$this->UserDepartmentSelection->deleteAll(["UserDepartmentSelection.user_id"=>$id, "NOT"=>["UserDepartmentSelection.now_department_id"=>$user["Profile"]["department_id"]] ] );
            $this->set('userDepartmentSelections',$this->UserDepartmentSelection->find('all',array('order' => 'UserDepartmentSelection.id asc','recursive'=>1,'conditions'=>"UserDepartmentSelection.user_id=".$id,'fields'=>["UserDepartmentSelection.*","NowDepartment.*","NextDepartment.*","User.id","User.username"])) );
        }

    }

    public function edit_gpa($id=null){
        if($id==null){
            $this->Flash->error("parameter needed");
            return $this->redirect(["action"=>"index"]);
        }

        /* POST */
        if($this->request->is("get")){
            return $this->redirect(["action"=>"user_add",$this->Auth->user("id")?$this->Auth->user("id"):null]);

        }else if ($this->request->is("post")) { 
            
            $saved=$this->Gpa->save($this->request->data); 
            if (!empty($saved)) { 
                $this->Flash->success('change success!');
                return $this->redirect(array('action' => 'user_add',$this->request->data["Gpa"]["id"]));  
            }else{
                $this->Flash->error('change Failed');
                return $this->redirect(array('action' => 'user_add',$this->request->data["Gpa"]["id"]));  
            }
 
        }  
    }

    public function result(){
        //auth
        $this->set("login_id",$this->Auth->user("id")?$this->Auth->user("id"):null); 
    
        $this->set("userSelections",$this->UserDepartmentSelection->find("all",[
            "conditions"=>["NOT"=>["Gpa.id"=>""]],
            "order"=>"UserDepartmentSelection.now_department_id asc, UserDepartmentSelection.rank asc, Gpa.gpa desc",
            "fields"=>["UserDepartmentSelection.rank","NowDepartment.department","NextDepartment.department","Gpa.gpa",],
        ]));

        $this->set('availableDepartmentSelections',$this->AvailableDepartmentSelection->find('all',['order' => 'AvailableDepartmentSelection.id asc',] ) );
    }

    /*
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
    */
}