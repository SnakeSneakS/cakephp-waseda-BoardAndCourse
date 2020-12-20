<?php
// https://www.moonmile.net/blog/archives/1799
class User extends AppModel{
    public $hasOne = array(
        "Grade" => array(
            "className" => "Grade",
            //"conditions" => array("User.id"=>"Grade.user_id"),
            'foreignKey' => 'user_id'
        ),
        "Department" => array(
            "className" => "Department",
            //"conditions" => array("User.department_id"=>"Department.id"),
            'foreignKey' => 'id'
        ),
        "Course" => array(
            "className" => "Course",
            //"conditions" => array("User.course_id"=>"Course.id"),
            'foreignKey' => 'id'
        )        
    );


}