<?php
class Grade extends AppModel{
    public $primaryKey = "user_id"; //これ必要。error: saveAssociated Integrity constraint violation: 1062 Duplicate entry '2' for key 'PRIMARY'
    public $belongsTo = array( //table user has foreign key "department_id" and "course_id". 多対一の関係
        'Department' => array(
            'className' => 'Department',
            //'conditions' => array('Department.department_id' => 'Grade.department_id'),
            'foreignKey' => 'department_id'
        ),
        'Course' => array (                // ここから追加
            'className' => 'Course',
            //'conditions' => array('Course.course_id' => 'Grade.course_id'),
            'foreignKey' => 'course_id'
        )
    );

    public $validate=array(//error check 
        /*"gpa"=>array(
            "rule"=>array("decimal",3), //小数点以下桁数を限定
            'message' => '小数点以下3桁まで入力して下さい。',
            'allowEmpty' => true  //空白許可
        )*/
    );
}