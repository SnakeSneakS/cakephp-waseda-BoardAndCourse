<?php
class Board extends AppModel{//table courses
    public $primaryKey = "id";
    public $belongsTo=[
        "ToBoard"=>[
            "className"=>"Board",
            "foreignKey"=>"to_board_id",
        ],
        "User"=>[
            "className"=>"User",
            "foreignKey"=>"user_id",
        ]
    ];
    public $hasMany=[
        /*
        "Boards"=>[
            "className"=>"Board",
            "foreignKey"=>"to_board_id",
        ],
        */
    ];
}