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
            "unique"=>[
                "rule"=>["isUnique",["user_id","board_id","type"],false]
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
                "message"=>"user is required",
            ]
        ],
        "board_id"=>[
            "notBlank"=>[
                "rule"=>"notBlank",
                "message"=>"board is required",
            ]
        ],
        "type"=>[
            "list"=>[
                "rule"=>[ "inList"=>["watch"] ],
                "message"=>"invalid type",
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
                "message"=>"user is required",
            ]
        ]
    );

}