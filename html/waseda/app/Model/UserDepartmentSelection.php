<?php
class UserDepartmentSelection extends AppModel{//table department_selections
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
            'className' => 'Department',
            'foreignKey' => 'now_department_id'
        ),
        'NextDepartment' => array (
            'className' => 'Department',
            'foreignKey' => 'next_department_id'
        ),
        'Profile' => array (
            'className' => '`Profile`',
            'foreignKey' => 'user_id'
        )
    );
}