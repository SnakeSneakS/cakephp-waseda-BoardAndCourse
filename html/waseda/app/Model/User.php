<?php
// https://www.moonmile.net/blog/archives/1799
class User extends AppModel{
    public $hasOne = array(
        "Grade" => array(
            "className" => "Grade",
            "conditions" => array("User.id"=>"Grade.user_id")
        )
    );
}