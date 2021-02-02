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

    public $validate=array(
        "user_id"=>[
            "number"=>[
                "rule"=>"numeric",
                "message"=>"整数です",
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
                "message"=>"user is required",
            ]
        ],
        "to_board_id"=>[
            "number"=>[
                "rule"=>"numeric",
                "message"=>"整数です",
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
                "message"=>"to board is required",
                "required"=>true,
            ]
        ],
        "title"=>[
            /*"unique"=>[
                "rule"=>"isUnique",
                "notEmpty"=>true,
            ],*/
            "length"=>[
                "rule"=>["maxLength",32],
                "message"=>"最大32文字",
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
                "message"=>"not blank",
                "required"=>true,
            ]
        ],
        "description"=>[
            "length"=>[
                "rule"=>["maxLength",255],
                "message"=>"最大255文字",
                "allowEmpty"=>true,
            ],
        ],
        "allow_comment_to"=>[
            
        ],
        "allow_board_to"=>[
            
        ],
        "created"=>[
            "rule"=>"blank"
        ],
        "modified"=>[
            "rule"=>"blank"
        ],
    );

    public function updateModifiedOfBoards($to_board_id=null){
        //to update "modified" of board
        //debug($data);
        if($to_board_id==null){ debug($this->data); return; }
        $i=0; $nowId=$to_board_id;
        while(1){
            $this->create();
            $newId=$this->findById($nowId)["Board"]["to_board_id"];
            $this->save([ "Board"=>["id"=>$nowId] ]); 

            if($nowId==$newId){ break; }
            else{ $nowId=$newId; }

            if($i>30){ $this->Flash->error("Error! infinite loop happen :(");  break; }
            else{$i++;}
        }
    }

}