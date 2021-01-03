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
        /*"Department" => array(
            "className" => "Department",
            //"conditions" => array("Profile.department_id"=>"Department.department_id"),
            'foreignKey' => 'department_id'
        ),
        "Course" => array(
            "className" => "Course",
            //"conditions" => array("Profile.course_id"=>"Course.course_id"),
            'foreignKey' => 'course_id'
        ) */
    );
/*
    public $belongsTo = array( //Profileに対してこれを設定したい
        'Department' => array(
            'className' => 'Department',
            //'conditions' => array('Department.department_id' => 'Profile.department_id'),
            'foreignKey' => 'department_id'
        ),
        'Course' => array (     
            'className' => 'Course',
            //'conditions' => array('Course.course_id' => 'Profile.course_id'),
            'foreignKey' => 'course_id'
        )
    );*/

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