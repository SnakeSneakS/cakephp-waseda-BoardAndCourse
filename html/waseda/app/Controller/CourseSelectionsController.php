<?php

/*
$ret = $this->query('UPDATE users SET point = point + ? WHERE id = ?', array($point, $user_id)); 直接SQL文書ける。SQL発行回数減らす時に使えそう？saveは便利だけどSQL発行回数が多い http://damepg.hatenablog.com/entry/2012/09/08/134126
*/

class CourseSelectionsController extends AppController{

    public $uses=array("User","Profile","Faculty","School","Department","FacultySchool","SchoolDepartment","AvailableDepartmentSelection","UserDepartmentSelection");//model 指定 AvailableDepartmentSelection, User

    //public $scaffold;//localhost/blog/postsでもう管理画面みたいなのが既にできてる。でもこれだとカスタマイズはできないよね〜〜
    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE

    public function index(){
        
    }

    public function add(){
        if($this->request->is("get")){
            $this->request->data=$this->Post->read();
        }else if($this->request->is("post")){
            $this->User->save($this->request->data);
            $this->redirect(["action"=>"view",$this->User->id]);
        }
    }

    public function view($id=-1){
        if($this->request->is('get')){ /*GET*/
            $data=$this->User->find("first",["conditions"=>"User.id=$id","recursive"=>2,"fields"=>["User.id","User.name","Profile.enter_year","Profile.comment","Profile.image","Profile.faculty_id","Profile.school_id","Profile.department_id"]]);
            if($data){
                $this->Flash->success('Load data success!');
                $this->set('user',$data); //$this->User->find('first',array("conditions"=>array("User.id"=>$id)) でも良い 
            }else{
                $this->Flash->error('load Failed');
                return $this->redirect(array('action' => 'index')); 
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
            if($this->request->data["AvailableDepartmentSelection"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
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
            if($this->request->data["SchoolDepartment"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
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
            if($this->request->data["FacultySchool"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
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
            if($this->request->data["UserDepartmentSelection"]["id"]==0) return $this->Flash->error('$id=0のとき、updateされずinsertされてしまう');
            
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