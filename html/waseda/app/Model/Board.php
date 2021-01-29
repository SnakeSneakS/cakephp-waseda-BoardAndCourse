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

    public $validation=array(
        /*
        $allow_board_to=$this->Board->findById($this->request->data["Board"]["to_board_id"],["recursive"=>-1,"fields"=>["Board.allow_board_to"] ] );
            if( isset($allow_board_to) && $allow_board_to["Board"]["allow_board_to"]===true ){
                return true;
            }
        */
    );

    /*
    public function isOwnedBy($board_id, $user_id){
        //if found column ("id"=>$board_id,"user_id"=>$user_id), return true
        return $this->field("id",["id"=>$board_id,"user_id"=>$user_id]) !== false;
    }
    */
}