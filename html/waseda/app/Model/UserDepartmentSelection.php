<?php
class UserDepartmentSelection extends AppModel{//table department_selections
    public $primaryKey = "id";
    var $belongsTo = array( 
        'NowDepartment' => array (
            'className' => 'Department',
            'foreignKey' => 'now_department_id'
        ),
        'NextDepartment' => array (
            'className' => 'Department',
            'foreignKey' => 'next_department_id'
        ),
        'User' => array (
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        "Gpa"=>array(
            'className' => 'Gpa',
            'foreignKey' => 'user_id'
        )
    );

    public $validate=array(//error check 
        "user_id"=>[
            "numeric"=>[
                "rule"=>"numeric",
                "required"=>true,
                "message"=>"invalid faculty",
            ],
            "unique1"=>[
                "rule"=>["isUnique",["user_id","rank"],false],
            ],
            "unique2"=>[
                "rule"=>["isUnique",["user_id","now_department_id","next_department_id"],false],
            ]  
        ],
        "rank"=>[
            "rule"=>"numeric",
            "required"=>true,
            "message"=>"invalid rank",
        ],
        "now_department_id"=>[
            "numeric"=>[
                "rule"=>"numeric",
                "requiews"=>true,
                "message"=>"invalid department",
            ],      
        ],
        "next_department_id"=>[
            "rule"=>"numeric",
            "requiews"=>true,
            "message"=>"invalid department",
        ],
        "modified"=>[
            "rule"=>"blank",
        ],
    );
}