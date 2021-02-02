<?php
class AvailableDepartmentSelection extends AppModel{//table course_selections
    public $primaryKey = "id";
    public $belongsTo = array( 
        'NowDepartment' => array (
            'className' => 'Department',
            'foreignKey' => 'now_department_id'
        ),
        'NextDepartment' => array (
            'className' => 'Department',
            'foreignKey' => 'next_department_id'
        )
    );

    public $validate=array(
        "now_department_id"=>[
            "unique"=>[
                "rule"=>["isUnique",["now_department_id","next_department_id"],false],
                "notEmpty"=>true,
            ],
            "number"=>[
                "rule"=>"numeric",
                "message"=>"整数です",
            ],
        ],
        "next_department_id"=>[
            "number"=>[
                "rule"=>"numeric",
                "message"=>"整数です",
                "notEmpty"=>true,
            ],
        ],
        "max_num"=>[
            "number"=>[
                "rule"=>"numeric",
                "message"=>"整数です",
                "notEmpty"=>true,
            ],
        ],
    );

}