<?php
class AvailableDepartmentSelection extends AppModel{//table course_selections
    public $primaryKey = "id";
    var $belongsTo = array( 
        'Faculty' => array(
            'className' => 'Faculty',
            'foreignKey' => 'faculty_id'
        ),
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'NowDepartment' => array (
            'className' => 'department',
            'foreignKey' => 'now_department_id'
        ),
        'NextDepartment' => array (
            'className' => 'department',
            'foreignKey' => 'next_department_id'
        )
    );
}