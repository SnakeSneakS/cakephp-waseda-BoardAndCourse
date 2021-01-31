<?php
class BoardUser extends AppModel{//table courses
    public $primaryKey = "id";
    public $belongsTo=[
        "User"=>[
            "className"=>"User",
            "foreignKey"=>"user_id",
        ],
        "Board"=>[
            "className"=>"Board",
            "foreignKey"=>"board_id",
        ]
    ];

    public $validation=array(
        "user_id"=>[
            "required"=>true,
            "message"=>"user is required",
        ],
        "board_id"=>[
            "required"=>true,
            "message"=>"board is required",
        ],
        "type"=>[
            "required"=>true,
            "rule"=>[ "inList"=>["watch"] ],
            "message"=>"invalid type",
        ]
    );

}