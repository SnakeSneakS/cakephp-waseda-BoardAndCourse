<?php
class Profile extends AppModel{
    public $primaryKey = "user_id"; //これ必要。error: saveAssociated Integrity constraint violation: 1062 Duplicate entry '2' for key 'PRIMARY'
    public $belongsTo = array( 
        'Faculty' => array (
            'className' => 'Faculty',
            'foreignKey' => 'faculty_id'
        ),
        'School' => array (
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        ),
        
    );

    public $validate=array(//error check 
        "enter_year"=>[
            "number"=>[
                "rule"=>["allowYearsAgo",10],
                "allowEmpty"=>true,
                "message"=>"invalid enter year",
            ],
        ],
        "faculty_id"=>[
            "rule"=>"numeric",
            "allowEmpty"=>true,
            "message"=>"invalid faculty",
        ],
        "school_id"=>[
            "rule"=>"numeric",
            "allowEmpty"=>true,
            "message"=>"invalid school",
        ],
        "department_id"=>[
            "rule"=>"numeric",
            "allowEmpty"=>true,
            "message"=>"invalid department",
        ],
        "comment"=>[
            "rule"=>["maxLength",512],
            "allowEmpty"=>true,
            "message"=>"最大512文字",
        ],
        "image"=>[

        ],
        "modified"=>[
            "rule"=>"blank",
        ],
    );

    //return true if year: nowYear-$ago <= $check <=nowYear
    public function allowYearsAgo($check=null,$ago=10){
        //debug($check);
        $enter_year=$check["enter_year"];
        $now_year=date("Y");
        if($check==null){
            return true;
        }else if(is_numeric($enter_year) && $now_year-$ago<=$enter_year && $enter_year<=$now_year){
            return true;
        }else{
            return false;
        }
    }

    public function beforeValidate($option=array()){
        if(isset($this->data["Profile"]["enter_year"]["year"])){
            $this->data["Profile"]["enter_year"]=$this->data["Profile"]["enter_year"]["year"];
        }
        return true;
    }
    
}