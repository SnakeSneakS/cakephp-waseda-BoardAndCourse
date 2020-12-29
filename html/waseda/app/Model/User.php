<?php
// https://www.moonmile.net/blog/archives/1799
class User extends AppModel{
    public $primaryKey = "id";

    /*
    //これ全くわからーーーーん
    public $hasAndBelongsToMany = array(
        "Grade" => array(
            "className" => "Grade",
            "joinTable"=>"departments",
            'foreignKey' => 'department_id',
            //'dependent' => true,
            "associationForeignKey"=>"department_id"
        )
    );
    */

    public $hasOne = array(
        "Grade" => array(
            "className" => "Grade",
            //"conditions" => array("User.id"=>"Grade.user_id"),
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        /*"Department" => array(
            "className" => "Department",
            //"conditions" => array("Grade.department_id"=>"Department.department_id"),
            'foreignKey' => 'department_id'
        ),
        "Course" => array(
            "className" => "Course",
            //"conditions" => array("Grade.course_id"=>"Course.course_id"),
            'foreignKey' => 'course_id'
        ) */
    );
/*
    public $belongsTo = array( //GRADEに対してこれを設定したい
        'Department' => array(
            'className' => 'Department',
            //'conditions' => array('Department.department_id' => 'Grade.department_id'),
            'foreignKey' => 'department_id'
        ),
        'Course' => array (     
            'className' => 'Course',
            //'conditions' => array('Course.course_id' => 'Grade.course_id'),
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