<?php
class Comment extends AppModel{//table courses
    public $primaryKey = "id";
    public $belongsTo=[
        "User"=>[
            "className"=>"User",
            "foreignKey"=>"user_id"
        ],
    ];

    public $validate=array(
        "user_id"=>[
            "number"=>[
                "rule"=>"numeric"
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
            ],
        ],
        "to_board_id"=>[
            "number"=>[
                "rule"=>"numeric"
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
            ],
        ],
        "to_comment_id"=>[
            "number"=>[
                "rule"=>"numeric"
            ],
            "allowBlank"=>[
                "rule"=>"allowBlank",
            ],
        ],
        "text"=>[
            "length"=>[
                "rule"=>["maxLength",255],
                "message"=>"最大255文字",
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
            ],
        ],
        "created"=>[
            "rule"=>"blank",
        ]
    );
}