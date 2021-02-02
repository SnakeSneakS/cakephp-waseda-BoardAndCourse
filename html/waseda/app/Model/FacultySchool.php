<?php
class FacultySchool extends AppModel{//table course_selections
    public $primaryKey = "id";
    var $belongsTo = array( 
        'Faculty' => array(
            'className' => 'Faculty',
            'foreignKey' => 'faculty_id'
        ),
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        )
    );

    public $validate=array(
        "faculty_id"=>[
            "numeric"=>[
                "rule"=>"numeric",
                "required"=>true,
                "message"=>"invalid faculty",
            ],
            "unique"=>[
                "rule"=>["isUnique",["faculty_id","school_id"],false],
            ]
        ],
        "school_id"=>[
            "rule"=>"numeric",
            "required"=>true,
            "message"=>"invalid school",
        ],
        "delete"=>[
            "rule"=>["isAdmin",[]],
            "allowEmpty"=>true,
        ]
    );

    public function isAdmin($check,$opt){
        return true;
    }
}