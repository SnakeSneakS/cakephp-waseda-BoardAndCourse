<?php
class Grade extends AppModel{
    var $belongsTo = array( //table user has foreign key "department_id" and "course_id". 多対一の関係
        'Department' => array(
            'className' => 'Department',
            'conditions' => 'Department.id = Grade.department_id',
            //'order' => 'Department.id ASC',
            'foreignKey' => 'department_id'),
        'Course' => array (                // ここから追加
            'className' => 'Course',
            'conditions' => 'Course.id = Grade.course_id',
            //'order' => 'Course.id ASC',
            'foreignKey' => 'course_id')
    );
}