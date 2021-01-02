<?php
class CourseSelection extends AppModel{//table course_selections
    public $primaryKey = "id";
    var $belongsTo = array( //table user has foreign key "department_id" and "course_id". 多対一の関係
        'Department' => array(
            'className' => 'Department',
            //'conditions' => 'Department.id = User.department_id',
            //'order' => 'Department.id ASC',
            'foreignKey' => 'department_id'
        ),
        'NowCourse' => array (                // ここから追加
            'className' => 'Course',
            //'conditions' => 'NowCourse.id = CourseSelection.now_course_id',
            //'order' => 'Course.id ASC',
            'foreignKey' => 'now_course_id'
        ),
        'NextCourse' => array (                // ここから追加
            'className' => 'Course',
            //'conditions' => 'NextCourse.id = CourseSelection.next_course_id',
            //'order' => 'Course.id ASC',
            'foreignKey' => 'next_course_id'
        )
    );

    //$hasAndBelongsToMany の方がいい？
}