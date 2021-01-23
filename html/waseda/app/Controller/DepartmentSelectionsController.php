<?php


class DepartmentSelectionsController extends AppController{

    public $uses=array("User","Gpa","Department","FacultySchool","SchoolDepartment","AvailableDepartmentSelection","UserDepartmentSelection");

    public function index(){
        
    }

    public function user_add($id=null) {

        if($id==null){
            return $this->redirect(["action"=>"index"]);
        }

        /* GET */
        if ($this->request->is('get')){
            $user=$this->User->find("first",['recursive'=>'1','conditions'=>["User.id"=>$id] , "fields"=>["User.id","User.name",/*"Gpa.*",*/"Profile.department_id"] /*, "joins"=>[ ["table"=>"gpas","alias"=>"Gpa","type"=>"left","conditions"=>["User.id=Gpa.id"]], ]*/ ] );
            $this->set('user',$user);
            $this->set('gpa',$this->Gpa->find("first",['conditions'=>["Gpa.id"=>$id] ,  ]) );
            $this->set('userDepartment',$this->Department->find('first',['conditions'=>["Department.id"=>!empty($user["Profile"]["department_id"])?$user["Profile"]["department_id"]:-1,] ]) );
            $this->set('availableDepartmentSelections',$this->AvailableDepartmentSelection->find('all',['order' => 'AvailableDepartmentSelection.id asc','recursive'=>1,'conditions'=>["AvailableDepartmentSelection.now_department_id"=>!empty($user["Profile"]["department_id"])?$user["Profile"]["department_id"]:-1]  ] ) );

            $deleted=$this->UserDepartmentSelection->deleteAll(["UserDepartmentSelection.user_id"=>$id, "NOT"=>["UserDepartmentSelection.now_department_id"=>$user["Profile"]["department_id"]] ] );
            $this->set('userDepartmentSelections',$this->UserDepartmentSelection->find('all',array('order' => 'UserDepartmentSelection.id asc','recursive'=>1,'conditions'=>"UserDepartmentSelection.user_id=".$id,'fields'=>["UserDepartmentSelection.*","NowDepartment.*","NextDepartment.*","User.id","User.name"])) );
        }
        /* POST */
        else if ($this->request->is('post')) { 
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

    public function user_view($id=null) {

        if($id==null){
            return $this->redirect(["action"=>"index"]);
        }

        /* GET */
        if ($this->request->is('get')){
            $user=$this->User->find("first",['recursive'=>'1','conditions'=>["User.id"=>$id] , "fields"=>["User.id","User.name",/*"Gpa.*",*/"Profile.department_id"] /*, "joins"=>[ ["table"=>"gpas","alias"=>"Gpa","type"=>"left","conditions"=>["User.id=Gpa.id"]], ]*/ ] );
            $this->set('user',$user);
            $this->set('gpa',$this->Gpa->find("first",['conditions'=>["Gpa.id"=>$id] ,  ]) );
            $this->set('userDepartment',$this->Department->find('first',['conditions'=>["Department.id"=>!empty($user["Profile"]["department_id"])?$user["Profile"]["department_id"]:-1,] ]) );
            
            $deleted=$this->UserDepartmentSelection->deleteAll(["UserDepartmentSelection.user_id"=>$id, "NOT"=>["UserDepartmentSelection.now_department_id"=>$user["Profile"]["department_id"]] ] );
            $this->set('userDepartmentSelections',$this->UserDepartmentSelection->find('all',array('order' => 'UserDepartmentSelection.id asc','recursive'=>1,'conditions'=>"UserDepartmentSelection.user_id=".$id,'fields'=>["UserDepartmentSelection.*","NowDepartment.*","NextDepartment.*","User.id","User.name"])) );
        }

    }

    public function editGpa(){
        /* POST */
        if ($this->request->is('post')) { 
            
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
        $this->set("userSelections",$this->UserDepartmentSelection->find("all",[
            "conditions"=>["NOT"=>["Gpa.id"=>""]],
            "order"=>"UserDepartmentSelection.now_department_id asc, UserDepartmentSelection.rank asc, Gpa.gpa desc",
            "fields"=>["UserDepartmentSelection.rank","NowDepartment.department","NextDepartment.department","Gpa.gpa",],
                
        ]));
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