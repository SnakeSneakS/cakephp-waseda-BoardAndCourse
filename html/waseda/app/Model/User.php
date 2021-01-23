<?php
// https://www.moonmile.net/blog/archives/1799
class User extends AppModel{
    public $primaryKey = "id";

    public $hasOne = array(
        "Profile" => array(
            "className" => "Profile",
            //"conditions" => array("User.id"=>"Profile.user_id"),
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
    );

    public $hasMany=[
        'UserDepartmentSelection'=>[
            "Classname"=>'UserDepartmentSelection',
            "foreignKey"=>"user_id"
        ]
    ];


    public $validate=array(//error check 
        "name" => array(
            "rule" => "notBlank",
            "message" => "not blank"
        ),
        "password"=>array(
            "rule" => "notBlank",
            "message" => "not blank"
        )
    );

}