<?php
class Comment extends AppModel{//table courses
    public $primaryKey = "id";
    public $belongsTo=[
        "User"=>[
            "className"=>"User",
            "foreignKey"=>"user_id"
        ],
    ];
}