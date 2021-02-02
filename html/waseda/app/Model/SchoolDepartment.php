<?php
class SchoolDepartment extends AppModel{//table course_selections
    public $primaryKey = "id";
    var $belongsTo = array( 
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        )
    );

    public $validate=array(
        "school_id"=>[
            "number"=>[
                "rule"=>"numeric",
                "required"=>true,
                "message"=>"invalid school",
            ],
            "unique"=>[
                "rule"=>["isUnique",["school_id","department_id"],false],
            ]            
        ],
        "department_id"=>[
            "rule"=>"numeric",
            "required"=>true,
            "message"=>"invalid department",
        ],
    );
}